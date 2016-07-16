<?php
$this->breadcrumbs=array(
	'Dummies'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Dummy', 'url'=>array('index')),
	array('label'=>'Create Dummy', 'url'=>array('create')),
	array('label'=>'View Dummy', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Dummy', 'url'=>array('admin')),
);
?>

<h1>Update Dummy <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>