<?php

namespace MarkdownToStaticSite\Plugin;

class SamplePlugin
{
    public function process(string $content): string
    {
        return str_replace('My Static Site', 'My Awesome Static Site', $content);
    }
}
