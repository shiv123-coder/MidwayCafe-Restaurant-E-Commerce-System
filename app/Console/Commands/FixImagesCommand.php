<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class FixImagesCommand extends Command
{
    protected $signature   = 'images:fix';
    protected $description = 'Migrate existing images and fix all database image columns to use images/filename.ext format.';

    // Dynamically populated list of valid files
    protected array $validFiles = [];

    public function handle()
    {
        $this->info('=== Starting Image Alignment Fix ===');

        $storagePath = storage_path('app/public/images');
        $legacyPath  = public_path('assets/images');

        // 1. Ensure storage directory exists
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
            $this->info('Created storage/app/public/images/');
        }

        // Dynamically load valid files
        $this->validFiles = array_map(function($file) {
            return $file->getFilename();
        }, File::files($storagePath));

        // 2. Migrate from legacy public/assets/images to storage/app/public/images
        if (File::exists($legacyPath)) {
            $files = File::files($legacyPath);
            $moved = 0;
            foreach ($files as $file) {
                $dest = $storagePath . '/' . $file->getFilename();
                if (!File::exists($dest)) {
                    File::copy($file->getRealPath(), $dest);
                    $moved++;
                }
            }
            $this->info("Migrated {$moved} files from public/assets/images to storage.");
        }

        // 3. Fix products table
        $this->fixTable('products', 'image', 'images/food-placeholder.jpg');

        // 4. Fix chefs table
        $this->fixTable('chefs', 'image', 'images/chef-placeholder.jpg');

        // 5. Fix banners table (column is 'banner')
        $this->fixTable('banners', 'banner', 'images/hero-banner-default.jpg');

        // 6. Fix about_us table (only valid image columns: image1, image2, image3)
        foreach (['image1', 'image2', 'image3'] as $col) {
            $this->fixTable('about_us', $col, 'images/about-thumb-01.jpg');
        }

        $this->info('');
        $this->info('=== Image fix complete! ===');
        $this->info('Run "php artisan storage:link" if not already done.');

        return Command::SUCCESS;
    }

    /**
     * Normalise the image column for a given table.
     * Rules:
     *  1. Strip the 'images/' prefix if already stored (legacy format).
     *  2. If the bare filename is in $validFiles AND exists on disk → store as images/filename.
     *  3. Otherwise → replace with the fallback placeholder.
     */
    private function fixTable(string $table, string $column, string $fallback): void
    {
        if (!DB::getSchemaBuilder()->hasTable($table)) {
            $this->warn("Table '{$table}' not found — skipped.");
            return;
        }

        if (!DB::getSchemaBuilder()->hasColumn($table, $column)) {
            $this->warn("Column '{$column}' not found in '{$table}' — skipped.");
            return;
        }

        $rows = DB::table($table)->get(['id', $column]);
        $this->info("Fixing {$rows->count()} rows in [{$table}.{$column}]...");
        $fixed = 0;

        foreach ($rows as $row) {
            $current  = $row->{$column} ?? '';
            $resolved = $this->resolveImagePath($current, $fallback);

            if ($resolved !== $current) {
                DB::table($table)->where('id', $row->id)->update([$column => $resolved]);
                $this->line("  [{$table}#{$row->id}] '{$current}' → '{$resolved}'");
                $fixed++;
            }
        }

        $this->info("  Done — {$fixed} records updated.");
    }

    /**
     * Given a raw DB value, return the canonical images/filename.ext path.
     */
    private function resolveImagePath(string $raw, string $fallback): string
    {
        // Already correct format — verify the file actually exists
        if (str_starts_with($raw, 'images/')) {
            $filename = substr($raw, 7); // strip 'images/'
            if (in_array($filename, $this->validFiles, true) &&
                File::exists(storage_path('app/public/images/' . $filename))) {
                return $raw; // already perfect — no change needed
            }
            // File referenced but doesn't exist on disk → fallback
            return $fallback;
        }

        // Reject anything that looks like a URL or a path with slashes (faker output, external URLs)
        if (str_contains($raw, 'http') || str_contains($raw, '://') || str_contains($raw, '/')) {
            return $fallback;
        }

        // Bare filename (e.g. "burger.jpg") — check if it's valid and exists
        if (in_array($raw, $this->validFiles, true) &&
            File::exists(storage_path('app/public/images/' . $raw))) {
            return 'images/' . $raw;
        }

        // Filename is in valid list but not on disk (missing file) → fallback
        return $fallback;
    }
}
