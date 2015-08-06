<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <style type="text/css">
        body {
            font-family: helvetica, verdana, sans-serif;
        }

        .grid-view
        {
            padding: 15px 0;
        }

        .grid-view table.items
        {
            background: white;
            border-collapse: collapse;
            width: 100%;
            border: 1px #D0E3EF solid;
        }

        .grid-view table.items th, .grid-view table.items td
        {
            font-size: 1.1em;
            border: 1px white solid;
            padding: 0.3em;
        }

        .grid-view table.items th
        {
            color: white;
            background: #5e94f3;
            text-align: center;
        }

        .grid-view table.items th a
        {
            color: #EEE;
            font-weight: bold;
            text-decoration: none;
        }

        .grid-view table.items th a:hover
        {
            color: #FFF;
        }

        .grid-view table.items tr.even
        {
            background: #F8F8F8;
        }

        .grid-view table.items tr.odd
        {
            background: #E5F1F4;
        }

        .grid-view table.items tr.selected
        {
            background: #BCE774;
        }

        .grid-view table.items tr:hover
        {
            background: #ECFBD4;
        }

        .grid-view .link-column img
        {
            border: 0;
        }

        .grid-view .button-column
        {
            text-align: center;
            width: 60px;
        }

        .grid-view .button-column img
        {
            border: 0;
        }

        .grid-view .checkbox-column
        {
            width: 15px;
        }

        .grid-view .summary
        {
            margin: 0 0 5px 0;
            text-align: right;
        }

        .grid-view .pager
        {
            margin: 5px 0 0 0;
            text-align: right;
        }

        .grid-view .empty
        {
            font-style: italic;
        }

        .grid-view .filters input,
        .grid-view .filters select
        {
            width: 100%;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="container" id="page" style="width: 98%; padding: 10px">
        <div class="row">
            <div class="column right" style="text-align: right">
                <div style="font-size: 32px"><strong>Trust Account</strong></div>
                <div style="margin-top: 10px">
                    <?php if ($model->company_logo != null) { ?>
                        <img id="company_logo" src="data:image/jpeg;base64, <?php echo $model->company_logo; ?>" style="width: 200px; height: 80px"/>
                    <?php } ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row">
            <div class="column left">
                <div style="font-size: 28px; margin-bottom: 0px"><?php echo $model->company_name; ?></div>
                <div style="width:496px; font-size: 18px"><?php echo $model->company_address; ?></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row" style="margin-top: 15px">
            <div class="column left">
                <div style="width:500px; font-size: 18px; margin-bottom: 0px"><?php echo $model->partner_name; ?></div>
                <div style="width:500px; font-size: 18px; margin-bottom: 0px"><?php echo $model->partner_telephone; ?></div>
                <div style="width:500px; font-size: 18px; margin-bottom: 0px"><?php echo $model->partner_email; ?></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row" style="margin-top: 20px; padding-bottom: 10px; border-bottom: solid 3px #000000">
            <div class="column left">
                <div style="width:390px; font-size: 18px"><span style="margin-right: 27px; font-size: 18px"><strong>Landlord:</strong></span><?php echo $model->landlord_name; ?></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <h1>Receipts Summary for Property : <?php echo $property->address; ?></h1>
        <h2>Date Range : From <?php echo $date_range['start_date']; ?> To <?php echo $date_range['end_date']; ?></h2>
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider'=>$dataProvider,
            'columns'=>array(
                array(
                    'name' => 'Receipt Number',
                    'value' => '$data->receipt_number',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                ),
                array(
                    'name' => 'Property Address',
                    'value' => '$data->property_address',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                ),
                array(
                    'name' => 'Landlord',
                    'value' => '$data->landlord_name',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                ),
                array(
                    'name' => 'Tenant',
                    'value' => '$data->tenant_name',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                ),
                array(
                    'name' => 'Rent',
                    'value' => '"$" . $data->rent',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                ),
                array(
                    'name' => 'Paid',
                    'value' => '"$" . $data->paid',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                ),
                array(
                    'name' => 'From Date',
                    'value' => '$data->from_date',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                ),
                array(
                    'name' => 'To Date',
                    'value' => '$data->to_date',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                ),
                array(
                    'name' => 'Generated By',
                    'value' => '$data->partner_name',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                ),
                array(
                    'name' => 'Generated Date',
                    'value' => '$data->receipt_date',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                )
            )
        ));
        ?>
        <div style="margin-top: 20px; font-size: 18px">Note: If there any dispute regarding your payment and receipt please contact the undersigned</div>
        <div class="row" style="margin-top: 15px; font-size: 18px">
            <div class="column" style="float: left">Date:</div>
            <div class="column" style="float: left"><?php echo $model->receipt_date; ?></div>
            <div class="clearfix" style="clear: both"></div>
        </div>
        <div style="margin-top: 10px; font-size: 18px"><span id="partner_name_bottom"><?php echo $model->partner_name; ?></span></div>
        <div style="margin-top: 20px; margin-left: 130px">
            <?php if ($model->signature != null) { ?>
                <img id="signature" src="data:image/jpeg;base64, <?php echo $model->signature; ?>" style="width: 339px; height: 49px"/>
            <?php } ?>
        </div>
        <div class="row" style="font-size: 18px">
            <div class="column" style="float: left">Signature:</div>
            <div class="column" style="float: left; margin-left: 100px; margin-top: 5px">----------------------------------</div>
            <div class="clearfix" style="clear: both"></div>
        </div>
    </div>
</body>
</html>