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
    <?php
    if (Yii::app()->user->user_type == '0') {

        require_once Yii::getPathOfAlias('webroot.protected.views.admin') . '/admin_header_include.php';

    } else if (Yii::app()->user->user_type == '1') {

        require_once Yii::getPathOfAlias('webroot.protected.views.referral') . '/referral_header_include.php';
    }
    ?>
</div>
<div style="float: left; width: 670px; padding-left: 10px">
    <div class="box" style="border-radius: 5px; border: solid 1px silver">
        <h2 class="icon_search">Manage Client Portal<span></span></h2>
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'admin-user-add',
                'htmlOptions' => array('autocomplete' => 'off'),
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange'=>true,
                ),
            ));
            ?>
            <div>
                <div class="row" style="margin-top: 25px">
                    <div class="column">First Name</div>
                    <div class="column"><?php echo $model->first_name; ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row" style="margin-top: 15px">
                    <div class="column">Last Name</div>
                    <div class="column"><?php echo $model->last_name; ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row" style="margin-top: 15px">
                    <div class="column">User Name</div>
                    <div class="column"><?php echo $form->textField($model, 'username', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'username'); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">Password</div>
                    <div class="column"><?php echo $form->passwordField($model, 'password', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'password'); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">Confirm Password</div>
                    <div class="column"><?php echo $form->passwordField($model, 'confirm_password', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'confirm_password'); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">&nbsp;</div>
                    <div><?php echo CHtml::submitButton((($model->id > 0) ? 'Update' : 'Enable') . ' Client Portal', array('class' => 'button')); ?></div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
