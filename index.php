<?php
# ***** BEGIN LICENSE BLOCK *****
# This file is part of YASH, a plugin for DotClear2.
# Copyright (c) 2008 Pep and contributors. All rights
# reserved.
#
# This plugin is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This plugin is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this plugin; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
# ***** END LICENSE BLOCK *****

if (!defined('DC_CONTEXT_ADMIN')) { exit; }

// Setting default parameters if missing configuration
$core->blog->settings->addNamespace('wordcount');
if (is_null($core->blog->settings->yash->yash_active)) {
	try {
		// Default state is active if the comments are configured to allow wiki syntax
		$core->blog->settings->yash->put('yash_active',false,'boolean',true);
		$core->blog->settings->yash->put('yash_custom_css','','string',true);
		$core->blog->triggerBlog();
		http::redirect(http::getSelfURI());
	}
	catch (Exception $e) {
		$core->error->add($e->getMessage());
	}
}

// Getting current parameters
$active = (boolean)$core->blog->settings->yash->yash_active;
$custom_css = (string)$core->blog->settings->yash->yash_custom_css;

if (!empty($_REQUEST['popup'])) {
	$yash_brushes = array(
		'plain' 	=> __('Plain Text'),
		'xml' 	=> __('XML/XSLT/XHTML/HTML'),
		'css' 	=> __('CSS'),
		'js' 	=> __('Javascript'),
		'php' 	=> __('PHP'),
		'sql' 	=> __('SQL'),
		'python'	=> __('Python'),
		'ruby'	=> __('Ruby'),
		'java'	=> __('Java'),
		'cpp'	=> __('C++'),
		'csharp'	=> __('C#'),
		'delphi'	=> __('Delphi'),
		'vb'		=> __('Visual Basic')
	);

	echo
		'<html>'.
		'<head>'.
	  	'<title>'.__('YASH - Syntax Selector').'</title>'.
	  	'<script type="text/javascript" src="index.php?pf=yash/popup.js"></script>'.
		'</head>'.
		'<body>'.
		'<h2>'.__('YASH - Syntax Selector').'</h2>'.
		'<form id="yash-form" action="'.$p_url.'&amp;popup=1" method="get">'.
		'<p><label>'.__('Select the primary syntax of your code snippet.').
		form::combo('syntax',array_flip($yash_brushes)).'</label></p>'.
		'<p><a id="yash-cancel" class="button" href="#">'.__('Cancel').'</a> - '.
		'<strong><a id="yash-ok" class="button" href="#">'.__('Ok').'</a></strong></p>'.
		'</form>'.
		'</body>'.
		'</html>';
	return;
}

// Saving new configuration
if (!empty($_POST['saveconfig'])) {
	try
	{
		$core->blog->settings->addNameSpace('yash');
		$active = (empty($_POST['active']))?false:true;
		$custom_css = (empty($_POST['custom_css']))?'':html::sanitizeURL($_POST['custom_css']);
		$core->blog->settings->yash->put('yash_active',$active,'boolean');
		$core->blog->settings->yash->put('yash_custom_css',$custom_css,'string');
		$core->blog->triggerBlog();
		$msg = __('Configuration successfully updated.');
	}
	catch (Exception $e)
	{
		$core->error->add($e->getMessage());
	}
}
?>
<html>
<head>
	<title><?php echo __('YASH'); ?></title>
</head>

<body>
<?php
	echo dcPage::breadcrumb(
		array(
			html::escapeHTML($core->blog->name) => '',
			'<span class="page-title">'.__('YASH').'</span>' => ''
		));
?>

<?php if (!empty($msg)) dcPage::success($msg); ?>

<div id="yash_options">
	<form method="post" action="<?php http::getSelfURI(); ?>">
	<p class="field">
		<?php echo form::checkbox('active', 1, $active); ?>
		<label class="classic" for="active">&nbsp;<?php echo __('Enable YASH');?></label>
	</p>

	<h3><?php echo __('Options'); ?></h3>
	<p class="field">
		<label class="classic"><?php echo __('Use custom CSS') ; ?> : </label>
		<?php echo form::field('custom_css',40,128,$custom_css); ?>
	</p>
	<p class="info"><?php echo __('You can use a custom CSS by providing its location.'); ?><br />
	<?php echo __('A location beginning with a / is treated as absolute, else it is treated as relative to the blog\'s current theme URL'); ?>
	</p>

	<p><input type="hidden" name="p" value="yash" />
	<?php echo $core->formNonce(); ?>
	<input type="submit" name="saveconfig" value="<?php echo __('Save configuration'); ?>" />
	</p>
	</form>
</div>

</body>
</html>