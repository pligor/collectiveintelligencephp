<?php

/**
 * This is the model class for table "iphone".
 * @author pligor
 * The followings are the available columns in table 'iphone':
 * @property integer $id
 * @property string $name
 * @property double $diagonal
 * @property string $features
 * @property integer $dummy_id
 *
 * The followings are the available model relations:
 * @property Dummy $dummy
 */
class Iphone extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Iphone the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{iphone}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, diagonal, dummy_id', 'required'),
			array('dummy_id', 'numerical', 'integerOnly'=>true),
			array('diagonal', 'numerical'),
			array('name', 'length', 'max'=>45),
			array('features', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, diagonal, features, dummy_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'dummy' => array(self::BELONGS_TO, 'Dummy', 'dummy_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => t('ID'),
			'name' => t('Name'),
			'diagonal' => t('Diagonal'),
			'features' => t('Features'),
			'dummy_id' => t('Dummy'),
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
		$criteria->compare('diagonal',$this->diagonal);
		$criteria->compare('features',$this->features,true);
		$criteria->compare('dummy_id',$this->dummy_id);

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
			'diagonal' => array(
				'type' => 'text',
				//'hint' => '',
				'attributes' => array(
				),
			),
			'features' => array(
				'type' => 'text',
				//'hint' => '',
				'attributes' => array(
				),
			),
			/*'dummy_id' => array(
				'type' => 'hidden',
				//'hint' => '',
				'attributes' => array(
				),
			),*/
		);
	}
}
