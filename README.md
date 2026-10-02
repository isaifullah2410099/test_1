run commands:

If you want to make sure the database is ready first, you can optionally run:
php -m | grep -i mysqli

Then:
mysql -h db -u uiu -puiu123 uiu_collabhub -e "SHOW TABLES;"

Then start the site:
php -S 0.0.0.0:8000


push changes:

before pushing the changes add these:

sudo apt-get update
sudo apt-get install -y git-lfs

then these:

git add .
git commit -m "describe what you changed"
git push

then check:

git status


## Login

Username: `admin`

Password: `1234`

011223344 / 123456
011223355 / 123456
011223366 / 123456

blue











# UIU CollabHub

A simple class project made with HTML, CSS, JavaScript, PHP and MySQL/MariaDB.

The idea is a student collaboration website where students can post projects, research work or freelance gigs, apply with a proposal, form teams and show portfolio work.

> This is a student class project and is not an official United International University website.

## Main Features

- Student registration with duplicate Student ID check
- Student login
- Simple forgot-password system using a security question
- Admin login using `admin` / `1234`
- Home page with recent projects
- Explore/search projects
- Post a project, research work or freelance gig
- Skill tags saved as simple comma-separated text
- Send a project proposal
- Project owner can accept or reject applicants
- Student dashboard
- Student profile and portfolio
- Admin can edit/delete users
- Admin can edit/delete projects



# Method 1 - GitHub Codespaces

No `npm install`, `npm run` or build command is needed. This is a plain PHP project.

## 1. Put the project on GitHub

1. Create a new GitHub repository.
2. Upload all files from this folder to the repository.
3. Make sure the hidden `.devcontainer` folder is also uploaded.

## 2. Create a Codespace

On the GitHub repository page:

1. Click **Code**.
2. Click **Codespaces**.
3. Click **Create codespace on main**.

The `.devcontainer` folder will create:

- PHP environment
- `mysqli` PHP extension
- MariaDB database service
- `uiu_collabhub` database
- Tables from `database.sql`

## 3. Start the PHP website

When the Codespace opens, open **Terminal** and run:

```bash
php -S 0.0.0.0:8000
```

You should see a message saying the PHP development server started.

Open the **Ports** tab in Codespaces and open port **8000** in the browser.

There is no npm command in this project.

## 4. First test

1. Register a new student account.
2. Login using that Student ID and password.
3. Post a project.
4. Register a second student and apply to that project.
5. Login as the first student and accept/reject the application.
6. Logout and login with `admin` / `1234` to test the admin panel.

## Database check in Codespaces

If you want to see whether MariaDB is running, use:

```bash
mysql -h db -u uiu -puiu123 -e "SHOW DATABASES;"
```

To see the tables:

```bash
mysql -h db -u uiu -puiu123 uiu_collabhub -e "SHOW TABLES;"
```

If the database container is still starting when you first open the site, wait a few seconds and refresh the page.

---

# Method 2 - XAMPP on Windows

## 1. Copy the project

Copy the `uiu-collabhub` folder into:

```text
C:\xampp\htdocs\
```

So the final folder becomes:

```text
C:\xampp\htdocs\uiu-collabhub\
```

## 2. Start XAMPP

Open XAMPP Control Panel and start:

- Apache
- MySQL

## 3. Import the database

Open:

```text
http://localhost/phpmyadmin
```

Then:

1. Click **Import**.
2. Choose `database.sql` from this project.
3. Run the import.

The SQL file creates the `uiu_collabhub` database and all four tables.

## 4. Open the website

Open:

```text
http://localhost/uiu-collabhub/
```

`db.php` automatically uses the normal XAMPP settings:

- Server: `localhost`
- User: `root`
- Password: empty
- Database: `uiu_collabhub`

If your XAMPP MySQL root account has a password, change the default password inside `db.php`.

---

# Database Tables

The project uses only four main tables:

1. `users`
2. `projects`
3. `applications`
4. `portfolio`

This was kept small on purpose so the code is easier to understand and explain in class.

# Files to Understand First

If you are preparing for a class demonstration, read these files first:

1. `index.php` - login and admin check
2. `register.php` - registration and duplicate Student ID check
3. `db.php` - database connection
4. `create_project.php` - inserts a new project
5. `project_details.php` - displays one project
6. `apply.php` - sends a proposal
7. `manage_applications.php` - project owner sees applicants
8. `update_application.php` - accepts/rejects an applicant
9. `admin_users.php` - admin user list
10. `admin_projects.php` - admin project list

# Notes

- Code comments are included around the important sections.
- The PHP style is intentionally simple: `if/else`, `$_POST`, `$_GET`, `mysqli`, loops and normal SQL queries.
- Passwords are stored using PHP's `password_hash()` instead of plain text.
- The admin password is intentionally simple and hard-coded only for the class demo.
