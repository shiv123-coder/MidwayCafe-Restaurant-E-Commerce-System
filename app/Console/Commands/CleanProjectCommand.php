<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class CleanProjectCommand extends Command
{
    protected $signature = 'project:clean';
    protected $description = 'Remove all item images from DB and delete redundant files/folders.';

    public function handle()
    {
        $this->info('=== Starting Selective Project Cleanup ===');

        // Essential files to keep in storage
        $essentialFiles = [
            'logo.png', 'short.jpg', 'about-video-bg.jpg', 
            'hero-banner-default.jpg', 'food-placeholder.jpg', 
            'chef-placeholder.jpg', 'delivery.png', 'cod.png', 
            'order.png', 'logo.jpg', 'white-logo.png'
        ];

        // 1. Database Cleanup
        $this->info('1. Clearing Database image references...');
        
        if (Schema::hasTable('products')) {
            DB::table('products')->update(['image' => null]);
            $this->line('   - [products] table cleared.');
        }

        if (Schema::hasTable('chefs')) {
            DB::table('chefs')->update(['image' => null]);
            $this->line('   - [chefs] table cleared.');
        }

        if (Schema::hasTable('banners')) {
            DB::table('banners')->update(['banner' => null]);
            $this->line('   - [banners] table cleared.');
        }

        if (Schema::hasTable('about_us')) {
            DB::table('about_us')->update([
                'image1' => null,
                'image2' => null,
                'image3' => null
            ]);
            $this->line('   - [about_us] table cleared.');
        }

        // 2. Clear Storage Images (Except Essential)
        $storageImages = storage_path('app/public/images');
        if (File::exists($storageImages)) {
            $this->info('2. Purging non-essential images from storage...');
            $files = File::files($storageImages);
            $deletedCount = 0;
            foreach ($files as $file) {
                if (!in_array($file->getFilename(), $essentialFiles)) {
                    File::delete($file->getRealPath());
                    $deletedCount++;
                }
            }
            $this->line("   - Purged {$deletedCount} item images. Kept " . count($essentialFiles) . " system assets.");
        }

        // 3. Delete Redundant Folders entirely
        $redundantFolders = [
            public_path('assets/images'),
            public_path('admin/assets'),
        ];

        $this->info('3. Deleting redundant duplicate asset folders...');
        foreach ($redundantFolders as $folder) {
            if (File::exists($folder)) {
                File::deleteDirectory($folder);
                $this->line("   - Deleted: " . basename($folder));
            }
        }

        $this->info('=== Cleanup Complete! ===');
    }
}
