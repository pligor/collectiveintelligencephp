<?php
/**
 * @author pligor
 */
class MultitestFormTest extends CDbTestCase {
	public $class;
	
	protected $classes = array(
		'Dummy',
		'Iphone',
	);
	
	protected $scenario = 'insert';
	
	public function __construct($name = NULL, array $data = array(), $dataName = '') {
		parent::__construct($name,$data,$dataName);
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
		$func = lcfirst( substr(__FUNCTION__, strlen('test')) );
		$function = array($this->class, $func);
		
		$actual = call_user_func($function,$var);
		$this->assertEmpty($actual);
		$this->assertEquals($expected, $actual);
	}*/
	
	/*public function testGetter() {
		$model = new $this->class($this->classes, $this->scenario);
		
		$model->not_existant_attr = 3;
		
		//$this->assertEmpty($actual);
		//$this->assertEquals($expected, $actual);
	}*/
	
	public function testGetFormElements() {
		$func = lcfirst( substr(__FUNCTION__, strlen('test')) );
		$model = new $this->class($this->classes, $this->scenario);
		$function = array($model, $func);
		
		$subForms = call_user_func($function);
		
		foreach($subForms as $class => $subForm) {
			$actual = $subForm['elements'];
			$expected = $model->models[$class]->getFormElements();
			$this->assertEquals($expected, $actual);
		}
	}
	
	public function testSetModelAttribute() {
		$func = lcfirst( substr(__FUNCTION__, strlen('test')) );
		$model = new $this->class($this->classes, $this->scenario);
		$function = array($model, $func);
		
		$condition = call_user_func($function,'xxxxxx','somevalue');	//not existing attribute
		$this->assertFalse($condition);
		
		$value = 'somevalue';
		$condition = call_user_func($function,'features',$value);	//not existing attribute
		$this->assertTrue($condition);
		$condition = ($model->models['Iphone']->features === $value);
		$this->assertTrue($condition);
		
		$value = 22;
		$condition = call_user_func($function,'descr',$value);	//not existing attribute
		$this->assertTrue($condition);
		$condition = ($model->models['Dummy']->descr === $value);
		$this->assertTrue($condition);
	}
	
	public function testGetModelAttribute() {
		$func = lcfirst( substr(__FUNCTION__, strlen('test')) );
		$model = new $this->class($this->classes, $this->scenario);
		$function = array($model, $func);
		
		$condition = call_user_func($function,'xxxxxx');
		$this->assertFalse($condition);
		//var_dump($condition);
		
		$model->models['Dummy']->value = 101;
		$actual = call_user_func($function,'value');
		$expected = $model->models['Dummy']->value;
		$this->assertEquals($expected, $actual);
		
		$model->models['Iphone']->features = 'some camera';
		$actual = call_user_func($function,'features');
		$expected = $model->models['Iphone']->features;
		$this->assertEquals($expected, $actual);
	}
	
	public function testCheckModelAttribute() {
		$func = lcfirst( substr(__FUNCTION__, strlen('test')) );
		$model = new $this->class($this->classes, $this->scenario);
		$function = array($model, $func);
		
		$condition = call_user_func($function,'name');
		$this->assertTrue($condition);
		
		$condition = call_user_func($function,'id');
		$this->assertTrue($condition);
		
		$condition = call_user_func($function,'value');
		$this->assertTrue($condition);
		
		$condition = call_user_func($function,'descr');
		$this->assertTrue($condition);
		
		$condition = call_user_func($function,'diagonal');
		$this->assertTrue($condition);
		
		$condition = call_user_func($function,'features');
		$this->assertTrue($condition);
		
		$condition = call_user_func($function,'dummy_id');
		$this->assertTrue($condition);
		
		$condition = call_user_func($function,'xxxxx');
		$this->assertFalse($condition);
	}
	
	public function testCheckModels() {
		$func = lcfirst( substr(__FUNCTION__, strlen('test')) );
		$model = new $this->class($this->classes, $this->scenario);
		$function = array($model, $func);
		
		$condition = call_user_func($function);
		$this->assertTrue($condition);
		
		unset($model->models['Dummy']);
		$condition = call_user_func($function);
		$this->assertFalse($condition);
		
		$model->models['Dummy'] = 'string';
		$condition = call_user_func($function);
		$this->assertFalse($condition);
		
		$model->models['Dummy'] = new Iphone();
		$condition = call_user_func($function);
		$this->assertFalse($condition);
		
		$model->models['Dummy'] = new Dummy();
		$condition = call_user_func($function);
		$this->assertTrue($condition);
	}
}
