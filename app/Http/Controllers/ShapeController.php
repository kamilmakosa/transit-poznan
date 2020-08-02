<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shape;
use Illuminate\Support\Facades\DB;

class ShapeController extends Controller
{
  // public function index() {
  //   return DB::table('shapes')->select('shape_id')->distinct()->get();
  // }

  public function show($shape_id) {
    return DB::table('shapes')->where('shape_id', $shape_id)->get();
  }
}
