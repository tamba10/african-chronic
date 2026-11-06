# African Chronicle

African Chronicle is a PHP newsroom site connected to the African Chronicle News workspace in MemehCMS. The public site reads published articles and categories from the tenant-scoped MemehCMS JSON API. Editorial work stays in MemehCMS.

## Shared hosting

- PHP 8.2 or newer; no Composer or Node build is required.
- Upload the project files and folders to the hosting account's web root. Apache shared hosting uses `.htaccess` to prefer `index.php` and redirect the older `.html` URLs to their PHP pages.
- Keep PHP execution enabled. cURL is preferred; the API client falls back to PHP streams when cURL is unavailable.
- The API URL and public tenant UUID are set in `includes/cms.php`. The UUID is tenant scope, not a password. The website makes public GET requests only. Never place MemehCMS login credentials or private API tokens in website files.
- Ensure outbound HTTPS requests to `memehcms.com` are allowed by the host.

## Local preview

```sh
php -S 127.0.0.1:8084
```

Open `http://127.0.0.1:8084/`. No database or third-party PHP package is required.

## Main files

| Path | Purpose |
| --- | --- |
| `index.php` | CMS-driven homepage |
| `section.php` | Category pages, filtered by the CMS category slug |
| `article.php` | Published CMS article page, looked up by slug |
| `archive.php` | Server-side keyword, category, month and year filters |
| `about.php`, `advertise.php` | Publication information pages |
| `includes/cms.php` | Tenant-scoped MemehCMS public API client and output helpers |
| `includes/header.php`, `includes/footer.php` | Shared navigation and publication footer |
| `assets/site.css` | Responsive editorial design |
| `assets/images/` | Existing local site imagery |

The public API exposes published posts only. Drafts remain private and do not appear on the website until an editor publishes verified copy in MemehCMS. An empty feed is displayed as an honest first-edition state rather than sample reporting.
