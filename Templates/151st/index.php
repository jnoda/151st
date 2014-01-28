<?php
/**
 * @package     151st.Site
 * @subpackage  Templates.151st
 *
 * @copyright   Copyright (C) 2014 151st Freedom Fighters. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Getting params from template
$params = JFactory::getApplication()->getTemplate(true)->params;

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->getCfg('sitename');

if($task == "edit" || $layout == "form" )
{
	$fullWidth = 1;
}
else
{
	$fullWidth = 0;
}

// Add JavaScript Frameworks
JHtml::_('behavior.framework', true);
$doc->addScript('http://code.jquery.com/jquery-1.10.2.min.js');
$doc->addScript('templates/' .$this->template. '/js/jui/bootstrap.min.js');
$doc->addScript('templates/' .$this->template. '/js/template.js');

// Add Stylesheets
$doc->addStyleSheet('templates/'.$this->template.'/css/bootstrap.min.css');
$doc->addStyleSheet('templates/'.$this->template.'/css/custom.css');

// Add current user information
$user = JFactory::getUser();

// Adjusting content width
if ($this->countModules('main-right') && $this->countModules('main-left'))
{
	$span = "col-md-6";
}
elseif ($this->countModules('main-right') && !$this->countModules('main-left'))
{
	$span = "col-md-9";
}
elseif (!$this->countModules('main-right') && $this->countModules('main-left'))
{
	$span = "col-md-9";
}
else
{
	$span = "col-md-12";
}

// Adjusting main-top content width
if ($this->countModules('main-top')){
	$topspan = "col-md-" . (int)(12 / $this->countModules('main-top'));
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="'. JUri::root() . $this->params->get('logoFile') .'" alt="'. $sitename .'" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="'. $sitename .'">'. htmlspecialchars($this->params->get('sitetitle')) .'</span>';
}
else
{
	$logo = '<span class="site-title" title="'. $sitename .'">'. $sitename .'</span>';
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
	<?php
	// Use of Google Font
	if ($this->params->get('googleFont'))
	{
	?>
		<link href='//fonts.googleapis.com/css?family=<?php echo $this->params->get('googleFontName');?>' rel='stylesheet' type='text/css' />
		<style type="text/css">
			h1,h2,h3,h4,h5,h6,.site-title,.navbar-default,#clockDiv{
				font-family: '<?php echo str_replace('+', ' ', $this->params->get('googleFontName'));?>', sans-serif;
			}
		</style>
	<?php
	}
	?>
</head>

<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '');
?>">

	<!-- Body -->
	<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : '');?>">
		<!-- Header -->
		<header class="header" role="banner">
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<a class="navbar-brand" href="<?php echo $this->baseurl; ?>">
						<?php echo $logo;?> <?php if ($this->params->get('sitedescription')) { echo '<div class="site-description">'. htmlspecialchars($this->params->get('sitedescription')) .'</div>'; } ?>
					</a>
				</div>
				<div class="header-right col-xs-12 col-sm-6">
					<jdoc:include type="modules" name="login" style="none" />
				</div>
			</div>
		</header>

		<?php if ($this->countModules('menu-header')) : ?>
		<nav class="navbar navbar-default" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="main-navbar-collapse">
				<jdoc:include type="modules" name="menu-header" style="none" />
			</div>
		</nav>
		<?php endif; ?>
		<jdoc:include type="modules" name="banner" style="xhtml" />
		<div class="row">
			<?php if ($this->countModules('main-left')) : ?>
			<!-- Begin Left Sidebar -->
			<div id="sidebar" class="col-md-3">
				<div class="sidebar-nav">
					<jdoc:include type="modules" name="main-left" style="xhtml" />
				</div>
			</div>
			<!-- End Sidebar -->
			<?php endif; ?>
			<main id="content" role="main" class="<?php echo $span;?>">
				<!-- Begin Content -->
				<jdoc:include type="modules" name="breadcrumb" style="none" />
				<jdoc:include type="message" />
				<div id="component">
					<?php if ($this->countModules('main-top')) : ?>
					<div class="row">
						<jdoc:include type="modules" name="main-top" style="box" span="<?php echo $topspan;?>" class="unestyled"/>
					</div>
					<?php endif; ?>
					<jdoc:include type="component" />
				</div>
				<!-- End Content -->
			</main>
			<?php if ($this->countModules('main-right')) : ?>
			<div id="aside" class="col-md-3">
				<!-- Begin Right Sidebar -->
				<jdoc:include type="modules" name="main-right" style="box" />
				<!-- End Right Sidebar -->
			</div>
			<?php endif; ?>
		</div>
	</div>
	<!-- Footer -->
	<footer class="footer" role="contentinfo">
		<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : '');?>">
			<hr />
			<jdoc:include type="modules" name="footer" style="none" />
			<p class="pull-right"><a href="#top" id="back-top"><?php echo JText::_('TPL_PROTOSTAR_BACKTOTOP'); ?></a></p>
			<p>&copy; <?php echo $sitename; ?> <?php echo date('Y');?></p>
		</div>
	</footer>
	<jdoc:include type="modules" name="debug" style="none" />
	<script type="text/javascript">
	  (function($){
		jQuery(document).ready(function(){
			/* changes for nav bar */
			$('.parent').addClass('dropdown');
			$('.parent > a').addClass('dropdown-toggle');
			$('.parent > a').attr('data-toggle', 'dropdown');
			$('.parent > a').attr('href','#');
			$('.parent > a').append(' <span class="caret"></span>');
			$('.parent > ul').addClass('dropdown-menu');
			/* changes for logo */
			$('.navbar-brand > img').addClass('img-responsive');
		});
	  })(jQuery);
	</script>
</body>
</html>
