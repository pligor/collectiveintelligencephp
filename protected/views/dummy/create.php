<?php
$this->breadcrumbs=array(
	'Dummies'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Dummy', 'url'=>array('index')),
	array('label'=>'Manage Dummy', 'url'=>array('admin')),
);
?>

<h1>Create Dummy</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>