<style type="text/css">
    .column{
        width: 200px;
    }
    div.form label {
        display: inline-block;
    }
</style>
<div style="float: left">
    <?php
    if (Yii::app()->user->user_type == '0') {

        require_once Yii::getPathOfAlias('webroot.protected.views.admin') . '/admin_header_include.php';

    } else if (Yii::app()->user->user_type == '1') {

        require_once Yii::getPathOfAlias('webroot.protected.views.referral') . '/referral_header_include.php';
    }
    ?>
</div>
<div style="float: left; width: 670px; padding-left: 10px">
    <div class="box" style="border-radius: 5px; border: solid 1px silver">
        <h2 class="icon_search">Assign Categories for Client : <span style="margin-left: 20px"><b><?php echo ucfirst($model->first_name) . ' ' . ucfirst($model->last_name); ?></b></span></h2>
        <hr style="border-top: solid 2px navy"/>
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'admin-category-assign',
                'htmlOptions' => array('autocomplete' => 'off'),
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange'=>true,
                ),
            ));
            ?>
            <?php
            $selected_array = array();
            $selected_categories = EntryDocumentCategory::model()->findAll('entry = ' . $model->id);

            foreach ($selected_categories as $category) {

                $selected_array[] = $category->category;
            }

            $all_categories = CHtml::listData(DocumentCategory::model()->findAll(),'id','name');

            echo CHtml::checkBoxList('entry_category_list', $selected_array, $all_categories, array(
                'separator'=>'',
                'template'=>'<div>{input}&nbsp;{label}</div>'
            ));
            ?>
            <div style="margin-top: 20px"><input id="btnSave" name="btnSave" type="submit" value="Save Categories" class="button"/></div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
