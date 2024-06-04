<?php

use MarkdownToStaticSite\Controller\SiteGenerator;

require_once __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../config.php';

$generator = new SiteGenerator($config);
$generator->generate();

echo "Site generated successfully!\n";
