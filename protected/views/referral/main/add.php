<?php if ($this->allow_add_referral){ ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#mainmenu ul').append('<li><a href="<?php echo Yii::app()->baseUrl; ?>/referral/main/AddReferral">Add new Referral</a></li>');
    });
</script>
<?php } ?>
<style type="text/css">
    .column{
        width: 200px;
    }
</style>    
<div style="float: left; width: 100%">
    <div class="box" style="border-radius: 5px; border: solid 1px silver">
    <h2 class="icon_search" style="padding-top: 12px">Add New Referral<span></span></h2>
    <div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'admin-entry-record',
        'htmlOptions' => array('autocomplete' => 'off'),
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange'=>true,
        ),
    ));
    ?>
    <div>
        <div class="row" style="padding-bottom: 10px">
            <div class="column">Partner Company</div>
            <div>
                <b><?php echo $model->referrelUser->company; ?></b>
           </div>
        </div>
        <div class="row">
            <div class="column">First name</div>
            <div><?php echo $form->textField($model, 'first_name', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'first_name'); ?></div>
        </div>
        <div class="row">
            <div class="column">Last name</div>
            <div><?php echo $form->textField($model, 'last_name', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'last_name'); ?></div>
        </div>
        <div class="row">
            <div class="column">Address</div>
            <div><?php echo $form->textField($model, 'address', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'address'); ?></div>
        </div>
        <div class="row">
            <div class="column">State</div>
            <div><?php echo $form->textField($model, 'state', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'state'); ?></div>
        </div>
        <div class="row">
            <div class="column">ZIP code</div>
            <div><?php echo $form->textField($model, 'zip', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'zip'); ?></div>
        </div>
        <div class="row">
            <div class="column">Country</div>
            <div><?php echo $form->textField($model, 'country', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'country'); ?></div>
        </div>
        <div class="row">
            <div class="column">Telephone</div>
            <div><?php echo $form->textField($model, 'telephone', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'telephone'); ?></div>
        </div>
        <div class="row">
            <div class="column">Email</div>
            <div><?php echo $form->textField($model, 'email', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'email'); ?></div>
        </div>
        <div class="row">
            <div class="column">Status</div>
            <div><?php echo $form->dropDownList($model, 'status', CHtml::listData(Status::model()->findAll('referral_user = :user', array(':user'=>$model->referrel_user)), 'id', 'status'), array('style'=>'width:135px','empty'=>'Select Status')); ?></div>
        </div>
        <div class="row">
            <div class="column">Description</div>
            <div>&nbsp;</div>
        </div>
        <div class="row">
            <?php 
            $this->widget('ext.ckeditor.CKEditorWidget',array(
            "model"=>$model, "attribute"=>'description', "defaultValue"=>"",
            "config" => array(
                "height"=>"200px",
                "width"=>"100%",
                "toolbar"=> array(array('Source','-','Bold','Italic','Underline',),array('Format','Font','FontSize','TextColor','BGColor','Link','Unlink'),array('SpellChecker','Scayt')),
                ),
            ));        
            ?>
        </div>
        <div class="row">
            <div class="column">&nbsp;</div>
            <div><?php echo CHtml::submitButton('Add Referral', array('class' => 'button')); ?></div>
        </div>
    </div>
    <?php $this->endWidget(); ?>    
    </div>
</div>
</div>
