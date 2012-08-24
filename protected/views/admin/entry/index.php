<div style="float: left">
    <?php require_once Yii::getPathOfAlias('webroot.protected.views.admin') . '/admin_header_include.php'; ?>
</div>  
<div style="float: left; width: 670px; padding: 12px 0 0 10px">
    <?php echo CHtml::beginForm('','post',array('id'=>'Entry')); ?>
    <div class="row">
        <div class="column" style="padding-top: 2px">Referral Company :</div>
        <div class="column"><?php echo CHtml::dropDownList('Entry[referrel_user]', '', CHtml::listData(User::model()->findAll('user_type = :user_type', array(':user_type'=>'1')),'id','company'), array('empty'=>'Select Referral','ajax' => array('type'=>'POST','url'=>CController::createUrl('ListStatus'),'update'=>'#Entry_status'))); ?></div>
        <div class="column" style="padding-top: 2px; padding-left: 40px">Status :</div>
        <div class="column"><?php echo CHtml::dropDownList('Entry[status]', '', array(), array('empty'=>'Select Status')); ?></div>
        <div class="column" style="padding-left: 40px"><?php echo CHtml::ajaxButton('List','', array('type'=>'POST','update'=>'#divGrid'), array('class'=>'button','style'=>'padding:2px 10px 2px 10px')) ?></div>    
    </div>
    <div class="row"><hr style="padding-top: 2px"/></div>
    <?php echo CHtml::endForm();  ?>
    <div id="divGrid"></div>
</div>
