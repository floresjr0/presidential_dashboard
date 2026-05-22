-- Seed data for University Dashboard
USE university_dashboard;

INSERT INTO campuses (code, name) VALUES
('MAIN', 'MAIN Campus'),
('BTVC', 'BTVC'),
('DRT', 'DRT Campus'),
('FFHNAS', 'FFHNAS-CAMPUS');

INSERT INTO institutes (campus_id, code, name) VALUES
(1, 'CAS', 'College of Arts and Sciences'),
(1, 'CET', 'College of Engineering and Technology'),
(1, 'CBM', 'College of Business and Management'),
(2, 'BTVC-IT', 'BTVC Institute of Technology'),
(3, 'DRT-ED', 'DRT College of Education'),
(4, 'FFHNAS-HS', 'FFHNAS Health Sciences');

INSERT INTO departments (institute_id, code, name) VALUES
(1, 'MATH', 'Mathematics Department'),
(1, 'ENG', 'English Department'),
(2, 'CSE', 'Computer Science'),
(2, 'CE', 'Civil Engineering'),
(3, 'ACC', 'Accountancy'),
(4, 'IT', 'Information Technology'),
(5, 'EDU', 'Education'),
(6, 'NUR', 'Nursing');

INSERT INTO academic_years (year_label, is_current) VALUES
('2023-2024', 0),
('2024-2025', 0),
('2025-2026', 1);

INSERT INTO semesters (name, sort_order) VALUES
('First Semester', 1),
('Second Semester', 2),
('Midyear', 3);

INSERT INTO courses (campus_id, institute_id, code, name) VALUES
(1, 1, 'BS-MATH', 'BS Mathematics'),
(1, 2, 'BS-CSE', 'BS Computer Science'),
(1, 2, 'BS-CE', 'BS Civil Engineering'),
(1, 3, 'BSBA', 'BS Business Administration'),
(2, 4, 'BSIT', 'BS Information Technology'),
(3, 5, 'BEED', 'Bachelor of Elementary Education'),
(4, 6, 'BSN', 'BS Nursing');

-- Default password for all: password123
INSERT INTO users (username, password, full_name, email, role, campus_id, institute_id, department_id) VALUES
('admin', '$2y$10$xrz1Ao20n0DWkX0mCPot1ewGnUBbvdTv9HSR3bb4TIp88.5SThEJ.', 'System Administrator', 'admin@university.edu', 'admin', NULL, NULL, NULL),
('president', '$2y$10$xrz1Ao20n0DWkX0mCPot1ewGnUBbvdTv9HSR3bb4TIp88.5SThEJ.', 'University President', 'president@university.edu', 'president', NULL, NULL, NULL),
('registrar', '$2y$10$xrz1Ao20n0DWkX0mCPot1ewGnUBbvdTv9HSR3bb4TIp88.5SThEJ.', 'Registrar Officer', 'registrar@university.edu', 'registrar', NULL, NULL, NULL),
('finance', '$2y$10$xrz1Ao20n0DWkX0mCPot1ewGnUBbvdTv9HSR3bb4TIp88.5SThEJ.', 'Finance Officer', 'finance@university.edu', 'finance', NULL, NULL, NULL),
('research', '$2y$10$xrz1Ao20n0DWkX0mCPot1ewGnUBbvdTv9HSR3bb4TIp88.5SThEJ.', 'Research Director', 'research@university.edu', 'research', NULL, NULL, NULL),
('hr', '$2y$10$xrz1Ao20n0DWkX0mCPot1ewGnUBbvdTv9HSR3bb4TIp88.5SThEJ.', 'HR Manager', 'hr@university.edu', 'hr', NULL, NULL, NULL),
('depthead', '$2y$10$xrz1Ao20n0DWkX0mCPot1ewGnUBbvdTv9HSR3bb4TIp88.5SThEJ.', 'CSE Department Head', 'depthead@university.edu', 'department_head', 1, 2, 3),
('campusadmin', '$2y$10$xrz1Ao20n0DWkX0mCPot1ewGnUBbvdTv9HSR3bb4TIp88.5SThEJ.', 'MAIN Campus Admin', 'campus@university.edu', 'campus_admin', 1, NULL, NULL),
('guidance', '$2y$10$xrz1Ao20n0DWkX0mCPot1ewGnUBbvdTv9HSR3bb4TIp88.5SThEJ.', 'Guidance Counselor', 'guidance@university.edu', 'guidance', NULL, NULL, NULL),
('mis', '$2y$10$xrz1Ao20n0DWkX0mCPot1ewGnUBbvdTv9HSR3bb4TIp88.5SThEJ.', 'MIS Administrator', 'mis@university.edu', 'mis', NULL, NULL, NULL);

-- Sample employees
INSERT INTO employees (employee_id, full_name, gender, employee_type, campus_id, institute_id, department_id, position, status) VALUES
('EMP-001', 'Dr. Juan Dela Cruz', 'male', 'instructor', 1, 2, 3, 'Professor', 'active'),
('EMP-002', 'Maria Santos', 'female', 'instructor', 1, 2, 3, 'Associate Professor', 'active'),
('EMP-003', 'Pedro Reyes', 'male', 'non_teaching', 1, 2, 3, 'Department Secretary', 'active'),
('EMP-004', 'Ana Lopez', 'female', 'instructor', 1, 1, 1, 'Instructor', 'active'),
('EMP-005', 'Carlos Mendoza', 'male', 'administrative', 1, NULL, NULL, 'Campus Coordinator', 'active');

-- Sample students
INSERT INTO students (student_id, full_name, gender, campus_id, institute_id, department_id, course_id, year_level, status) VALUES
('2025-0001', 'John Student', 'male', 1, 2, 3, 2, 3, 'enrolled'),
('2025-0002', 'Jane Student', 'female', 1, 2, 3, 2, 4, 'graduating'),
('2025-0003', 'Mark Applicant', 'male', 1, 2, 3, 2, 1, 'bascat'),
('2025-0004', 'Lisa Dropout', 'female', 1, 1, 1, 1, 2, 'dropped'),
('2025-0005', 'Amy Nurse', 'female', 4, 6, 6, 7, 2, 'enrolled');

INSERT INTO enrollment_stats (academic_year_id, semester_id, campus_id, institute_id, enrolled_count, graduating_count, bascat_count, drop_count, male_count, female_count, recorded_by) VALUES
(3, 1, 1, 2, 450, 85, 120, 15, 220, 230, 3),
(3, 1, 1, 1, 280, 45, 60, 8, 130, 150, 3),
(3, 1, 2, 4, 180, 30, 40, 5, 95, 85, 3);

INSERT INTO finance_records (record_type, title, amount, record_date, campus_id, category, description, academic_year_id, recorded_by) VALUES
('revenue', 'Tuition Fees - January', 2500000.00, '2025-01-15', 1, 'Tuition', 'First semester collection', 3, 4),
('expense', 'Faculty Salaries - January', 1800000.00, '2025-01-31', NULL, 'Payroll', 'Monthly payroll', 3, 4),
('revenue', 'Laboratory Fees', 150000.00, '2025-02-10', 1, 'Fees', 'Lab fees collection', 3, 4),
('budget_allocation', 'Research Fund Q1', 500000.00, '2025-01-01', NULL, 'Research', 'Quarterly allocation', 3, 4);

INSERT INTO research_documents (title, authors, abstract, status, campus_id, department_id, academic_year_id, uploaded_by) VALUES
('AI in Education', 'Dr. Juan Dela Cruz', 'Study on AI integration in classroom', 'ongoing', 1, 3, 3, 5),
('Sustainable Engineering', 'Maria Santos', 'Green building materials research', 'completed', 1, 3, 3, 5),
('Student Wellness Program', 'Ana Lopez', 'Mental health support framework', 'published', 1, 1, 3, 5);

INSERT INTO announcements (title, content, type, target_role, is_pinned, posted_by) VALUES
('Welcome AY 2025-2026', 'Academic year 2025-2026 has officially started. All departments please submit enrollment data.', 'announcement', 'all', 1, 1),
('Enrollment Deadline', 'Final enrollment submission deadline: May 30, 2026', 'deadline', 'registrar', 0, 1);
