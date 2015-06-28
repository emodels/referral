<div style="font-family: arial">
    <div style="float: left"><img src="http://referral.snt3.com/images/logo.jpg"/></div>
    <div style="padding: 7px 0 0 20px; color: navy"><h2>Dwellings Group Referral Management System</h2></div>
</div>
<br/>
<div style="border: solid 1px silver; width: 100%; padding: 10px; background-color: #f7f7f7; font-family: arial">
    <p><b>Hi <?php echo ucfirst($document->property0->entry0->first_name); ?>,</b></p>
    <p>New Document has been added for your property as following.</p>
    <p style="color: blue; font-size: 12px; font-weight: bold; padding-top: 15px">
        Property Address: <?php echo $document->property0->address; ?><br/><br/>
        Category : <?php echo $document->category0->name; ?><br/><br/>
        Document Caption : <?php echo $document->caption; ?><br/><br/>
        Document Dropbox Link : <a href="<?php echo $document->document ?>"><?php echo $document->document; ?></a><br/><br/>
        Document Added Date : <?php echo $document->entry_date; ?><br/><br/>
    </p>
    <p>Best Regards,<br/><br/>
        Dwellings Group<br/>
        <a href="http://www.dwellingsgroup.com.au/">www.dwellingsgroup.com.au</a>
    </p>
</div>