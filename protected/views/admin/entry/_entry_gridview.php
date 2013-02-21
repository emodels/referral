<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/grid.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" type="text/css" media="all">
<?php if(isset($grid_title)){ ?>
<div style="float: left; padding-bottom: 5px"><font style="font-size: 14px"><b><?php echo $grid_title; ?></b></font></div>
<?php } ?>
<?php
$total=0;
if (isset($dataProvider)) {
    foreach($dataProvider->data as $item){
        $total+=$item->referral_commission_amount;
    }
}

$this->widget('zii.widgets.grid.CGridView', array(
'dataProvider'=>$dataProvider,
'ajaxUpdate'=>true,
'enablePagination' => true,
'columns'=>array(
        'id',
        'first_name',
        'last_name',
        'country',
        array(
            'name'=>'Last Updated',
            'value'=>'Yii::app()->dateFormatter->format("yyyy-MM-dd", strtotime($data->entry_last_updated_date))'
        ),
        array(
            'name'=>'status',
            'value'=>'$data->status0->status',
            'type'=>'html',
            'footer'=>$dataProvider->itemCount===0 ? '' : '<div style="border-top: solid 1px silver;border-bottom: double 4px silver; padding: 5px 0 5px 0"><b>Total Commission :</b></div>'
        ),
        array( 'name'=> 'priority',
                'value'=> '($data->priority == "0") ? Low : (($data->priority == "1") ? Medium : High)'
            ),
        array(
            'name'=>'Commission',
            'value'=>'$data->referral_commission_amount',
            'type'=>'html',
            'footer'=>$dataProvider->itemCount===0 ? '' : '<div style="border-top: solid 1px silver;border-bottom: double 4px silver; padding: 5px 0 5px 0"><b>' . $total . '</b></div>'
        ),
        array
        (
            'class'=>'CButtonColumn',
            'deleteConfirmation'=>"js:'Are you sure you want to delete this Referral ?'",
            'template'=>'{delete}{update}',
            'buttons'=>array(
                'delete' => array
                (
                    'options'=>array('style'=>'padding-right:25px'),
                ),
                'update' => array(
                    'options'=>array('target'=>'_blank'),
                )
            )
        )                 
)));        
?>
