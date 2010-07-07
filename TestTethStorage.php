<?php
class TestTethStorage extends BaseTest{
  public $class = "TethStorage";

  public function construct(){
    $test_storage = new $this->class;
    $this->results['construct']['empty'] = ($test_storage->collection == null) && ($test_storage->position == 0);
    $test_storage = new $this->class(array("test1","test2"));
    $this->results['construct']['with_data'] = ($test_storage->collection == array("test1","test2")) && ($test_storage->position == 0);
    return $this->results['construct']['empty'] && $this->results['construct']['with_data'];
  }

  public function filter(){
    $ret = true;
    $class = $this->class;
    $result = $class::get()->filter("column", "value");
    if(count($result->filters) === 1) $this->results['filter']['single_filter'] = true;
    else $this->results['filter']['single_filter'] = $ret = false;

    $result = $result->filter("col", "value1")->filter("col", "value2")->filter("col", "value3")->filter("col", "value4", "!=");
    if(count($result->filters) === 5) $this->results['filter']['additive_filter'] = true;
    else $this->results['filter']['additive_filter'] = $ret = false;

    return $ret;
  }

  public function remove_filter(){
    $ret = true;
    $class = $this->class;
    $result = $class::get()->filter("column", "value")->filter("col", "value1")->filter("col", "value2")->filter("col", "value3")->filter("col", "value4", "!=");

    $result = $result->remove_filter("col", "value4", "!=");
    if(count($result->filters) === 4) $this->results['filter']['removed_by_col_and_value_and_op'] = true;
    else $this->results['filter']['removed_by_col_and_value_and_op'] = $ret = false;

    $result = $result->remove_filter("col", "value1");
    if(count($result->filters) === 3) $this->results['filter']['removed_by_col_and_value'] = true;
    else $this->results['filter']['removed_by_col_and_value'] = $ret = false;

    $result = $result->remove_filter("col");
    if(count($result->filters) === 1) $this->results['filter']['removed_by_col'] = true;
    else $this->results['filter']['removed_by_col'] = $ret = false;

    return $ret;
  }

  public function save(){
		$class = $this->class;
		$start = $class::get()->all()->count();
    $model1 = new TethModel;
		$model1->var = 1;
		$class::save($model1);
		$this->results['save']['saved_single'] = ($class::get()->all()->count() == ($start+1) );
		$model2 = new TethModel;
		$model2->var = 2;
		$model3 = new TethModel;
		$model3->var = 3;
		$class::save($model2, $model3);
		$this->results['save']['saved_multiple'] = ($class::get()->all()->count() == ($start+3) );
		
		return $this->results['save']['saved_multiple'] && $this->results['save']['saved_single'];
	}

  public function all(){
    $ret = true;
    $class = $this->class;
    $model = new TethModel;
    $model->name = "x";
    $class::save($model);

    $model = new TethModel;
    $model->name = "z";
    $class::save($model);
		
		$model = new TethModel;
    $model->name = "x";
		$model->sect = 'section';
    $class::save($model);

		$result = $class::get()->all();
    $this->results['all']['found_all'] = ($result->count() == 3);
		
    $result = $class::get()->filter("name", "z")->all();
    $this->results['all']['found_by_name'] = ($result->count() == 1);

		$result = $class::get()->filter("name", "x")->all();
    $this->results['all']['found_by_name_with_duplicates'] = ($result->count() == 2);

		$result = $class::get()->filter("name", "x")->filter('sect', "section")->all();
		$this->results['all']['chained_filter'] = ($result->count() == 1);

		$result = $class::get()->filter("name", "z")->filter('name', "x")->all();
		$this->results['all']['chained_filter_fail'] = ($result->count() == 0);
		
		return $this->results['all']['found_all'] && $this->results['all']['found_by_name'] && $this->results['all']['found_by_name_with_duplicates'] && $this->results['all']['chained_filter'] && $this->results['all']['chained_filter_fail'];
  }

  //Iterator methods
  public function rewind(){
    $test_storage = new $this->class;
    $test_storage->position = 5;
    $test_storage->rewind();
    return $this->results['rewind']['is_at_start'] = ($test_storage->position === 0);
  }
  public function current(){
    $test_storage = new $this->class(array("test1"));
    $this->results['current']['valid_position'] = ($test_storage->current() instanceof TethModel);
    $test_storage->position = 5;
    $this->results['current']['invalid_position'] = !($test_storage->current() instanceof TethModel);
    return $this->results['current']['valid_position'] && $this->results['current']['invalid_position'];
  }
  public function key(){
    $test_storage = new $this->class;
    $test_storage->position = 5;
    return $this->results['key']['returns_correct_position'] = ($test_storage->key() == 5);
  }
  public function next(){
    $test_storage = new $this->class;
    $test_storage->position = 5;
    $test_storage->next();
    return $this->results['next']['returns_correct_type'] = ($test_storage->position == 6);
  }
  public function valid(){
    $test_storage = new $this->class(array("test1","test2"));
    $test_storage->position = 1;
    $this->results['valid']['valid_check'] = $test_storage->valid();
    $test_storage->position = 5;
    $this->results['valid']['invalid_check'] = !$test_storage->valid();
    return $this->results['valid']['valid_check'] && $this->results['valid']['invalid_check'];
  }

  //ArrayAccess methods
  public function offsetSet(){
    $test_storage = new $this->class;
    $test_storage->offsetSet(5,"testing");
    return $this->results['offsetSet']['sets_correctly'] = ($test_storage->collection[5] == "testing");
  }
  public function offsetExists(){
    $test_storage = new $this->class;
    $test_storage->offsetSet(5,"testing");
    return $this->results['offsetExists']['exists_checks_correctly'] = $test_storage->offsetExists(5);
  }
  public function offsetUnset(){
    $test_storage = new $this->class(array("test1","test2"));
    $test_storage->offsetUnset(0);
    return $this->results['offsetUnset']['unsets_correctly'] = (!$test_storage->offsetExists(0));
  }
  public function offsetGet(){
    $test_storage = new $this->class(array("test1","test2"));
    $this->results['offsetGet']['gets_existing'] = ($test_storage->offsetGet(1)->data == "test2");
    $this->results['offsetGet']['gets_empty_non_existing'] = ($test_storage->offsetGet(5) == null);
    return $this->results['offsetGet']['gets_existing'] && $this->results['offsetGet']['gets_empty_non_existing'];
  }

  //Countable method
  public function count(){
    $test_storage = new $this->class(array("test1","test2"));
    return $this->results['count']['count_match'] = ($test_storage->count() == 2);
  }
}?>