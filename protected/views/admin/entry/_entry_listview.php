<tr class="odd">
    <td><?php echo $data->id; ?></td>
    <td><?php echo $data->first_name; ?></td>
    <td><?php echo $data->last_name; ?></td>
    <td><?php echo $data->country; ?></td>
    <td><?php echo Yii::app()->dateFormatter->format("yyyy-MM-dd", strtotime($data->entry_last_updated_date)); ?></td>
    <td><?php echo $data->status0->status; ?></td>
    <td><?php echo ($data->priority == "0") ? "Low" : (($data->priority == "1") ? "Medium" : "High"); ?></td>
    <td><?php echo $data->referral_commission_amount; ?></td>
    <td class="button-column">
        <a style="text-decoration: none" class="delete" title="Delete" href="../admin/entry/delete/id/<?php echo $data->id ?>">
            <img src="../images/delete.png" alt="Delete">
        </a>
        <a target="_blank" style="text-decoration: none" title="Update" href="../admin/entry/update/id/<?php echo $data->id ?>">
            <img src="../images/update.png" alt="Update">
        </a>
        <a title="<?php echo $data->client_portal_status == 0 ? 'Enable Client Portal' : 'Manage Client Portal'; ?>" href="../client/manageclientportal/<?php echo $data->id ?>">
            <img src="../images/<?php echo $data->client_portal_status == 0 ? 'add' : 'cog'; ?>.png" alt="Manage Client Portal">
        </a>
    </td>
</tr>
