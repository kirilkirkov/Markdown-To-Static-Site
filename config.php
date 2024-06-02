<?php

return [
    'contentDir' => __DIR__ . '/content',
    'outputDir' => __DIR__ . '/public',
    'themeDir' => __DIR__ . '/themes/default',
    'plugins' => [
        \MarkdownToStaticSite\Plugin\SamplePlugin::class,
    ],
];
