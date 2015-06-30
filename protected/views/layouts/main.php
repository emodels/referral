<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <script type="text/javascript">
            $(document).ready(function(){
                $('body').children().ajaxStart(function(){
                    $('.ajax-loading').show();
                    return false;
                });

                $('body').children().ajaxStop(function(){
                    $('.ajax-loading').hide();
                    return false;
                });    
            });
        </script>
</head>
<body>
<div class="container" id="page" style="width: 99%">
<?php
    $flashMessages = Yii::app()->user->getFlashes();
    if ($flashMessages) {
        echo '<ul class="flashes" style="list-style-type:none; margin: 0px; padding: 0px">';
        foreach($flashMessages as $key => $message) {
            echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
        }
        echo '</ul>';
        Yii::app()->clientScript->registerScript(
        'myHideEffect',
        '$(".flashes").animate({opacity: 1.0}, 3000).fadeOut("slow");',
        CClientScript::POS_READY
        );            
    }
?>
	<div id="header">
        <?php if (isset($this->header_logo)) { ?>
            <img id="logo" src="data:image/jpeg;base64, <?php echo $this->header_logo ?>"/>
        <?php } else { ?>
            <img id="logo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.jpg"/>
        <?php } ?>
        <div id="logo_name"><?php echo isset($this->header_title) ? $this->header_title : 'Dwellings group - Customer collaboration portal'; ?></div>
        <div style="clear: both; height: 0px;"></div>
	</div><!-- header -->
        
	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>Yii::app()->request->baseUrl . '/site/logout', 'visible'=>!Yii::app()->user->isGuest),
                $this->menu
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
            Copyright &copy; <?php echo date('Y'); ?> by © <a href="http://www.snt3.com/" target="_blank" style="color: white">SNT3</a> – IT Division of Dwellings Group<br/>
	</div><!-- footer -->

</div><!-- page -->
<div class="ajax-loading"><div></div></div>    
</body>
</html>
