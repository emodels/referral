<div style="font-family: arial">
    <div style="float: left"><img width="<?php echo Yii::app()->user->site_logo_width; ?>" height="<?php echo Yii::app()->user->site_logo_height; ?>" src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/logo.jpg"/></div>
    <div style="padding: 7px 0 0 20px; color: navy"><h2><?php echo Yii::app()->user->site_name; ?></h2></div>
</div>
<br/>
<div style="border: solid 1px silver; width: 100%; padding: 10px; background-color: #f7f7f7; font-family: arial">
    <p><b>Hi <?php echo $user->first_name; ?>,</b></p>
    <p><?php echo Yii::app()->user->site_name; ?> have enabled your Clint Portal and please use following login information to access the portal.</p>
    <p>
        <b><u>Login Details:</u></b><br/><br/>
        Portal Login URL : <?php echo Yii::app()->params['domain']; ?><br/><br/>
        User Name : <?php echo $user->username; ?><br/><br/>
        Password : <?php echo $user->password; ?><br/><br/>
    </p>
</div>
<div style="padding: 10px 0 10px 0; font-size:8.0pt; font-family: arial, sans-serif; color:#333399">Best Regards,</div>
<div><img width="<?php echo Yii::app()->user->site_logo_width; ?>" height="<?php echo Yii::app()->user->site_logo_height; ?>" src="<?php echo Yii::app()->getBaseUrl(true) . '/images/logo.jpg'; ?>"></div>
<div style="font-size:8.0pt; font-family: arial, sans-serif; color:#333399"><?php echo Yii::app()->user->site_address; ?></div>
