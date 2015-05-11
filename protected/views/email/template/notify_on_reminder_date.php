<div style="font-family: arial">
    <div style="float: left"><img src="http://referral.snt3.com/images/logo.jpg"/></div>
    <div style="padding: 7px 0 0 20px; color: navy"><h2>Dwellings Group Referral Management System</h2></div>
</div>
<br/>
<div style="border: solid 1px silver; width: 100%; padding: 10px; background-color: #f7f7f7; font-family: arial">
    <p><b>Hi <?php echo $client_name; ?>,</b></p>
    <p>This is an automated reminder to notify Status of Referral ID : <?php echo $entry_id; ?>, <a href="<?php echo $link; ?>">Click here</a> to view and update Status and details.</p>
    <p style="color: red; font-size: 14px; font-weight: bold">
        Reminder Date : <?php echo $customer->remind_date; ?><br/><br/>
        Remarks : <?php echo $customer->remarks; ?><br/><br/>
    </p>
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
    <p>Best Regards,<br/><br/>
        Dwellings Group<br/>
        <a href="http://www.dwellingsgroup.com.au/">www.dwellingsgroup.com.au</a>
    </p>
</div>