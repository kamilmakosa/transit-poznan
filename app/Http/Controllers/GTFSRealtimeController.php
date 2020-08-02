<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GTFSRealtime;

class GTFSRealtimeController extends Controller
{
  public function vehiclePositions() {
    $vehiclePositionsOptions = [
    	'path' => public_path()."/gtfs-realtime",
    	'file' => 'vehicle_positions.pb',
    	'output-file' => 'vehicle_positions.json',
    ];

    $parser = new GTFSRealtime($vehiclePositionsOptions, null);

    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0Mi56dG0ucG96bmFuLnBsIiwiY29kZSI6MSwibG9naW4iOiJtaFRvcm8iLCJ0aW1lc3RhbXAiOjE1MTM5NDQ4MTJ9.ND6_VN06FZxRfgVylJghAoKp4zZv6_yZVBu_1-yahlo';
    $url = 'https://www.ztm.poznan.pl/pl/dla-deweloperow/getGtfsRtFile?token='.$token.'&file='.$vehiclePositionsOptions['file'];

    $parser->pb_download($url, $vehiclePositionsOptions['path'].'/'.$vehiclePositionsOptions['file']);
    $parser->vehicle_positions_parse();
    $parser->display_json($vehiclePositionsOptions['path'].'/'.$vehiclePositionsOptions['output-file']);

  }

  public function tripUpdates() {
    $tripUpdatesOptions = [
    	'path' => public_path()."/gtfs-realtime",
    	'file' => 'trip_updates.pb',
    	'output-file' => 'trip_updates.json',
    ];

    $parser = new GTFSRealtime(null, $tripUpdatesOptions);

    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0ZXN0Mi56dG0ucG96bmFuLnBsIiwiY29kZSI6MSwibG9naW4iOiJtaFRvcm8iLCJ0aW1lc3RhbXAiOjE1MTM5NDQ4MTJ9.ND6_VN06FZxRfgVylJghAoKp4zZv6_yZVBu_1-yahlo';
    $url = 'https://www.ztm.poznan.pl/pl/dla-deweloperow/getGtfsRtFile?token='.$token.'&file='.$tripUpdatesOptions['file'];

    $parser->pb_download($url, $tripUpdatesOptions['path'].'/'.$tripUpdatesOptions['file']);
    $parser->trip_updates_parse();
    $parser->display_json($tripUpdatesOptions['path'].'/'.$tripUpdatesOptions['output-file']);
  }
}
