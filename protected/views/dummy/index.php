<?php
$this->breadcrumbs=array(
	'Dummies',
);

$this->menu=array(
	array('label'=>'Create Dummy', 'url'=>array('create')),
	array('label'=>'Manage Dummy', 'url'=>array('admin')),
);
?>

<h1>Dummies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
