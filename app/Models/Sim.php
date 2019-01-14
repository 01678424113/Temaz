<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sim extends Model
{
    protected $table = 'sims';
    public static $ACTIVE = 1;
    public static $UNACTIVE = 0;
    public $timestamps = false;
}
