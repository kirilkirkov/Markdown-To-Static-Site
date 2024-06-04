<?php

namespace MarkdownToStaticSite\Controller;

use MarkdownToStaticSite\Util\MarkdownParser;

class SiteGenerator
{
    private MarkdownParser $parser;
    private array $config;

    public function __construct(array $config = [])
    {
        $this->parser = new MarkdownParser();
        $this->config = $config;
    }

    public function generate()
    {
        $this->copyStaticResources();
        $files = glob($this->config['contentDir'] . '/*.md');

        foreach ($files as $file) {
            $markdown = file_get_contents($file);
            $html = $this->parser->parse($markdown);
            $html = $this->applyPlugins($html);
            $outputFile = $this->config['outputDir'] . '/' . basename($file, '.md') . '.html';
            $this->render($html, $outputFile);
        }
    }

    private function render(string $content, string $outputFile)
    {
        ob_start();
        include $this->config['themeDir'] . '/template.php';
        $renderedContent = ob_get_clean();
        file_put_contents($outputFile, $renderedContent);
    }

    private function applyPlugins(string $content): string
    {
        $plugins = array_map(fn($pluginClass) => new $pluginClass(), $this->config['plugins']);
        foreach ($plugins as $plugin) {
            $content = $plugin->process($content);
        }
        return $content;
    }

    private function copyStaticResources()
    {
        $source = $this->config['themeDir'] . '/assets';
        $destination = $this->config['outputDir'] . '/assets';

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
