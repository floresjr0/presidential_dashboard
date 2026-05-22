<?php

function e(?string $s): string {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void {
    header('Location: ' . APP_URL . $path);
    exit;
}

function flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash(): ?array {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

function auditLog(string $action, string $module = '', ?int $recordId = null, string $details = ''): void {
    $db = getDB();
    $uid = $_SESSION['user_id'] ?? null;
    $username = $_SESSION['username'] ?? 'guest';
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $ua = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);
    $stmt = $db->prepare('INSERT INTO audit_logs (user_id, username, action, module, record_id, details, ip_address, user_agent) VALUES (?,?,?,?,?,?,?,?)');
    $stmt->bind_param('isssisss', $uid, $username, $action, $module, $recordId, $details, $ip, $ua);
    $stmt->execute();
}

function getCurrentAY(): ?array {
    $r = getDB()->query("SELECT * FROM academic_years WHERE is_current = 1 LIMIT 1");
    return $r ? $r->fetch_assoc() : null;
}

function getCampuses(): array {
    $rows = [];
    $r = getDB()->query("SELECT * FROM campuses WHERE status = 'active' ORDER BY name");
    while ($row = $r->fetch_assoc()) $rows[] = $row;
    return $rows;
}

function getInstitutes(?int $campusId = null): array {
    $db = getDB();
    if ($campusId) {
        $stmt = $db->prepare("SELECT i.*, c.name as campus_name FROM institutes i JOIN campuses c ON i.campus_id = c.id WHERE i.campus_id = ? ORDER BY i.name");
        $stmt->bind_param('i', $campusId);
        $stmt->execute();
        $r = $stmt->get_result();
    } else {
        $r = $db->query("SELECT i.*, c.name as campus_name FROM institutes i JOIN campuses c ON i.campus_id = c.id ORDER BY c.name, i.name");
    }
    $rows = [];
    while ($row = $r->fetch_assoc()) $rows[] = $row;
    return $rows;
}

function getDepartments(?int $instituteId = null): array {
    $db = getDB();
    if ($instituteId) {
        $stmt = $db->prepare("SELECT d.*, i.name as institute_name FROM departments d JOIN institutes i ON d.institute_id = i.id WHERE d.institute_id = ? ORDER BY d.name");
        $stmt->bind_param('i', $instituteId);
        $stmt->execute();
        $r = $stmt->get_result();
    } else {
        $r = $db->query("SELECT d.*, i.name as institute_name FROM departments d JOIN institutes i ON d.institute_id = i.id ORDER BY i.name, d.name");
    }
    $rows = [];
    while ($row = $r->fetch_assoc()) $rows[] = $row;
    return $rows;
}

function getSemesters(): array {
    $rows = [];
    $r = getDB()->query("SELECT * FROM semesters ORDER BY sort_order");
    while ($row = $r->fetch_assoc()) $rows[] = $row;
    return $rows;
}

function getAcademicYears(): array {
    $rows = [];
    $r = getDB()->query("SELECT * FROM academic_years ORDER BY year_label DESC");
    while ($row = $r->fetch_assoc()) $rows[] = $row;
    return $rows;
}

function getCourses(?int $campusId = null): array {
    $db = getDB();
    if ($campusId) {
        $stmt = $db->prepare("SELECT co.*, ca.name as campus_name FROM courses co JOIN campuses ca ON co.campus_id = ca.id WHERE co.campus_id = ? ORDER BY co.name");
        $stmt->bind_param('i', $campusId);
        $stmt->execute();
        $r = $stmt->get_result();
    } else {
        $r = $db->query("SELECT co.*, ca.name as campus_name FROM courses co JOIN campuses ca ON co.campus_id = ca.id ORDER BY ca.name, co.name");
    }
    $rows = [];
    while ($row = $r->fetch_assoc()) $rows[] = $row;
    return $rows;
}

function roleLabel(string $role): string {
    $labels = [
        'admin' => 'Administrator',
        'president' => 'President',
        'registrar' => 'Registrar',
        'finance' => 'Finance Officer',
        'research' => 'Research Department',
        'hr' => 'HR Department',
        'department_head' => 'Department Head',
        'campus_admin' => 'Campus Administrator',
        'guidance' => 'Guidance Office',
        'mis' => 'MIS Administrator',
    ];
    return $labels[$role] ?? $role;
}

function getDashboardStats(?int $campusFilter = null, ?int $ayFilter = null): array {
    $db = getDB();
    $campusWhere = $campusFilter ? " AND campus_id = $campusFilter" : '';
    $ay = $ayFilter ?: (getCurrentAY()['id'] ?? null);

    $stats = [
        'students' => 0, 'instructors' => 0, 'non_teaching' => 0, 'admin_staff' => 0,
        'enrolled' => 0, 'graduating' => 0, 'bascat' => 0, 'dropped' => 0, 'graduated' => 0,
        'male_students' => 0, 'female_students' => 0,
        'male_instructors' => 0, 'female_instructors' => 0,
        'male_staff' => 0, 'female_staff' => 0,
        'revenue' => 0, 'expenses' => 0, 'budget' => 0,
        'research_ongoing' => 0, 'research_completed' => 0, 'research_published' => 0,
        'by_campus' => [], 'by_institute' => [],
    ];

    // ── ENROLLMENT: prefer enrollment_stats if records exist for current AY ──
    $esWhere = $ay ? " AND academic_year_id = $ay" : '';
    if ($campusFilter) $esWhere .= " AND campus_id = $campusFilter";

    $esCheck = $db->query("SELECT COUNT(*) as c FROM enrollment_stats WHERE 1=1 $esWhere");
    $hasStats = (int)$esCheck->fetch_assoc()['c'] > 0;

    if ($hasStats) {
        // Pull aggregated counts from enrollment_stats
        $r = $db->query("SELECT 
            SUM(enrolled_count)   as enrolled,
            SUM(graduating_count) as graduating,
            SUM(bascat_count)     as bascat,
            SUM(drop_count)       as dropped,
            SUM(male_count)       as male_students,
            SUM(female_count)     as female_students
            FROM enrollment_stats WHERE 1=1 $esWhere");
        $row = $r->fetch_assoc();
        $stats['enrolled']        = (int)($row['enrolled'] ?? 0);
        $stats['graduating']      = (int)($row['graduating'] ?? 0);
        $stats['bascat']          = (int)($row['bascat'] ?? 0);
        $stats['dropped']         = (int)($row['dropped'] ?? 0);
        $stats['male_students']   = (int)($row['male_students'] ?? 0);
        $stats['female_students'] = (int)($row['female_students'] ?? 0);
        $stats['students']        = $stats['enrolled'] + $stats['graduating'] + $stats['bascat'];
    } else {
        // Fallback: count directly from students table
        $r = $db->query("SELECT COUNT(*) as c FROM students WHERE status != 'inactive' $campusWhere");
        $stats['students'] = (int)$r->fetch_assoc()['c'];

        $r = $db->query("SELECT status, COUNT(*) as c FROM students WHERE 1=1 $campusWhere GROUP BY status");
        while ($row = $r->fetch_assoc()) {
            if ($row['status'] === 'enrolled')   $stats['enrolled']   = (int)$row['c'];
            if ($row['status'] === 'graduating')  $stats['graduating'] = (int)$row['c'];
            if ($row['status'] === 'bascat')      $stats['bascat']     = (int)$row['c'];
            if ($row['status'] === 'dropped')     $stats['dropped']    = (int)$row['c'];
            if ($row['status'] === 'graduated')   $stats['graduated']  = (int)$row['c'];
        }

        $r = $db->query("SELECT gender, COUNT(*) as c FROM students WHERE status IN ('enrolled','graduating','bascat') $campusWhere GROUP BY gender");
        while ($row = $r->fetch_assoc()) {
            if ($row['gender'] === 'male')   $stats['male_students']   = (int)$row['c'];
            if ($row['gender'] === 'female') $stats['female_students'] = (int)$row['c'];
        }
    }

    $empWhere = $campusFilter ? " AND campus_id = $campusFilter" : '';
    $r = $db->query("SELECT employee_type, gender, COUNT(*) as c FROM employees WHERE status = 'active' $empWhere GROUP BY employee_type, gender");
    while ($row = $r->fetch_assoc()) {
        $c = (int)$row['c'];
        if ($row['employee_type'] === 'instructor') {
            $stats['instructors'] += $c;
            if ($row['gender'] === 'male') $stats['male_instructors'] += $c;
            if ($row['gender'] === 'female') $stats['female_instructors'] += $c;
        } elseif ($row['employee_type'] === 'non_teaching') {
            $stats['non_teaching'] += $c;
            if ($row['gender'] === 'male') $stats['male_staff'] += $c;
            if ($row['gender'] === 'female') $stats['female_staff'] += $c;
        } else {
            $stats['admin_staff'] += $c;
        }
    }

    $finWhere = $campusFilter ? " AND (campus_id = $campusFilter OR campus_id IS NULL)" : '';
    if ($ay) $finWhere .= " AND (academic_year_id = $ay OR academic_year_id IS NULL)";
    $r = $db->query("SELECT record_type, SUM(amount) as total FROM finance_records WHERE 1=1 $finWhere GROUP BY record_type");
    while ($row = $r->fetch_assoc()) {
        if ($row['record_type'] === 'revenue') $stats['revenue'] = (float)$row['total'];
        if ($row['record_type'] === 'expense') $stats['expenses'] = (float)$row['total'];
        if ($row['record_type'] === 'budget_allocation') $stats['budget'] = (float)$row['total'];
    }

    $resWhere = $campusFilter ? " AND (campus_id = $campusFilter OR campus_id IS NULL)" : '';
    $r = $db->query("SELECT status, COUNT(*) as c FROM research_documents WHERE status != 'archived' $resWhere GROUP BY status");
    while ($row = $r->fetch_assoc()) {
        if ($row['status'] === 'ongoing') $stats['research_ongoing'] = (int)$row['c'];
        if ($row['status'] === 'completed') $stats['research_completed'] = (int)$row['c'];
        if ($row['status'] === 'published') $stats['research_published'] = (int)$row['c'];
    }

    $r = $db->query("SELECT c.id, c.name, c.code,
        (SELECT COUNT(*) FROM students s WHERE s.campus_id = c.id AND s.status != 'inactive') as students,
        (SELECT COUNT(*) FROM employees e WHERE e.campus_id = c.id AND e.status = 'active') as employees
        FROM campuses c WHERE c.status = 'active' ORDER BY c.name");
    while ($row = $r->fetch_assoc()) $stats['by_campus'][] = $row;

    $r = $db->query("SELECT i.id, i.name, c.name as campus_name,
        (SELECT COUNT(*) FROM students s WHERE s.institute_id = i.id) as students
        FROM institutes i JOIN campuses c ON i.campus_id = c.id ORDER BY c.name, i.name");
    while ($row = $r->fetch_assoc()) $stats['by_institute'][] = $row;

    return $stats;
}

function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrf(): bool {
    $token = $_POST['csrf_token'] ?? '';
    return $token && hash_equals($_SESSION['csrf_token'] ?? '', $token);
}
