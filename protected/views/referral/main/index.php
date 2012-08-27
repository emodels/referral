<div style="float: left; width: 100%">
    <?php echo CHtml::beginForm('','post',array('id'=>'Entry')); ?>
    <div class="row">
        <div class="column" style="padding-top: 2px"><b>Partner Company : </b><?php echo Yii::app()->user->company; ?></div>
        <div class="column" style="padding-top: 2px; padding-left: 40px">Status :</div>
        <div class="column"><?php echo CHtml::dropDownList('Entry[status]', '', CHtml::listData(Status::model()->findAll('referral_user=:id', array(':id'=> Yii::app()->user->id)),'id','status'), array('empty'=>'Select Status')); ?></div>
        <div class="column" style="padding-left: 40px"><?php echo CHtml::ajaxButton('List','', array('type'=>'POST','update'=>'#divGrid'), array('class'=>'button','style'=>'padding:2px 10px 2px 10px')) ?></div>    
    </div>
    <div class="row"><hr style="padding-top: 2px"/></div>
    <?php echo CHtml::endForm();  ?>
    <div id="divGrid">
        <?php if (isset($grid)) {
            echo $grid;
        } ?>
    </div>
</div>
