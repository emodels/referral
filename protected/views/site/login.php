<?php
$this->pageTitle=Yii::app()->name . ' - Login';
?>
<div align="center">
<div id="login">
    <div style="border-bottom: solid 1px silver; padding: 10px 0 0 10px; background: url(<?php echo Yii::app()->baseUrl; ?>/css/bg.gif) repeat-x;"><h1 style="color: white">Login</h1></div>
    <div style="padding:10px;">
        <p>Please fill out the following form with your login credentials:</p>
        <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'login-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                ),
        )); ?>

                <div class="row">
                    <div style="float: left; width: 150px"><?php echo $form->labelEx($model,'username'); ?></div>
                    <div><?php echo $form->textField($model,'username'); ?><?php echo $form->error($model,'username'); ?></div>
                        
                </div>

                <div class="row">
                    <div style="float: left; width: 150px"><?php echo $form->labelEx($model,'password'); ?></div>
                    <div><?php echo $form->passwordField($model,'password'); ?><?php echo $form->error($model,'password'); ?></div>
                       
                </div>

                <div class="row rememberMe" style="display: none">
                    <div style="padding-left: 150px"><?php echo $form->checkBox($model,'rememberMe'); ?>
                        <?php echo $form->label($model,'rememberMe'); ?>
                        <?php echo $form->error($model,'rememberMe'); ?>
                    </div>
                </div>

                <div class="row buttons">
                    <div style="padding-left: 150px"><?php echo CHtml::submitButton('Login',array('class'=>'button')); ?></div>
                </div>

                <div class="row" style="margin-top: 10px">
                    <div style="text-align: center">Forgot your password ? <a href="javascript:$('#divReset').show();">Click here to get your password</a></div>
                </div>

        <?php $this->endWidget(); ?>
        </div><!-- form -->

        <div id="divReset" class="form hide" style="margin-top: 20px">

            <hr/>

            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'reset-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
            )); ?>

            <div class="row">

                <h3>Request Password</h3>

                <h5>You will receive an email with you password</h5>

                <div class="column" style="margin-top: 5px">User Name</div>
                <div class="column"><?php echo $form->textField($model,'username'); ?><?php echo $form->error($model,'username'); ?></div>
                <div class="column"><?php echo CHtml::submitButton('Send Password',array('name'=>'reset', 'class'=>'button', 'style'=>'padding: 5px')); ?></div>
                <div class="clearfix"></div>

            </div>

            <?php $this->endWidget(); ?>
        </div>

    </div>
</div>
</div>