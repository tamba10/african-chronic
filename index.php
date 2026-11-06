<?php
require __DIR__.'/includes/cms.php';
$categories = ac_categories();
$articles = ac_articles();
$pageTitle = 'Independent journalism. African perspective.';
require __DIR__.'/includes/head.php';
require __DIR__.'/includes/header.php';
$featured = $articles[0] ?? null;
$other = array_slice($articles, 1);
?>
<main class="container">
  <?php if ($featured): ?>
  <section class="home-lead" aria-label="Top stories">
    <article><a href="<?= ac_e(ac_article_url($featured)) ?>"><?php if ($image = ac_image($featured)): ?><img class="lead-image" src="<?= ac_e($image) ?>" alt=""><?php else: ?><div class="lead-image lead-image-empty" aria-hidden="true"></div><?php endif ?><div class="lead-copy"><div class="eyebrow lead-category"><?= ac_e(ac_category_name($featured)) ?></div><h1><?= ac_e($featured['title'] ?? '') ?></h1><p class="standfirst"><?= ac_e($featured['summary'] ?? '') ?></p><div class="byline"><?php if (!empty($featured['author']['name'])): ?>By <?= ac_e($featured['author']['name']) ?> · <?php endif ?><?= ac_e(ac_date($featured)) ?></div></div></a></article>
    <div class="lead-secondary"><?php foreach (array_slice($other, 0, 2) as $story): ?><article class="secondary-story"><a href="<?= ac_e(ac_article_url($story)) ?>"><?php if ($image = ac_image($story)): ?><img class="story-image" src="<?= ac_e($image) ?>" alt="" loading="lazy"><?php else: ?><div class="story-image lead-image-empty" aria-hidden="true"></div><?php endif ?></a><div class="secondary-copy"><div class="eyebrow"><?= ac_e(ac_category_name($story)) ?></div><h2><a href="<?= ac_e(ac_article_url($story)) ?>"><?= ac_e($story['title'] ?? '') ?></a></h2><p><?= ac_e($story['summary'] ?? '') ?></p><div class="meta"><?= ac_e(ac_date($story)) ?></div></div></article><?php endforeach ?></div>
  </section>
  <section class="home-columns">
    <div><h2 class="section-heading">Top stories <a href="archive.php">All stories</a></h2><ol class="top-list"><?php foreach (array_slice($other, 0, 5) as $story): ?><li><a href="<?= ac_e(ac_article_url($story)) ?>"><?= ac_e($story['title'] ?? '') ?></a><div class="meta"><?= ac_e(ac_category_name($story)) ?> · <?= ac_e(ac_date($story)) ?></div></li><?php endforeach ?></ol></div>
    <div><h2 class="section-heading">Latest reporting <a href="archive.php">Explore</a></h2><div class="editors-grid"><?php foreach (array_slice($other, 5, 4) as $story): ?><article class="editor-card"><a href="<?= ac_e(ac_article_url($story)) ?>"><?php if ($image = ac_image($story)): ?><img src="<?= ac_e($image) ?>" alt="" loading="lazy"><?php endif ?><div class="eyebrow"><?= ac_e(ac_category_name($story)) ?></div><h3><?= ac_e($story['title'] ?? '') ?></h3><p><?= ac_e($story['summary'] ?? '') ?></p></a></article><?php endforeach ?></div></div>
    <aside class="trending"><h2 class="section-heading">News sections</h2><ol class="trending-list"><?php foreach (array_slice($categories, 0, 7) as $category): ?><li><a href="<?= ac_e(ac_category_url($category)) ?>"><?= ac_e($category['name'] ?? '') ?></a></li><?php endforeach ?></ol></aside>
  </section>
  <?php else: ?>
  <section class="page-intro first-edition"><div class="eyebrow">The newsroom</div><h1>African Chronicle</h1><p>Independent journalism. African perspective.</p><p>Published reporting from the newsroom will appear here. Browse our sections or return when the first stories are ready.</p><a class="text-link" href="archive.php">Browse the news archive</a></section>
  <nav class="category-strip" aria-label="Browse news sections"><?php foreach ($categories as $category): ?><a href="<?= ac_e(ac_category_url($category)) ?>"><?= ac_e($category['name'] ?? '') ?></a><?php endforeach ?></nav>
  <?php endif ?>
</main>
<?php require __DIR__.'/includes/footer.php'; ?>
