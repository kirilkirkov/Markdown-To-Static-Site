# Markdown to Static Site Generator

A simple PHP tool to generate static sites from Markdown files.

## Usage

1. Place your Markdown files in the `content` directory.
2. Run the generator:
   ```bash
   php src/main.php
   ```
3. Your static site will be generated in the public directory.

## Custom Themes

<p>You can create custom themes by adding them to the themes directory and updating the path in config.php.</p>

## Plugins

<p>Plugins can be created in the plugins directory and added to config.php.</p>

## How to run the project
1. Clone the repository and install the dependencies
   ```bash
   git clone https://github.com/kirilkirkov/Markdown-To-Static-Site.git
   cd Markdown-To-Static-Site
   composer install
   ```
2. Start the generator
   ```bash
   php src/main.php
   ```

<p>Thats all. Your site will be generated to the <b>public directory</b></p>