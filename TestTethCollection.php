<?php
class TestTethCollection extends BaseTest{
  public $class = "TethCollection";
  
  //Iterator methods
  public function rewind(){
    $test_collection = new $this->class;
    $test_collection->position = 5;
    $test_collection->rewind();
    return $this->results['rewind']['is_at_start'] = ($test_collection->position === 0);
  }
  public function current(){ return false; }
  public function key(){ return false; }
  public function next(){ return false; }
  public function valid(){ return false; }

  //ArrayAccess methods
  public function offsetSet(){ return false; }
  public function offsetExists(){ return false; }
  public function offsetUnset(){ return false; }
  public function offsetGet(){ return false; }

  //Countable method
  public function count(){ return false; }
}?>