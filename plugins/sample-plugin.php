<?php

namespace MarkdownToStaticSite\Plugin;

class SamplePlugin
{
    public function process(string $content): string
    {
        // Добави някаква функционалност към съдържанието
        return str_replace('My Static Site', 'My Awesome Static Site', $content);
    }
}
