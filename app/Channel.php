<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $table='channels';
    public $primaryKey='id';
    public $timestamps=false;
}
