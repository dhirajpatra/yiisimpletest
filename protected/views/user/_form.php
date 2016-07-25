<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
    'method' => 'post',
    'action' => 'user/create',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
    'htmlOptions'=>array(
        'enctype' => 'multipart/form-data',
        'onsubmit'=>"return false;",/* Disable normal form submit */
        'onkeypress'=>" if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
    ),
));

echo $form->errorSummary($model);

?>
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="info">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="">
		<div class="column-left">
			<?php echo $form->textField($model,'salutation',array('size'=>20,'maxlength'=>20, 'placeholder' => 'salutation')); ?>
			<?php echo $form->error($model,'salutation'); ?>

		</div>

		<div class="column-left">

			<?php echo $form->textField($model,'title',array('size'=>20,'maxlength'=>20, 'placeholder' => 'title')); ?>
			<?php echo $form->error($model,'title'); ?>

		</div>

		<div class="column-right">

			<?php echo CHtml::activeFileField($model, 'photo'); ?>
            <?php //echo $form->fileField($model, 'photo', array('id' => 'photo')) ?>
			<?php echo $form->error($model,'photo'); ?>
            <div class="row">
                <?php //echo CHtml::image(Yii::app()->request->baseUrl.'/images/'.$model->photo,"photo",array("width"=>200)); ?>
            </div>

		</div>
	</div>

	<div>
		<div>
			<div class="column-left">

				<?php echo $form->textField($model,'firstname',array('size'=>20,'maxlength'=>20, 'placeholder' => 'first name')); ?>
				<?php echo $form->error($model,'firstname'); ?>

			</div>

			<div class="column-left">

				<?php echo $form->textField($model,'lastname',array('size'=>20,'maxlength'=>20, 'placeholder' => 'last name')); ?>
				<?php echo $form->error($model,'lastname'); ?>

			</div>
		</div>
		<div>
			<div class="column-right">

				<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>20, 'placeholder' => 'description')); ?>
				<?php echo $form->error($model,'description'); ?>

			</div>
		</div>
	</div>

	<div>
		<div class="column-left">

			<?php echo $form->textField($model,'street',array('size'=>40,'maxlength'=>40, 'placeholder' => 'street')); ?>
			<?php echo $form->error($model,'street'); ?>

		</div>
		<div class="column-left">

			<?php echo $form->textField($model,'streetnumber',array('size'=>10,'maxlength'=>10, 'placeholder' => 'street no')); ?>
			<?php echo $form->error($model,'streetnumber'); ?>

		</div>

	</div>
	<div>
		<div class="column-left">

			<?php echo $form->textField($model,'city',array('size'=>30,'maxlength'=>30, 'placeholder' => 'city')); ?>
			<?php echo $form->error($model,'city'); ?>

		</div>
		<div class="column-right">

			<?php echo $form->textField($model,'zip',array('size'=>7,'maxlength'=>7, 'placeholder' => 'zip')); ?>
			<?php echo $form->error($model,'zip'); ?>

		</div>
	</div>

	<div class="row">

		<?php echo $form->textField($model,'register_date', array( 'placeholder' => 'register date', 'value' => date('Y-m-d H:i:s'), 'readonly' => 'readonly')); ?>
		<?php echo $form->error($model,'register_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::Button('SUBMIT',array('onclick'=>'javascript: send();')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<script type="text/javascript">

    function send()
    {
        //var form_data = new FormData();
        var data=jQuery("form").serialize();
        //var file_data = jQuery("#User_photo").prop("files")[0];
        //console.log(file_data);

        jQuery.ajax({
            type: 'POST',
            //async: false,
            url: '<?php echo CController::createUrl("user/create"); ?>',
            data:data,
            //processData: false,  // tell jQuery not to process the data
            //contentType: false,  // tell jQuery not to set contentType
            success:function(data){
                //alert(data);
                var obj = jQuery.parseJSON(data);
                if(obj.status == "success"){
                    alert('User successfully saved');
                    location.reload();
                }else{
                    //alert("Error occured.please try again");
                    //console.log(obj);
                    if(obj.User_salutation != ""){
                        jQuery("#User_salutation_em_").html(obj.User_salutation);
                        jQuery("#User_salutation_em_").show();
                    }
                    if(obj.User_city != ""){
                        jQuery("#User_city_em_").html(obj.User_city);
                        jQuery("#User_city_em_").show();
                    }
                    if(obj.User_firstname != ""){
                        jQuery("#User_firstname_em_").html(obj.User_firstname);
                        jQuery("#User_firstname_em_").show();
                    }
                    if(obj.User_lastname != ""){
                        jQuery("#User_lastname_em_").html(obj.User_lastname);
                        jQuery("#User_lastname_em_").show();
                    }
                    if(obj.User_zip != ""){
                        jQuery("#User_zip_em_").html(obj.User_zip);
                        jQuery("#User_zip_em_").show();
                    }
                    if(obj.User_street != ""){
                        jQuery("#User_street_em_").html(obj.User_street);
                        jQuery("#User_street_em_").show();
                    }
                    if(obj.User_streetnumber != ""){
                        jQuery("#User_streetnumber_em_").html(obj.User_streetnumber);
                        jQuery("#User_streetnumber_em_").show();
                    }
                    if(obj.User_title != ""){
                        jQuery("#User_title_em_").html(obj.User_title);
                        jQuery("#User_title_em_").show();
                    }
                    /*if(obj.User_photo != ""){
                        jQuery("#User_photo_em_").html(obj.User_photo);
                        jQuery("#User_photo_em_").show();
                    }*/
                    if(obj.User_description != ""){
                        jQuery("#User_description_em_").html(obj.User_description);
                        jQuery("#User_description_em_").show();
                    }
                }
            },
            dataType:'html'
        });

    }

</script>