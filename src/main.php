<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MarkdownToStaticSite\Controller\SiteGenerator;

$config = require __DIR__ . '/../config.php';

$plugins = array_map(fn($pluginClass) => new $pluginClass(), $config['plugins']);

$generator = new SiteGenerator(
    $config['contentDir'],
    $config['outputDir'],
    $config['themeDir'],
    $plugins
);

$generator->generate();

echo "Site generated successfully!\n";
