<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Route;

class RouteController extends Controller
{
  public function index() {
    return Route::all();
  }

  public function show($route_id) {
    return Route::find($route_id);
  }
}
