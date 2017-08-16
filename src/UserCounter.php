<?php

namespace Craneplus\ViewCounter;

use Illuminate\Database\Eloquent\Model;

class UserCounter extends Model
{
  protected $fillable =[
  	'class_name',
  	'object_id',
  	'user_id',
  	'action'
  ];
}
