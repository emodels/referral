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
    <h2 class="icon_search" style="padding-top: 12px">Update Category<span></span></h2>
    <div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'admin-category-update',
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
            <div class="column">Name</div>
            <div><?php echo $form->textField($model, 'name', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'name'); ?></div>
        </div>
        <div class="row">
            <div class="column">&nbsp;</div>
            <div><?php echo CHtml::submitButton('Update Category', array('class' => 'button')); ?></div>
        </div>
    </div>
    <?php $this->endWidget(); ?>    
    </div>
</div>
</div>
