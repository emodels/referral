<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/grid.css" type="text/css" media="all">
<script type="text/javascript">
    $(document).ready(function () {

        $('.viewMessage').click(function () {

            $('#logMessage').html($(this).next().html());
            $("#mydialog").dialog("open");
        })
    });
</script>
<div style="float: left; width: 17%">
    <?php
    if (Yii::app()->user->user_type == '0') {

        require_once Yii::getPathOfAlias('webroot.protected.views.admin') . '/admin_header_include.php';

    } else {

        require_once Yii::getPathOfAlias('webroot.protected.views.referral') . '/referral_header_include.php';
    }
    ?>
</div>
<div style="float: left; width: 82%; padding-left: 10px">
    <div style="float: right">
        <h1>Mail Log for <?php echo $user->company . ' - ' . $user->first_name . ' ' . $user->last_name; ?></h1>
    </div>
    <div class="clearfix"></div>
    <div class="grid-view">
        <table class="items">
            <thead>
            <tr>
                <th style="text-align: left">Email</th>
                <th style="text-align: left">Subject</th>
                <th>Message</th>
                <th>Date/Time</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'enableSorting' => false,
                'itemView' => '_mail_log_listview'
            ));
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'mydialog',
    'options'=>array(
        'title'=>'Mail Log - Message',
        'autoOpen'=>false,
        'width'=> '800',
        'height' => '600'
    ),
));
?>
<div id="logMessage" style="padding: 20px"></div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
