<tr class="odd">
    <td><a name="<?php echo $data->id; ?>" style="text-decoration: none; color: #000000"><?php echo $data->id; ?></a></td>
    <td><?php echo $data->first_name; ?></td>
    <td><?php echo $data->last_name; ?></td>
    <td>
        <?php echo str_replace('_', ' ', $data->property_holder); ?>
        <?php if ($data->property_holder == 'Tenant') { ?>
            <img src="images/icon_tenant.png" style="padding-left: 20px; vertical-align: middle" />
            <?php $landload_property = Property::model()->find('tenant = ' . $data->id); ?>
            <?php if (isset($landload_property)) { ?>
                <div style="float: right; padding: 5px; background-color: blue; width: 90px; text-align: center; border: solid 1px #000000"><a href="#<?php echo $landload_property->entry; ?>" onclick="javascript:highlightRow('<?php echo $landload_property->entry; ?>', 'blue');" style="color: white; text-decoration: none">View Landlord</a></div>
            <?php } ?>
        <?php } ?>
        <?php if ($data->property_holder == 'Landlord') { ?><img src="images/icon_rental_agent.png" style="width: 23px; padding-left: 10px; vertical-align: middle" /><?php } ?>
    </td>
    <td><?php echo $data->country; ?></td>
    <td><?php echo Yii::app()->dateFormatter->format("yyyy-MM-dd", strtotime($data->entry_last_updated_date)); ?></td>
    <td><?php echo $data->status0->status; ?></td>
    <td><?php echo ($data->priority == "0") ? "Low" : (($data->priority == "1") ? "Medium" : "High"); ?></td>
    <td><?php echo $data->referral_commission_amount; ?></td>
    <td class="button-column">
        <a style="text-decoration: none" class="delete" title="Delete" href="javascript:deleteReferral('<?php echo $data->id ?>');">
            <img src="images/delete.png" alt="Delete">
        </a>
        <a style="text-decoration: none" title="Update" href="entry/update/id/<?php echo $data->id ?>">
            <img src="images/update.png" alt="Update">
        </a>
        <a style="display: <?php echo ((Yii::app()->user->user_type == 1 && Yii::app()->user->allow_portal_management == 0) ? 'none' : 'inline-block' )?>;" title="<?php echo $data->client_portal_status == 0 ? 'Enable Client Portal' : 'Manage Client Portal'; ?>" href="client/manageclientportal/<?php echo $data->id ?>">
            <img src="images/<?php echo $data->client_portal_status == 0 ? 'add' : 'cog'; ?>.png" alt="Manage Client Portal">
        </a>
        <a href="site/maillog/entry/<?php echo $data->id; ?>/type/0">
            <img src="images/mail.png" alt="Mail Log" title="Mail Log">
        </a>
    </td>
</tr>
<?php if (count($data->properties) > 0) { ?>
<tr>
    <td colspan="10" style="padding: 0px; border-bottom: solid 5px navy">
        <table class="items">
            <thead>
                <tr>
                    <th style="background: #cecece; color: #000000; text-align: left">Builder</th>
                    <th style="background: #cecece; color: #000000; text-align: left">Property</th>
                    <th style="background: #cecece; color: #000000; text-align: left">Status</th>
                    <th style="background: #cecece; color: #000000; text-align: left">Owner</th>
                    <?php if ($data->property_holder !== 'Tenant') { ?>
                    <th style="background: #cecece; color: #000000; text-align: left">Initial Deposit ?</th>
                    <th style="background: #cecece; color: #000000; text-align: left">Contracts Signed ?</th>
                    <th style="background: #cecece; color: #000000; text-align: left">5% - 10% Deposit ?</th>
                    <th style="background: #cecece; color: #000000; text-align: left">FIRB Approval ?</th>
                    <th style="background: #cecece; color: #000000; text-align: left">Finance Approval ?</th>
                    <th style="background: #cecece; color: #000000; text-align: left">Property Completion ?</th>
                    <th style="background: #cecece; color: #000000; text-align: left">Rented Out ?</th>
                    <th style="background: #cecece; color: #000000; text-align: left">Insurance in Place ?</th>
                    <th style="background: #cecece; color: #000000; text-align: left">Expected Settlement Date</th>
                    <?php } ?>
                    <th style="background: #cecece; color: #000000; text-align: center; display: <?php echo ((Yii::app()->user->user_type == 1 && Yii::app()->user->allow_portal_management == 0) ? 'none' : 'table-cell')?>;">Documents</th>
                    <th style="background: #cecece; color: #000000; text-align: center; display: <?php echo ((Yii::app()->user->user_type == 1 && Yii::app()->user->allow_portal_management == 0) ? 'none' : 'table-cell')?>;">Receipts</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($data->properties as $property) { ?>
                <tr>
                    <td><?php echo $property->builder; ?></td>
                    <td>
                        <a href="<?php echo Yii::app()->baseUrl . '/client/property/update/id/' . $property->id ?>" title="Update Property Information"><?php echo $property->address; ?></a>
                        <?php if (isset($property->tenant) && $property->tenant != 0) { ?>
                            <div style="padding: 5px; margin: 5px 0 5px 0; background-color: red; width: 65px; text-align: center; border: solid 1px #000000"><a href="#<?php echo $property->tenant; ?>" onclick="javascript:highlightRow('<?php echo $property->tenant; ?>', 'red');" style="color: white; text-decoration: none">View Tenant</a></div>
                        <?php } ?>
                    </td>
                    <td class="hover_highlight" onclick="javascript:ChangePropValue('<?php echo $property->id; ?>', 'status', '<?php echo $property->status == 'Open' ? 'Closed' : 'Open'; ?>');" style="cursor: pointer; <?php echo $property->status == 'Open' ? 'background-color: #FFF733; color: black' : 'background-color: #006600; color: white'; ?>"><?php echo $property->status; ?></td>
                    <td><?php echo $property->owner0->first_name; ?></td>
                    <?php if ($data->property_holder !== 'Tenant') { ?>
                    <td class="hover_highlight" onclick="javascript:ChangePropValue('<?php echo $property->id; ?>', 'initial_deposit', '<?php echo $property->initial_deposit == 1 ? '0' : '1'; ?>');" style="cursor: pointer; background-color: <?php echo $property->initial_deposit == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->initial_deposit == 1 ? 'Yes' : 'No'; ?></td>
                    <td class="hover_highlight" onclick="javascript:ChangePropValue('<?php echo $property->id; ?>', 'contracts_signed', '<?php echo $property->contracts_signed == 1 ? '0' : '1'; ?>');" style="cursor: pointer; background-color: <?php echo $property->contracts_signed == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->contracts_signed == 1 ? 'Yes' : 'No'; ?></td>
                    <td class="hover_highlight" onclick="javascript:ChangePropValue('<?php echo $property->id; ?>', 'five_ten_deposit', '<?php echo $property->five_ten_deposit == 1 ? '0' : '1'; ?>');" style="cursor: pointer; background-color: <?php echo $property->five_ten_deposit == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->five_ten_deposit == 1 ? 'Yes' : 'No'; ?></td>
                    <td class="hover_highlight" onclick="javascript:ChangePropValue('<?php echo $property->id; ?>', 'firb_approval', '<?php echo $property->firb_approval == 1 ? '0' : '1'; ?>');" style="cursor: pointer; background-color: <?php echo $property->firb_approval == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->firb_approval == 1 ? 'Yes' : 'No'; ?></td>
                    <td class="hover_highlight" onclick="javascript:ChangePropValue('<?php echo $property->id; ?>', 'finance_approval', '<?php echo $property->finance_approval == 1 ? '0' : '1'; ?>');" style="cursor: pointer; background-color: <?php echo $property->finance_approval == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->finance_approval == 1 ? 'Yes' : 'No'; ?></td>
                    <td class="hover_highlight" onclick="javascript:ChangePropValue('<?php echo $property->id; ?>', 'property_completion', '<?php echo $property->property_completion == 1 ? '0' : '1'; ?>');" style="cursor: pointer; background-color: <?php echo $property->property_completion == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->property_completion == 1 ? 'Yes' : 'No'; ?></td>
                    <td class="hover_highlight" onclick="javascript:ChangePropValue('<?php echo $property->id; ?>', 'rented_out', '<?php echo $property->rented_out == 1 ? '0' : '1'; ?>');" style="cursor: pointer; background-color: <?php echo $property->rented_out == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->rented_out == 1 ? 'Yes' : 'No'; ?></td>
                    <td class="hover_highlight" onclick="javascript:ChangePropValue('<?php echo $property->id; ?>', 'insurance_in_place', '<?php echo $property->insurance_in_place == 1 ? '0' : '1'; ?>');" style="cursor: pointer; background-color: <?php echo $property->insurance_in_place == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->insurance_in_place == 1 ? 'Yes' : 'No'; ?></td>
                    <td class="hover_highlight" onclick="javascript:window.document.location.replace('<?php echo Yii::app()->baseUrl . '/client/property/update/id/' . $property->id ?>');" style="text-align: center; cursor: pointer; background-color: <?php echo isset($property->expected_settlement_date) && $property->expected_settlement_date != '0000-00-00' ? '#aed375' : '#FF884B'; ?>"><?php echo isset($property->expected_settlement_date) && $property->expected_settlement_date != '0000-00-00' ? $property->expected_settlement_date : 'N/A'; ?></td>
                    <?php } ?>
                    <td style="text-align: center; display: <?php echo ((Yii::app()->user->user_type == 1 && Yii::app()->user->allow_portal_management == 0) ? 'none' : 'table-cell')?>;"><a style="text-decoration: none" title="Documents" href="documents/index/id/<?php echo $property->id ?>"><img src="images/document.png" alt="Documents"></a></td>
                    <td style="text-align: center; display: <?php echo ((Yii::app()->user->user_type == 1 && Yii::app()->user->allow_portal_management == 0) ? 'none' : 'table-cell')?>;"><a style="text-decoration: none" title="Receipts" href="receipts/index/id/<?php echo $property->id ?>"><img src="images/receipt.png" alt="Receipts"></a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </td>
</tr>
<?php } ?>