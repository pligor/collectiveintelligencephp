<?php

/**
 * @author pligor
 */
class UserTest extends CDbTestCase {

    public $class;

    public function __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->class = substr(__CLASS__, 0, -strlen('test'));
    }

    //The array represents a mapping from fixture names that will be
    //used in the tests to model class names or fixture table names
    //(for example, from fixture name projects to model class Project)
    public $fixtures = array(
            //'prosopos' => 'Prosopo',
            //'projUsrAssign' => ':tbl_project_user_assignment',
    );

    //If you need to use a fixture for a table that is not represented
    //by an AR class, you need to prefix table name with a colon
    //(for example, :tbl_project) to differentiate it from the model class name.
    //REMEMBER: fixtures can be accessed as an object or as an array, whichever is suitable
///*
    public function testFindAllUsers() {
        $func = lcfirst(substr(__FUNCTION__, strlen('test')));
        $function = array($this->class, $func);

        $actual = call_user_func($function);
        //$this->assertEmpty($actual);
        //$this->assertArrayHasKey();
    }

    public function testGetPreferences() {
        $func = lcfirst(substr(__FUNCTION__, strlen('test')));
        $model = new $this->class();
        $function = array($model, $func);
        
        $model->name = 'Michael Phillips';
        $actual = call_user_func($function);
        $this->assertEquals(4, count($actual));
        
        
        $model->name = 'Mick LaSalle';
        $actual = call_user_func($function);
        $this->assertEquals(6, count($actual));
        
        $model->name = 'Mick';
        $actual = call_user_func($function);
        $this->assertEquals(null, $actual);
    }
    
    public function testGetSharedPrefs() {
        $func = lcfirst(substr(__FUNCTION__, strlen('test')));
        $model = new $this->class();
        $function = array($model, $func);
        
        $model->name = 'Michael Phillips';
        
        $user = new $this->class();
        $user->name = 'Claudia Puig';
        
        $actual = call_user_func($function,$user);
        $this->assertEquals(3, count($actual));
    }
    
    public function testSimilarity() {
        $func = lcfirst(substr(__FUNCTION__, strlen('test')));
        $model = new $this->class();
        $function = array($model, $func);
        
        $user = new $this->class();
        
        $model->name = 'Michael Phillips';
        $user->name = 'Claudia Puig';
        
        $actual = round(call_user_func($function,$user),3);
        $this->assertEquals(0.866, $actual);
        
        $actual = call_user_func($function,$user,'pearson');
        $this->assertEquals(0, $actual);
    }
    //*/
    ///*
    public function testMostSimilars() {
        $func = lcfirst(substr(__FUNCTION__, strlen('test')));
        $model = new $this->class();
        $function = array($model, $func);
        
        $model->name = 'George Pligor';
        
        $actual = call_user_func($function);
        $this->assertEquals(3, count($actual));
       
        //$actual = $model->mostSimilars('euclidean');
        //print_r($actual);
    }
    //*/
    public function testGetRecommendations() {
        $func = lcfirst(substr(__FUNCTION__, strlen('test')));
        $model = new $this->class();
        $function = array($model, $func);
        
        $model->name = 'Toby';
        
        $actual = call_user_func($function);
        $this->assertEquals(3, count($actual));
        //print_r($actual);
        
        $actual = call_user_func($function,'euclidean',2);
        $this->assertEquals(2, count($actual));
        //print_r($actual);
    }
    
    public function testGetRecommendedItems() {
        $func = lcfirst(substr(__FUNCTION__, strlen('test')));
        $model = new $this->class('Toby');
        $function = array($model, $func);
        
        $ranks = call_user_func($function);
    }
}
