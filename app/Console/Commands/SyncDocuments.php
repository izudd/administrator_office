<?php

namespace App\Console\Commands;

use App\Models\Document;
use App\Models\Folder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SyncDocuments extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'documents:sync {folder? : Folder name to sync}';

    /**
     * The console command description.
     */
    protected $description = 'Sync files from storage to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $folderName = $this->argument('folder');

        if ($folderName) {
            // Sync specific folder
            $this->syncFolder($folderName);
        } else {
            // Sync all folders
            $this->info('Syncing all folders...');
            $folders = Folder::all();
            
            foreach ($folders as $folder) {
                $this->syncFolder($folder->name);
            }
        }

        $this->info('✅ Sync completed!');
    }

    /**
     * Sync a specific folder
     */
    protected function syncFolder($folderName)
    {
        $this->info("📂 Processing folder: {$folderName}");

        // Get or create folder
        $folder = Folder::firstOrCreate(
            ['name' => $folderName],
            ['parent_id' => null]
        );

        // Get files from storage
        $storagePath = "public/legal-documents/{$folderName}";
        $files = Storage::files($storagePath);

        if (empty($files)) {
            $this->warn("  ⚠️  No files found in storage path: {$storagePath}");
            return;
        }

        $newCount = 0;
        $skippedCount = 0;

        foreach ($files as $filePath) {
            $fileName = basename($filePath);
            
            // Skip hidden files
            if (str_starts_with($fileName, '.')) {
                continue;
            }

            // Check if already exists in database
            $exists = Document::where('folder_id', $folder->id)
                ->where('file_name', $fileName)
                ->exists();

            if ($exists) {
                $skippedCount++;
                continue;
            }

            // Get file extension
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);

            // Create document record
            Document::create([
                'folder_id' => $folder->id,
                'file_name' => $fileName,
                'file_path' => str_replace('public/', '', $filePath),
                'file_type' => strtolower($extension),
            ]);

            $newCount++;
            $this->line("  ✓ Added: {$fileName}");
        }

        $this->info("  📊 Summary: {$newCount} new files, {$skippedCount} already existed");
    }
}