<?php

namespace Database\Seeders;

use App\Models\Reference;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        /**
         * Reference Seeder
         */
        $reference = Reference::create([
            'code' => 'overtime_method',
            'name' => 'Salary / 173',
            'expression' => '(salary / 173) * overtime_duration_total'
        ]);

        Reference::create([
            'code' => 'overtime_method',
            'name' => 'Fixed',
            'expression' => '10000 * overtime_duration_total'
        ]);

        /**
         * Setting Seeder
         */
        Setting::create([
            'key' => 'overtime_method',
            'value' => $reference->id
        ]);
    }
}
