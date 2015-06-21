<?php

if (Yii::app()->user->user_type == '2') {

    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'columns'=>array(
            array(
                'name' => 'Caption',
                'value' => '$data->caption',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
            ),
            array(
                'name' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Download / View document", CHtml::encode($data->document), array("target"=>"_blank"))',
                'htmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'name' => 'Uploaded Date',
                'value' => '$data->entry_date',
                'htmlOptions'=>array('style'=>'text-align:center;'),
            ),
        )
    ));

} else {

    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'columns'=>array(
            array(
                'name' => 'Caption',
                'value' => '$data->caption',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
            ),
            array(
                'name' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Download / View document", CHtml::encode($data->document), array("target"=>"_blank"))',
                'htmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'name' => 'Uploaded Date',
                'value' => '$data->entry_date',
                'htmlOptions'=>array('style'=>'text-align:center;'),
            ),
            $button = array('class'=>'CButtonColumn', 'template'=>'{delete}')
        )
    ));
}
?>