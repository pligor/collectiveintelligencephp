<?php
$output = $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
	'name' => 'city',
	'source' => array_values( array('ac1', 'ac2', 'ac3') ),
	// additional javascript options for the autocomplete plugin
	'options'=>array(
		'minLength'=>'1',
	),
	'htmlOptions'=>array(
		'style'=>'height:20px;'
	),
), true);
print $output;
//print CHtml::encode($output);
//CVarDumper::dumpAsString($output);