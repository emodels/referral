<div style="float: left">
    <?php require_once Yii::getPathOfAlias('webroot.protected.views.admin') . '/admin_header_include.php'; ?>
</div>  
<div style="float: left; width: 670px; padding-left: 10px">
<div style="float: right">
    <a href="<?php echo Yii::app()->baseUrl; ?>/admin/category/add" class="button" style="text-decoration: none">Add New Category</a>
</div>
<div class="clearfix"></div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider->search(),
    'filter'=>$dataProvider,
    'ajaxUpdate'=>true,
    'enablePagination' => true,
    'columns'=>array(
            'name',
            array
            (
                'class'=>'CButtonColumn',
                'deleteConfirmation'=>"js:'Are you sure you want to delete this Category ?'",
                'template'=>'{delete}{update}',
                'buttons'=>array(
                    'delete' => array
                    (
                        'options'=>array('style'=>'padding-right:25px'),
                    ))
            )                 
    ))); ?>
</div>
