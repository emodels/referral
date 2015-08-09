<div>
    <div style="text-align: center"><h1>Dear <?php echo ucwords($model->first_name); ?>, Dwellings Group wishing you another year of success, health and happiness...</h1></div>
    <div>
        <img src="<?php echo Yii::app()->getBaseUrl(true) . '/images/happy_birthday_background.jpg'; ?>" style="width: 750px; height: 467px"/>
    </div>
    <div>Best Regards,</div>
    <div><img width="149" height="68" src="<?php echo Yii::app()->getBaseUrl(true) . '/images/logo.jpg'; ?>"></div>
    <div>
        <?php
        $user = User::model()->find('user_type = 0');

        if (isset($user)) {

            echo $user_>header_title;
        }
        ?>
    </div>
</div>