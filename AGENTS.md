# Bankir Academy V3

Penyedia media pembelajaran untuk calon dan karyawan bank (online & offline).

## Tech stack

- **Backend:** Laravel 9.x (PHP ^8.0)
- **Frontend:** Blade + Bootstrap 5 + vanilla JS (no Vue/React)
- **Bundler:** Vite 3.x (`resources/sass/app.scss`, `resources/js/app.js`)
- **Auth:** Laravel UI scaffold, Sanctum (API tokens), Socialite (Google OAuth)
- **Payments:** DOKU (webhook at `POST /doku/notification`) + Tripay
- **Notable packages:** DOMPDF, Laravel Excel, Yajra DataTables, SweetAlert, Spatie Sitemap

## Commands

| Command | Purpose |
|---|---|
| `npm run dev` | Vite dev server (HMR) |
| `npm run build` | Build frontend assets |
| `php artisan serve` | Laravel dev server |
| `./vendor/bin/pint` | PHP CS fixer (Laravel Pint) |
| `./vendor/bin/phpunit` | Run tests (Unit + Feature) |
| `php artisan key:generate` | Set APP_KEY (needed after clone) |

## Architecture

- **View versions:** The frontend has been iterated — `homev3` is current (see `Front\HomeController::indexv2()`), but old versions (`homev2`, `kelasv2`, `profilev2`) remain in `resources/views/`. Keep them unless explicitly removing.
- **Helper autoload:** `app/Helper/GlobalHelper.php` is autoloaded via `composer.json` `files` — global functions like `saldo()`, `cekip()`, `reff()`, `namabulan()` are available everywhere.
- **API routes** (`routes/api.php`) are protected by `AksesByIpAddress` middleware — whitelist IPs via admin panel.
- **Admin routes** are grouped under `IsAdminRoot` middleware — only root users access `/admin/*`.
- **Database dumps** in repo root (`bankumul.sql`, `import db corporate.sql`) are not migrations — use them for reference.
- **Referral system** uses a multi-model pattern: `RefferralModel`, `RefferralPesertaModel`, `RefferralWithdrawModel`, `MasterRefferralModel`.
- **Wallet system** (`Dompet`, `MutasiDompet`, `PenarikanDana`) was the most recent addition (May 2026 migrations).
- **Certificates** are generated via DOMPDF (`barryvdh/laravel-dompdf`).

## Conventions

- **Routes** are defined in `routes/web.php` (~255 lines, one file) — no splitting into multiple route files.
- **Controllers** are organized by domain under `app/Http/Controllers/` (Admin/, Backend/, Front/, API/, Auth/, Loker/).
- **Models** are plain Eloquent models in `app/Models/` (38 models, no dedicated DTOs or repositories).
- **Middleware** `IsAdminRoot` and `AksesByIpAddress` are custom — check them before adding new admin/IP-gated routes.
- **SweetAlert** is used for flash messages from the base `Controller.php` — `alert()->success(...)->flash()`.

## Testing

- PHPUnit 9.x with Laravel defaults (Unit + Feature test suites).
- No integration/end-to-end tests; no CI pipeline configured.
- DB connection defaults to MySQL in `.env`; testing uses array cache/session (see `phpunit.xml`).

## ⚠️ Gotchas

- `.env` contains live credentials (Google OAuth, DOKU sandbox keys) — **do not commit**.
- `bankumul.sql` and `import db corporate.sql` are tracked in git — they are DB dumps, not migration seeds.
- Multiple frontend view directories exist for the same feature (e.g., `home/`, `homev2/`, `homev3/`) — know which version is active before editing.
- No `.github/workflows/` or CI — all verification is local.
