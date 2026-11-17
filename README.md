# E-Archive

![Laravel 13](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)
![PHP 8.3+](https://img.shields.io/badge/PHP-8.3%2B-777BB4?logo=php&logoColor=white)
![Vue 3](https://img.shields.io/badge/Vue-3-4FC08D?logo=vuedotjs&logoColor=white)
![TypeScript](https://img.shields.io/badge/TypeScript-3178C6?logo=typescript&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-06B6D4?logo=tailwindcss&logoColor=white)
![MariaDB](https://img.shields.io/badge/MariaDB-003545?logo=mariadb&logoColor=white)

**E-Archive** is a self-hosted web application that turns shelves of paper files into a searchable digital archive. Upload documents as PDFs, organize them into boxes, find them quickly by number, subject, date, or even the words written inside the file, and keep a clear record of who borrowed what and who changed what.

<!-- TODO: add a screenshot or two here, e.g. ![Dashboard](docs/screenshots/dashboard.png) -->

## Table of contents

- [About the project](#about-the-project)
- [Features](#features)
- [Tech stack](#tech-stack)
- [Roles and permissions](#roles-and-permissions)
- [Getting started](#getting-started)
    - [Requirements](#requirements)
    - [Download](#download)
    - [Install](#install)
    - [First login](#first-login)
    - [Configuration](#configuration)
- [Using E-Archive](#using-e-archive)
- [Running the tests](#running-the-tests)
- [Handy Sail commands](#handy-sail-commands)
- [Troubleshooting](#troubleshooting)
- [Deploying to production](#deploying-to-production)
- [Contributing](#contributing)
- [License](#license)
- [Acknowledgements](#acknowledgements)

## About the project

### Why it exists

Paper archives have the same problems almost everywhere:

- **Finding a document is slow.** Someone has to remember which box it is in and dig through it by hand.
- **Borrowed files get lost.** A document leaves the room and the only record is somebody's memory or a note on a desk.
- **There is no history.** When a file is moved, replaced, or thrown away, nothing says who did it or when.
- **Access is all or nothing.** Anyone who can open the cabinet can touch everything inside.

E-Archive was built to solve these problems with a simple system that an office can run on its own server: no per-user licenses, and no need to send private documents to a third-party service.

### What it is for

E-Archive is meant for any team that keeps important documents in physical boxes or folders and wants a digital counterpart: administrative and municipal offices, schools and universities, law firms, accounting and HR departments, associations, and NGOs.

A typical workflow looks like this:

1. Scan the paper document (or export it) as a PDF.
2. Create a box that matches the physical box where the original is stored.
3. Upload the PDF into the box with its number, subject, and date.
4. E-Archive extracts the text from the PDF, so the content becomes searchable too.
5. Staff find documents with search and date filters. Admins record when an original is lent out.
6. Every operation is written to the audit log.

### How it works

| Concept               | What it is                                                                                                   |
| --------------------- | ------------------------------------------------------------------------------------------------------------ |
| **Box**               | A container that groups documents, the digital twin of a physical archive box. One box holds many documents. |
| **Document**          | A PDF file with a number, subject, and date. Its text is extracted after upload so it can be searched.       |
| **Borrowed document** | A record of a document that was lent out: lender, borrower, document number, and date.                       |
| **Audit log entry**   | A record of one operation: who did it, when, and what was done.                                              |
| **Role**              | `sudo`, `admin`, or `user`. Decides what a person is allowed to do.                                          |

Laravel controllers hand data to Vue pages through Inertia.js, so the app feels like a single-page application without a separate REST API. See [Tech stack](#tech-stack) for the full list of tools.

## Features

- **PDF archiving.** Store every document as a PDF with its number, subject, and date.
- **Boxes.** Organize documents into boxes. Each box holds many documents.
- **Search.** Find documents by number, subject, or content.
- **Date range.** Narrow the results to documents between two dates.
- **Full-text search inside PDFs.** Text is extracted from the first two pages of every uploaded PDF ([configurable](#good-to-know-about-search)), so you can search for the words written in the document, not just its title.
- **Role-based access.** Three roles (`sudo`, `admin`, `user`) with different permissions.
- **Borrowing register.** Record the lender, the borrower, the document number, and the date whenever a document is lent out.
- **Audit log.** Every operation is saved with who did it, when it happened, and what was done.
- **Modern interface.** Vue 3, TypeScript, Tailwind CSS, and shadcn-vue.
- **Docker environment.** Runs on Laravel Sail with MariaDB. Nothing to install on your machine except Docker.
- **Tested.** Automated tests written with Pest.

## Tech stack

| Layer       | Technology                    | Role in the project                                                                    |
| ----------- | ----------------------------- | -------------------------------------------------------------------------------------- |
| Back end    | Laravel 13 (PHP 8.3+)         | Routing, validation, authorization, file storage, PDF text extraction, database access |
| Front end   | Vue 3, Inertia.js, TypeScript | Pages and components, connected to Laravel without a separate API                      |
| UI          | Tailwind CSS, shadcn-vue      | Styling and ready-made, accessible components                                          |
| Database    | MariaDB                       | Boxes, documents, borrowing records, users, entities and audit logs                    |
| Environment | Docker with Laravel Sail      | The same setup on every machine                                                        |
| Testing     | Pest                          | Automated tests                                                                        |

## Roles and permissions

| Capability                                | Sudo | Admin | User |
| ----------------------------------------- | :--: | :---: | :--: |
| View and search boxes and documents       |  ✅  |  ✅   |  ✅  |
| Add, edit, and revoke boxes and documents |  ✅  |  ✅   |  ❌  |
| Record borrowed documents                 |  ✅  |  ✅   |  ❌  |
| Assign roles to new users                 |  ✅  |  ❌   |  ❌  |
| Delete users                              |  ✅  |  ❌   |  ❌  |

- **Sudo** is the super administrator. It has full permission, including assigning a role to new users and deleting users. One sudo account is created automatically when the application is installed (see [First login](#first-login)).
- **Admin** has full permission over the archive (boxes, documents, borrowing, and the audit log) except assigning roles and deleting users.
- **User** is read-only. Users can view and search, nothing else.

## Getting started

### Requirements

- [Docker](https://docs.docker.com/get-docker/) (Recomended): Docker Desktop on macOS and Windows, or Docker Engine with the Compose plugin on Linux.
- [Git](https://git-scm.com/downloads), or you can download the project as a ZIP file.
- [PHP](https://www.php.net/downloads.php) >= 8.3
- [Node](https://nodejs.org/en/download) >= 22
- [Composer](https://getcomposer.org/download/)
- [Mariadb](https://mariadb.org/) (or MySQL)
- **Cup of coffee "Important"**

PDF text extraction needs `poppler-utils`, `tesseract-ocr`, `tesseract-ocr-eng`, and `tesseract-ocr-ara`. They are already installed in the Sail Dockerfile, so Sail users need to do nothing.

By default the app uses these ports on your machine: **80** (web app), **5173** (Vite dev server), and **3306** (MariaDB). If one of them is already taken, see [Troubleshooting](#troubleshooting).

### Download

Clone the repository:

```bash
git clone https://github.com/hayder-abbas/e-archive
cd e-archive
```

Prefer not to use Git? On the repository page choose **Code → Download ZIP**, extract it, and open a terminal inside the extracted folder.

### Configuration (development)

All settings live in the `.env` file at the project root. The ones you are most likely to change:

Typical database settings for the Sail MariaDB container:

```env
DB_CONNECTION=mariadb
DB_HOST=mariadb
DB_PORT=3306
DB_DATABASE=e_archive
DB_USERNAME=sail
DB_PASSWORD=password
```

`DB_HOST` must be `mariadb` (the name of the Docker service), not `127.0.0.1`, because the app runs inside a container.

> **Set these values before the first `sail up`.** MariaDB only reads them the first time its Docker volume is created, so changing them later makes the app and the existing database disagree. To start over with new values, run `./vendor/bin/sail down -v` (⚠️ this deletes all data) and then `./vendor/bin/sail up -d`.

### Install

Run these commands from the project folder.

```bash
# Create your environment file, generate key, migrate database, install and build resources
composer setup:dev

# Run the application
composer run dev

# Install sail (If you want to use docker)
php artisan sail:install

# Start the containers (the first run builds the images and can take a few minutes)
./vendor/bin/sail up -d

# Run the application
composer run dev
```

Open <http://localhost> in your browser. You should see the login page.

> **Tip: shorter commands.** Add this alias to `~/.bashrc` or `~/.zshrc`, restart your terminal, and type `sail` instead of `./vendor/bin/sail`:
>
> ```bash
> alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
> ```

### First login

A **sudo** account is created automatically during installation:

| Field    | Value                   |
| -------- | ----------------------- |
| URL      | <http://localhost:8000> |
| Email    | `admin@mail.com`        |
| Password | `admin123`              |

> **⚠️ Change this password right after your first login.** These credentials are public: they are written in this README. Never put an installation on the internet before changing them.

## Using E-Archive

1. **Sign in** with your account. New users receive their role from a sudo user.
2. **Create a box** for each physical box or folder (admin and sudo).
3. **Add documents** to a box: upload the PDF and fill in its number, subject, and date (admin and sudo).
4. **Search** by name, number, subject, or content, and optionally set a from/to date to narrow the results. Everyone can search.
5. **Record a borrowed document** with the lender, borrower, document number, and date (admin and sudo).
6. **Review the audit log** to see who did what and when (admin and sudo).
7. **Manage users.** Only sudo can assign roles to new users and delete users.

### Good to know about search

**E-Archive does not read the text embedded in a PDF.** Every uploaded PDF, whether it contains real text or only scanned images, is converted to images with pdftoppm (from poppler-utils) and read with Tesseract OCR. Searching by content therefore works the same way for all files.

**Only the first two pages are scanned.** This keeps processing fast and the database small, and the first pages usually hold the most important information. Content that appears only on later pages will not be found by search. To change this, open app/Services/PdfOcr.php and edit or remove the -l 2 option.
**Languages:** English and Arabic.
**Speed:** OCR is slower than reading embedded text, so large PDFs take longer to process.
**Quality:** results depend on the image quality, so clear, straight, high-resolution documents give the best results.

## Running the tests

The test suite is written with [Pest](https://pestphp.com).

```bash
./vendor/bin/sail test
```

Any Pest option can be added after the command, for example `./vendor/bin/sail test --filter="your test name"`.

## Handy Sail commands

The examples assume you set up the `sail` alias shown in [Install](#install).

| Task                                       | Command                  |
| ------------------------------------------ | ------------------------ |
| Start the containers                       | `sail up -d`             |
| Stop the containers                        | `sail stop`              |
| Remove the containers (your data is kept)  | `sail down`              |
| Remove the containers **and the database** | `sail down -v`           |
| Run an Artisan command                     | `sail artisan <command>` |
| Open a shell in the app container          | `sail root-shell`        |
| Open Tinker                                | `sail tinker`            |
| Run the tests                              | `sail test`              |
| Build the front-end assets                 | `sail npm run build`     |
| Start the Vite dev server                  | `sail npm run dev`       |
| Start with composer                        | `sail composer run dev`  |
| Rebuild the Docker images                  | `sail build --no-cache`  |

## Troubleshooting

**`./vendor/bin/sail: No such file or directory`**
The PHP dependencies are not installed yet. [Install](#install).

**`SQLSTATE[HY000] [2002] Connection refused` while migrating**
MariaDB needs a few seconds to start after `sail up`. Wait a moment and try again. Also check that `DB_HOST=mariadb` in `.env`.

**`Access denied` for the database user**
The credentials in `.env` do not match the ones the MariaDB volume was created with. Restore the original values, or reset the database with `./vendor/bin/sail down -v` (⚠️ this deletes all data) and start again.

**`Vite manifest not found`**
The front-end assets have not been built. Run `./vendor/bin/sail npm run build`, or keep `./vendor/bin/sail npm run dev` running while you develop.

**Permission denied on `storage/` or `bootstrap/cache/`**
Make them writable: `chmod -R ug+rwx storage bootstrap/cache`.

**A PDF fails to upload**
It is probably larger than the PHP upload limit. Raise `upload_max_filesize` and `post_max_size` in `php.ini`. With Sail: run `./vendor/bin/sail artisan sail:publish`, edit the `php.ini` inside the new `docker/` folder, then run `./vendor/bin/sail build --no-cache` and `./vendor/bin/sail up -d`.

**Search does not find words that are inside a PDF**
The scan may be too blurry, skewed, or low-resolution for OCR to read, or the text is in a language other than English or Arabic, and only the first two pages are indexed ([here](#good-to-know-about-search)). Re-scan at a higher quality (300 DPI is a good target). To add a language, install its package (for example tesseract-ocr-fra) in the Dockerfile and rebuild with ./vendor/bin/sail build --no-cache.

## Deploying to production

Sail is built for local development. For a live server, run the app with PHP-FPM behind Nginx or Apache (or with your own production container image) and follow this checklist:

Run this command to set everything up automatically.

```bash
composer setup:prod
```

Or setup manually

```bash
# Create the environment file
cp .env.example .env
```

- Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`.
- Change the default sudo password and use strong database credentials.
- Make sure PHP and your web server accept the PDF sizes you expect (`upload_max_filesize`, `post_max_size`, and `client_max_body_size` on Nginx).
- Back up the database and the `storage/app/private/` directory regularly. Your archive lives in both.

Typical deployment commands:

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
# first deployment only: creates the default sudo account
php artisan db:seed --class=UserSeeder --force
npm ci && npm run build
php artisan optimize
```

## Contributing

Contributions are welcome.

1. Fork the repository and create a branch: `git checkout -b feature/my-change`.
2. Make your changes and add or update tests.
3. Run `./vendor/bin/sail test` and make sure everything passes.
4. Open a pull request that explains what you changed and why.

Found a bug or have an idea? Please open an issue.

## License

Released under the [GPL License](LICENSE).

## Acknowledgements

E-Archive is built on these open-source projects:

- [Laravel](https://laravel.com) and [Laravel Sail](https://laravel.com/docs/13.x/sail)
- [Inertia.js](https://inertiajs.com)
- [Vue.js](https://vuejs.org)
- [Tailwind CSS](https://tailwindcss.com)
- [shadcn-vue](https://www.shadcn-vue.com)
- [MariaDB](https://mariadb.org)
- [Pest](https://pestphp.com)
