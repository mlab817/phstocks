<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StockHistoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $data = array_map('str_getcsv', file(base_path('notebooks/stock prices as of 10 13.csv')));
//        $dataWithoutHeaders = array_slice($data, 2, count($data));
//
//        $formattedData = collect($dataWithoutHeaders)->map(function ($data) {
//            if ($stock = Stock::findBySymbol($data[0])) {
//                return [
//                    'stock_id'  => $stock->id,
//                    'date'      => date('Y-m-d', strtotime($data[1])),
//                    'open'      => $data[2],
//                    'high'      => $data[3],
//                    'low'       => $data[4],
//                    'close'     => $data[5],
//                    'average'   => $data[6],
//                    'volume'    => $data[7],
//                    'value'     => $data[8],
//                ];
//            } else {
//                return null;
//            }
//        })->filter(function ($d) {
//            if ($d) {
//                return $d;
//            }
//        });
//
//        foreach ($formattedData as $d) {
//            if ($d) {
//                DB::table('stock_histories')->insert($d);
//            }
//        }
        $files = File::allFiles(database_path('seeders/stocks'));

        foreach ($files as $file) {
            $stock = Stock::findBySymbol(str_replace('.csv','',$file->getFilename()));

            if ($stock) {
                $data = array_map('str_getcsv', file($file->getRealPath()));
                $dataWithoutHeaders = array_slice($data, 2, count($data));

                $formattedData = array_map(function ($data) use ($stock) {
                    return [
                        'stock_id' => $stock->id,
                        'open' => floatval($data[0]),
                        'value' => floatval($data[1]),
                        'close' => floatval($data[2]),
                        'date' => date('Y-m-d', strtotime($data[3])),
                        'high' => floatval($data[4]),
                        'low' => floatval($data[5]),
                    ];
                }, $dataWithoutHeaders);

                DB::table('stock_histories')->insert($formattedData);

//                if ($formattedData) {
//                    $stock->histories()->createMany($formattedData);
//                }
            }
        }
    }
}
