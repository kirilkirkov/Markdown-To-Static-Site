<?php

namespace MarkdownToStaticSite\Util;

use Parsedown;

class MarkdownParser
{
    private Parsedown $parser;

    public function __construct()
    {
        $this->parser = new Parsedown();
    }

    public function parse(string $markdown): string
    {
        return $this->parser->text($markdown);
    }
}
