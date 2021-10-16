<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/stocks/{stock}/histories', function (\App\Models\Stock $stock) {
    return response()->json([
        'stock' => $stock,
        'chartData' => \App\Models\StockHistory::where('stock_id', $stock->id)->orderBy('date')->get(),
    ]);
});

Route::get('/stocks/{stock}', function (\App\Models\Stock $stock) {
    return response()->json($stock->load('histories'));
});

Route::get('/stocks', function () {
    return response()->json(\App\Models\Stock::all());
});

Route::get('/all_stocks', function () {
    return response()->json(json_decode(file_get_contents(database_path('stocks.json'))));
});
