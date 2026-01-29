const fs = require('fs');
const path = require('path');

const dist = path.join(__dirname, '../dist_upload');
const root = path.join(dist, 'root');
const core = path.join(dist, 'core');

console.log("Cleaning previous dist...");
if (fs.existsSync(dist)) fs.rmSync(dist, { recursive: true, force: true });
fs.mkdirSync(root, { recursive: true });
fs.mkdirSync(core, { recursive: true });

console.log("Copying public folder to dist/root (excluding storage symlink)...");
const publicDir = path.join(__dirname, '../public');
const publicItems = fs.readdirSync(publicDir);
publicItems.forEach(item => {
    if (item === 'storage') return;
    const srcPath = path.join(publicDir, item);
    const destPath = path.join(root, item);
    console.log(`Copying public/${item}...`);
    fs.cpSync(srcPath, destPath, { recursive: true });
});

console.log("Creating link_storage.php...");
const linkScript = `<?php
$target = __DIR__ . '/rosevilla_core/storage/app/public';
$link = __DIR__ . '/storage';
if(file_exists($link)) {
    echo "Link already exists or is a file/dir at $link";
} else {
    if(symlink($target, $link)) {
        echo "Symlink created successfully: $link -> $target";
    } else {
        echo "Failed to create symlink.";
    }
}
`;
fs.writeFileSync(path.join(root, 'link_storage.php'), linkScript);

console.log("Modifying index.php...");
const indexPhp = path.join(root, 'index.php');
if (fs.existsSync(indexPhp)) {
    let content = fs.readFileSync(indexPhp, 'utf8');
    // Adjust paths for shared hosting structure
    // Original: require __DIR__.'/../vendor/autoload.php';
    // Target: require __DIR__.'/rosevilla_core/vendor/autoload.php';
    content = content.replace(
        "require __DIR__.'/../vendor/autoload.php';",
        "require __DIR__.'/rosevilla_core/vendor/autoload.php';"
    );
    content = content.replace(
        "require_once __DIR__.'/../bootstrap/app.php';",
        "require_once __DIR__.'/rosevilla_core/bootstrap/app.php';"
    );
    fs.writeFileSync(indexPhp, content);
} else {
    console.warn("Warning: public/index.php not found!");
}

console.log("Copying core files...");
const src = path.join(__dirname, '..');
const dirs = ['app', 'bootstrap', 'config', 'database', 'lang', 'resources', 'routes', 'storage', 'tests', 'vendor'];
const files = ['artisan', 'composer.json', 'composer.lock', 'package.json', 'vite.config.js', '.env']; // Copying .env explicitly

dirs.forEach(d => {
    const sourcePath = path.join(src, d);
    if (fs.existsSync(sourcePath)) {
        console.log(`Copying ${d}...`);
        fs.cpSync(sourcePath, path.join(core, d), { recursive: true });
    }
});

files.forEach(f => {
    const sourcePath = path.join(src, f);
    if (fs.existsSync(sourcePath)) {
        console.log(`Copying ${f}...`);
        fs.copyFileSync(sourcePath, path.join(core, f)); // copyFileSync handles files
    }
});

console.log("Securing core directory...");
fs.writeFileSync(path.join(core, '.htaccess'), 'Deny from all');

console.log("Preparation complete.");
