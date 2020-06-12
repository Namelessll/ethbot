<?php

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;

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

        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.binance.com/api/v1/ticker/24hr?symbol=ETHUSDT']);
        $value = json_decode($client->request('GET', '')->getBody()->getContents());

        DB::table('table_eth_course')
            ->insert([
               'value' => $value->askPrice,
               'created_at' => \Carbon\Carbon::now()
            ]);
    }
}
