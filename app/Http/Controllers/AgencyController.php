<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agency;
use Illuminate\Support\Facades\Log;

class AgencyController extends Controller
{
    public function index() {
      return Agency::all();
    }

    public function show($agency_id) {
      return Agency::find($agency_id);
    }
}
