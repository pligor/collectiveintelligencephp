<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<ul>
    <li>Views file: <?php echo __FILE__; ?></li>
    <li>Layout file: <?php echo $this->getLayoutFile('main'); ?></li>
</ul>

<div class="form">
<?php
/**
 * @var \CForm $form
 */
if($form) {
	print $form->render();
}
?>
</div>