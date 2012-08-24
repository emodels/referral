<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/grid.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" type="text/css" media="all">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
'dataProvider'=>$dataProvider,
'ajaxUpdate'=>true,
'enablePagination' => true,
'columns'=>array(
        'id',
        'first_name',
        'last_name',
        'state',
        'country',
        array(
            'name'=>'status',
            'value'=>'$data->status0->status'
        ),
        array
        (
            'class'=>'CButtonColumn',
            'deleteConfirmation'=>"js:'Are you sure you want to delete this Entry Record ?'",
            'template'=>'{delete}{update}',
            'buttons'=>array(
                'delete' => array
                (
                    'options'=>array('style'=>'padding-right:25px'),
                ))
        )                 
)));        
?>