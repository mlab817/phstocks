<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockHistoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array_map('str_getcsv', file(database_path('prices.csv')));
        $dataWithoutHeaders = array_slice($data, 2, count($data));

        $formattedData = collect($dataWithoutHeaders)->map(function ($data) {
            if ($stock = Stock::findBySymbol($data[0])) {
                return [
                    'stock_id'  => $stock->id,
                    'date'      => date('Y-m-d', strtotime($data[1])),
                    'open'      => floatval($data[2]),
                    'high'      => floatval($data[3]),
                    'low'       => floatval($data[4]),
                    'close'     => floatval($data[5]),
                    'average'   => floatval($data[6]),
                    'volume'    => intval($data[7]),
                    'value'     => floatval($data[8]),
                ];
            }
        });

        foreach ($formattedData as $data) {
            if ($data) {
                DB::table('stock_histories')->insert($data);
            }
        }
    }
}
