<tr class="odd">
    <td><?php echo '<b>' . $data->to_name . '</b><br>(' . $data->to_email . ')'; ?></td>
    <td><?php echo $data->subject; ?></td>
    <td style="text-align: center">
        <button class="button viewMessage">View Message</button>
        <div class="hide"><?php echo $data->message; ?></div>
    </td>
    <td style="text-align: center"><?php echo Yii::app()->dateFormatter->format("yyyy-MM-dd h:i:s", strtotime($data->entry_date)); ?></td>
</tr>
