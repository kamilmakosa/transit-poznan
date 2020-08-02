<?php

namespace App\Http\Controllers;

use App\GTFSStatic;
use Illuminate\Http\Request;

class GTFSStaticController extends Controller
{
  public function listGTFSFiles() {
    return GTFSStatic::listGTFSFiles();
  }
}
