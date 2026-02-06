<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Sync existing legal_documents records to folders table
     * so that document uploads work with the FK constraint.
     */
    public function up()
    {
        // Get all folder names from legal_documents that don't exist in folders
        $legalDocs = DB::table('legal_documents')->pluck('name')->unique();

        foreach ($legalDocs as $name) {
            DB::table('folders')->insertOrIgnore([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        // No rollback needed
    }
};
