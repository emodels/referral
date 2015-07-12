<style type="text/css">
    .border-less {
        border: none;
    }
</style>
<script type="application/javascript">
    $(document).ready(function () {

        $('#Receipt_paid').keyup(function() {
            calculateDisbursements();
        });

        $('#Receipt_rent').keyup(function() {
            $('#Receipt_paid').val($('#Receipt_rent').val());
            calculateDisbursements();
        });
    });

    function calculateDisbursements() {

        var rent_received = parseFloat($('#Receipt_paid').val()).toFixed(2);

        $('#rent_received').html('$' + rent_received);

        var management_fee = parseFloat(parseFloat($('#Receipt_paid').val()) * (4.5 / 100)).toFixed(2);
        var gst = parseFloat(management_fee * (10/100)).toFixed(2);
        var your_account = parseFloat(rent_received - parseFloat(management_fee + gst)).toFixed(2);

        $('#management_fees').html('$' + management_fee);
        $('#gst').html('$' + gst);
        $('#your_account').html('$' + your_account);
    }

    function ToggleMenu() {

        if ($('#lnkMenuToggle').val().indexOf('Hide') > -1) {

            $('#lnkMenuToggle').val('Show Input Field Borders');
            $('input, textarea').addClass('border-less');

        } else {

            $('#lnkMenuToggle').val('Hide Input Field Borders');
            $('input, textarea').removeClass('border-less');
        }
    }
</script>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'receipt-add',
        'htmlOptions' => array('autocomplete' => 'off'),
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange'=>true,
        ),
    ));
    ?>
    <div class="row">
        <div class="column left"><input type="button" id="lnkMenuToggle" onclick="javascript:ToggleMenu();" class="button" value="Hide Input Field Borders"/></div>
        <div class="column right" style="text-align: right">
            <div style="font-size: 32px"><strong>Trust Account</strong></div>
            <div style="font-size: 28px"><strong>Receipt number: </strong><?php echo $form->textField($model, 'receipt_number', array('style' => 'width:120px; font-size: 28px')); ?><?php echo $form->error($model, 'receipt_number', array('style' => 'font-size: 15px')); ?></div>
            <div style="margin-top: 10px">
                <?php if ($model->company_logo != null) { ?>
                    <img src="data:image/jpeg;base64, <?php echo $model->company_logo; ?>" style="width: 200px; height: 80px"/>
                <?php } ?>
                <div style="margin-top: 10px"><?php echo $form->fileField($model, 'company_logo'); ?></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="column left">
            <div><?php echo $form->textField($model, 'company_name', array('style' => 'width:500px; font-size: 28px; margin-bottom: 0px')); ?><?php echo $form->error($model, 'company_name', array('style' => 'font-size: 15px')); ?></div>
            <div><?php echo $form->textArea($model, 'company_address', array('style' => 'width:496px; font-size: 18px', 'rows' => '4')); ?><?php echo $form->error($model, 'company_address', array('style' => 'font-size: 15px')); ?></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row" style="margin-top: 15px">
        <div class="column left">
            <div><?php echo $form->textField($model, 'partner_name', array('style' => 'width:500px; font-size: 18px; margin-bottom: 0px')); ?><?php echo $form->error($model, 'partner_name', array('style' => 'font-size: 15px')); ?></div>
            <div><?php echo $form->textField($model, 'partner_telephone', array('style' => 'width:500px; font-size: 18px; margin-bottom: 0px')); ?><?php echo $form->error($model, 'partner_telephone', array('style' => 'font-size: 15px')); ?></div>
            <div><?php echo $form->textField($model, 'partner_email', array('style' => 'width:500px; font-size: 18px; margin-bottom: 0px')); ?><?php echo $form->error($model, 'partner_email', array('style' => 'font-size: 15px')); ?></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row" style="margin-top: 20px; padding-bottom: 10px; border-bottom: solid 3px #000000">
        <div class="column left">
            <div><span style="margin-right: 27px; font-size: 18px"><strong>Landlord:</strong></span><?php echo $form->textField($model, 'landlord_name', array('style' => 'width:390px; font-size: 18px')); ?><?php echo $form->error($model, 'landlord_name', array('style' => 'font-size: 15px')); ?></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div style="margin-top: 20px; font-size: 18px; border-bottom: solid 4px #000000"><strong>Particulars</strong></div>
    <div class="row" style="margin-top: 25px; font-size: 18px; font-weight: bold; border-bottom: solid 5px #000000">
        <div class="column" style="width: 25%">Property</div>
        <div class="column" style="width: 20%">Tenant</div>
        <div class="column" style="width: 15%">Rent</div>
        <div class="column" style="width: 15%">Paid</div>
        <div class="column" style="width: 10%">From</div>
        <div class="column" style="width: 10%">To</div>
        <div class="clearfix"></div>
    </div>
    <div class="row" style="margin-top: 25px; padding-bottom: 20px; font-size: 18px; font-weight: bold; border-bottom: solid 5px #000000">
        <div class="column" style="width: 25%"><?php echo $form->textField($model, 'property_address', array('style' => 'width:95%; font-size: 18px')); ?><?php echo $form->error($model, 'property_address', array('style' => 'font-size: 15px')); ?></div>
        <div class="column" style="width: 20%"><?php echo $form->textField($model, 'tenant_name', array('style' => 'width:95%; font-size: 18px')); ?><?php echo $form->error($model, 'tenant_name', array('style' => 'font-size: 15px')); ?></div>
        <div class="column" style="width: 15%">$<?php echo $form->textField($model, 'rent', array('style' => 'width:92%; font-size: 18px')); ?><?php echo $form->error($model, 'rent', array('style' => 'font-size: 15px')); ?></div>
        <div class="column" style="width: 15%">$<?php echo $form->textField($model, 'paid', array('style' => 'width:92%; font-size: 18px')); ?><?php echo $form->error($model, 'paid', array('style' => 'font-size: 15px')); ?></div>
        <div class="column" style="width: 10%">
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker',
                array(
                    'model'=>$model,
                    'attribute'=>'from_date',
                    'options'=>array(
                        'showAnim'=>'fold',
                        'dateFormat'=>'yy-mm-dd',
                        'changeMonth' => 'true',
                        'changeYear' => 'true',
                        'constrainInput' => 'false'
                    ),
                    'htmlOptions'=>array('style' => 'width:95%; font-size: 18px'),
                ));
            ?>
            <?php echo $form->error($model, 'from_date', array('style' => 'font-size: 15px')); ?>
        </div>
        <div class="column" style="width: 10%">
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker',
                array(
                    'model'=>$model,
                    'attribute'=>'to_date',
                    'options'=>array(
                        'showAnim'=>'fold',
                        'dateFormat'=>'yy-mm-dd',
                        'changeMonth' => 'true',
                        'changeYear' => 'true',
                        'constrainInput' => 'false'
                    ),
                    'htmlOptions'=>array('style' => 'width:95%; font-size: 18px'),
                ));
            ?>
            <?php echo $form->error($model, 'to_date', array('style' => 'font-size: 15px')); ?></div>
        <div class="clearfix"></div>
    </div>
    <div style="margin-top: 20px; font-size: 18px; border-bottom: solid 4px #000000"><strong>Disbursements</strong></div>
    <div class="row" style="margin-top: 25px; font-size: 18px; font-weight: bold; border-bottom: solid 5px #000000">
        <div class="column" style="width: 61.5%">Item</div>
        <div class="column" style="width: 20%">Debit</div>
        <div class="column" style="width: 15%">Credit</div>
        <div class="clearfix"></div>
    </div>
    <div class="row" style="margin-top: 25px; font-size: 18px">
        <div class="column" style="width: 61.5%">Rent received</div>
        <div class="column" style="width: 20%">&nbsp;</div>
        <div class="column" style="width: 15%"><span id="rent_received"><?php echo $model->paid; ?></span></div>
        <div class="clearfix"></div>
    </div>
    <div class="row" style="font-size: 18px">
        <div class="column" style="width: 61.5%">Management fees</div>
        <div class="column" style="width: 20%"><span id="management_fees"><?php echo $model->management_fees; ?></span></div>
        <div class="column" style="width: 15%">&nbsp;</div>
        <div class="clearfix"></div>
    </div>
    <div class="row" style="font-size: 18px">
        <div class="column" style="width: 61.5%">GST</div>
        <div class="column" style="width: 20%"><span id="gst"><?php echo $model->gst; ?></span></div>
        <div class="column" style="width: 15%">&nbsp;</div>
        <div class="clearfix"></div>
    </div>
    <div class="row" style="font-size: 18px">
        <div class="column" style="width: 61.5%">Your account</div>
        <div class="column" style="width: 20%"><span id="your_account"><?php echo $model->gst; ?></span></div>
        <div class="column" style="width: 15%">&nbsp;</div>
        <div class="clearfix"></div>
    </div>
    <?php $this->endWidget(); ?>
</div>