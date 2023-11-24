<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;

class EmployeeEnhancementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = Document::where('name', 'Dokumen Karyawan')->first();
        $document->is_required = 0;
        $document->save();
    }
}
