<script type="text/javascript">
    function validate() {

        if ($("#start_date").val() == "" || $("#end_date").val() == "") {

            alert("Please enter Start and End Dates")
            return false;

        } else {

            return true;
        }
    }
</script>
<div style="float: left">
    <h3>Receipts for Property : <?php echo $property->address; ?></h3>
</div>
<div style="float: right">
    <h3>Owner : <?php echo ucfirst($property->entry0->first_name) . ' ' . ucfirst($property->entry0->last_name); ?></h3>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="column"><input type="button" value="Add New Receipt" class="button" onclick="javascript:window.document.location.replace('<?php echo Yii::app()->baseUrl ?>/receipts/add/prop_id/<?php echo $property->id; ?>')"></div>
    <div class="column right form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'receipt-grid',
            'htmlOptions' => array('autocomplete' => 'off'),
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange'=>true
            ),
        ));
        ?>
        <div class="row">
            <div class="column" style="margin-top: 15px">Start Date :</div>
            <div class="column" style="margin-top: 5px">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(
                        'id'=>'start_date',
                        'name'=>'start_date',
                        'value'=>$date_range['start_date'],
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
            </div>
            <div class="column" style="margin-top: 15px">End Date :</div>
            <div class="column" style="margin-top: 5px">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(
                        'id'=>'end_date',
                        'name'=>'end_date',
                        'value'=>$date_range['end_date'],
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
            </div>
            <div class="column" style="margin-right: 0px">
                <input id="btn_view" name="btn_view" type="submit" value="View Summary" class="button" onclick="javascript:return validate();" style="float: left; margin-right: 10px" />
                <input id="btn_pdf" name="btn_pdf" type="submit" value="Generate PDF Summary" class="button" onclick="javascript:return validate();"/>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <div class="clearfix"></div>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        array(
            'name' => 'Receipt Number',
            'value' => '$data->receipt_number',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
        ),
        array(
            'name' => 'Property Address',
            'value' => '$data->property_address',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
        ),
        array(
            'name' => 'Landlord',
            'value' => '$data->landlord_name',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
        ),
        array(
            'name' => 'Tenant',
            'value' => '$data->tenant_name',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
        ),
        array(
            'name' => 'Rent',
            'value' => '"$" . $data->rent',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
        ),
        array(
            'name' => 'Paid',
            'value' => '"$" . $data->paid',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
        ),
        array(
            'name' => 'From Date',
            'value' => '$data->from_date',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
        ),
        array(
            'name' => 'To Date',
            'value' => '$data->to_date',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
        ),
        array(
            'header' => 'PDF Report',
            'type'=>'html',
            'value'=>'(!empty($data->pdf)?"<a href=\'" . Yii::app()->baseUrl . "/receipts/download/id/" . base64_encode($data->id) . "\' target=\'_blank\'><img src=\'" . Yii::app()->baseUrl . "/images/icon-pdf.png\'/></a>":"N/A")',
            'htmlOptions'=>array('style'=>'text-align: center')
        ),
        array(
            'header' => 'Status',
            'type'=>'html',
            'value'=>'($data->status == 0)?"<img src=\'" . Yii::app()->baseUrl . "/images/notify_error.png\' style=\'width: 24px\' title=\'Still not Published and Emailed\'/>":"<img src=\'" . Yii::app()->baseUrl . "/images/notify_success.png\' style=\'width: 24px\' title=\'Already Published and Emailed\'/>"',
            'htmlOptions'=>array('style'=>'text-align: center')
        ),
        array(
            'name' => 'Generated By',
            'value' => '$data->partner_name',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
        ),
        array(
            'name' => 'Generated Date',
            'value' => '$data->receipt_date',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
        ),
        array
        (
            'class'=>'CButtonColumn',
            'deleteConfirmation'=>"js:'Are you sure you want to delete this Receipt ?'",
            'template'=>'{delete}{update}',
            'buttons'=>array(
                'delete' => array
                (
                    'options'=>array('style'=>'padding-right:25px'),
                ),
                'update' => array
                (
                    'url'=>'Yii::app()->baseUrl . "/receipts/add/prop_id/" . $data->property_id . "/receipt_id/" . $data->id'
                )
            )
        )
    )
));
?>