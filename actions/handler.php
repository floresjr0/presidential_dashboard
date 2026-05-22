<?php
require_once __DIR__ . '/../config/app.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verifyCsrf()) {
    flash('error', 'Invalid request.');
    redirect('/dashboard.php');
}

$action = $_POST['action'] ?? '';
$db = getDB();
$user = currentUser();

switch ($action) {
    case 'create_user':
        requireRole(['admin']);
        $stmt = $db->prepare('INSERT INTO users (username, password, full_name, email, role, campus_id, institute_id, department_id) VALUES (?,?,?,?,?,?,?,?)');
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $campus = $_POST['campus_id'] ?: null;
        $inst = $_POST['institute_id'] ?: null;
        $dept = $_POST['department_id'] ?: null;
        $stmt->bind_param('sssssiii', $_POST['username'], $hash, $_POST['full_name'], $_POST['email'], $_POST['role'], $campus, $inst, $dept);
        $stmt->execute();
        auditLog('create', 'users', $db->insert_id);
        flash('success', 'User created.');
        redirect('/modules/admin/users.php');
        break;

    case 'save_employee':
        requireRole(['admin','hr','department_head','campus_admin']);
        $cid = $_POST['campus_id'] ?: $user['campus_id'];
        $iid = $_POST['institute_id'] ?: null;
        $did = $_POST['department_id'] ?: $user['department_id'];
        if ($user['role'] === 'department_head') $did = $user['department_id'];
        if ($user['role'] === 'campus_admin') $cid = $user['campus_id'];
        if (!empty($_POST['id'])) {
            $stmt = $db->prepare('UPDATE employees SET employee_id=?, full_name=?, gender=?, employee_type=?, campus_id=?, institute_id=?, department_id=?, position=?, email=?, phone=?, status=? WHERE id=?');
            $stmt->bind_param('ssssiiissssi', $_POST['employee_id'], $_POST['full_name'], $_POST['gender'], $_POST['employee_type'], $cid, $iid, $did, $_POST['position'], $_POST['email'], $_POST['phone'], $_POST['status'], $_POST['id']);
        } else {
            $stmt = $db->prepare('INSERT INTO employees (employee_id, full_name, gender, employee_type, campus_id, institute_id, department_id, position, email, phone, hire_date, created_by) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)');
            $hire = $_POST['hire_date'] ?: null;
            $stmt->bind_param('ssssiiissssi', $_POST['employee_id'], $_POST['full_name'], $_POST['gender'], $_POST['employee_type'], $cid, $iid, $did, $_POST['position'], $_POST['email'], $_POST['phone'], $hire, $user['id']);
        }
        $stmt->execute();
        auditLog('save', 'employees', $_POST['id'] ?? $db->insert_id);
        flash('success', 'Employee saved.');
        redirect($_POST['redirect'] ?? '/modules/hr/employees.php');
        break;

    case 'save_student':
        requireRole(['admin','registrar','guidance','campus_admin']);
        $stmt = $db->prepare('INSERT INTO students (student_id, full_name, gender, campus_id, institute_id, department_id, course_id, year_level, status, email) VALUES (?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE full_name=VALUES(full_name), gender=VALUES(gender), status=VALUES(status), year_level=VALUES(year_level)');
        $stmt->bind_param('sssiiiiiss', $_POST['student_id'], $_POST['full_name'], $_POST['gender'], $_POST['campus_id'], $_POST['institute_id'], $_POST['department_id'], $_POST['course_id'], $_POST['year_level'], $_POST['status'], $_POST['email']);
        $stmt->execute();
        auditLog('save', 'students', $db->insert_id);
        flash('success', 'Student saved.');
        redirect('/modules/registrar/students.php');
        break;

    case 'save_enrollment_stats':
        requireRole(['admin','registrar']);
        $stmt = $db->prepare('INSERT INTO enrollment_stats (academic_year_id, semester_id, campus_id, institute_id, course_id, enrolled_count, graduating_count, bascat_count, drop_count, male_count, female_count, notes, recorded_by) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $course = $_POST['course_id'] ?: null;
        $inst = $_POST['institute_id'] ?: null;
        $stmt->bind_param('iiiiiiiiiiisi', $_POST['academic_year_id'], $_POST['semester_id'], $_POST['campus_id'], $inst, $course, $_POST['enrolled_count'], $_POST['graduating_count'], $_POST['bascat_count'], $_POST['drop_count'], $_POST['male_count'], $_POST['female_count'], $_POST['notes'], $user['id']);
        $stmt->execute();
        auditLog('create', 'enrollment_stats', $db->insert_id);
        flash('success', 'Enrollment statistics recorded.');
        redirect('/modules/registrar/enrollment.php');
        break;

    case 'save_finance':
        requireRole(['admin','finance']);
        $stmt = $db->prepare('INSERT INTO finance_records (record_type, title, amount, record_date, campus_id, category, description, academic_year_id, recorded_by) VALUES (?,?,?,?,?,?,?,?,?)');
        $campus = $_POST['campus_id'] ?: null;
        $ay = $_POST['academic_year_id'] ?: null;
        $stmt->bind_param('ssdsissii', $_POST['record_type'], $_POST['title'], $_POST['amount'], $_POST['record_date'], $campus, $_POST['category'], $_POST['description'], $ay, $user['id']);
        $stmt->execute();
        auditLog('create', 'finance', $db->insert_id);
        flash('success', 'Financial record saved.');
        redirect('/modules/finance/records.php');
        break;

    case 'save_research':
        requireRole(['admin','research']);
        $filePath = null; $fileName = null; $fileType = null;
        if (!empty($_FILES['document']['name'])) {
            $ext = pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION);
            $fileName = $_FILES['document']['name'];
            $fileType = $_FILES['document']['type'];
            $newName = uniqid('research_') . '.' . $ext;
            if (!is_dir(UPLOAD_PATH)) mkdir(UPLOAD_PATH, 0755, true);
            move_uploaded_file($_FILES['document']['tmp_name'], UPLOAD_PATH . $newName);
            $filePath = $newName;
        }
        $campus = $_POST['campus_id'] ?: null;
        $dept = $_POST['department_id'] ?: null;
        $ay = $_POST['academic_year_id'] ?: null;
        if (!empty($_POST['id'])) {
            if ($filePath) {
                $stmt = $db->prepare('UPDATE research_documents SET title=?, authors=?, abstract=?, status=?, campus_id=?, department_id=?, academic_year_id=?, file_path=?, file_name=?, file_type=? WHERE id=?');
                $stmt->bind_param('ssssiisssi', $_POST['title'], $_POST['authors'], $_POST['abstract'], $_POST['status'], $campus, $dept, $ay, $filePath, $fileName, $fileType, $_POST['id']);
            } else {
                $stmt = $db->prepare('UPDATE research_documents SET title=?, authors=?, abstract=?, status=?, campus_id=?, department_id=?, academic_year_id=? WHERE id=?');
                $stmt->bind_param('ssssiiii', $_POST['title'], $_POST['authors'], $_POST['abstract'], $_POST['status'], $campus, $dept, $ay, $_POST['id']);
            }
        } else {
            $stmt = $db->prepare('INSERT INTO research_documents (title, authors, abstract, status, campus_id, department_id, academic_year_id, file_path, file_name, file_type, uploaded_by) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
            $stmt->bind_param('ssssiissssi', $_POST['title'], $_POST['authors'], $_POST['abstract'], $_POST['status'], $campus, $dept, $ay, $filePath, $fileName, $fileType, $user['id']);
        }
        $stmt->execute();
        auditLog('save', 'research', $_POST['id'] ?? $db->insert_id);
        flash('success', 'Research document saved.');
        redirect('/modules/research/documents.php');
        break;

    case 'save_announcement':
        requireRole(['admin']);
        $stmt = $db->prepare('INSERT INTO announcements (title, content, type, target_role, is_pinned, posted_by) VALUES (?,?,?,?,?,?)');
        $pinned = !empty($_POST['is_pinned']) ? 1 : 0;
        $stmt->bind_param('ssssii', $_POST['title'], $_POST['content'], $_POST['type'], $_POST['target_role'], $pinned, $user['id']);
        $stmt->execute();
        flash('success', 'Announcement posted.');
        redirect('/modules/admin/announcements.php');
        break;

    case 'save_campus':
        requireRole(['admin','mis']);
        $stmt = $db->prepare('INSERT INTO campuses (code, name) VALUES (?,?)');
        $stmt->bind_param('ss', $_POST['code'], $_POST['name']);
        $stmt->execute();
        flash('success', 'Campus added.');
        redirect('/modules/mis/campuses.php');
        break;

    case 'save_course':
        requireRole(['admin','campus_admin','mis']);
        $inst = $_POST['institute_id'] ?: null;
        $stmt = $db->prepare('INSERT INTO courses (campus_id, institute_id, code, name, level) VALUES (?,?,?,?,?)');
        $stmt->bind_param('iisss', $_POST['campus_id'], $inst, $_POST['code'], $_POST['name'], $_POST['level']);
        $stmt->execute();
        flash('success', 'Course added.');
        redirect('/modules/campus/courses.php');
        break;

    case 'delete_record':
        requireRole(['admin']);
        $table = $_POST['table'] ?? '';
        $id = (int)($_POST['id'] ?? 0);
        $allowed = ['users','employees','students','finance_records','research_documents','announcements'];
        if (in_array($table, $allowed) && $id) {
            $db->query("DELETE FROM `$table` WHERE id = $id");
            auditLog('delete', $table, $id);
            flash('success', 'Record deleted.');
        }
        redirect($_POST['redirect'] ?? '/dashboard.php');
        break;

    default:
        flash('error', 'Unknown action.');
        redirect('/dashboard.php');
}
