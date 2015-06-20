<style type="text/css">
    .column{
        width: 200px;
    }
</style>
<script type="text/javascript">
    function openDialog(url) {
        alert(url);
        $('#iframe_dialog').src = url;
        $("#mydialog").dialog("open");
        return false;
    }
</script>
<div style="float: left">
    <h3>Documents for Property : <?php echo $property->address; ?></h3>
</div>
<div style="float: right">
    <h3>Owner : <?php echo ucfirst($property->entry0->first_name) . ' ' . ucfirst($property->entry0->last_name); ?></h3>
</div>
<div class="clearfix"></div>
<?php if (Yii::app()->user->user_type !== '2') { ?>
<div id="divForm">
    <div class="box" style="border-radius: 5px; border: solid 1px silver">
        <h2 class="icon_search">Add Document</h2>
        <hr style="border-top: solid 2px navy"/>
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'admin-document-add',
                'htmlOptions' => array('autocomplete' => 'off'),
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange'=>true,
                ),
            ));
            ?>
            <div>
                <div class="row" style="margin-top: 25px">
                    <div class="column">Caption</div>
                    <div class="column"><?php echo $form->textField($model, 'caption', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'caption'); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">Category</div>
                    <div class="column"><?php echo $form->dropDownList($model, 'category', CHtml::listData(EntryDocumentCategory::model()->findAllbySql('SELECT dc.id as id, dc.name as category FROM `entry_document_category` AS edc, `document_category` AS dc WHERE edc.category = dc.id AND edc.entry = ' . $property->entry),'id', 'category'), array('style' => 'width:200px', 'empty'=>'Select Category')); ?><?php echo $form->error($model, 'category'); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">Document - Dropbox link URL</div>
                    <div class="column"><?php echo $form->textField($model, 'document', array('style' => 'width:200px')); ?><?php echo $form->error($model, 'document'); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="column">&nbsp;</div>
                    <div><?php echo CHtml::submitButton('Add Document', array('class' => 'button')); ?></div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<?php } ?>
<?php
$tabsList = EntryDocumentCategory::model()->findAll('entry = ' . $property->entry);

foreach ($tabsList as $tab) {

    $dataProvider = new CActiveDataProvider('PropertyDocument', array('criteria'=>array('condition'=> 'property = ' . $property->id . ' AND category = ' . $tab->category, 'order'=>'id DESC'), 'pagination' => false));

    $tabsArray["<span id='tab-" . $tab->id . "'>" . $tab->category0->name . "</span>"] = $this->renderPartial('_tab_view', array('dataProvider' => $dataProvider), TRUE);
}

$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>$tabsArray,
    'options' => array(
        'collapsible' => true,
    ),
    'id'=>'MyTab-Menu1'
));

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'mydialog',
    'options'=>array(
        'title'=>'Document Viewer',
        'autoOpen'=>false,
    ),
));
?>
<iframe id="iframe_dialog" src="" border="1" width="100%"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
