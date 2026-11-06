<?php
require __DIR__.'/includes/cms.php';
$categories = ac_categories();
$slug = trim((string) ($_GET['slug'] ?? ''));
$category = null;
foreach ($categories as $item) if ($slug !== '' && (string) ($item['slug'] ?? '') === $slug) { $category = $item; break; }
if (!$category && isset($_GET['section'])) {
    foreach ($categories as $item) if (strcasecmp((string) ($item['name'] ?? ''), (string) $_GET['section']) === 0) { $category = $item; break; }
}
$title = (string) ($category['name'] ?? 'All sections');
$articles = ac_articles();
if ($category) $articles = array_values(array_filter($articles, fn ($story) => (string) ($story['category']['slug'] ?? '') === (string) $category['slug']));
$pageTitle = $title.' news';
$pageDescription = 'Reporting and analysis in '.$title.' from African Chronicle.';
require __DIR__.'/includes/head.php'; require __DIR__.'/includes/header.php';
?>
<main class="container"><header class="page-intro"><div class="eyebrow">African Chronicle · News desk</div><h1><?= ac_e($title) ?></h1><p>Reporting and analysis from <?= ac_e($title) ?>.</p></header>
<nav class="category-strip" aria-label="Browse sections"><?php foreach ($categories as $item): ?><a href="<?= ac_e(ac_category_url($item)) ?>" <?= $category && $item['slug'] === $category['slug'] ? 'aria-current="page"' : '' ?>><?= ac_e($item['name'] ?? '') ?></a><?php endforeach ?></nav>
<div class="section-layout"><section><h2 class="section-heading">Latest reporting</h2><div class="article-list">
<?php foreach ($articles as $story): ?><article class="article-card"><?php if ($image = ac_image($story)): ?><a href="<?= ac_e(ac_article_url($story)) ?>"><img src="<?= ac_e($image) ?>" alt="" loading="lazy"></a><?php endif ?><div class="article-card-copy"><div class="eyebrow"><?= ac_e(ac_category_name($story)) ?></div><h2><a href="<?= ac_e(ac_article_url($story)) ?>"><?= ac_e($story['title'] ?? '') ?></a></h2><p><?= ac_e($story['summary'] ?? '') ?></p><div class="meta"><?= ac_e(ac_date($story)) ?></div></div></article><?php endforeach ?>
<?php if (!$articles): ?><div class="empty-state">No published stories in this section yet. Check the archive again when the newsroom publishes new reporting.</div><?php endif ?>
</div></section><aside><div class="sidebar-block"><h2>Browse the newsroom</h2><ol class="top-list"><?php foreach (array_slice($categories, 0, 8) as $item): ?><li><a href="<?= ac_e(ac_category_url($item)) ?>"><?= ac_e($item['name'] ?? '') ?></a></li><?php endforeach ?></ol></div></aside></div></main>
<?php require __DIR__.'/includes/footer.php'; ?>
