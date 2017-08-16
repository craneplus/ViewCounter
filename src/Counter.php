
<?php

namespace CounterPackage\ViewCounter;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
  protected $fillable = [
  	'class_name',
  	'object_id'
  ];
}
