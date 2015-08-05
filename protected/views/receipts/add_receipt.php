<style type="text/css">
    .border-less {
        border: none;
    }
    div.form label {
        display: inline-block;
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

        $('#Receipt_partner_name').keyup(function () {
            $('#partner_name_bottom').html($('#Receipt_partner_name').val());
        });

        $('#Receipt_company_logo').change(function(){

            readImage(this, 'company_logo');
        });

        $('#Receipt_signature').change(function(){

            readImage(this, 'signature');
        });

        calculateDisbursements();
    });

    function validatePublish() {

        if ($('input:checked').length == 0) {

            alert('Please select at least single Category to Publish this Receipt');
            return false;

        } else {

            return true;
        }
    }

    function readImage(input, image) {

        if ( input.files && input.files[0] ) {

            var FR= new FileReader();
            FR.onload = function(e) {
                $('#' + image).attr( "src", e.target.result);
            };
            FR.readAsDataURL( input.files[0] );
        }
    }

    function calculateDisbursements() {

        var rent_received = Math.floor(parseFloat($('#Receipt_paid').val()) * 100) / 100;

        $('#rent_received').html('$' + rent_received.toFixed(2));

        var management_fee = Math.floor(parseFloat(parseFloat($('#Receipt_paid').val()) * (<?php echo $property->management_fee_percentage;?> / 100)) * 100) / 100;
        var gst = Math.floor(parseFloat(management_fee * (<?php echo Yii::app()->params['GST']; ?>/100)) * 100) / 100;

        /*----( Calculate Costs )-------*/
        var costsTotal = 0;

        $('#divCosts input.cost_value').each(function () {

            var cost = $(this).val();

            if (cost !== '' && !isNaN(cost)) {

                costsTotal += parseFloat(cost);
            }
        });

        var your_account = Math.floor((rent_received - (management_fee + gst + costsTotal)) * 100) / 100;

        $('#Receipt_management_fees').val(management_fee);
        $('#management_fees').html('$' + management_fee);

        $('#Receipt_gst').val(gst);
        $('#gst').html('$' + gst);

        $('#your_account').html('$' + your_account);
        $('#total_debit').html('$' + rent_received);
        $('#total_credit').html('$' + rent_received);
    }

    function addCostRow() {

        var inputCount = $('#divCosts input.cost_name').length;

        var strContent = '<div id="rowCost_' + inputCount + '" class="row" style="font-size: 18px">' +
                            '<div class="column" style="width: 61.5%"><input type="text" class="cost_name" name="Costs[name][' + inputCount + ']" style="font-size: 18px"/></div>' +
                            '<div class="column" style="width: 20%">$<input type="text" class="cost_value" name="Costs[value][' + inputCount + ']" style="font-size: 18px" onKeyUp="javascript:calculateDisbursements();"/></div>' +
                            '<div class="column" style="width: 15%"><a href="javascript:deleteCostRow(' + inputCount + ');" style="text-decoration: none; font-size: 32px; color: red">-</a></div>' +
                            '<div class="clearfix"></div>' +
                        '</div>';

        $('#divCosts').append(strContent);
    }

    function deleteCostRow(index) {

        $('#rowCost_' + index).remove();
        calculateDisbursements();
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

    function formSend(form, data, hasError) {

        if ($('#divCosts input').length > 0) {

            var isError = false;
            var strError = '';

            $('#divCosts input.cost_name').each(function () {

                var name = $(this).val();
                var value = $(this).parent().next().find('input').val();

                if (name != '' && value == '') {

                    isError = true;
                    strError = 'Cost "' + name + '" required a value';

                    return false;
                }

                if (name == '' && value != '') {

                    isError = true;
                    strError = 'Name of the Cost is required';

                    return false;
                }

                if (isNaN(value)) {

                    isError = true;
                    strError = 'Value of the Cost "' + name + '" must be numeric';

                    return false;
                }
            });

            if (isError == true) {

                hasError = true;
                alert(strError);
            }
        }

        if (!hasError) {

            $('#progress').show();
            return true;
        }
    }
</script>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'receipt-add',
        'htmlOptions' => array('autocomplete' => 'off', 'enctype' => 'multipart/form-data'),
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange'=>true,
            'afterValidate'=>'js:formSend'
        ),
    ));
    ?>
    <div class="row">
        <div class="column left"><input type="button" id="lnkMenuToggle" onclick="javascript:ToggleMenu();" class="button" value="Hide Input Field Borders"/></div>
        <div class="column left"><input type="submit" class="button" value="Save Receipt"/></div>
        <?php if (isset($model->id)) { ?>
        <div class="column left">
            <input type="submit" id="btnPublish" class="button" value="Publish and Email" onclick="javascript:return validatePublish();"/>
            <?php if($model->status == 1) { ?>
                <span style="font-size: 15px; color: red; padding-left: 10px"><b>Warning: This receipt was already published and emailed</b></span>
            <?php } ?>
            <div>
            <?php
            $all_categories = EntryDocumentCategory::model()->findAll('entry = ' . $model->property->entry);

            foreach ($all_categories as $category) {

                $listData[$category->category] = $category->category0->name;
            }

            echo CHtml::checkBoxList('category_list', array(), $listData, array(
                'separator'=>'',
                'template'=>'<div>{input}&nbsp;{label}</div>'
            ));
            ?>
            </div>
            <div id="progress" style="font-size: 32px; padding: 10px; border: solid 1px #c0c0c0; border-radius: 5px; display: none"><img src="<?php echo Yii::app()->baseUrl ?>/images/ajax-loader2.gif" style="vertical-align: middle" /> Update in progress. Please wait...</div>
        </div>
        <?php } ?>
        <div class="column right" style="text-align: right">
            <div style="font-size: 32px"><strong>Trust Account</strong></div>
            <div style="font-size: 28px"><strong>Receipt number: </strong><?php echo $model->receipt_number; ?></div>
            <div style="margin-top: 10px">
                <?php if ($model->company_logo != null) { ?>
                    <img id="company_logo" src="data:image/jpeg;base64, <?php echo $model->company_logo; ?>" style="width: 200px; height: 80px"/>
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
        <div class="column" style="width: 20%"><span id="management_fees"><?php echo $model->management_fees; ?></span><?php echo $form->hiddenField($model, 'management_fees'); ?></div>
        <div class="column" style="width: 15%">&nbsp;</div>
        <div class="clearfix"></div>
    </div>
    <div class="row" style="font-size: 18px">
        <div class="column" style="width: 61.5%">GST</div>
        <div class="column" style="width: 20%"><span id="gst"><?php echo $model->gst; ?></span><?php echo $form->hiddenField($model, 'gst'); ?></div>
        <div class="column" style="width: 15%">&nbsp;</div>
        <div class="clearfix"></div>
    </div>
    <a href="javascript:addCostRow();" style="text-decoration: none; font-size: 32px">+</a>
    <div id="divCosts">
        <?php if (isset($model->costs) && $model->costs !== '') {

            $costArray = json_decode($model->costs);

            foreach ($costArray as $cost) { ?>

                <div id="rowCost_<?php echo $cost->index; ?>" class="row" style="font-size: 18px">
                    <div class="column" style="width: 61.5%"><input type="text" class="cost_name" name="Costs[name][<?php echo $cost->index; ?>]" value="<?php echo $cost->name; ?>" style="font-size: 18px"/></div>
                    <div class="column" style="width: 20%">$<input type="text" class="cost_value" name="Costs[value][<?php echo $cost->index; ?>]" value="<?php echo $cost->value; ?>" style="font-size: 18px" onKeyUp="javascript:calculateDisbursements();"/></div>
                    <div class="column" style="width: 15%"><a href="javascript:deleteCostRow(<?php echo $cost->index; ?>);" style="text-decoration: none; font-size: 32px; color: red">-</a></div>
                    <div class="clearfix"></div>
                </div>

            <?php } ?>

        <?php } ?>
    </div>
    <div class="row" style="font-size: 18px">
        <div class="column" style="width: 61.5%">Transfer to your account</div>
        <div class="column" style="width: 20%"><span id="your_account"></span></div>
        <div class="column" style="width: 15%">&nbsp;</div>
        <div class="clearfix"></div>
    </div>
    <div class="row" style="font-size: 18px; border-bottom: solid 4px #000000; border-top: solid 4px #000000; padding: 2px 0 2px 0; margin-top: 20px">
        <div class="column" style="width: 61.5%">Total</div>
        <div class="column" style="width: 20%"><span id="total_debit"></span></div>
        <div class="column" style="width: 15%"><span id="total_credit"></span></div>
        <div class="clearfix"></div>
    </div>
    <div style="margin-top: 20px; font-size: 18px">Note: If there any dispute regarding your payment and receipt please contact the undersigned</div>
    <div class="row" style="margin-top: 15px; font-size: 18px">
        <div class="column" style="margin-top: 7px">Date:</div>
        <div class="column">
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker',
                array(
                    'model'=>$model,
                    'attribute'=>'receipt_date',
                    'options'=>array(
                        'showAnim'=>'fold',
                        'dateFormat'=>'yy-mm-dd',
                        'changeMonth' => 'true',
                        'changeYear' => 'true',
                        'constrainInput' => 'false'
                    ),
                    'htmlOptions'=>array('style' => 'width:200px; font-size: 18px'),
                ));
            ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div style="margin-top: 10px; font-size: 18px"><span id="partner_name_bottom"><?php echo $model->partner_name; ?></span></div>
    <div style="margin-top: 20px; margin-left: 130px">
        <?php if ($model->signature != null) { ?>
            <img id="signature" src="data:image/jpeg;base64, <?php echo $model->signature; ?>" style="width: 339px; height: 49px"/>
        <?php } ?>
    </div>
    <div class="row" style="font-size: 18px">
        <div class="column">Signature:</div>
        <div class="column" style="margin-left: 100px; margin-top: 5px">----------------------------------</div>
        <div class="clearfix"></div>
    </div>
    <div style="margin-top: 10px; margin-left: 200px"><?php echo $form->fileField($model, 'signature'); ?></div>
    <?php $this->endWidget(); ?>
</div>