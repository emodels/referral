<tr class="odd">
    <td><?php echo $data->first_name; ?></td>
    <td><?php echo $data->last_name; ?></td>
    <td><?php echo $data->country; ?></td>
    <td><?php echo Yii::app()->dateFormatter->format("yyyy-MM-dd", strtotime($data->entry_last_updated_date)); ?></td>
    <td><?php echo $data->status0->status; ?></td>
</tr>
<?php if (count($data->properties) > 0) { ?>
<tr>
    <td colspan="9" style="padding: 0px; border-bottom: solid 5px navy">
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
                    <th style="background: #cecece; color: #000000; text-align: left">Documents</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($data->properties as $property) { ?>
                <tr>
                    <td><?php echo $property->builder; ?></td>
                    <td><?php echo $property->address; ?></td>
                    <td style="<?php echo $property->status == 'Open' ? 'background-color: #FFF733; color: black' : 'background-color: #006600; color: white'; ?>"><?php echo $property->status; ?></td>
                    <td><?php echo $property->owner0->first_name; ?></td>
                    <?php if ($data->property_holder !== 'Tenant') { ?>
                    <td style="background-color: <?php echo $property->initial_deposit == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->initial_deposit == 1 ? 'Yes' : 'No'; ?></td>
                    <td style="background-color: <?php echo $property->contracts_signed == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->contracts_signed == 1 ? 'Yes' : 'No'; ?></td>
                    <td style="background-color: <?php echo $property->five_ten_deposit == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->five_ten_deposit == 1 ? 'Yes' : 'No'; ?></td>
                    <td style="background-color: <?php echo $property->firb_approval == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->firb_approval == 1 ? 'Yes' : 'No'; ?></td>
                    <td style="background-color: <?php echo $property->finance_approval == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->finance_approval == 1 ? 'Yes' : 'No'; ?></td>
                    <td style="background-color: <?php echo $property->property_completion == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->property_completion == 1 ? 'Yes' : 'No'; ?></td>
                    <td style="background-color: <?php echo $property->rented_out == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->rented_out == 1 ? 'Yes' : 'No'; ?></td>
                    <td style="background-color: <?php echo $property->insurance_in_place == 1 ? '#aed375' : '#FF884B'; ?>"><?php echo $property->insurance_in_place == 1 ? 'Yes' : 'No'; ?></td>
                    <td style="text-align: center; background-color: <?php echo isset($property->expected_settlement_date) && $property->expected_settlement_date != '0000-00-00' ? '#aed375' : '#FF884B'; ?>"><?php echo isset($property->expected_settlement_date) && $property->expected_settlement_date != '0000-00-00' ? $property->expected_settlement_date : 'N/A'; ?></td>
                    <?php } ?>
                    <td style="text-align: center"><a style="text-decoration: none" title="Documents" href="../documents/index/id/<?php echo $property->id ?>"><img src="../images/document.png" alt="Documents"></a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </td>
</tr>
<?php } ?>