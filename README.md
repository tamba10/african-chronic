# African Chronicle

African Chronicle is a PHP newsroom site connected to the African Chronicle News workspace in MemehCMS. The public site reads published articles and categories from the tenant-scoped MemehCMS JSON API. Editorial work stays in MemehCMS.

## Shared hosting

- PHP 8.2 or newer; no Composer or Node build is required.
- Upload the project files and folders to the hosting account's web root. Apache shared hosting uses `.htaccess` to prefer `index.php` and redirect the older `.html` URLs to their PHP pages.
- Keep PHP execution enabled. cURL is preferred; the API client falls back to PHP streams when cURL is unavailable.
- The API URL and public tenant UUID are set in `includes/cms.php`. The UUID is tenant scope, not a password. The website makes public GET requests only. Never place MemehCMS login credentials or private API tokens in website files.
- Ensure outbound HTTPS requests to `memehcms.com` are allowed by the host.

## Test locally

Requirements: PHP 8.2 or newer and outbound HTTPS access to `memehcms.com` for live category/article data. cURL is recommended; PHP streams are used as a fallback. No Composer, database, or Node install is needed.

From the project root, confirm PHP and start its built-in web server:

```sh
php -v
php -S localhost:8083
```

Open [http://localhost:8083/](http://localhost:8083/). Keep that terminal open while you browse. Stop the server with `Ctrl+C`.

Useful pages to check:

- Homepage: `http://localhost:8083/`
- Sierra Leone section: `http://localhost:8083/section.php?slug=african-chronicle-news-sierra-leone`
- News archive and filters: `http://localhost:8083/archive.php`
- About and advertising: `http://localhost:8083/about.php` and `http://localhost:8083/advertise.php`
- Article page: `http://localhost:8083/article.php?slug=<published-article-slug>`

The site reads published stories from the live MemehCMS public API. Drafts are private, so a new or empty workspace shows the first-edition message until an editor publishes reviewed reporting. A category URL with no stories should show the empty section state.

## Host it and share the public URL

This is PHP and needs a PHP-enabled shared host. GitHub stores the source but GitHub Pages cannot execute the PHP pages.

For a SiteGround/cPanel-style host, use the African Chronicle site's own document root (`public_html`):

1. Set the site's PHP version to 8.2 or newer and make sure outbound HTTPS requests to `memehcms.com` work.
2. In Site Tools → Site → File Manager, open that site's `public_html` folder. FTPS works as an alternative.
3. Upload the site files and folders from this repository root, keeping the layout intact: the PHP page files, `.htaccess`, `includes/`, and `assets/`. The `index.php` file must be directly inside `public_html`.
4. Make sure Apache `.htaccess` support is enabled. It sets `index.php` as the default page, redirects the old `.html` links, and blocks direct web requests to `includes/`.
5. Enable HTTPS for the African Chronicle domain. After upload, purge that site's Dynamic Cache if the previous page still appears.
6. Open the domain in a private browser window. Check the homepage, one category, the archive, and a missing article URL. Confirm the category menu loads from MemehCMS and that published articles appear after editorial review.
7. Share the verified HTTPS address, for example `https://<african-chronicle-domain>/`.

Use the African Chronicle site's own hosting document root. It is separate from `police.gov.sl`; do not upload these files into the police website. The public domain and SiteGround document root for African Chronicle still need to be confirmed before a hosted URL can be shared.

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
