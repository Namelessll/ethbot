<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('table_server_settings')->insert([
            'setting_code' => 'activity',
            'setting_value' => 'on',
        ]);
    }
}
