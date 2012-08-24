<?php
$this->pageTitle=Yii::app()->name . ' - Login';
?>
<div align="center">
<div id="login">
    <div style="border-bottom: solid 1px silver; padding: 10px 0 0 10px; background: url(../css/bg.gif) repeat-x;"><h1 style="color: white">Login</h1></div>
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

                <div class="row rememberMe">
                    <div style="padding-left: 150px"><?php echo $form->checkBox($model,'rememberMe'); ?>
                        <?php echo $form->label($model,'rememberMe'); ?>
                        <?php echo $form->error($model,'rememberMe'); ?>
                    </div>
                </div>

                <div class="row buttons">
                    <div style="padding-left: 150px"><?php echo CHtml::submitButton('Login',array('class'=>'button')); ?></div>
                </div>

        <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</div>
</div>