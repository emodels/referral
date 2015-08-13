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
        <h2 class="icon_search">Add Property for Client : <span style="margin-left: 20px"><b><?php echo ucfirst($model->entry0->first_name) . ' ' . ucfirst($model->entry0->last_name) . ' - (' . $model->entry0->property_holder . ')'; ?></b></span></h2>
        <hr style="border-top: solid 2px navy"/>
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'admin-property-add',
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
                    <div class="column">Builder</div>
                    <div class="column"><?php echo $form->textField($model, 'builder', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'builder'); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">Address</div>
                    <div class="column">
                        <?php if ($model->entry0->property_holder == 'Tenant') { ?>
                            <?php echo $form->dropDownList($model, 'address', CHtml::listData(Property::model()->findAllBySql('SELECT P.* FROM `property` as P, `entry` as E WHERE P.entry = E.id AND E.referrel_user = ' . $model->entry0->referrel_user), 'address', 'address') ,array('style' => 'width:200px', 'empty'=>'Select Address')); ?>
                        <?php } else { ?>
                            <?php echo $form->textField($model, 'address', array('style' => 'width:200px')); ?>
                        <?php } ?>
                        <?php echo $form->error($model, 'address'); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">Status</div>
                    <div class="column"><?php echo $form->dropDownList($model, 'status', array('Open'=>'Open', 'Closed'=>'Closed'),array('style' => 'width:200px', 'empty'=>'Select Status')); ?><?php echo $form->error($model, 'status'); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">Owner</div>
                    <div class="column"><?php echo $form->dropDownList($model, 'owner', CHtml::listData(User::model()->findAll(array('condition'=>'user_type = 1','order' => 'first_name')),'id','first_name'),array('style' => 'width:200px', 'empty'=>'Select Owner')); ?><?php echo $form->error($model, 'owner'); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">Management fee percentage (%)</div>
                    <div class="column"><?php echo $form->textField($model, 'management_fee_percentage', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'management_fee_percentage'); ?></div>
                    <div class="clearfix"></div>
                </div>
                <?php if ($model->entry0->property_holder !== 'Tenant') { ?>
                <div class="row">
                    <div class="column">Initial Deposit</div>
                    <div class="column"><?php echo $form->checkBox($model, 'initial_deposit', array('value'=>1,'uncheckValue'=>0), array('style' => 'width:200px')); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">Contracts Signed</div>
                    <div class="column"><?php echo $form->checkBox($model, 'contracts_signed', array('value'=>1,'uncheckValue'=>0), array('style' => 'width:200px')); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">5% - 10% Deposit</div>
                    <div class="column"><?php echo $form->checkBox($model, 'five_ten_deposit', array('value'=>1,'uncheckValue'=>0), array('style' => 'width:200px')); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">FIRB Approval</div>
                    <div class="column"><?php echo $form->checkBox($model, 'firb_approval', array('value'=>1,'uncheckValue'=>0), array('style' => 'width:200px')); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">Finance Approval</div>
                    <div class="column"><?php echo $form->checkBox($model, 'finance_approval', array('value'=>1,'uncheckValue'=>0), array('style' => 'width:200px')); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">Property Completion</div>
                    <div class="column"><?php echo $form->checkBox($model, 'property_completion', array('value'=>1,'uncheckValue'=>0), array('style' => 'width:200px')); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">Rented Out</div>
                    <div class="column"><?php echo $form->checkBox($model, 'rented_out', array('value'=>1,'uncheckValue'=>0), array('style' => 'width:200px')); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">Insurance In Place</div>
                    <div class="column"><?php echo $form->checkBox($model, 'insurance_in_place', array('value'=>1,'uncheckValue'=>0), array('style' => 'width:200px')); ?></div>
                    <div class="clearfix"></div>
                </div>
                <?php } ?>
                <div class="row">
                    <div class="column">&nbsp;</div>
                    <div><?php echo CHtml::submitButton('Add Property', array('class' => 'button')); ?></div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
