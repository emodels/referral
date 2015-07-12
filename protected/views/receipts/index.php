<div style="float: left">
    <h3>Receipts for Property : <?php echo $property->address; ?></h3>
</div>
<div style="float: right">
    <h3>Owner : <?php echo ucfirst($property->entry0->first_name) . ' ' . ucfirst($property->entry0->last_name); ?></h3>
</div>
<div class="clearfix"></div>
<div><input type="button" value="Add New Receipt" class="button" onclick="javascript:window.document.location.replace('<?php echo Yii::app()->request->baseUrl ?>/receipts/add/id/<?php echo $property->id; ?>')"></div>
<?php
$dataProvider = new CActiveDataProvider('Receipt', array('criteria'=>array('condition'=> 'property_id = ' . $property->id, 'order'=>'id DESC'), 'pagination' => false));

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        array(
            'name' => 'Receipt Number',
            'value' => '$data->receipt_number',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
        ),
        $button = array('class'=>'CButtonColumn', 'template'=>'{delete}')
    )
));
?>