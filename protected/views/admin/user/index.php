<div style="float: left">
    <?php require_once Yii::getPathOfAlias('webroot.protected.views.admin') . '/admin_header_include.php'; ?>
</div>  
<div style="float: left; width: 670px; padding-left: 10px">
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'ajaxUpdate'=>true,
    'enablePagination' => true,
    'columns'=>array(
            'company',
            'first_name',
            'last_name',
            'email',
            array(
                'class'=>'CLinkColumn',
                'label'=>'Status',
                'urlExpression'=>'"status/".$data->id'
                ),
            array
            (
                'class'=>'CButtonColumn',
                'deleteConfirmation'=>"js:'Are you sure you want to delete this Partner ?'",
                'template'=>'{delete}{update}',
                'buttons'=>array(
                    'delete' => array
                    (
                        'options'=>array('style'=>'padding-right:25px'),
                    ))
            )                 
    ))); ?>
</div>
