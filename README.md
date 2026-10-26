# Campus Safe Report & Incident Management System (CSRIMS)

A CRUD web app for anonymous/identified campus incident reporting, built with
**PHP + MySQL + XAMPP**. No JavaScript is used anywhere in this project — all
interactivity is done through plain HTML forms, PHP server-side logic, and CSS.

Persona: **Kael Tan**, Student Council Leader & Gender Rights Advocate — this system
exists so students can safely report bullying/harassment without fear of retaliation,
and so student leaders/admins can track and resolve cases.

---

## 1. Prerequisites

- [XAMPP](https://www.apachefriends.org/) installed (Apache + MySQL + PHP)
- [VS Code](https://code.visualstudio.com/) installed
- (Optional but recommended) VS Code extensions: **PHP Intelephense**, **PHP Debug**

## 2. Install the project into XAMPP

1. Locate your XAMPP `htdocs` folder:
   - Windows: `C:\xampp\htdocs`
   - macOS: `/Applications/XAMPP/htdocs`
   - Linux: `/opt/lampp/htdocs`
2. Copy the entire `csrims` folder from this download into `htdocs`, so you end up with:
   `htdocs/csrims/...`
3. Open that `csrims` folder in **VS Code** (`File > Open Folder`).

## 3. Start XAMPP

1. Open the XAMPP Control Panel.
2. Click **Start** next to **Apache**.
3. Click **Start** next to **MySQL**.

## 4. Create the database

1. Open your browser to `http://localhost/phpmyadmin`.
2. Click **Import**.
3. Choose the file `csrims/database/csrims.sql` from this project.
4. Click **Go**. This creates the `csrims_db` database with all 7 tables
   (`roles`, `users`, `students`, `categories`, `incidents_reports`, `attachments`,
   `case_logs`) and seeds the 3 roles + starter categories.

> If your MySQL root user has a password (most default XAMPP installs don't),
> update `config/db.php` with your credentials.

## 5. Create your first Administrator account

1. In your browser, go to `http://localhost/csrims/database/create_admin.php`.
2. Enter an email and password for the admin account and submit.
3. **Delete or rename `database/create_admin.php` afterward** — it should not stay
   publicly accessible once the admin account exists (it already blocks itself once
   one admin exists, but removing it is safer).

## 6. Run the system

1. Go to `http://localhost/csrims/` in your browser.
2. Log in with the admin account you just created, or click **Create an account**
   to register as a student.
3. As admin: go to **Users** to create Council accounts (students self-register;
   council/admin accounts are created by an admin).

## 7. How the roles work

| Role | Can do |
|---|---|
| **Student** | Register/login, submit incident reports (optionally anonymous), attach evidence, view own identified reports, check any report's status via a reference code |
| **Council** | View/search/filter all reports, update status, add case log entries |
| **Admin** | Everything Council can do, plus manage users/roles, manage categories, view analytics, export CSV reports |

## 8. Anonymity guarantee

When a student checks "Submit this report anonymously," `student_id` is stored as
`NULL` in `incidents_reports` — no identity is saved anywhere for that report. The
student instead receives a **report reference code** (shown once after submission)
that they can use on the public "Check Status" page to track their case without
ever logging in or being identified.

## 9. No-JavaScript design notes

- All page interactivity (forms, filters, status updates, role changes) is done via
  standard HTML forms and full-page PHP `POST`/`GET` requests.
- The dashboard "charts" are CSS bars whose width is calculated and echoed by PHP —
  no JS charting library involved.
- The evidence-attachments list uses a native `<details>/<summary>` element for
  expand/collapse — no JS toggle needed.
- CSV export uses PHP's `fputcsv()` streamed with download headers — no JS-triggered
  file download.

## 10. Folder structure

```
csrims/
├── config/db.php
├── includes/            (header, footer, navbar, auth guard)
├── assets/css/style.css
├── uploads/evidence/    (uploaded evidence files)
├── auth/                (login, register, logout)
├── student/              (dashboard, submit report, my reports, check status)
├── council/              (dashboard, manage reports, update status, case logs)
├── admin/                (dashboard, manage users, manage categories, analytics, export)
├── database/csrims.sql   (schema + seed data)
├── database/create_admin.php (one-time admin setup script)
└── index.php
```
