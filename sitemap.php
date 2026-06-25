<?php
require_once __DIR__ . '/config.php';

header('Content-Type: application/xml; charset=UTF-8');

$pages = [
    [ 'path' => '', 'file' => __DIR__ . '/index.php', 'changefreq' => 'weekly', 'priority' => '1.0' ],
    [ 'path' => 'about.php', 'file' => __DIR__ . '/about.php', 'changefreq' => 'monthly', 'priority' => '0.8' ],
    [ 'path' => 'services.php', 'file' => __DIR__ . '/services.php', 'changefreq' => 'monthly', 'priority' => '0.8' ],
    [ 'path' => 'portfolio.php', 'file' => __DIR__ . '/portfolio.php', 'changefreq' => 'weekly', 'priority' => '0.8' ],
    [ 'path' => 'store.php', 'file' => __DIR__ . '/store.php', 'changefreq' => 'weekly', 'priority' => '0.7' ],
    [ 'path' => 'cv.php', 'file' => __DIR__ . '/cv.php', 'changefreq' => 'monthly', 'priority' => '0.6' ],
    [ 'path' => 'resume.php', 'file' => __DIR__ . '/resume.php', 'changefreq' => 'monthly', 'priority' => '0.6' ],
    [ 'path' => 'contact.php', 'file' => __DIR__ . '/contact.php', 'changefreq' => 'monthly', 'priority' => '0.6' ],
];

$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

foreach ($pages as $p) {
    if (!empty($p['file']) && !file_exists($p['file'])) {
        continue;
    }

    $loc = siteUrl($p['path']);
    $lastmod = '';

    if (!empty($p['file']) && file_exists($p['file'])) {
        $ts = @filemtime($p['file']);
        if ($ts) {
            $lastmod = gmdate('Y-m-d\TH:i:s\Z', $ts);
        }
    }

    $xml .= "  <url>\n";
    $xml .= "    <loc>" . htmlspecialchars($loc, ENT_XML1) . "</loc>\n";
    if ($lastmod) {
        $xml .= "    <lastmod>" . $lastmod . "</lastmod>\n";
    }
    $xml .= "    <changefreq>" . $p['changefreq'] . "</changefreq>\n";
    $xml .= "    <priority>" . $p['priority'] . "</priority>\n";
    $xml .= "  </url>\n";
}

$xml .= "</urlset>\n";

echo $xml;
