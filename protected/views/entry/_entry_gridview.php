<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/grid.css" type="text/css" media="all">

<style type="text/css">
    .hover_highlight:hover {
        border: solid 2px #000000 !important;
    }
</style>

<script type="text/javascript">

    function deleteReferral(id) {

        var confirm = window.confirm('Do you want to delete this record ?');

        if (confirm) {

            $.ajax({
                method: "POST",
                url: "entry/delete/id/" + id

            }).done(function( msg ) {

                if (msg == 'Deleted') {

                    window.document.location.reload();

                } else {

                    alert(msg);
                }
            });
        }
    }

    function ChangePropValue(id, field, value) {

        if (confirm('Are you sure you want to change status of this field ?')) {

            $.ajax({
                type: 'POST',
                url: 'client/property/updatefieldvalue',
                dataType: 'json',
                data: {'id': id, 'field': field, 'value': value},
                complete: function (data) {

                    if (data.responseText == 'done'){

                        window.document.location.reload();
                    }
                }
            });
        }
    }
</script>

<?php if(isset($grid_title)){ ?>
<div style="float: left; padding-bottom: 5px"><font style="font-size: 14px"><b><?php echo $grid_title; ?></b></font></div>
<?php } ?>

<?php
$total = 0;
if (isset($dataProvider)) {

    foreach($dataProvider->data as $item){

        $total += $item->referral_commission_amount;
    }
}
?>

<div class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Type</th>
                <th>Country</th>
                <th>Last  Updated</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Commission</th>
                <th class="button-column">&nbsp;</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><div style="border-top: solid 1px silver;border-bottom: double 4px silver; padding: 5px 0 5px 0"><b>Total Commission :</b></div></td><td>&nbsp;</td><td><div style="border-top: solid 1px silver;border-bottom: double 4px silver; padding: 5px 0 5px 0"><b><?php echo $total; ?></b></div></td><td class="button-column">&nbsp;</td>
            </tr>
        </tfoot>
        <tbody>
            <?php
            $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'enableSorting' => false,
            'itemView' => '_entry_listview'
            ));
            ?>
        </tbody>
    </table>
</div>