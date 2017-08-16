<?php

namespace CounterPackage\ViewCounter;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    use \Illuminate\Console\DetectsApplicationNamespace;
   /**
   * like-Action to call with class_name and object_id
   *
   * @return null
   */  
  public function like($class_name, $object_id)
  {
    $message = 'view_counter.messages.like.';
    
    $class_name = "\\".self::getAppNamespace().ucfirst($class_name);
    $object = $class_name::find($object_id);
    if($object->like())
      $type = "success";
    else
      $type = "error";
    
    return \Redirect::back()->with($type, $message.$type);
  }
  /**
   * unlike-Action to call with class_name and object_id
   *
   * @return null
   */  
  public function unlike($class_name, $object_id)
  {
    $message = 'view_counter.messages.unlike.';
    
    $class_name = "\\".self::getAppNamespace().ucfirst($class_name);
    $object = $class_name::find($object_id);
    $object = $class_name::find($object_id);
    if($object->unlike())
      $type = "success";
    else
      $type = "error";
    return \Redirect::back()->with($type, $message.$type);
  }
}