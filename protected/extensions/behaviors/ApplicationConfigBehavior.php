<?php

/**
 * ApplicationConfigBehavior class
 * @author pligor
 */
class ApplicationConfigBehavior extends CBehavior {
    /**
     * Declares events and the event handler methods
     * See yii documentation on behaviour
     */
    public function events() {
        return array_merge(parent::events(), array(
            'onBeginRequest' => 'beginRequest',
        ));
    }
 
    /**
     * Load configuration that cannot be put in config/main
     */
    public function beginRequest() {
        Yii::app()->clientScript->registerCoreScript('jquery');
		
		if(!function_exists('t')) {
			function t($message, $params=array(), $source=null, $language=null, $category='') {
				return Yii::t($category, $message, $params, $source, $language);
			}
		}
    }
}