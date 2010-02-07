<?php
class TestTethModel extends BaseTest{
  public $class = "TethModel";
  
  public function construct(){
    $test_model = new TethModel();
    $this->results['construct']['empty'] = ($test_model->data == array());
    $test_model = new TethModel(array("testcol1"=>"test1","testcol2"=>"test2"));
    $this->results['construct']['with_data'] = ($test_model->data == array("testcol1"=>"test1","testcol2"=>"test2"));
    return $this->results['construct']['empty'] && $this->results['construct']['with_data'];
  }
  
  public function setter(){
    $ret = true;
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