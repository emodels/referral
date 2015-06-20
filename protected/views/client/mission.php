<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/grid.css" type="text/css" media="all">

<?php if(isset($grid_title)){ ?>
    <div style="float: left; padding-bottom: 5px"><font style="font-size: 14px"><b><?php echo $grid_title; ?></b></font></div>
<?php } ?>

<div class="grid-view">
    <table class="items">
        <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Country</th>
            <th>Last  Updated</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'enableSorting' => false,
            'itemView' => '/client/_entry_listview'
        ));
        ?>
        </tbody>
    </table>
</div>