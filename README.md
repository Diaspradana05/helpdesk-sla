# Helpdesk SLA

Sistem ticketing dengan SLA tracking otomatis untuk tim support, dibangun dengan Laravel dan PostgreSQL. Mendukung role-based access, notifikasi real-time, audit log, dan dashboard analitik.

> Status: 🚧 Dalam pengembangan (Hari 1 dari 8)

## Fitur
- [ ] Role-based access (Admin, Agent, Customer)
- [ ] CRUD tiket dengan status workflow
- [ ] SLA tracking otomatis (first response & resolution)
- [ ] Komentar & catatan internal
- [ ] Notifikasi email & in-app
- [ ] Audit log / activity timeline
- [ ] Dashboard analitik dengan grafik
- [ ] REST API (Sanctum)
- [ ] Automated testing (Pest)
- [ ] Docker & CI/CD

## Tech Stack
- **Backend:** Laravel 12, PHP 8.3+
- **Database:** PostgreSQL 16
- **Frontend:** Tailwind CSS, Blade, Alpine.js
- **Auth:** Laravel Breeze, Spatie Permission
- **Testing:** Pest
- **Deployment:** Docker, GitHub Actions

## ERD
Lihat [docs/erd.md](docs/erd.md)

## Instalasi (lokal)
```bash
git clone https://github.com/USERNAME/helpdesk-sla.git
cd helpdesk-sla
composer install
cp .env.example .env
php artisan key:generate
# sesuaikan kredensial database di .env
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

## Akun Demo
| Role | Email | Password |
|---|---|---|
| Admin | admin@demo.test | password |
| Agent | agent1@demo.test | password |
| Customer | customer@demo.test | password |

## Live Demo
_(diisi setelah deployment — Hari 8)_

## Lisensi
MIT
