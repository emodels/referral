<script type="text/javascript">
    $(document).ready(function(){
        $('#User_confirm_password').change(function(){
            if ($('#User_password').val()==$('#User_confirm_password').val()) {
                $('#User_password_em_').html('');
            }
        })
    });
</script>
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
    <h2 class="icon_search" style="padding-top: 12px">Edit Admin Profile<span></span></h2>
    <div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'admin-user-profile',
        'htmlOptions' => array('autocomplete' => 'off', 'enctype' => 'multipart/form-data'),
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange'=>true,
        ),
    ));
    ?>
    <div>
        <div class="row">
            <div class="column">Company Name</div>
            <div><?php echo $form->textField($model, 'company', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'company'); ?></div>
        </div>
        <div class="row">
            <div class="column">First Name</div>
            <div><?php echo $form->textField($model, 'first_name', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'first_name'); ?></div>
        </div>
        <div class="row">
            <div class="column">Last Name</div>
            <div><?php echo $form->textField($model, 'last_name', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'last_name'); ?></div>
        </div>
        <div class="row">
            <div class="column">User Name</div>
            <div><?php echo $form->textField($model, 'username', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'username'); ?></div>
        </div>
        <div class="row">
            <div class="column">Password</div>
            <div><?php echo $form->passwordField($model, 'password', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'password'); ?></div>
        </div>
        <div class="row">
            <div class="column">Confirm Password</div>
            <div><?php echo $form->passwordField($model, 'confirm_password', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'confirm_password'); ?></div>
        </div>
        <div class="row">
            <div class="column">Email</div>
            <div><?php echo $form->textField($model, 'email', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'email'); ?></div>
        </div>
        <div class="row" style="margin-top: 15px">
            <div class="column">Company Logo <br/>(<i style="font-size: 11px">Optional</i>)</div>
            <div class="column">
                <?php echo $form->fileField($model, 'logo'); ?><?php echo $form->error($model, 'logo'); ?>
                <?php if ($model->logo != null) { ?>
                    <img src="data:image/jpeg;base64, <?php echo $model->logo; ?>" style="width: 200px; height: 80px"/>
                <?php } ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row" style="margin-top: 15px">
            <div class="column">Logo Width<br/>(<i style="font-size: 11px">Optional</i>)</div>
            <div class="column"><?php echo $form->textField($model, 'logo_width', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'logo_width'); ?></div>
            <div class="clearfix"></div>
        </div>
        <div class="row" style="margin-top: 15px">
            <div class="column">Logo Height<br/>(<i style="font-size: 11px">Optional</i>)</div>
            <div class="column"><?php echo $form->textField($model, 'logo_height', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'logo_height'); ?></div>
            <div class="clearfix"></div>
        </div>
        <div class="row">
            <div class="column">Address</div>
            <div><?php echo $form->textArea($model, 'header_title', array('style' => 'width:600px', 'rows' => '5')); ?><?php echo $form->error($model, 'header_title'); ?></div>
        </div>
        <div class="row">
            <div class="column">&nbsp;</div>
            <div><?php echo CHtml::submitButton('Save Changes', array('class' => 'button')); ?></div>
        </div>
    </div>
    <?php $this->endWidget(); ?>    
    </div>
</div>
</div>
