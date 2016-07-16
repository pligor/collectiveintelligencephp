<?php
$this->breadcrumbs=array(
	'Dummies'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Dummy', 'url'=>array('index')),
	array('label'=>'Create Dummy', 'url'=>array('create')),
	array('label'=>'Update Dummy', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Dummy', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Dummy', 'url'=>array('admin')),
);
?>

<h1>View Dummy #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'value',
		'descr',
	),
)); ?>
