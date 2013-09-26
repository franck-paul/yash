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

if (!defined('DC_RC_PATH')) { return; }

$core->addBehavior('publicHeadContent',		array('dcYASH','publicHeadContent'));
$core->addBehavior('publicFooterContent',	array('dcYASH','publicFooterContent'));

class dcYASH
{
	public static function publicHeadContent()
	{
		global $core;

		if ($core->blog->settings->yash->yash_active)
		{
			$custom_css = $core->blog->settings->yash->yash_custom_css;
			if (!empty($custom_css)) {
				if (strpos('/',$custom_css) === 0) {
					$css = $custom_css;
				}
				else {
					$css =
						$core->blog->settings->system->themes_url."/".
						$core->blog->settings->system->theme."/".
						$custom_css;
				}
			}
			else {
				$css = html::stripHostURL($core->blog->getQmarkURL().'pf=yash/yash-theme.css');
			}
			echo
				'<style type="text/css" media="screen">@import url('
				.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/yash.css').');</style>'."\n".
				'<style type="text/css" media="screen">@import url('.$css.');</style>'."\n";
		}
	}

	public static function publicFooterContent()
	{
		global $core;

		if ($core->blog->settings->yash->yash_active)
		{
			echo
				'<script type="text/javascript" src="'.
				html::stripHostURL($core->blog->getQmarkURL().'pf=yash/yash.js').
				'"></script>'."\n".
				'<script type="text/javascript">'."\n".
				"//<![CDATA[\n".
				"\$(function() {\n".
				"	dp.sh.ClipboardSwf = '".
				html::stripHostURL($core->blog->getQmarkURL().'pf=yash/yash.swf')."';\n".
				"	dp.sh.highlight();\n".
				"});\n".
				"\n//]]>\n".
				"</script>\n";
		}
	}
}
