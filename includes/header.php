<?php
$navCategories = ac_categories();
$navNames = [
    'Sierra Leone' => 'Sierra Leone', 'Africa' => 'Africa', 'World' => 'International',
    'Business' => 'Business', 'Politics' => 'Politics', 'Society' => 'Community News',
    'Opinion' => 'Opinion and Editorial', 'Lifestyle' => 'Features and Interviews',
    'Sports' => 'Sports', 'Investigations' => 'Investigations',
];
$nav = [];
foreach ($navNames as $label => $wanted) {
    foreach ($navCategories as $category) {
        if (strcasecmp((string) ($category['name'] ?? ''), $wanted) === 0) { $category['nav_label'] = $label; $nav[] = $category; break; }
    }
}
$today = new DateTimeImmutable('now', new DateTimeZone('Africa/Freetown'));
?>
<div class="breaking"><div class="container"><span class="breaking-label">African Chronicle</span><a href="archive.php">Independent journalism · African perspective</a></div></div>
<div class="utility"><div class="container"><div class="utility-left"><span><?= ac_e($today->format('l, j F Y')) ?></span><span>Freetown · Sierra Leone</span></div><div class="utility-links"><a href="archive.php">News archive</a><a href="about.php">About us</a><a href="advertise.php">Advertise</a><a href="about.php#contact">Contact</a></div></div></div>
<div class="masthead"><div class="container mast-row"><div class="date-weather" aria-hidden="true"></div><a class="brand" href="index.php" aria-label="African Chronicle home"><div class="brand-name">AFRICAN CHRONICLE</div><div class="brand-tagline">Independent journalism · African perspective</div></a><div class="mast-tools"><form class="search" action="archive.php" method="get" role="search"><input name="q" type="search" placeholder="Search news and topics" aria-label="Search news and topics"><button aria-label="Search">⌕</button></form></div></div></div>
<nav class="section-nav" aria-label="News sections"><div class="container"><a href="index.php">Home</a><?php foreach ($nav as $category): ?><a href="<?= ac_e(ac_category_url($category)) ?>"><?= ac_e($category['nav_label'] ?? $category['name'] ?? '') ?></a><?php endforeach ?><a href="archive.php">Archive</a></div></nav>
