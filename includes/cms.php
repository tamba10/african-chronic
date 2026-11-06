<?php
declare(strict_types=1);

/* Public, tenant-scoped read access to MemehCMS. No CMS credentials belong here. */
const AC_CMS_API = 'https://memehcms.com';
const AC_CMS_TENANT = '01a1af44-6743-7102-87a8-091dfccd2394';

function ac_api(string $endpoint, array $query = []): array
{
    static $cache = [];
    $query = ['tenant_id' => AC_CMS_TENANT] + $query;
    $url = AC_CMS_API.'/api/'.ltrim($endpoint, '/').'?'.http_build_query($query);
    if (isset($cache[$url])) return $cache[$url];

    $body = false;
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_TIMEOUT => 6,
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
            CURLOPT_USERAGENT => 'AfricanChronicleWeb/1.0',
        ]);
        $result = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        if ($status >= 200 && $status < 300 && is_string($result)) $body = $result;
    } else {
        $context = stream_context_create(['http' => [
            'method' => 'GET', 'timeout' => 6, 'ignore_errors' => true,
            'header' => "Accept: application/json\r\nUser-Agent: AfricanChronicleWeb/1.0\r\n",
        ]]);
        $result = @file_get_contents($url, false, $context);
        $statusLine = $http_response_header[0] ?? '';
        if (is_string($result) && preg_match('/\s2\d\d\s/', $statusLine)) $body = $result;
    }

    $payload = is_string($body) ? json_decode($body, true) : null;
    return $cache[$url] = is_array($payload) ? $payload : [];
}

function ac_rows(string $endpoint, array $query = []): array
{
    $payload = ac_api($endpoint, $query);
    $data = $payload['data'] ?? [];
    return is_array($data) ? array_values(array_filter($data, 'is_array')) : [];
}

function ac_categories(): array
{
    return ac_rows('categories', ['per_page' => 100]);
}

function ac_articles(): array
{
    return ac_rows('articles', ['per_page' => 100, 'include' => 'category,feature,tags']);
}

function ac_article(string $slug): array
{
    if ($slug === '') return [];
    $payload = ac_api('articles/'.rawurlencode($slug), ['include' => 'category,feature,tags']);
    return is_array($payload['data'] ?? null) ? $payload['data'] : [];
}

function ac_e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function ac_category_name(array $article): string
{
    return (string) ($article['category']['name'] ?? 'News');
}

function ac_category_slug(array $article): string
{
    return (string) ($article['category']['slug'] ?? '');
}

function ac_article_url(array $article): string
{
    return 'article.php?slug='.rawurlencode((string) ($article['slug'] ?? ''));
}

function ac_category_url(array $category): string
{
    return 'section.php?slug='.rawurlencode((string) ($category['slug'] ?? ''));
}

function ac_date(array $article): string
{
    $value = (string) ($article['published_at'] ?? '');
    if ($value === '') return '';
    try { return (new DateTimeImmutable($value))->format('j F Y'); }
    catch (Throwable) { return ''; }
}

function ac_image(array $article): string
{
    $url = (string) ($article['feature']['url'] ?? '');
    return $url !== '' ? $url : '';
}

function ac_safe_body(string $html): string
{
    $allowed = '<p><br><strong><b><em><i><h2><h3><ul><ol><li><blockquote><a><figure><figcaption><img>';
    $clean = strip_tags($html, $allowed);
    $clean = preg_replace("/\\s+(?:on[a-z]+|style)\\s*=\\s*(?:\"[^\"]*\"|'[^']*'|[^\\s>]+)/iu", '', $clean) ?? $clean;
    $clean = preg_replace('/\b(href|src)\s*=\s*(?:"\s*(?:javascript|data):[^"]*"|\'\s*(?:javascript|data):[^\']*\'|(?:javascript|data):[^\s>]+)/iu', '$1="#"', $clean) ?? $clean;
    return $clean;
}

function ac_display_name(): string
{
    return trim((string) ($_SERVER['AC_CMS_STATUS'] ?? ''));
}
