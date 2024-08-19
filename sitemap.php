<?php

header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

echo '<url>';
echo '<loc>https://cmrmed.online/?page=home</loc>';
echo '<lastmod>' . date('Y-m-d') . '</lastmod>'; 
echo '<changefreq>weekly</changefreq>';
echo '<priority>0.8</priority>';
echo '</url>';

$start_id = 1;
$end_id = 1000;

for ($id = $start_id; $id <= $end_id; $id++) {
    echo '<url>';
    echo '<loc>https://cmrmed.online/?page=product&id=' . $id . '</loc>';
    echo '<lastmod>' . date('Y-m-d') . '</lastmod>'; 
    echo '<changefreq>weekly</changefreq>';
    echo '<priority>0.8</priority>';
    echo '</url>';
}

echo '</urlset>';
?>
