1.7 — 2017-03-04
================
 * Add compatibility mode with old SyntaxeHL plugin  
   (SyntaxeHL supported langages are not all supported by YASH, see [documentation](user-guide/syntaxehl.md))
 * Add an option to hide gutter with line numbers, see [documentation](user-guide/settings.md#presentation)


1.6.3 - 2016-10-03
==================
 * Add some CSS/Sass units and flexbox set in CSS/Sass Js brushes


1.6.2 - 2016-04-06
==================
 * Add “Material” [theme](/user-guide/settings#presentation), remove toolbar from display.


1.6.1 - 2016-03-25
==================
 * 3 new [themes](/user-guide/settings#presentation) (“Solarized Dark”, “Solarized Light” et “Tomorrow Night”), remove some unecessary css files


1.6 - 2016-03-25
================

!!! warning
	Minimum Dotclear version: 2.9

 * Add Yaml syntax (see [available syntaxes](/user-guide/usage/#available-syntaxes))
 * Using ```dcPage::cssLoad```, ```dcPage::jsLoad``` and ```dcPage::getPF``` is a better way to load plugin resources
 * Using ```dcUtils::cssLoad```, ```dcUtils::jsLoad``` and ```$core->blog->getPF()``` is a better way to load plugin resources (public context)


1.5 - 2015-10-08
================
 * Update [SyntaxHighlighter](http://alexgorbatchev.com/SyntaxHighlighter/) script from 3.0.83 to 3.0.9


1.4 - 2015-08-11
================

!!! warning
	Minimum Dotclear version: 2.8

 * Split behaviors registration
 * Add syntax parameter for **adminPostEditor** behaviour


1.3 - 2015-01-13
================
 * Cope with the new behaviour **adminPostEditor**
 * Set lower priority than **dcLegacyEditor** in order to register macro function


1.2 - 2013-10-17
================

!!! warning
	Minimum Dotclear version: 2.6

 * Dotclear 2.6 compatibility
 * [SyntaxHighlighter](http://alexgorbatchev.com/SyntaxHighlighter/) script upgraded from version 1.6 to version 3.0.83
 * Move plugin to Blog menu
 * New icon and toolbar button design: ![](img/icon.png)
