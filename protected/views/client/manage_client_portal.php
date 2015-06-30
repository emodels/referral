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
<div style="float: left; width: 770px; padding-left: 10px">
    <div class="box" style="border-radius: 5px; border: solid 1px silver">
        <?php if ($model->id > 0) { ?>
        <div style="float: right">
            <a href="<?php echo Yii::app()->baseUrl; ?>/client/property/add/id/<?php echo $model->entry; ?>" class="button" style="text-decoration: none">Add Property</a>
            <a href="<?php echo Yii::app()->baseUrl; ?>/client/category/index/id/<?php echo $model->entry; ?>" class="button" style="text-decoration: none">Assign Categories</a>
        </div>
        <?php } ?>
        <h2 class="icon_search"><?php echo $model->id > 0 ? 'Manage' : 'Enable' ?> Client Portal<span></span></h2>
        <hr style="border-top: solid 2px navy"/>
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'admin-user-add',
                'htmlOptions' => array('autocomplete' => 'off', 'enctype' => 'multipart/form-data'),
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
                <?php if ($entry->property_holder == 'Rental_Client') { ?>
                    <div class="row" style="margin-top: 15px">
                        <div class="column">Header Logo</div>
                        <div class="column">
                            <?php echo $form->fileField($entry, 'logo'); ?><?php echo $form->error($entry, 'logo'); ?>
                            <?php if ($entry->logo != null) { ?>
                            <img src="data:image/jpeg;base64, <?php echo $entry->logo; ?>"/>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row" style="margin-top: 15px">
                        <div class="column">Header Title</div>
                        <div class="column"><?php echo $form->textField($entry, 'header_title', array('style' => 'width:200px')); ?><?php echo $form->error($entry, 'header_title'); ?></div>
                        <div class="clearfix"></div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="column">&nbsp;</div>
                    <div><?php echo CHtml::submitButton((($model->id > 0) ? 'Update' : 'Enable') . ' Client Portal', array('class' => 'button')); ?></div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
