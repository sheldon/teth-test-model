<?php
class TestTethModel extends BaseTest{
  public $class = "TethModel";
  
  public function setter(){
    $ret = false;
    $test_model = new TethModel();
    $test_model->test_col = "test_value";
    if($test_model->data["test_col"] != "test_value") $this->results['setter']['basic_string_value'] = $ret = false;
    else $this->results['setter']['basic_string_value'] = true;

    return $ret;
  }
  public function getter(){
    $ret = true;
    $test_model = new TethModel();
    $test_model->test_col = "test_value";
    if($test_model->test_col != "test_value") $this->results['getter']['basic_string_value'] = $ret = false;
    else $this->results['getter']['basic_string_value'] = true;

    return $ret;
  }
}?>