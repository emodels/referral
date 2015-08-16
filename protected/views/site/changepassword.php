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
<div style="text-align: center">
    <div class="box" style="display: inline-block; text-align: left; width: 670px; border-radius: 5px; border: solid 1px silver">
        <h2 class="icon_search" style="padding-top: 12px">Change Password<span></span></h2>
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'change-password',
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
                    <div class="column">User Name</div>
                    <div><b><?php echo $model->username; ?></b></div>
                </div>
                <div class="row" style="margin-top: 15px">
                    <div class="column">New Password</div>
                    <div><?php echo $form->passwordField($model, 'password', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'password'); ?></div>
                </div>
                <div class="row">
                    <div class="column">Confirm New Password</div>
                    <div><?php echo $form->passwordField($model, 'confirm_password', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'confirm_password'); ?></div>
                </div>
                <div class="row">
                    <div class="column">&nbsp;</div>
                    <div><?php echo CHtml::submitButton('Change Password', array('class' => 'button')); ?></div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
