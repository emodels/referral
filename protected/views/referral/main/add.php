<?php if ($this->allow_add_referral){ ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#mainmenu ul').append('<li><a href="<?php echo Yii::app()->baseUrl; ?>/referral/main/AddReferral">Add new Referral</a></li>');
    });
    function validateForm(form, data, hasError){

        if ($('#Entry_remind').is(':checked')) {

            if ($('#Entry_remind_date').val().trim() == '') {

                $('#Entry_remind_date_em_').html('Reminding Date cannot be blank').show();
                $('#Entry_remind_date_em_').parent().removeClass('success').addClass('error');
                hasError = true;
            }

        } else {

            $('#Entry_remind_date').val('');
            $('#Entry_remind_date_em_').html('').hide();
            $('#Entry_remind_date_em_').parent().removeClass('error').addClass('success');
            hasError = false;
        }

        if (!hasError) {
            return true;
        }
        return false;
    }
</script>
<?php } ?>
<style type="text/css">
    .column{
        width: 200px;
    }
</style>
<div style="float: left">
    <?php require_once Yii::getPathOfAlias('webroot.protected.views.referral') . '/referral_header_include.php'; ?>
</div>
<div style="float: left; width: 670px; padding-left: 10px">
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
            'afterValidate'=>'js:validateForm'
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
            <div class="column">Additional Email</div>
            <div><?php echo $form->textField($model, 'additional_email', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'additional_email'); ?></div>
        </div>
        <div class="row">
            <div class="column">Status</div>
            <div><?php echo $form->dropDownList($model, 'status', CHtml::listData(Status::model()->findAll('referral_user = :user', array(':user'=>$model->referrel_user)), 'id', 'status'), array('style'=>'width:135px','empty'=>'Select Status')); ?><?php echo $form->error($model, 'status'); ?></div>
        </div>
        <div class="row">
            <div class="column">Priority</div>
            <div><?php echo $form->dropDownList($model, 'priority', array('0'=>'Low','1'=>'Medium','2'=>'High'), array('style'=>'width:135px','empty'=>'Select Priority')); ?><?php echo $form->error($model, 'priority'); ?></div>
        </div>
        <div class="row">
            <div class="column">Property Holder</div>
            <div><?php echo $form->dropDownList($model, 'property_holder', array('Owner'=>'Owner','Tenant'=>'Tenant'), array('style'=>'width:135px','empty'=>'Select Property Holder')); ?><?php echo $form->error($model, 'property_holder'); ?></div>
        </div>
        <div class="row">
            <div class="column">Send Reminder</div>
            <div><?php echo $form->checkbox($model, 'remind', array('onClick'=>'js:validateForm()')); ?></div>
        </div>
        <div class="row">
            <div class="column" style="padding-top: 5px">Reminding Date</div>
            <div>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(
                        'model'=>$model,
                        'attribute'=>'remind_date',
                        'options'=>array(
                            'showAnim'=>'fold',
                            'dateFormat'=>'yy-mm-dd',
                            'changeMonth' => 'true',
                            'changeYear' => 'true',
                            'constrainInput' => 'false'
                        ),
                        'htmlOptions'=>array('style'=>'width:200px'),
                    ));
                ?>
                <?php echo $form->error($model, 'remind_date'); ?>
            </div>
        </div>
        <div class="row">
            <div class="column" style="padding-top: 5px">Date of Birth</div>
            <div>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(
                        'model'=>$model,
                        'attribute'=>'date_of_birth',
                        'options'=>array(
                            'showAnim'=>'fold',
                            'dateFormat'=>'yy-mm-dd',
                            'changeMonth' => 'true',
                            'changeYear' => 'true',
                            'constrainInput' => 'false'
                        ),
                        'htmlOptions'=>array('style'=>'width:200px'),
                    ));
                ?>
                <?php echo $form->error($model, 'date_of_birth'); ?>
            </div>
        </div>
        <div class="row">
            <div class="column" style="margin-top: 5px">Remarks</div>
            <div><?php echo $form->textField($model, 'remarks', array('style' => 'width:200px')); ?></div>
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
