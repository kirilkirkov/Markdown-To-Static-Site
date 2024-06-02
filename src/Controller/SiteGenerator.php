<?php

namespace MarkdownToStaticSite\Controller;

use MarkdownToStaticSite\Util\MarkdownParser;

class SiteGenerator
{
    private MarkdownParser $parser;
    private string $contentDir;
    private string $outputDir;
    private string $themeDir;
    private array $plugins = [];

    public function __construct(string $contentDir, string $outputDir, string $themeDir, array $plugins = [])
    {
        $this->parser = new MarkdownParser();
        $this->contentDir = $contentDir;
        $this->outputDir = $outputDir;
        $this->themeDir = $themeDir;
        $this->plugins = $plugins;
    }

    public function generate()
    {
        $this->copyStaticResources();
        $files = glob($this->contentDir . '/*.md');

        foreach ($files as $file) {
            $markdown = file_get_contents($file);
            $html = $this->parser->parse($markdown);
            $html = $this->applyPlugins($html);
            $outputFile = $this->outputDir . '/' . basename($file, '.md') . '.html';
            $this->render($html, $outputFile);
        }
    }

    private function render(string $content, string $outputFile)
    {
        ob_start();
        include $this->themeDir . '/template.php';
        $renderedContent = ob_get_clean();
        file_put_contents($outputFile, $renderedContent);
    }

    private function applyPlugins(string $content): string
    {
        foreach ($this->plugins as $plugin) {
            $content = $plugin->process($content);
        }
        return $content;
    }

    private function copyStaticResources()
    {
        $source = $this->themeDir . '/assets';
        $destination = $this->outputDir . '/assets';

        if (!is_dir($source)) {
            echo "Source directory does not exist: $source\n";
            return;
        }

        echo "Copying assets from $source to $destination\n";
        $this->recurseCopy($source, $destination);
    }

    private function recurseCopy($source, $destination)
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
            echo "Created directory: $destination\n";
        }

        $dir = opendir($source);
        while (($file = readdir($dir)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $srcFile = $source . '/' . $file;
            $destFile = $destination . '/' . $file;
            if (is_dir($srcFile)) {
                $this->recurseCopy($srcFile, $destFile);
            } else {
                copy($srcFile, $destFile);
                echo "Copied file: $srcFile to $destFile\n";
            }
        }
        closedir($dir);
    }
}
