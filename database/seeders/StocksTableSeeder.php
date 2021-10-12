<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array_map('str_getcsv', file(database_path('stocks.csv')));
        $dataWithoutHeaders = array_slice($data, 2, count($data));

        $formattedData = array_map(function ($data) {
            return [
                'name' => $data[1],
                'url' => $data[2],
                'symbol' => $data[3],
                'last_traded_date' => date('Y-m-d', strtotime($data[4])),
                'last_traded_price' => $data[5],
                'outstanding_shares' => $data[6],
            ];
        }, $dataWithoutHeaders);

        DB::table('stocks')->insert($formattedData);
    }
}
