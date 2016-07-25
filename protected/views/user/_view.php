<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">
    <div class="container">
        <div class="column-center">

        </div>
        <div class="column-left">
            <div class="column-left-user">
                <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
                <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
                <?php echo '<img class="img-circle" src="'. Yii::app()->request->baseUrl . '/images/usr' . $data->id . '.jpg" >'; ?>
            </div>
            <div class="column-right-user">
                <div>
                    <h6>
                        <?php echo CHtml::encode($data->salutation); ?>
                        <?php echo CHtml::encode($data->title); ?>
                        <?php echo CHtml::encode($data->firstname); ?>
                        <?php echo CHtml::encode($data->lastname); ?>
                    </h6>
                </div>
                <br>
                <?php echo CHtml::encode($data->streetnumber); ?>
                <?php echo CHtml::encode($data->street); ?>
                <br>
                <?php echo CHtml::encode($data->zip) . ', '; ?>
                <?php echo CHtml::encode($data->city); ?>
            </div>
        </div>
        <div class="column-right">

        </div>
    </div>

</div>