<?php

use Illuminate\Support\Facades\Route;
use App\Agency;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/agencies', "AgencyController@index");
Route::get('/agencies/{agency_id}', "AgencyController@show");
// Route::get('/agency/{agency_id}', function($agency_id) {
//   $agency = Agency::find($agency_id);
//   return response()->json($agency, 200, [], JSON_PRETTY_PRINT);
// });
Route::get('/routes', "RouteController@index");
Route::get('/routes/{route_id}', "RouteController@show");

// Route::get('/shapes', "ShapeController@index");
Route::get('/shapes/{shape_id}', "ShapeController@show");

Route::get('/stops', "StopController@index");
Route::get('/stops/{stop_id}', "StopController@show");
Route::get('/stops/code/{stop_code}', "StopController@showByCode");

Route::get('/stop_times/{trip_id}', "StopTimeController@show");

Route::get('/trips', "TripController@index");
Route::get('/trips/{trip_id}', "TripController@show");
Route::get('/routes/{route_id}/trips', "TripController@indexByRoute");

Route::get('/gtfs-static-files', "GTFSStaticController@listGTFSFiles");

Route::get('/vehicle-positions', "GTFSRealtimeController@vehiclePositions");
Route::get('/trip-updates', "GTFSRealtimeController@tripUpdates");
