<?php

/**
 * @author pligor
 */
class ClusteringTest extends CDbTestCase {

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
/*
    public function testStaticFunction() {
        $func = lcfirst(substr(__FUNCTION__, strlen('test')));
        $function = array($this->class, $func);

        $actual = call_user_func($function, $var);
        $this->assertEmpty($actual);
        $this->assertEquals($expected, $actual);
    }
*/
    public function testInit() {
        $func = lcfirst(substr(__FUNCTION__, strlen('test')));
        $model = new $this->class();
        $function = array($model, $func);

        call_user_func($function);
        $actual =  count($model->clusters);
        $this->assertEquals(98, $actual);
    }
    /*
    public function testHcluster() {
        $func = lcfirst(substr(__FUNCTION__, strlen('test')));
        $model = new $this->class();
        $function = array($model, $func);
        
        $actual = call_user_func($function);
        $this->assertInstanceOf($actual,'Cluster');
    }
    */
    
    public function testRenderDendrogram() {
        $func = lcfirst(substr(__FUNCTION__, strlen('test')));
        $model = new $this->class();
        $function = array($model, $func);
        
        $root = $model->hcluster();

        $filepath = Yii::getPathOfAlias('application.data') .'/RenderDendrogram.out';
        $expected = file_get_contents($filepath);

        ob_start();
        call_user_func($function, $root);
        $actual = ob_get_clean();

        $this->assertEquals($expected,$actual);
    }
}
