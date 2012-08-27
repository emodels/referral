<style type="text/css">
    .column{
        width: 200px;
    }
</style>    
<div style="float: left">
    <?php require_once Yii::getPathOfAlias('webroot.protected.views.admin') . '/admin_header_include.php'; ?>
</div>  
<div style="float: left; width: 670px; padding-left: 10px">
    <div class="box" style="border-radius: 5px; border: solid 1px silver">
    <h2 class="icon_search" style="padding-top: 12px"><?php echo $model->referralUser->company; ?> - Update Referral Status<span></span></h2>
    <div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'admin-user-status',
        'htmlOptions' => array('autocomplete' => 'off'),
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange'=>true,
        ),
    ));
    ?>
    <div>
        <div class="row">
            <div class="column">Status</div>
            <div><?php echo $form->textField($model, 'status', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'status'); ?></div>
        </div>
        <div class="row">
            <div class="column">Remind Days</div>
            <div><?php echo $form->textField($model, 'remind_days', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'remind_days'); ?></div>
        </div>
        <div class="row">
            <div class="column">&nbsp;</div>
            <div><?php echo CHtml::submitButton('Update Status', array('class' => 'button')); ?></div>
        </div>
    </div>
    <?php $this->endWidget(); ?>    
    </div>
</div>
</div>
