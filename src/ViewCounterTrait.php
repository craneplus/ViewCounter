<?php
namespace Craneplus\ViewCounter;
trait ViewCounterTrait {
  /**
   * Return the most liked content
   *
   * @return Integer
   */
  public function scopeMostLiked($query, $limit = false)
  {
    return $query->leftJoin('counter','counter.object_id','=',$this->getTable().'.id')
      ->whereClassName(snake_case(get_class($this)))
      ->orderBy('counter.like_counter', 'DESC');
  }
  /**
   * Return the most viewed content
   *
   * @return Integer
   */
  public function scopeMostViewed($query, $limit = false)
  {
    return $query->leftJoin('counter','counter.object_id','=',$this->getTable().'.id')
      ->whereClassName(snake_case(get_class($this)))
      ->orderBy('counter.view_counter', 'DESC');
  }
  public function counters()
  {
    if(!isset($this->counter))
    {
      $class_name = snake_case(get_class($this));
      $this->counter = \Craneplus\ViewCounter\Counter::firstOrCreate(array('class_name' => $class_name, 'object_id' => $this->id));
    }
    return $this->counter;
  }
  public function user_counters()
  {
    return $this->hasMany('\Craneplus\ViewCounter\UserCounter', 'object_id')->where('class_name', snake_case(get_class($this)));
  }
  /**
   * Return authentificated users who viewed we know
   *
   * @return Integer
   */
  public function views()
  {
  }
  public function view()
  {
    if(!$this->isViewed())
    {
      if(\Auth::user())
      {
        $this->user_counters()->create(array(
          'class_name' => snake_case(get_class($this)),
          'object_id' => $this->id,
          'user_id' => \Auth::user()->id,
          'action' => 'view'
        ));
        $this->counters()->increment('view_counter');
        
        return true;
      } else {
        \Session::put($this->get_view_key(), time());
        $this->counters()->increment('view_counter');
        
        return true;
      }
    }
    return false;
  }
  /**
   * Return views count
   *
   * @return Integer
   */
  public function views_count()
  {
    return $this->counters()->view_counter;
  }
  /**
   * Is object already viewed by user?
   *
   * @return Boolean
   */
  public function isViewed()
  {
    if(!\Auth::user())
    {
      $viewed = \Session::get($this->get_view_key());
      if(!empty($viewed)) {
        return true;
      }  
    } else {
      $user_action = $this->user_counters()
        ->where('action', 'view')
        ->where('class_name', snake_case(get_class($this)))
        ->where('object_id', $this->id)
        ->where('user_id', \Auth::user()->id)->count();
       if($user_action > 0)
         return true;
    }
    return false;
  }
  /**
   * get session storage key for view
   *
   * @return String
   */
  private function get_view_key()
  {
    return 'viewed_'.snake_case(get_class($this)).'_'.$this->id;
  }
  /**
   * Return authentificated users who liked we know
   *
   * @return Integer
   */
  public function likes()
  {
  }
  /**
   * Do a like on this object
   * returns success or failure
   *
   * @return Boolean
   */
  public function like()
  {
    if(!$this->isLiked())
    {
      if(\Auth::user())
      {
        $this->user_counters()->create(array(
          'class_name' => snake_case(get_class($this)),
          'object_id' => $this->id,
          'user_id' => \Auth::user()->id,
          'action' => 'like'
        ));
        $this->counters()->increment('like_counter');
        
        return true;
      } else {
        \Session::put($this->get_like_key(), time());
        $this->counters()->increment('like_counter');
        
        return true;
      }
    }
    return false;
  }
  /**
   * Unlike on this object
   * returns success or failure
   *
   * @return Boolean
   */
  public function unlike()
  {
    if($this->isLiked())
    {
      if(\Auth::user())
      {
        $this->user_counters()->where(array(
          'class_name' => snake_case(get_class($this)),
          'object_id' => $this->id,
          'user_id' => \Auth::user()->id,
          'action' => 'like'
        ))->delete();
        $this->counters()->decrement('like_counter');
        
        return true;
      } else {
        \Session::forget($this->get_like_key());
        $this->counters()->decrement('like_counter');
        
        return true;
      }
    }
    return false;
  }
  /**
   * Return likes count
   *
   * @return Integer
   */
  public function likes_count()
  {
    return $this->counters()->like_counter;
  }
  /**
   * Is object already liked by user?
   *
   * @return Boolean
   */
  public function isLiked()
  {
    if(!\Auth::user())
    {
      $viewed = \Session::get($this->get_like_key());
      if(!empty($viewed)) {
        return true;
      }  
    } else {
      $user_action = $this->user_counters()
        ->where('action', 'like')
        ->where('class_name', snake_case(get_class($this)))
        ->where('object_id', $this->id)
        ->where('user_id', \Auth::user()->id)->count();
       if($user_action > 0)
         return true;
    }
    return false;
  }
  /**
   * get session storage key for like
   *
   * @return String
   */
  private function get_like_key()
  {
    return 'liked_'.snake_case(get_class($this)).'_'.$this->id;
  }
}
