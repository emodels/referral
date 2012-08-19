<div style="float: left">
    <?php require_once Yii::getPathOfAlias('webroot.protected.views.admin') . '/admin_header_include.php'; ?>
</div>  
<div style="float: left; width: 670px; padding: 12px 0 0 10px">
    <div style="float: left"><a href="add/id/<?php echo Yii::app()->request->getQuery('id'); ?>" class="link_box"><img style="vertical-align: middle; text-decoration: none; padding-right: 5px" src="<?php echo Yii::app()->baseUrl; ?>/images/add.png">Add Status</a></div>
    <div style="float: left; padding-left: 20px; font-size: 18px"><?php echo $referral_user_name; ?></div>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'ajaxUpdate'=>true,
    'enablePagination' => true,
    'columns'=>array(
            'status',
            array
            (
                'class'=>'CButtonColumn',
                'deleteConfirmation'=>"js:'Are you sure you want to delete this Status ?'",
                'template'=>'{delete}{update}',
                'buttons'=>array(
                    'delete' => array
                    (
                        'options'=>array('style'=>'padding-right:25px'),
                    ))
            )                 
    ))); ?>
</div>
