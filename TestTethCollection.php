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
  public function current(){
    $test_collection = new $this->class;
    return $this->results['current']['returns_correct_type'] = ($test_collection->current() instanceof TethModel);
  }
  public function key(){
    $test_collection = new $this->class;
    $test_collection->position = 5;
    return $this->results['key']['returns_correct_position'] = ($test_collection->key() == 5);
  }
  public function next(){
    $test_collection = new $this->class;
    $test_collection->position = 5;
    $test_collection->next();
    return $this->results['next']['returns_correct_type'] = ($test_collection->position == 6);
  }
  public function valid(){
    $test_collection = new $this->class(array("test1","test2"));
    $test_collection->position = 1;
    $should_be_valid = $test_collection->valid();
    $test_collection->position = 5;
    $should_be_invalid = $test_collection->valid();
    return ($this->results['valid']['valid_check'] = $should_be_valid) && ($this->results['valid']['invalid_check'] = !$should_be_invalid);
  }

  //ArrayAccess methods
  public function offsetSet(){
    $test_collection = new $this->class;
    $test_collection->offsetSet(5,"testing");
    return $this->results['offsetSet']['sets_correctly'] = ($test_collection->collection[5] == "testing");
  }
  public function offsetExists(){
    $test_collection = new $this->class;
    $test_collection->offsetSet(5,"testing");
    return $this->results['offsetExists']['exists_checks_correctly'] = $test_collection->offsetExists(5);
  }
  public function offsetUnset(){
    $test_collection = new $this->class(array("test1","test2"));
    $test_collection->offsetUnset(0);
    return $this->results['offsetUnset']['unsets_correctly'] = (!$test_collection->offsetExists(0));
  }
  public function offsetGet(){
    $test_collection = new $this->class(array("test1","test2"));
    return $this->results['offsetGet']['gets_correctly'] = ($test_collection->offsetGet(1)->data == "test2");
  }

  //Countable method
  public function count(){
    $test_collection = new $this->class(array("test1","test2"));
    return $this->results['count']['count_match'] = ($test_collection->count() == 2);
  }
}?>