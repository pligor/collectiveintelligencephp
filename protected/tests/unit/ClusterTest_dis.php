<?php

/**
 * @author pligor
 */
class ClusterTest extends CDbTestCase {

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

    /*public function testStaticFunction() {
        $func = lcfirst(substr(__FUNCTION__, strlen('test')));
        $function = array($this->class, $func);

        $actual = call_user_func($function, $var);
        $this->assertEmpty($actual);
        $this->assertEquals($expected, $actual);
    }*/
   
    public function testMergeVec() {
        $func = lcfirst(substr(__FUNCTION__, strlen('test')));
        $model = new $this->class();
        $function = array($model, $func);
        
        $model->vec = array(1,5,2);
        $otherModel = new $this->class(array(3,9,18));

        $actual = call_user_func($function,$otherModel);
        $expected = array(2,7,10);
        $this->assertEquals($expected, $actual);
    }

}
