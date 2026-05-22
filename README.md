# University Executive Dashboard

Vanilla PHP institutional dashboard for university presidents and staff — population monitoring, finance, research repository, and role-based data entry.

## Requirements

- XAMPP (Apache + MySQL + PHP 8+)
- phpMyAdmin (optional)

## Installation

1. Start **Apache** and **MySQL** in XAMPP.
2. Open: `http://localhost/university_dashboard/install.php`
3. After success, login at: `http://localhost/university_dashboard/`

## Demo Accounts

| Username | Role | Password |
|----------|------|----------|
| admin | Administrator | password123 |
| president | President (view-only) | password123 |
| registrar | Registrar | password123 |
| finance | Finance Officer | password123 |
| research | Research Department | password123 |
| hr | HR Department | password123 |
| depthead | Department Head | password123 |
| campusadmin | Campus Administrator | password123 |
| guidance | Guidance Office | password123 |
| mis | MIS Administrator | password123 |

## Modules

| Role | Functions |
|------|-----------|
| **President** | Executive dashboard, charts, population & finance overview (read-only) |
| **Admin** | Full access, user management, announcements, logs |
| **Registrar** | Enrollment stats per institute/semester, student records |
| **Finance** | Revenue, expenses, budget records |
| **Research** | Upload studies, research library |
| **HR** | All employee records |
| **Department Head** | Employees under their department only |
| **Campus Admin** | Campus employees & courses |
| **Guidance** | Student statistics & gender analytics |
| **MIS** | Campuses, system logs, maintenance |

## Campuses (seeded)

- MAIN Campus
- BTVC
- DRT Campus
- FFHNAS-CAMPUS

## Project Structure

```
config/          Database & app config
database/        schema.sql, seed.sql
includes/        Auth, layout, helpers
modules/         Role-specific UI pages
actions/         POST form handlers
assets/          CSS & JavaScript
uploads/research/ Document storage
```

## Security Notes

- Change all default passwords in production.
- Update `config/database.php` for production credentials.
- Restrict `install.php` access after setup.
