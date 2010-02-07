<?php
class TestTethCollection extends BaseTest{
  public $class = "TethCollection";
  
  public function construct(){
    $test_collection = new $this->class;
    $this->results['construct']['empty'] = ($test_collection->collection == null) && ($test_collection->position == 0);
    $test_collection = new $this->class(array("test1","test2"));
    $this->results['construct']['with_data'] = ($test_collection->collection == array("test1","test2")) && ($test_collection->position == 0);
    return $this->results['construct']['empty'] && $this->results['construct']['with_data'];
  }
  
  public function get(){
    $test_collection = TethCollection::get();
    return $this->results['get']['returns_correct_class'] = ($test_collection instanceof $this->class);
  }

  //Iterator methods
  public function rewind(){
    $test_collection = new $this->class;
    $test_collection->position = 5;
    $test_collection->rewind();
    return $this->results['rewind']['is_at_start'] = ($test_collection->position === 0);
  }
  public function current(){
    $test_collection = new $this->class;
    return $this->results['current']['empty_teth_class'] = ($test_collection->current() instanceof TethModel);
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
    $this->results['valid']['valid_check'] = $test_collection->valid();
    $test_collection->position = 5;
    $this->results['valid']['invalid_check'] = !$test_collection->valid();
    return $this->results['valid']['valid_check'] && $this->results['valid']['invalid_check'];
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
    $this->results['offsetGet']['gets_existing'] = ($test_collection->offsetGet(1)->data == "test2");
    $this->results['offsetGet']['gets_empty_non_existing'] = ($test_collection->offsetGet(5) == null);
    return $this->results['offsetGet']['gets_existing'] && $this->results['offsetGet']['gets_empty_non_existing'];
  }

  //Countable method
  public function count(){
    $test_collection = new $this->class(array("test1","test2"));
    return $this->results['count']['count_match'] = ($test_collection->count() == 2);
  }
}?>