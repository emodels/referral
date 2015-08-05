<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
</head>
<body>
    <div class="container" id="page" style="width: 98%; padding: 10px">
        <div class="form">
            <div class="row">
                <div class="column right" style="text-align: right">
                    <div style="font-size: 32px"><strong>Trust Account</strong></div>
                    <div style="font-size: 28px"><strong>Receipt number: <?php echo $model->receipt_number; ?></div>
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
            <div style="margin-top: 20px; font-size: 18px; border-bottom: solid 4px #000000"><strong>Particulars</strong></div>
            <div class="row" style="margin-top: 25px; font-size: 18px; font-weight: bold; border-bottom: solid 5px #000000">
                <div class="column" style="float: left; width: 25%">Property</div>
                <div class="column" style="float: left; width: 20%">Tenant</div>
                <div class="column" style="float: left; width: 15%">Rent</div>
                <div class="column" style="float: left; width: 15%">Paid</div>
                <div class="column" style="float: left; width: 10%">From</div>
                <div class="column" style="float: left; width: 10%">To</div>
                <div class="clearfix" style="clear: both"></div>
            </div>
            <div class="row" style="margin-top: 25px; padding-bottom: 20px; font-size: 18px; font-weight: bold; border-bottom: solid 5px #000000">
                <div class="column" style="float: left; width: 25%"><?php echo $model->property_address; ?></div>
                <div class="column" style="float: left; width: 20%"><?php echo $model->tenant_name; ?></div>
                <div class="column" style="float: left; width: 15%">$<?php echo $model->rent; ?></div>
                <div class="column" style="float: left; width: 15%">$<?php echo $model->paid; ?></div>
                <div class="column" style="float: left; width: 10%"><?php echo $model->from_date; ?></div>
                <div class="column" style="float: left; width: 10%"><?php echo $model->to_date; ?></div>
                <div class="clearfix" style="clear: both"></div>
            </div>
            <div style="margin-top: 20px; font-size: 18px; border-bottom: solid 4px #000000"><strong>Disbursements</strong></div>
            <div class="row" style="margin-top: 25px; font-size: 18px; font-weight: bold; border-bottom: solid 5px #000000">
                <div class="column" style="float: left; width: 61.5%">Item</div>
                <div class="column" style="float: left; width: 20%">Debit</div>
                <div class="column" style="float: left; width: 15%">Credit</div>
                <div class="clearfix" style="clear: both"></div>
            </div>
            <div class="row" style="margin-top: 25px; font-size: 18px">
                <div class="column" style="float: left; width: 61.5%">Rent received</div>
                <div class="column" style="float: left; width: 20%">&nbsp;</div>
                <div class="column" style="float: left; width: 15%">$<span id="rent_received"><?php echo $model->paid; ?></span></div>
                <div class="clearfix" style="clear: both"></div>
            </div>
            <div class="row" style="font-size: 18px">
                <div class="column" style="float: left; width: 61.5%">Management fees</div>
                <div class="column" style="float: left; width: 20%"><span id="management_fees">$<?php echo $model->management_fees; ?></span></div>
                <div class="column" style="float: left; width: 15%">&nbsp;</div>
                <div class="clearfix" style="clear: both"></div>
            </div>
            <div class="row" style="font-size: 18px">
                <div class="column" style="float: left; width: 61.5%">GST</div>
                <div class="column" style="float: left; width: 20%"><span id="gst">$<?php echo $model->gst; ?></span></div>
                <div class="column" style="float: left; width: 15%">&nbsp;</div>
                <div class="clearfix" style="clear: both"></div>
            </div>
            <div id="divCosts">
                <?php
                $costsTotal = 0;

                if (isset($model->costs) && $model->costs !== '') {

                    $costArray = json_decode($model->costs);

                    foreach ($costArray as $cost) { $costsTotal += $cost->value; ?>

                        <div class="row" style="font-size: 18px">
                            <div class="column" style="float: left; width: 61.5%"><?php echo $cost->name; ?></div>
                            <div class="column" style="float: left; width: 20%">$<?php echo $cost->value; ?></div>
                            <div class="column" style="float: left; width: 15%">&nbsp;</div>
                            <div class="clearfix" style="clear: both"></div>
                        </div>

                    <?php } ?>

                <?php } ?>
            </div>
            <div class="row" style="font-size: 18px">
                <div class="column" style="float: left; width: 61.5%">Your account</div>
                <div class="column" style="float: left; width: 20%">$<?php echo number_format($model->paid - ($model->management_fees + $model->gst + $costsTotal), 2, '.', ''); ?></div>
                <div class="column" style="float: left; width: 15%">&nbsp;</div>
                <div class="clearfix" style="clear: both"></div>
            </div>
            <div class="row" style="font-size: 18px; border-bottom: solid 4px #000000; border-top: solid 4px #000000; padding: 2px 0 2px 0; margin-top: 20px">
                <div class="column" style="float: left; width: 61.5%">Total</div>
                <div class="column" style="float: left; width: 20%"><span id="total_debit">$<?php echo $model->paid; ?></span></div>
                <div class="column" style="float: left; width: 15%"><span id="total_credit">$<?php echo $model->paid; ?></span></div>
                <div class="clearfix" style="clear: both"></div>
            </div>
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
    </div>
</body>
</html>