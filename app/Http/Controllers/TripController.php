<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trip;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
  public function index() {
    return DB::table('trips')->get();
  }

  public function show($trip_id) {
    return DB::table('trips')->where('trip_id', 'LIKE', '%_'.$trip_id.'%')->get();
  }

  public function indexByRoute($route_id) {
    return DB::table('trips')->where('route_id', $route_id)->get();
  }
}
