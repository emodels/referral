<div style="float: left">
    <?php require_once Yii::getPathOfAlias('webroot.protected.views.admin') . '/admin_header_include.php'; ?>
</div>  
<div style="float: left; width: 670px; padding: 12px 0 0 10px">
    <?php echo CHtml::beginForm('','post',array('id'=>'Entry')); ?>
    <div class="row">
        <div class="column" style="padding-top: 2px">Partner Company :</div>
        <div class="column"><?php echo CHtml::dropDownList('Entry[referrel_user]', '', CHtml::listData(User::model()->findAll('user_type = :user_type', array(':user_type'=>'1')),'id','company'), array('empty'=>'Select Partner',
                                       'ajax' => array('type'=>'POST','url'=>CController::createUrl('ListStatus'),
                                       'beforeSend' => 'function(){
                                            $(".ajax-loading").hide();
                                            $("#divProgress").show();
                                       }',
                                       'success'=>'js:function(data) {
                                            $("#divProgress").hide();
                                            $("#Entry_status").html(data);
                                        }'))); ?></div>
        <div class="column" style="padding-top: 2px; padding-left: 40px">Status :</div>
        <div class="column"><?php echo CHtml::dropDownList('Entry[status]', '', array(), array('empty'=>'Select Status')); ?></div>
        <div class="column" style="padding-left: 40px"><?php echo CHtml::ajaxButton('List','', array('type'=>'POST',
                                       'beforeSend' => 'function(){
                                            $(".ajax-loading").hide();
                                            $("#divProgress").show();
                                       }',
                                       'success'=>'js:function(data) {
                                            $("#divProgress").hide();
                                            $("#divGrid").html(data);
                                       }'), array('class'=>'button','style'=>'padding:2px 10px 2px 10px')); ?>
        </div>
    </div>
    <div class="row"><hr style="padding-top: 2px"/></div>
    <?php echo CHtml::endForm();  ?>
    <div id="divProgress" style="display: none; padding-bottom: 10px">
        <span><img src="<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader2.gif" style="width: 40px; vertical-align: middle"/></span>
        <span style="font-size: 16px; color: green"><b>Loading results . . .</b></span>
    </div>
    <div id="divGrid">
    <?php
    if ($ShowAll == TRUE) {
        $partners = User::model()->findAll('user_type = :user_type', array(':user_type'=>'1'));
        foreach ($partners as $partner) {
            $dataProvider_custom = new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . $partner->id, 'order'=>'id DESC')));
            $this->renderPartial('_entry_gridview', array('dataProvider'=>$dataProvider_custom,'grid_title'=>$partner->company),false,true);
        }
    }
    ?>
    </div>
</div>
