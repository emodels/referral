<div style="font-family: arial">
    <div style="float: left"><img src="http://referral.snt3.com/images/logo.jpg"/></div>
    <div style="padding: 7px 0 0 20px; color: navy"><h2>Dwellings Group Referral Management System</h2></div>
</div>
<br/>
<div style="border: solid 1px silver; width: 100%; padding: 10px; background-color: #f7f7f7; font-family: arial">
    <p><b>Hi <?php echo $user->first_name; ?>,</b></p>
    <p>Dwellings Group have enabled your Clint Portal and please use following login information to access the portal.</p>
    <p>
        <b><u>Login Details:</u></b><br/><br/>
        Portal Login URL : <?php echo Yii::app()->getBaseUrl(true); ?><br/><br/>
        User Name : <?php echo $user->username; ?><br/><br/>
        Password : <?php echo $user->password; ?><br/><br/>
    </p>
    <p>Best Regards,<br/><br/>
        Dwellings Group<br/>
        <a href="http://www.dwellingsgroup.com.au/">www.dwellingsgroup.com.au</a>
    </p>
</div>