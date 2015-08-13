<div style="font-family: arial">
    <div style="float: left"><img width="<?php echo Yii::app()->user->site_logo_width; ?>" height="<?php echo Yii::app()->user->site_logo_height; ?>" src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/logo.jpg"/></div>
    <div style="padding: 7px 0 0 20px; color: navy"><h2><?php echo Yii::app()->user->site_name; ?></h2></div>
</div>
<br/>
<div style="border: solid 1px silver; width: 100%; padding: 10px; background-color: #f7f7f7; font-family: arial">
    <p><b>Hi Admin,</b></p>
    <p>Partner <b><?php echo $client_name; ?></b> from <b><?php echo $client_company; ?></b> have recently <b>changed details and Status</b> of Referral ID : <?php echo $entry_id; ?>. <a href="<?php echo $link; ?>">Click here</a> to view details.</p>
    <p>
        <b><u>Customer Details:</u></b><br/><br/>
        Name : <?php echo $customer->first_name . ' ' . $customer->last_name; ?><br/><br/>
        Telephone : <?php echo $customer->telephone; ?><br/><br/>
        Email : <?php echo $customer->email; ?><br/><br/>
        Status : <?php echo $customer->status0->status; ?><br/><br/>
        Description : <br/><br/>
        <div style="padding: 10px; border: solid 1px silver; background-color: white">
            <?php echo $customer->description; ?>
        </div>
    </p>
</div>
<div style="padding: 10px 0 10px 0; font-size:8.0pt; font-family: arial, sans-serif; color:#333399">Best Regards,</div>
<div><img width="<?php echo Yii::app()->user->site_logo_width; ?>" height="<?php echo Yii::app()->user->site_logo_height; ?>" src="<?php echo Yii::app()->getBaseUrl(true) . '/images/logo.jpg'; ?>"></div>
<div style="font-size:8.0pt; font-family: arial, sans-serif; color:#333399"><?php echo Yii::app()->user->site_address; ?></div>
