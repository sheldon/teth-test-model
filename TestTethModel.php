<?php
class TestTethModel extends BaseTest{
  public $class = "TethModel";
  
  public function construct(){
    $test_model = new $this->class();
    $this->results['construct']['empty'] = ($test_model->data == array());
    $test_model = new TethModel(array("testcol1"=>"test1","testcol2"=>"test2"));
    $this->results['construct']['with_data'] = ($test_model->data == array("testcol1"=>"test1","testcol2"=>"test2"));
    return $this->results['construct']['empty'] && $this->results['construct']['with_data'];
  }
  
  public function setter(){
    $test_model = new $this->class();
    $test_model->test_col = "test_value";
    return $this->results['setter']['basic_string_value'] = ($test_model->data["test_col"] == "test_value");
  }
  
  public function getter(){
    $test_model = new $this->class();
    $test_model->test_col = "test_value";
    return $this->results['getter']['basic_string_value'] = ($test_model->test_col == "test_value");
  }
}?>