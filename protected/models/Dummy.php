<?php

/**
 * This is the model class for table "dummy".
 * @author pligor
 * The followings are the available columns in table 'dummy':
 * @property integer $id
 * @property string $name
 * @property integer $value
 * @property string $descr
 * 
 * The followings are the available model relations:
 * @property Iphone[] $iphones
 */
class Dummy extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Dummy the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{dummy}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, value', 'required'),
			array('value', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('descr', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, value, descr', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'iphones' => array(self::HAS_MANY, 'Iphone', 'dummy_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => t('ID'),
			'name' => t('Name'),
			'value' => t('Value'),
			'descr' => t('Descr'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value);
		$criteria->compare('descr',$this->descr,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * @return \CForm 
	 */
	public function getForm($formClass='CForm') {
		$config = $this->getFormConfig();
		return new $formClass($config, $this);	//all subforms get the model from their parent
	}
	
	/**
	 * @return array with the configuration of this form 
	 */
	public function getFormConfig() {
		return array(
		    //'title' => '',
		    'showErrorSummary' => true,
		    //'elements' => array(get_class() => $this->getFormElements(),),	//if you want subforms
			'elements' => $this->getFormElements(),
		    'buttons' => array(
		        'submit' => array(
					'type' => 'submit',
					'label' => t('Submit'),
		        ),
		    ),/*
		    'attributes' => array(
		    	'enctype' => 'multipart/form-data', //ALWAYS REMEMBER TO DEFINE THIS WHEN HANDLING FILES
		    ),*/
			'activeForm' => array(
				'class' => 'CActiveForm',
			),
		);
	}
	/**
	 * @return array the elements of this form
	 */
	public function getFormElements() {
		return array(
			'name' => array(
				'type' => 'text',
				//'hint' => '',
				'attributes' => array(
				),
			),
			'value' => array(
				'type' => 'text',
				//'hint' => '',
				'attributes' => array(
				),
			),
			'descr' => array(
				'type' => 'text',
				//'hint' => '',
				'attributes' => array(
				),
			),
		);
	}
}
