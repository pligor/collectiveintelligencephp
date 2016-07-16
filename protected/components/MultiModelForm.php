<?php
/**
 * @author pligor
 * 
 * NOTES before use:
 * By definition all models are assigned the same scenario 
 * If you have the same name among models then there is a conflict and therefore do not use the automatic __get and __set
 * rather use $this->models['some_class_name']->attributeName = ....
 * 
 * @property CForm $form
 */
abstract class MultiModelForm extends FormModel {
	/**
	 * @var array
	 */
	public $classes = array();
	
	/**
	 * @var array
	 */
	public $models = array();
	
	/**
	 * validation is enabled on how you implement this function 
	 * @throws CException
	 */
	abstract protected function actualSave();
	
	/**
	 * @return boolean 
	 */
	public function save() {
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$this->actualSave();
			
			$transaction->commit();
			return true;
		}
		catch(CException $e) {
		    $transaction->rollBack();
		    //throw new CException( $e->getMessage(), $e->getCode() ); //rethrow
			return false;
		}
	}
	
	/**
	 * Force setting classes as well as scenario before instantiating
	 * @param array $classes
	 * @param string $scenario
	 */
	public function __construct($classes, $scenario, $models=array()) {
		//$name = 'MultiModelBehavior';
		//$behavior = new $name($classes);
		//$this->attachBehavior($name, $behavior);
		
		//scenario is set later with set scenario
		$this->classes = $classes;
		foreach($this->classes as $class) {
			if( isset($models[$class]) ) {
				$this->models[$class] = $models[$class];
			}
			else {
				$this->models[$class] = new $class();
			}
		}
		
		parent::__construct($scenario);

		//$this->appendSafeRules();
	}
	
	/**
	 * @todo THIS WORKS ONLY if you have one level deep forms
	 * @param CForm $form
	 * @return CForm
	 */
	public function assignModels2Form($form) {
		if( $this->checkModels() ) {
			foreach($this->models as $class => $model) {
				$form[$class]->model = $model;
			}
		}
		return $form;
	}
	
	public function getForm($formClass='CForm') {
		$formConfig = $this->getFormConfig();
		$form = new $formClass($formConfig);
		$form = $this->assignModels2Form($form);
		
		return $form;
	}
	
	public function getFormConfig() {
		return array(
			'showErrorSummary' => true,
			'elements' => $this->getFormElements(),
			'buttons' => array(
				'submit' => array(
					'type' => 'submit',
					'label' => t('Submit'),
				),
			),
			'activeForm' => array(
				'class' => 'CActiveForm',
				'enableAjaxValidation' => false,
				'enableClientValidation' => false,
			),
			/*
		    'attributes' => array(
		    	'enctype' => 'multipart/form-data',		//ALWAYS REMEMBER TO DEFINE THIS WHEN HANDLING FILES
		    ),*/
		);
	}
	
	public function getFormElements() {
		$subForms = array();
		foreach($this->models as $class => $model) {
			$subForms[$class] = array(
				'type' => 'form',
				'title' => $class,
			);
			$subForms[$class]['elements'] = $model->getFormElements();
		}
		return $subForms;
	}
	
	/**
	 * Get safe attribute name
	 * @param string $name
	 * @see CComponent::__get()
	 */
	public function __get($name) {
		if( !$this->checkModelAttribute($name) ) {
			return parent::__get($name);
		}
		return $this->getModelAttribute($name);
	}
	
	/**
	 * @see CComponent::__set()
	 */
	public function __set($name, $value) {
		if( !$this->setModelAttribute($name, $value) ) {
			parent::__set($name, $value);
		}
	}
	
	/**
	 * BE AWARE: works only for non conflicting attribute names
	 * @param string $name
	 * @param mixed $value
	 * @return bool 
	 */
	public function setModelAttribute($name, $value) {
		if( $this->checkModels() ) {
			foreach($this->models as $class => $model) {
				if( in_array($name, $model->attributeNames()) ) {
					$model->$name = $value;
					return true;
				}	
			}
		}
		return false;
	}
	
	/**
	 * BE AWARE: works only for non conflicting attribute names
	 * Get the value of the attribute contained in the models
	 * @param string $name
	 * @return mixed 
	 */
	public function getModelAttribute($name) {
		if( $this->checkModels() ) {
			foreach($this->models as $class => $model) {
				if( in_array($name, $model->attributeNames()) ) {
					return $model->$name;
				}	
			}	
		}
		return false;
	}
	
	/**
	 * BE AWARE: works only for non conflicting attribute names
	 * Check whether the attribute is contained inside the models
	 * @param string $name the name of the attribute which we are looking for
	 * @return boolean 
	 */
	public function checkModelAttribute($name) {
		if($this->checkModels()) {
			foreach($this->models as $class => $model) {
				if( in_array($name, $model->attributeNames()) ) {
					return true;
				}	
			}	
		}
		return false;
	}
	
	/**
	 * check if all models are set and are objects of the correct class each
	 * @return bool
	 */
	public function checkModels() {
		foreach($this->classes as $class) {
			if( !isset($this->models[$class]) ) {
				return false;
			}
			
			if( !is_object($this->models[$class]) ) {
				return false;
			}
			
			if( !($this->models[$class] instanceof $class) ) {
				return false;
			}
		}
		return true;
	}
	
	/**
	 * set the scenario to all the models
	 * @param string $value 
	 */
	public function setModelsScenario($value) {
		if( $this->checkModels() ) {
			foreach($this->models as $model) {
				$model->scenario = $value;
			}
		}
	}
	
	/**
	 * Set the same scenario also for all the corresponding models
	 * @param string $value
	 * @see CModel::setScenario()
	 */
	public function setScenario($value) {
		$this->setModelsScenario($value);
		parent::setScenario($value);
	}
}

/**
 * @property array $classes
 * @property array $models
 */
class HNFARIHRIAHIAG {
	
	public function rules() {
		return $this->rules;
	}
	
	public function attributeLabels() {
		return $this->getAttrLabels();
	}
	
	public $rules = array();
	
	/**
	 * get rules for currently safe attributes for all models
	 */
	public function appendSafeRules() {
		foreach($this->models as $model) {
			$this->rules = array_merge($this->rules, $this->getSafeRules($model));
		}
	}
	
	/**
	 * get rules for currently safe attributes for specific model
	 */
	public function getSafeRules($model) {
		$safeRules = array();
		$rules = $model->rules();
		foreach($rules as $rule) {
			if(isset($rule['on']) && $model->scenario != $rule['on']) {	//skip invalid scenario rules
				continue;
			}
			
			if($rule[1]=='safe' || $rule[1]=='unsafe') {	//skip safe and unsafe rules
				continue;
			}
			
			$attributes = ArrayHelper::commaSeparated2array( $rule[0] );
			$safeRuleAttrs = array_intersect($model->safeAttributeNames, $attributes);
			$rule[0] = implode(', ', $safeRuleAttrs);
			
			$safeRules[] = $rule;
		}
		return $safeRules;
	}
	
	/**
	 * Get all attributes with their values
	 */
	public function getAttrs() {
		if( !$this->checkModels() ) return false;
		$attrs = array();
		foreach($this->attrNames as $attrName) {
			$attrs[$attrName] = $this->getModelAttribute($attrName); //$this->$attrName;
		}
		return $attrs;
	}

	/**
	 * Helper function to get all attribute names
	 */
	public function getAttrNames() {
		if( !$this->checkModels() ) return false;
		$attrNames = array();
		foreach($this->classes as $class) {
			foreach($this->models[$class]->safeAttributeNames as $safeAttributeName) {
				$attrNames[] = $safeAttributeName;
			}
		}
		return $attrNames;
	}
	
	public function getAttrLabels() {
		$attrLabels = array();
		foreach($this->models as $model) {
			$attrLabels += $model->attributeLabels();
		}
		return $attrLabels;
	}
}