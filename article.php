<?php
require __DIR__.'/includes/cms.php';
$slug = trim((string) ($_GET['slug'] ?? $_GET['id'] ?? ''));
$story = ac_article($slug);
if (!$story) { http_response_code(404); }
$categoryName = $story ? ac_category_name($story) : 'News';
$pageTitle = $story ? (string) ($story['title'] ?? 'Article') : 'Story not found';
$pageDescription = $story ? (string) ($story['summary'] ?? '') : 'This story could not be found.';
$related = array_values(array_filter(ac_articles(), fn ($item) => $story && (string) ($item['slug'] ?? '') !== (string) ($story['slug'] ?? '') && (string) ($item['category']['slug'] ?? '') === ac_category_slug($story)));
require __DIR__.'/includes/head.php'; require __DIR__.'/includes/header.php';
?>
<main class="article-wrap">
<?php if (!$story): ?><nav class="breadcrumbs"><a href="index.php">Home</a> / Story not found</nav><div class="empty-state"><h1>Story not found</h1><p>This story may have been removed or is no longer available.</p><a class="text-link" href="archive.php">Browse the news archive</a></div>
<?php else: ?><nav class="breadcrumbs"><a href="index.php">Home</a> / <a href="section.php?slug=<?= rawurlencode(ac_category_slug($story)) ?>"><?= ac_e($categoryName) ?></a></nav>
<header class="article-head"><div class="eyebrow"><?= ac_e($categoryName) ?></div><h1><?= ac_e($story['title'] ?? '') ?></h1><p class="standfirst"><?= ac_e($story['summary'] ?? '') ?></p><div class="article-meta"><?= ac_e(ac_date($story)) ?></div></header>
<?php if ($image = ac_image($story)): ?><img class="article-hero" src="<?= ac_e($image) ?>" alt=""><?php endif ?>
<div class="article-tools"><button id="share-story" type="button">Share story</button><button id="print-story" type="button">Print</button></div>
<div class="article-body-grid"><article class="article-body"><?= ac_safe_body((string) ($story['body_html'] ?? '')) ?></article><aside class="article-aside"><div class="sidebar-block"><h2>Related stories</h2><ol class="top-list"><?php foreach (array_slice($related, 0, 5) as $item): ?><li><a href="<?= ac_e(ac_article_url($item)) ?>"><?= ac_e($item['title'] ?? '') ?></a></li><?php endforeach ?></ol><?php if (!$related): ?><p>More reporting in this section will appear here.</p><?php endif ?></div></aside></div>
<?php endif ?></main>
<?php require __DIR__.'/includes/footer.php'; ?><script src="assets/site.js"></script>
