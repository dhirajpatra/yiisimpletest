<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Users',
);

$this->menu=array(
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>Users</h1>
<?php echo CHtml::link('<img src="'. Yii::app()->request->baseUrl . '/images/add-user-enabled.jpg" onclick="javascript: jQuery(\'#user-form\').show(); jQuery(this).hide();">'); ?>
<div id="user-form" style="display: none;">
	<?php
	$this->breadcrumbs=array(
		'Users'=>array('index'),
		'Create',
	);
	$this->renderPartial('_form', array('model'=>User::model()));
	?>
</div>

<?php
/*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$result,
	'itemView'=>'_view',
));*/

foreach ($result as $data){
	$data = $data['user'];

?>

	<div class="view">
		<div class="container">
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'user-form'.$data['id'],
				'method' => 'post',
				'action' => 'lend/borrow',
				'enableAjaxValidation'=>false,
			)); ?>
			<div class="column-center">
				<?php
					echo '<div class="book-count-img">' . (($data['total'] > 0)?CHtml::encode($data['total']):null) . '</div>';
				?>
			</div>
			<div class="column-left">
				<div class="column-left-user">
					<?php echo CHtml::hiddenField("user_id", CHtml::encode($data['id'])); ?>
					<?php echo '<img class="img-circle" src="'. Yii::app()->request->baseUrl . '/images/' . $data['photo'].'" >'; ?>
				</div>
				<div class="column-right-user">
					<div>
						<h6>
							<?php echo CHtml::encode($data['name']); ?>
						</h6>
					</div>
					<br>
					<?php echo CHtml::encode($data['address1']); ?>
					<br>
					<?php echo CHtml::encode($data['address2']); ?>
				</div>
			</div>
			<div class="column-right">

				<?php
				foreach ( $data['books'] as $book ) {
					echo '<span style="color: red;">-</span>' . CHtml::encode($book['title'] . ' - ' .$book['author']) .'<br>';
				}

				?>
				<div style="display: none;" id="add-book-select-<?php echo CHtml::encode($data['id']); ?>">
					<?php

						Yii::import('application.controllers.BookController');
						echo CHtml::dropDownList('books', '', BookController::actionBooksList(),
						array(
							'prompt' => 'Select Book',
							'ajax' => array(
								'type'=>'POST', //request type
								'url'=>CController::createUrl('lend/borrow'), //url to call.
//Style: CController::createUrl('currentController/methodToCall')
								//'update'=>'', //selector to update
								'data' => 'js:jQuery(this).parents("form").serialize()',
								//'data' => 'js:jQuery("#user_id").val() + "##" + jQuery("#books").val()',
//'data'=>'js:javascript statement'
								'success' => "function(string){
									//alert(string);	
									var obj = jQuery.parseJSON(string);
									if(obj.status == 'success'){
										//console.log(string);
										location.reload();
									}
									
								}"
//leave out the data key to pass all form values through
							)));

					?>
				</div>
				<div style="font-size: 18px;" onclick="jQuery('#add-book-select-<?php echo CHtml::encode($data['id']); ?>').show(); jQuery(this).hide();">+</div>
			</div>
			<?php $this->endWidget(); ?>
		</div>

	</div>

<?php

}

?>
