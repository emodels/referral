<div style="float: left; width: 17%">
    <?php
    if (Yii::app()->user->user_type == '0') {

        require_once Yii::getPathOfAlias('webroot.protected.views.admin') . '/admin_header_include.php';

    } else {

        require_once Yii::getPathOfAlias('webroot.protected.views.referral') . '/referral_header_include.php';
    }
    ?>
</div>  
<div id="divListing" style="float: left; width: 82%; padding: 0 0 0 10px">

    <script type="text/javascript">

        $(document).ready(function () {

            ToggleMenu();
        });

        function ToggleMenu() {

            $('.link_box').toggle();

            if ($('#lnkMenuToggle h5').html().indexOf('Hide') > -1) {

                $('#lnkMenuToggle h5').html('Show Menu >>');
                $('#divListing').css('width', '100%').css('padding-left', '0px');

            } else {

                $('#lnkMenuToggle h5').html('<< Hide Menu');
                $('#divListing').css('width', '82%').css('padding-left', '10px');
            }
        }

        function ValidatePortalClients(obj) {

            if ($(obj).attr('id') == 'Entry_isPortalClientsOnly') {

                $('#Entry_isNonPortalClientsOnly').removeAttr('checked');

            } else {

                $('#Entry_isPortalClientsOnly').removeAttr('checked');
            }

            $('#yt0').click();
        }
    </script>

    <div style="width: 100px"><a id="lnkMenuToggle" href="javascript:ToggleMenu();"><h5><< Hide Menu</h5></a></div>

    <?php
    $partnerCompany = '';
    $partnerListData = CHtml::listData(User::model()->findAll('user_type = :user_type', array(':user_type'=>'1')),'id','company');
    $statusArray = array();

    if (Yii::app()->user->user_type == '0' && Yii::app()->session['referrel_user']) {

        $partnerCompany = Yii::app()->session['referrel_user'];
        $statusArray = CHtml::listData(Status::model()->findAll('referral_user=:id',array(':id'=>Yii::app()->session['referrel_user'])),'id','status');
    }

    if (Yii::app()->user->user_type != '0') {

        $partnerCompany = Yii::app()->user->id;
        $partnerListData = CHtml::listData(User::model()->findAll('id = ' . Yii::app()->user->id),'id','company');
        $statusArray = CHtml::listData(Status::model()->findAll('referral_user=:id',array(':id'=>Yii::app()->user->id)),'id','status');
    }
    ?>

    <?php echo CHtml::beginForm('','post',array('id'=>'Entry')); ?>
    <div class="row">
        <div class="column" style="padding-top: 2px">Partner Company :</div>
        <div class="column"><?php echo CHtml::dropDownList('Entry[referrel_user]', $partnerCompany, $partnerListData, array('empty'=> $partnerCompany != '' ? null : 'Select Partner','style' => 'width:153px',
                                       'ajax' => array('type'=>'POST','url'=>CController::createUrl('ListStatus'),
                                       'beforeSend' => 'function(){
                                            $(".ajax-loading").hide();
                                            $("#divProgress").show();
                                       }',
                                       'success'=>'js:function(data) {
                                            $("#divProgress").hide();
                                            $("#Entry_status").html(data);
                                        }'))); ?></div>
        <div class="column" style="padding-top: 2px; padding-left: 40px; padding-right: 28px">Status :</div>
        <div class="column"><?php echo CHtml::dropDownList('Entry[status]', '', $statusArray, array('empty'=>'Select Status', 'style' => 'width:153px')); ?></div>
        <div class="column" style="padding-top: 2px; padding-left: 40px; padding-right: 28px">Property Holder :</div>
        <div class="column"><?php echo CHtml::dropDownList('Entry[property_holder]', '', array('Owner'=>'Owner','Tenant'=>'Tenant','Landlord'=>'Landlord'), array('empty'=>'Select Property Holder', 'style' => 'width:160px')); ?></div>
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
        <div class="column right"><?php echo CHtml::checkBox('Entry[isPortalClientsOnly]', false, array('style' => 'width:20px', 'onclick' => 'js:ValidatePortalClients(this);')); ?> Show Portal Clients Only</div>
    </div>
    <div class="clearfix" style="padding-bottom: 5px"></div>
    <div class="row" style="border-top: solid 1px silver; padding-top: 5px">
        <div class="column" style="padding-top: 2px; padding-right: 45px">First Name</div>
        <div class="column"><?php echo CHtml::textField('Entry[first_name]', '') ?></div>
        <div class="column" style="padding-top: 2px; padding-left: 40px">Last Name :</div>
        <div class="column"><?php echo CHtml::textField('Entry[last_name]', '') ?></div>
        <div class="column" style="padding-left: 38px"><?php echo CHtml::ajaxButton('List','', array('type'=>'POST',
                                       'beforeSend' => 'function(){
                                            $(".ajax-loading").hide();
                                            $("#divProgress").show();
                                       }',
                                       'success'=>'js:function(data) {
                                            $("#divProgress").hide();
                                            $("#divGrid").html(data);
                                       }'), array('class'=>'button','style'=>'padding:2px 10px 2px 10px')); ?>
        </div>
        <div class="column right"><?php echo CHtml::checkBox('Entry[isNonPortalClientsOnly]', false, array('style' => 'width:20px', 'onclick' => 'js:ValidatePortalClients(this);')); ?> Show Non-Portal Clients Only</div>
    </div>
    <div class="row"><hr style="padding-top: 2px"/></div>
    <?php echo CHtml::endForm();  ?>

    <div id="divProgress" style="display: none; padding-bottom: 10px">
        <span><img src="<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader2.gif" style="width: 40px; vertical-align: middle"/></span>
        <span style="font-size: 16px; color: green"><b>Loading results . . .</b></span>
    </div>

    <div id="divGrid">
    <?php

    if (Yii::app()->user->user_type == '0') {

        $partners = User::model()->findAll('user_type = :user_type', array(':user_type'=>'1'));

    } else {

        $partners = User::model()->findAll('id = :id', array(':id'=>Yii::app()->user->id));
    }

    if (isset(Yii::app()->session['referrel_user'])) {

        $partners = User::model()->findAll('id = :id', array(':id'=>Yii::app()->session['referrel_user']));
    }

    foreach ($partners as $partner) {

        $dataProvider_custom = new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . $partner->id, 'order'=>'id DESC'), 'pagination' => false));
        echo $this->renderPartial('_entry_gridview', array('dataProvider'=>$dataProvider_custom,'grid_title'=>$partner->company . ' - '. $partner->first_name . ' ' . $partner->last_name),true,false);
    }
    ?>
    </div>
</div>
