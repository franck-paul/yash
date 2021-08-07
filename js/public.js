/*global SyntaxHighlighter, dotclear */
'use strict';

dotclear.yash_config = dotclear.getData('yash_config');

function shGetPath() {
  const args = arguments;
  let result = [];
  for (let i = 0; i < args.length; i++) result.push(args[i].replace('@', dotclear.yash_config.path));
  return result;
}
SyntaxHighlighter.autoloader.apply(
  null,
  shGetPath(
    'applescript            @shBrushAppleScript.js',
    'actionscript3 as3      @shBrushAS3.js',
    'bash shell             @shBrushBash.js',
    'coldfusion cf          @shBrushColdFusion.js',
    'cpp c                  @shBrushCpp.js',
    'c# c-sharp csharp      @shBrushCSharp.js',
    'css                    @shBrushCss.js',
    'delphi pascal          @shBrushDelphi.js',
    'diff patch pas         @shBrushDiff.js',
    'erl erlang             @shBrushErlang.js',
    'groovy                 @shBrushGroovy.js',
    'java                   @shBrushJava.js',
    'jfx javafx             @shBrushJavaFX.js',
    'js jscript javascript  @shBrushJScript.js',
    'perl pl                @shBrushPerl.js',
    'php                    @shBrushPhp.js',
    'text plain             @shBrushPlain.js',
    'ps powershell          @shBrushPowerShell.js',
    'py python              @shBrushPython.js',
    'ruby rails ror rb      @shBrushRuby.js',
    'sass scss              @shBrushSass.js',
    'scala                  @shBrushScala.js',
    'sql                    @shBrushSql.js',
    'vb vbnet               @shBrushVb.js',
    'xml xhtml xslt html    @shBrushXml.js',
    'yaml yaml              @shBrushYaml.js'
  )
);
SyntaxHighlighter.defaults.toolbar = false;
SyntaxHighlighter.defaults.gutter = dotclear.yash_config.gutter;
SyntaxHighlighter.all();
