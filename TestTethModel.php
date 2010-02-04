<?php
class TestTethModel extends BaseTest{
  public $class = "TethModel";
  
  public function setter(){
    $test_model = new TethModel();
    $test_model->test_col = "test_value";
    if($test_model->data["test_col"] == "test_value"){
      $this->results['setter']['basic_string_value'] = true;
      return true;
    }else return false;
  }
  public function getter(){
    $test_model = new TethModel();
    $test_model->test_col = "test_value";
    if($test_model->test_col == "test_value"){
      $this->results['getter']['basic_string_value'] = true;
      return true;
    }else return false;
  }
}?>