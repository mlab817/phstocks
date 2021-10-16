<?php

namespace Database\Seeders;

use App\Models\Stock;
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
        $data = array_map('str_getcsv', file(database_path('seeders/all-stocks.csv')));
        $dataWithoutHeaders = array_slice($data, 2, count($data));

        $formattedData = array_map(function ($data) {
            return [
                'cmpy_id' => intval($data[0]),
                'security_id' => intval($data[1]),
                'name' => $data[2],
                'symbol' => $data[3],
                'sector' => $data[4],
                'subsector' => $data[5],
                'listing_date' => date('Y-m-d', strtotime($data[6])),
                'url' => 'https://frames.pse.com.ph/security/' . strtolower($data[3]),
            ];
        }, $dataWithoutHeaders);

        DB::table('stocks')->insert($formattedData);

        // seed from json
        $json = file_get_contents(database_path('seeders/stocks.json'));
        $jsonData = json_decode($json, true);

        foreach ($jsonData as $data) {
            $stock = Stock::findBySymbol($data['symbol']);

            if ($stock) {
                $stock->update([
                    'outstanding_shares' => intval(str_replace(',','',$data['Outstanding Shares'])),
                    'logo' => $data['logo'],
                    'pe_ratio' => floatval($data['P/E Ratio:']),
                    'issued_shares' => intval(str_replace(',','',$data['Issued Shares'])),
                    'listed_shares' => intval(str_replace(',','',$data['Listed Shares'])),
                    'free_float_level' => floatval(str_replace('%','',$data['Free Float Level'])),
                    'market_capitalization' => floatval(str_replace(',','',$data['Market Capitalization'])),
                    'isin' => $data['ISIN'],
                    'issue_type' => $data['Issue Type'],
                    'board_lot' => intval($data['Board Lot']),
                    'par_value' => intval($data['Par Value']),
                    'foreign_ownership_limit' => floatval(str_replace('%','',$data['Foreign Ownership Limit'])),
                    'year_end_eps' => floatval(str_replace(',','',$data['Year End EPS'])),
                    'year_end_eps_period' => date('Y-m-d', strtotime($data['Year End EPS Period'])),
                    'interim_eps' => floatval(str_replace(',','',$data['Interim EPS'])),
                    'interim_eps_period' => $data['Interim Period'],
                ]);

                $market_statistics = $data['market_statistics'];

                $market_statistics = collect($market_statistics)->map(function ($ms) {
                    return [
                        'year' => $ms['year'],
                        'volume' => intval(str_replace(',','',$ms['volume'])),
                        'value' => floatval(str_replace(',','',$ms['value'])),
                    ];
                });

                $stock->market_statistics()->createMany($market_statistics);
            }
        }
    }
}
