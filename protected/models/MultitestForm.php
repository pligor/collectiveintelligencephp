<?php
//Yii::import('application.models.form.UserLogin');
//Yii::import('application.models.form.RegistrationForm');
/**
 * MultitestForm class
 * @author pligor
 * 
 */
class MultitestForm extends MultiModelForm {
	/**
	 * Initialize model before executing setScenario inside parent's construct
	 */
	public function __construct($models=array(),$scenario='insert') {
		$classes = array(
			'Dummy',
			'Iphone',
		);
		parent::__construct($classes, $scenario, $models);
	}
	
	public function getId() {
		return substr(get_class(), 0, -strlen('Form'));
	}
	
	/*public function rules() {
		return array(
			array('testattr','safe'),
		);
	}*/
	
	/**
	 * Save all models
	 */
	protected function actualSave() {
		$model = $this->models['Dummy'];
		
		if( !$model->save() ) {
			$message = t('saving in table {tableName} has failed',array(
				'{tableName}' => /*$model->tableName()*/'dummy',
			));
			throw new CException($message);
		}
		
		$dummy_id = $model->id;
		
		$model = $this->models['Iphone'];
		
		$model->dummy_id = $dummy_id;
		
		if( !$model->save() ) {
			$message = t('saving in table {tableName} has failed',array(
				'{tableName}' => /*$model->tableName()*/'dummy',
			));
			throw new CException($message);
		}
	}
	
	/**
	 * override parent function since we have a peculiar situation here
	 * @return CForm 
	 */
	/*public function getForm() {
		$formConfig = $this->getFormConfig();
		
		$formConfig['showErrorSummary'] = true;
		
		//Kint::dump($formConfig);
		
		$form = new CForm($formConfig);
		//$form = $this->assignModels2Form($form);
		$form['UserLogin']->model = $this->models['UserLogin'];
		$form['RegistrationForm']['Registration']->model = $this->models['RegistrationForm'];
		$form['RegistrationForm']['Profile']->model = $this->models['RegistrationForm']->profile;

		return $form;
	}*/
}