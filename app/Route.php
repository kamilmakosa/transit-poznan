<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
  protected $table = "routes";
  protected $primaryKey = 'route_id';
}
