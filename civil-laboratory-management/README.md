# Civil Laboratory & Instrument Management SaaS

A Laravel-based SaaS starter project for civil engineering laboratories that manage projects, samples, test methods, test execution, instrument inventory, calibration records, and role-based access.

## Core modules

- **SaaS tenancy:** Every operational record includes `tenant_id` so each laboratory account has isolated users, projects, samples, tests, instruments, and calibration history.
- **Role-based access control:** Owner, admin, lab manager, technician, store keeper, and client roles are seeded and enforced with `role` middleware.
- **Civil project tracking:** Capture client, site, project code, contact, dates, and status.
- **Sample and lab testing workflow:** Link samples to civil projects, schedule tests by method, assign technicians and instruments, and update reviewed results.
- **Instrument management:** Register instruments, track status, locations, maintenance notes, due dates, and calibration certificates.
- **Dashboard:** Displays operational metrics for projects, samples, pending tests, and calibration due within 30 days.

## Quick start

```bash
composer install
cp .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate --seed
php artisan serve
```

Demo credentials after seeding:

- Email: `owner@example.test`
- Password: `password`

## Suggested next features

1. Add Laravel Breeze or Jetstream authentication scaffolding.
2. Add report PDF generation with QR-code certificate verification.
3. Add instrument issue/return workflows for store keepers.
4. Add subscription billing integration for the SaaS plans.
5. Add client portal screens for approved reports only.
