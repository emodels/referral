<?php
$allow_add_referral = false;

if (!Yii::app()->user->isGuest) {
    $user = User::model()->findByPk(Yii::app()->user->id);

    if (isset($user)) {
        $allow_add_referral = $user->allow_add_referral;
    }
}
?>
<div class="link_box">
    <ul>
        <?php if($allow_add_referral == true) { ?>
        <li><a href="<?php echo Yii::app()->baseUrl; ?>/entry/add">Add New Referral</a></li>
        <?php } ?>
        <li><a href="<?php echo Yii::app()->baseUrl; ?>/entry">View Referrals</a></li>
    </ul>
</div>  