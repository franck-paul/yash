
var dp={sh:{Version:'1.6',Strings:{aboutDialog:'<html><head><title>About...</title></head><body class="dp-about"><table cellspacing="0"><tr><td class="copy"><p class="title">dp.SyntaxHighlighter</div><div class="para">Version: {V}</p><p><a href="http://code.google.com/p/syntaxhighlighter/" target="_blank">http://code.google.com/p/syntaxhighlighter</a></p>&copy;2004-2008 Alex Gorbatchev.</td></tr><tr><td class="footer"><input type="button" class="close" value="OK" onClick="window.close()"/></td></tr></table></body></html>'},ClipboardSwf:null,Toolbar:{create:function(highlighter)
{var div=document.createElement('DIV');div.className='toolbar';for(var name in dp.sh.Toolbar.Commands)
{var cmd=dp.sh.Toolbar.Commands[name];if(cmd.check!=null&&!cmd.check(highlighter))
continue;div.innerHTML+='<a href="#" onclick="dp.sh.Toolbar.command(\''+name+'\',this);return false;">'+cmd.label+'</a>';}
return div;},command:function(name,sender)
{var n=sender;while(n!=null&&n.className.indexOf('dp-highlighter')==-1)
n=n.parentNode;if(n!=null)
dp.sh.Toolbar.Commands[name].func(sender,n.highlighter);},Commands:{expandSource:{label:'+ expand source',check:function(highlighter)
{return highlighter.getParam('collapse',false);},func:function(sender,highlighter)
{sender.parentNode.removeChild(sender);highlighter.div.className=highlighter.div.className.replace('collapsed','');}},viewSource:{label:'voir source',func:function(sender,highlighter)
{var code=dp.sh.Utils.fixForBlogger(highlighter.originalCode).replace(/</g,'&lt;');var wnd=window.open('','_blank','width=750, height=400, location=0, resizable=1, menubar=0, scrollbars=0');wnd.document.write('<textarea style="width:99%;height:99%">'+code+'</textarea>');wnd.document.close();}},copyToClipboard:{label:'copier vers le presse-papier',check:function()
{return window.clipboardData!=null||dp.sh.ClipboardSwf!=null;},func:function(sender,highlighter)
{var code=dp.sh.Utils.fixForBlogger(highlighter.originalCode).replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&');if(window.clipboardData)
{window.clipboardData.setData('text',code);}
else if(dp.sh.ClipboardSwf!=null)
{if(!highlighter.flashCopier)
{var flashcopier=document.createElement('div');highlighter.flashCopier=flashcopier;highlighter.div.appendChild(flashcopier);}
else
{var flashcopier=highlighter.flashCopier;}
flashcopier.innerHTML='<embed src="'+dp.sh.ClipboardSwf+'" FlashVars="clipboard='+encodeURIComponent(code)+'" width="0" height="0" type="application/x-shockwave-flash"></embed>';}
alert('Le code a été copié dans votre presse-papier');}},printSource:{label:'imprimer',func:function(sender,highlighter)
{var iframe=document.createElement('IFRAME');var doc=null;iframe.style.cssText='position:absolute;width:0px;height:0px;left:-500px;top:-500px;';document.body.appendChild(iframe);doc=iframe.contentWindow.document;dp.sh.Utils.copyStyles(doc,window.document);doc.write('<div class="'+highlighter.div.className.replace('collapsed','')+' printing">'+highlighter.div.innerHTML+'</div>');doc.close();iframe.contentWindow.focus();iframe.contentWindow.print();alert('Impression en cours...');document.body.removeChild(iframe);}},about:{label:'?',func:function(highlighter)
{var wnd=window.open('','_blank','dialog,width=300,height=150,scrollbars=0');var doc=wnd.document;dp.sh.Utils.copyStyles(doc,window.document);doc.write(dp.sh.Strings.aboutDialog.replace('{V}',dp.sh.Version));doc.close();wnd.focus();}}}},Utils:{trimFirstAndLastLines:function(str)
{return str.replace(/^[ ]*[\n]+|[\n]*[ ]*$/g,'');},inArray:function(array,value)
{for(var i in array)
if(array[i]===value)
return true;return false;},parseParams:function(str)
{var match,result={},arrayRegex=/^\[(.*?)\]$/,regex=/([\w-]+)\s*:\s*(([\w-]+)|(\[.*?\]))/g;while((match=regex.exec(str))!=null)
{var value=match[2];if(value!=null&&arrayRegex.test(value))
{var m=arrayRegex.exec(value);value=(m!=null)?m[1].split(/\s*,\s*/):null;}
result[match[1]]=value;}
return result;},addTplLink:function(code)
{return code.replace(/(tpl:([^<}& ]*))/g,
'<a class="tpl-link" href="http://fr.dotclear.org/documentation/2.0/resources/themes/tags/$2">$1</a>');},
processUrls:function(code)
{return code.replace(dp.sh.RegexLib.url,function(m)
{return'<a href="'+m+'">'+m+'</a>';})},
decorateBit:function(str,css)
{if(str==null||str.length==0||str=='\n')
return str;str=str.replace(/</g,'&lt;');str=str.replace(/ {2,}/g,function(m)
{var spaces='';for(var i=0;i<m.length-1;i++)
spaces+='&nbsp;';return spaces+' ';});if(css!=null)
str=str.replace(/^.*$/gm,function(line)
{if(line.length==0)
return'';var spaces='';line=line.replace(/^(&nbsp;| )+/,function(s)
{spaces=s;return'';});if(line.length==0)
return spaces;return spaces+'<span class="reset font '+css+'">'+line+'</span>';});return str;},padNumber:function(number,length)
{var result=number.toString();while(result.length<length)
result='0'+result;return result;},measureSpace:function()
{var span=document.createElement("span");span.innerHTML="&nbsp;";span.className="dp-highlighter reset font";document.body.appendChild(span);var result=0;if(/opera/i.test(navigator.userAgent))
{var style=window.getComputedStyle(span,null);result=parseInt(style.getPropertyValue("width"));}
else
{result=span.offsetWidth;}
document.body.removeChild(span);return result;},processSmartTabs:function(code,tabSize)
{var lines=code.split('\n'),tab='\t',spaces='';for(var i=0;i<50;i++)
spaces+='                    ';function insertSpaces(line,pos,count)
{return line.substr(0,pos)
+spaces.substr(0,count)
+line.substr(pos+1,line.length);};function processLine(line,tabSize)
{if(line.indexOf(tab)==-1)
return line;var pos=0;while((pos=line.indexOf(tab))!=-1)
{var spaces=tabSize-pos%tabSize;line=insertSpaces(line,pos,spaces);}
return line;};return code.replace(/^.*$/gm,function(m)
{return processLine(m,tabSize);});},copyStyles:function(destDoc,sourceDoc)
{var links=sourceDoc.getElementsByTagName('link');for(var i=0;i<links.length;i++)
if(links[i].rel.toLowerCase()=='stylesheet')
destDoc.write('<link type="text/css" rel="stylesheet" href="'+links[i].href+'"></link>');},fixForBlogger:function(str)
{return(dp.sh.isBloggerMode==true)?str.replace(/<br\s*\/?>|&lt;br\s*\/?&gt;/gi,'\n'):str;},trim:function(str)
{return str.replace(/\s*$/g,'').replace(/^\s*/,'');},unindent:function(str)
{var lines=dp.sh.Utils.fixForBlogger(str).split('\n'),indents=new Array(),regex=/^\s*/,min=1000;for(var i=0;i<lines.length&&min>0;i++)
{var line=lines[i];if(dp.sh.Utils.trim(line).length==0)
continue;var matches=regex.exec(line);if(matches==null)
return str;min=Math.min(matches[0].length,min);}
if(min>0)
for(var i=0;i<lines.length;i++)
lines[i]=lines[i].substr(min);return lines.join('\n');},matchesSortCallback:function(m1,m2)
{if(m1.index<m2.index)
return-1;else if(m1.index>m2.index)
return 1;else
{if(m1.length<m2.length)
return-1;else if(m1.length>m2.length)
return 1;}
return 0;},getMatches:function(code,regexInfo)
{function defaultAdd(match,regexInfo)
{return[new dp.sh.Match(match[0],match.index,regexInfo.css)];};var index=0,match=null,result=[],func=regexInfo.func?regexInfo.func:defaultAdd;;while((match=regexInfo.regex.exec(code))!=null)
result=result.concat(func(match,regexInfo));return result;}},RegexLib:{multiLineCComments:/\/\*[\s\S]*?\*\//gm,singleLineCComments:/\/\/.*$/gm,singleLinePerlComments:/#.*$/gm,doubleQuotedString:/"(?:\.|(\\\")|[^\""\n])*"/g,singleQuotedString:/'(?:\.|(\\\')|[^\''\n])*'/g,url:/\w+:\/\/[\w-.\/?%&=]*/g},Brushes:{},BloggerMode:function()
{dp.sh.isBloggerMode=true;}}};dp.SyntaxHighlighter=dp.sh;dp.sh.Match=function(value,index,css)
{this.value=value;this.index=index;this.length=value.length;this.css=css;};dp.sh.Match.prototype={toString:function()
{return this.value;}};dp.sh.Highlighter=function()
{this.params={};this.div=null;this.lines=null;this.code=null;this.bar=null;this.spaceWidth=dp.sh.Utils.measureSpace();};dp.sh.Highlighter.prototype={getParam:function(name,defaultValue)
{var result=this.params[name];switch(result)
{case"false":result=false;break;case"true":result=true;break;}
return result!=null?result:defaultValue;},createElement:function(name)
{var result=document.createElement(name);result.highlighter=this;return result;},isMatchNested:function(match)
{for(var i=0;i<this.matches.length;i++)
{var item=this.matches[i];if(item===null)
continue;if((match.index>item.index)&&(match.index<item.index+item.length))
return true;}
return false;},findMatches:function()
{var result=[];if(this.regexList!=null)
for(var i=0;i<this.regexList.length;i++)
result=result.concat(dp.sh.Utils.getMatches(this.code,this.regexList[i]));result=result.sort(dp.sh.Utils.matchesSortCallback);this.matches=result;},setupRuler:function()
{var div=this.createElement('div');var ruler=this.createElement('div');var showEvery=10;var i=1;while(i<=150)
{if(i%showEvery===0)
{div.innerHTML+=i;i+=(i+'').length;}
else
{div.innerHTML+='&middot;';i++;}}
ruler.className='ruler font line';ruler.appendChild(div);this.bar.appendChild(ruler);},removeNestedMatches:function()
{for(var i=0;i<this.matches.length;i++)
if(this.isMatchNested(this.matches[i]))
this.matches[i]=null;},splitIntoDivs:function(code)
{var lines=code.split(/\n/g),firstLine=parseInt(this.getParam("first-line",1)),padLength=(firstLine+lines.length).toString().length,highlightedLines=this.getParam("highlight-lines",[]);if(highlightedLines!=null&&highlightedLines.join==null)
highlightedLines==[highlightedLines];code='';for(var i=0;i<lines.length;i++)
{var line=lines[i],indent=/^(&nbsp;)+ /.exec(line),lineClass='font line alt'+(i%2==0?1:2),lineNumber=dp.sh.Utils.padNumber(firstLine+i,padLength),highlighted=dp.sh.Utils.inArray(highlightedLines,(firstLine+i).toString());if(indent!=null)
{line=line.substr(indent[0].length);indent=this.spaceWidth*(indent[0].length+5)/6;}
else
{indent=0;}
line=dp.sh.Utils.trim(line);if(line.length==0)
line='&nbsp;';if(highlighted)
lineClass+=' highlighted';code+='<div class="'+lineClass+'">'
+'<div class="number">'+lineNumber+'.</div>'
+'<div class="content">'
+'<div style="padding-left:'+indent+'px;">'+line+'</div>'
+'</div>'
+'</div>';}
return code;},processMatches:function()
{function copy(string,pos1,pos2)
{return string.substr(pos1,pos2-pos1);}
var pos=0,code='',decorateBit=dp.sh.Utils.decorateBit;for(var i=0;i<this.matches.length;i++)
{var match=this.matches[i];if(match===null||match.length===0)
continue;code+=decorateBit(copy(this.code,pos,match.index),'plain');code+=decorateBit(match.value,match.css);pos=match.index+match.length;}
code+=decorateBit(this.code.substr(pos),'plain');code=this.splitIntoDivs(dp.sh.Utils.trim(code));if(this.getParam('auto-links',true))
code=dp.sh.Utils.processUrls(code);code=dp.sh.Utils.addTplLink(code);this.lines.innerHTML=code;},highlight:function(code,params)
{if(code===null)
code='';if(params!=null)
this.params=params;this.div=this.createElement('DIV');this.bar=this.createElement('DIV');this.lines=this.createElement('DIV');this.lines.className='lines';this.div.className='dp-highlighter';this.bar.className='bar';if(this.getParam('collapse',false))
this.div.className+=' collapsed';if(this.getParam('gutter',true)==false)
this.div.className+=' nogutter';this.originalCode=code;this.code=dp.sh.Utils.trimFirstAndLastLines(code).replace(/\r/g,' ');if(this.getParam('smart-tabs',true))
{this.code=dp.sh.Utils.processSmartTabs(this.code,this.getParam('smart-tabs-size',4));this.code=dp.sh.Utils.unindent(this.code);}
if(this.getParam('controls',true))
this.bar.appendChild(dp.sh.Toolbar.create(this));if(this.getParam('ruler',false))
this.setupRuler();this.div.appendChild(this.bar);this.div.appendChild(this.lines);this.findMatches();this.removeNestedMatches();this.processMatches();},getKeywords:function(str)
{return'\\b'+str.replace(/ /g,'\\b|\\b')+'\\b';}};dp.sh.highlight=function(element)
{var elements=element?[element]:document.getElementsByTagName('pre'),propertyName='innerHTML',highlighter=null,brushes={};if(elements.length===0)
return;for(var brush in dp.sh.Brushes)
{var aliases=dp.sh.Brushes[brush].aliases;if(aliases===null)
continue;for(var i=0;i<aliases.length;i++)
brushes[aliases[i]]=brush;}
for(var i=0;i<elements.length;i++)
{var element=elements[i],params=dp.sh.Utils.parseParams(element.className),brush=brushes[params['brush']];if(brush==null)
continue;highlighter=new dp.sh.Brushes[brush]();element.style.display='none';highlighter.highlight(element[propertyName],params);highlighter.source=element;element.parentNode.insertBefore(highlighter.div,element);highlighter=null;}}
dp.sh.Brushes.Xml=function()
{function addAttribute(match,regexInfo)
{var result=[];if(match[1]==null)
return[];result.push(new dp.sh.Match(match[1],match.index,regexInfo.attrCss));if(match[2]!=undefined)
result.push(new dp.sh.Match(match[2],match.index+match[0].indexOf(match[2]),regexInfo.valueCss));return result;};function addTagName(match,regexInfo)
{return[new dp.sh.Match(match[1],match.index+match[0].indexOf(match[1]),regexInfo.css)];};this.regexList=[{regex:/(\&lt;|<)\!\[[\w\s]*?\[(.|\s)*?\]\](\&gt;|>)/gm,css:'color1'},{regex:/(\&lt;|<)!--\s*.*?\s*--(\&gt;|>)/gm,css:'comments'},{regex:/([:\w\-\.]+)\s*=\s*(".*?"|'.*?'|\w+)*|(\w+)/gm,attrCss:'variable',valueCss:'string',func:addAttribute},{regex:/(?:\&lt;|<)\/*\?*\s*([:\w-\.]+)/gm,css:'keyword',func:addTagName}];};dp.sh.Brushes.Xml.aliases=['xml','xhtml','xslt','html','xhtml'];dp.sh.Brushes.Xml.prototype=new dp.sh.Highlighter();dp.sh.Brushes.CSS=function()
{function getKeywordsCSS(str)
{return'\\b([a-z_]|)'+str.replace(/ /g,'(?=:)\\b|\\b([a-z_\\*]|\\*|)')+'(?=:)\\b';};function getValuesCSS(str)
{return'\\b'+str.replace(/ /g,'(?!-)(?!:)\\b|\\b()')+'\:\\b';};var keywords='ascent azimuth background-attachment background-color background-image background-position '+'background-repeat background baseline bbox border-collapse border-color border-spacing border-style border-top '+'border-right border-bottom border-left border-top-color border-right-color border-bottom-color border-left-color '+'border-top-style border-right-style border-bottom-style border-left-style border-top-width border-right-width '+'border-bottom-width border-left-width border-width border cap-height caption-side centerline clear clip color '+'content counter-increment counter-reset cue-after cue-before cue cursor definition-src descent direction display '+'elevation empty-cells float font-size-adjust font-family font-size font-stretch font-style font-variant font-weight font '+'height letter-spacing line-height list-style-image list-style-position list-style-type list-style margin-top '+'margin-right margin-bottom margin-left margin marker-offset marks mathline max-height max-width min-height min-width orphans '+'outline-color outline-style outline-width outline overflow padding-top padding-right padding-bottom padding-left padding page '+'page-break-after page-break-before page-break-inside pause pause-after pause-before pitch pitch-range play-during position '+'quotes richness size slope src speak-header speak-numeral speak-punctuation speak speech-rate stemh stemv stress '+'table-layout text-align text-decoration text-indent text-shadow text-transform unicode-bidi unicode-range units-per-em '+'vertical-align visibility voice-family volume white-space widows width widths word-spacing x-height z-index';var values='above absolute all always aqua armenian attr aural auto avoid baseline behind below bidi-override black blink block blue bold bolder '+'both bottom braille capitalize caption center center-left center-right circle close-quote code collapse compact condensed '+'continuous counter counters crop cross crosshair cursive dashed decimal decimal-leading-zero default digits disc dotted double '+'embed embossed e-resize expanded extra-condensed extra-expanded fantasy far-left far-right fast faster fixed format fuchsia '+'gray green groove handheld hebrew help hidden hide high higher icon inline-table inline inset inside invert italic '+'justify landscape large larger left-side left leftwards level lighter lime line-through list-item local loud lower-alpha '+'lowercase lower-greek lower-latin lower-roman lower low ltr marker maroon medium message-box middle mix move narrower '+'navy ne-resize no-close-quote none no-open-quote no-repeat normal nowrap n-resize nw-resize oblique olive once open-quote outset '+'outside overline pointer portrait pre print projection purple red relative repeat repeat-x repeat-y rgb ridge right right-side '+'rightwards rtl run-in screen scroll semi-condensed semi-expanded separate se-resize show silent silver slower slow '+'small small-caps small-caption smaller soft solid speech spell-out square s-resize static status-bar sub super sw-resize '+'table-caption table-cell table-column table-column-group table-footer-group table-header-group table-row table-row-group teal '+'text-bottom text-top thick thin top transparent tty tv ultra-condensed ultra-expanded underline upper-alpha uppercase upper-latin '+'upper-roman url visible wait white wider w-resize x-fast x-high x-large x-loud x-low x-slow x-small x-soft xx-large xx-small yellow';this.regexList=[{regex:dp.sh.RegexLib.multiLineCComments,css:'comments'},{regex:dp.sh.RegexLib.doubleQuotedString,css:'string'},{regex:dp.sh.RegexLib.singleQuotedString,css:'string'},{regex:/\#[a-zA-Z0-9]{3,6}/g,css:'value'},{regex:/(-?\d+)(\.\d+)?(px|em|pt|\:|\%|)/g,css:'value'},{regex:/!important/g,css:'color3'},{regex:new RegExp(getKeywordsCSS(keywords),'gm'),css:'keyword'},{regex:new RegExp(getValuesCSS(values),'g'),css:'value'}];};dp.sh.Brushes.CSS.prototype=new dp.sh.Highlighter();dp.sh.Brushes.CSS.aliases=['css'];dp.sh.Brushes.JScript=function()
{var keywords='abstract boolean break byte case catch char class const continue debugger '+'default delete do double else enum export extends false final finally float '+'for function goto if implements import in instanceof int interface long native '+'new null package private protected public return short static super switch '+'synchronized this throw throws transient true try typeof var void volatile while with';this.regexList=[{regex:dp.sh.RegexLib.singleLineCComments,css:'comments'},{regex:dp.sh.RegexLib.multiLineCComments,css:'comments'},{regex:dp.sh.RegexLib.doubleQuotedString,css:'string'},{regex:dp.sh.RegexLib.singleQuotedString,css:'string'},{regex:/\s*#.*/gm,css:'preprocessor'},{regex:new RegExp(this.getKeywords(keywords),'gm'),css:'keyword'}];};dp.sh.Brushes.JScript.prototype=new dp.sh.Highlighter();dp.sh.Brushes.JScript.aliases=['js','jscript','javascript'];dp.sh.Brushes.Php=function()
{var funcs='abs acos acosh addcslashes addslashes '+'array_change_key_case array_chunk array_combine array_count_values array_diff '+'array_diff_assoc array_diff_key array_diff_uassoc array_diff_ukey array_fill '+'array_filter array_flip array_intersect array_intersect_assoc array_intersect_key '+'array_intersect_uassoc array_intersect_ukey array_key_exists array_keys array_map '+'array_merge array_merge_recursive array_multisort array_pad array_pop array_product '+'array_push array_rand array_reduce array_reverse array_search array_shift '+'array_slice array_splice array_sum array_udiff array_udiff_assoc '+'array_udiff_uassoc array_uintersect array_uintersect_assoc '+'array_uintersect_uassoc array_unique array_unshift array_values array_walk '+'array_walk_recursive atan atan2 atanh base64_decode base64_encode base_convert '+'basename bcadd bccomp bcdiv bcmod bcmul bindec bindtextdomain bzclose bzcompress '+'bzdecompress bzerrno bzerror bzerrstr bzflush bzopen bzread bzwrite ceil chdir '+'checkdate checkdnsrr chgrp chmod chop chown chr chroot chunk_split class_exists '+'closedir closelog copy cos cosh count count_chars date decbin dechex decoct '+'deg2rad delete ebcdic2ascii echo empty end ereg ereg_replace eregi eregi_replace error_log '+'error_reporting escapeshellarg escapeshellcmd eval exec exit exp explode extension_loaded '+'feof fflush fgetc fgetcsv fgets fgetss file_exists file_get_contents file_put_contents '+'fileatime filectime filegroup fileinode filemtime fileowner fileperms filesize filetype '+'floatval flock floor flush fmod fnmatch fopen fpassthru fprintf fputcsv fputs fread fscanf '+'fseek fsockopen fstat ftell ftok getallheaders getcwd getdate getenv gethostbyaddr gethostbyname '+'gethostbynamel getimagesize getlastmod getmxrr getmygid getmyinode getmypid getmyuid getopt '+'getprotobyname getprotobynumber getrandmax getrusage getservbyname getservbyport gettext '+'gettimeofday gettype glob gmdate gmmktime ini_alter ini_get ini_get_all ini_restore ini_set '+'interface_exists intval ip2long is_a is_array is_bool is_callable is_dir is_double '+'is_executable is_file is_finite is_float is_infinite is_int is_integer is_link is_long '+'is_nan is_null is_numeric is_object is_readable is_real is_resource is_scalar is_soap_fault '+'is_string is_subclass_of is_uploaded_file is_writable is_writeable mkdir mktime nl2br '+'parse_ini_file parse_str parse_url passthru pathinfo readlink realpath rewind rewinddir rmdir '+'round str_ireplace str_pad str_repeat str_replace str_rot13 str_shuffle str_split '+'str_word_count strcasecmp strchr strcmp strcoll strcspn strftime strip_tags stripcslashes '+'stripos stripslashes stristr strlen strnatcasecmp strnatcmp strncasecmp strncmp strpbrk '+'strpos strptime strrchr strrev strripos strrpos strspn strstr strtok strtolower strtotime '+'strtoupper strtr strval substr substr_compare';var keywords='and or xor __FILE__ __LINE__ array as break case '+'cfunction class const continue declare default die do else '+'elseif empty enddeclare endfor endforeach endif endswitch endwhile '+'extends for foreach function include include_once global if '+'new old_function return static switch use require require_once '+'var while __FUNCTION__ __CLASS__ '+'__METHOD__ abstract interface public implements extends private protected throw';this.regexList=[{regex:dp.sh.RegexLib.singleLineCComments,css:'comments'},{regex:dp.sh.RegexLib.multiLineCComments,css:'comments'},{regex:dp.sh.RegexLib.doubleQuotedString,css:'string'},{regex:dp.sh.RegexLib.singleQuotedString,css:'string'},{regex:/\$\w+/g,css:'variable'},{regex:new RegExp(this.getKeywords(funcs),'gmi'),css:'functions'},{regex:new RegExp(this.getKeywords(keywords),'gm'),css:'keyword'}];};dp.sh.Brushes.Php.prototype=new dp.sh.Highlighter();dp.sh.Brushes.Php.aliases=['php'];dp.sh.Brushes.Sql=function()
{var funcs='abs avg case cast coalesce convert count current_timestamp '+'current_user day isnull left lower month nullif replace right '+'session_user space substring sum system_user upper user year';var keywords='absolute action add after alter as asc at authorization begin bigint '+'binary bit by cascade char character check checkpoint close collate '+'column commit committed connect connection constraint contains continue '+'create cube current current_date current_time cursor database date '+'deallocate dec decimal declare default delete desc distinct double drop '+'dynamic else end end-exec escape except exec execute false fetch first '+'float for force foreign forward free from full function global goto grant '+'group grouping having hour ignore index inner insensitive insert instead '+'int integer intersect into is isolation key last level load local max min '+'minute modify move name national nchar next no numeric of off on only '+'open option order out output partial password precision prepare primary '+'prior privileges procedure public read real references relative repeatable '+'restrict return returns revoke rollback rollup rows rule schema scroll '+'second section select sequence serializable set size smallint static '+'statistics table temp temporary then time timestamp to top transaction '+'translation trigger true truncate uncommitted union unique update values '+'varchar varying view when where with work';var operators='all and any between cross in join like not null or outer some';this.regexList=[{regex:/--(.*)$/gm,css:'comments'},{regex:dp.sh.RegexLib.doubleQuotedString,css:'string'},{regex:dp.sh.RegexLib.singleQuotedString,css:'string'},{regex:new RegExp(this.getKeywords(funcs),'gmi'),css:'color2'},{regex:new RegExp(this.getKeywords(operators),'gmi'),css:'color1'},{regex:new RegExp(this.getKeywords(keywords),'gmi'),css:'keyword'}];};dp.sh.Brushes.Sql.prototype=new dp.sh.Highlighter();dp.sh.Brushes.Sql.aliases=['sql'];dp.sh.Brushes.Python=function()
{var keywords='and assert break class continue def del elif else '+'except exec finally for from global if import in is '+'lambda not or pass print raise return try yield while';var special='None True False self cls class_';this.regexList=[{regex:dp.sh.RegexLib.singleLinePerlComments,css:'comments'},{regex:/^\s*@\w+/gm,css:'decorator'},{regex:/(['\"]{3})([^\1])*?\1/gm,css:'comments'},{regex:/"(?!")(?:\.|\\\"|[^\""\n])*"/gm,css:'string'},{regex:/'(?!')*(?:\.|(\\\')|[^\''\n])*'/gm,css:'string'},{regex:/\b\d+\.?\w*/g,css:'number'},{regex:new RegExp(this.getKeywords(keywords),'gm'),css:'keyword'},{regex:new RegExp(this.getKeywords(special),'gm'),css:'color1'}];};dp.sh.Brushes.Python.prototype=new dp.sh.Highlighter();dp.sh.Brushes.Python.aliases=['py','python'];dp.sh.Brushes.Ruby=function()
{var keywords='alias and BEGIN begin break case class def define_method defined do each else elsif '+'END end ensure false for if in module new next nil not or raise redo rescue retry return '+'self super then throw true undef unless until when while yield';var builtins='Array Bignum Binding Class Continuation Dir Exception FalseClass File::Stat File Fixnum Fload '+'Hash Integer IO MatchData Method Module NilClass Numeric Object Proc Range Regexp String Struct::TMS Symbol '+'ThreadGroup Thread Time TrueClass';this.regexList=[{regex:dp.sh.RegexLib.singleLinePerlComments,css:'comments'},{regex:dp.sh.RegexLib.doubleQuotedString,css:'string'},{regex:dp.sh.RegexLib.singleQuotedString,css:'string'},{regex:/:[a-z][A-Za-z0-9_]*/g,css:'color2'},{regex:/(\$|@@|@)\w+/g,css:'variable bold'},{regex:new RegExp(this.getKeywords(keywords),'gm'),css:'keyword'},{regex:new RegExp(this.getKeywords(builtins),'gm'),css:'color1'}];};dp.sh.Brushes.Ruby.prototype=new dp.sh.Highlighter();dp.sh.Brushes.Ruby.aliases=['ruby','rails','ror'];dp.sh.Brushes.Java=function()
{var keywords='abstract assert boolean break byte case catch char class const '+'continue default do double else enum extends '+'false final finally float for goto if implements import '+'instanceof int interface long native new null '+'package private protected public return '+'short static strictfp super switch synchronized this throw throws true '+'transient try void volatile while';this.regexList=[{regex:dp.sh.RegexLib.singleLineCComments,css:'comments'},{regex:dp.sh.RegexLib.multiLineCComments,css:'comments'},{regex:dp.sh.RegexLib.doubleQuotedString,css:'string'},{regex:dp.sh.RegexLib.singleQuotedString,css:'string'},{regex:/\b([\d]+(\.[\d]+)?|0x[a-f0-9]+)\b/gi,css:'value'},{regex:/(?!\@interface\b)\@[\$\w]+\b/g,css:'color1'},{regex:/\@interface\b/g,css:'keyword'},{regex:new RegExp(this.getKeywords(keywords),'gm'),css:'keyword'}];};dp.sh.Brushes.Java.prototype=new dp.sh.Highlighter();dp.sh.Brushes.Java.aliases=['java'];dp.sh.Brushes.Cpp=function()
{var datatypes='ATOM BOOL BOOLEAN BYTE CHAR COLORREF DWORD DWORDLONG DWORD_PTR '+'DWORD32 DWORD64 FLOAT HACCEL HALF_PTR HANDLE HBITMAP HBRUSH '+'HCOLORSPACE HCONV HCONVLIST HCURSOR HDC HDDEDATA HDESK HDROP HDWP '+'HENHMETAFILE HFILE HFONT HGDIOBJ HGLOBAL HHOOK HICON HINSTANCE HKEY '+'HKL HLOCAL HMENU HMETAFILE HMODULE HMONITOR HPALETTE HPEN HRESULT '+'HRGN HRSRC HSZ HWINSTA HWND INT INT_PTR INT32 INT64 LANGID LCID LCTYPE '+'LGRPID LONG LONGLONG LONG_PTR LONG32 LONG64 LPARAM LPBOOL LPBYTE LPCOLORREF '+'LPCSTR LPCTSTR LPCVOID LPCWSTR LPDWORD LPHANDLE LPINT LPLONG LPSTR LPTSTR '+'LPVOID LPWORD LPWSTR LRESULT PBOOL PBOOLEAN PBYTE PCHAR PCSTR PCTSTR PCWSTR '+'PDWORDLONG PDWORD_PTR PDWORD32 PDWORD64 PFLOAT PHALF_PTR PHANDLE PHKEY PINT '+'PINT_PTR PINT32 PINT64 PLCID PLONG PLONGLONG PLONG_PTR PLONG32 PLONG64 POINTER_32 '+'POINTER_64 PSHORT PSIZE_T PSSIZE_T PSTR PTBYTE PTCHAR PTSTR PUCHAR PUHALF_PTR '+'PUINT PUINT_PTR PUINT32 PUINT64 PULONG PULONGLONG PULONG_PTR PULONG32 PULONG64 '+'PUSHORT PVOID PWCHAR PWORD PWSTR SC_HANDLE SC_LOCK SERVICE_STATUS_HANDLE SHORT '+'SIZE_T SSIZE_T TBYTE TCHAR UCHAR UHALF_PTR UINT UINT_PTR UINT32 UINT64 ULONG '+'ULONGLONG ULONG_PTR ULONG32 ULONG64 USHORT USN VOID WCHAR WORD WPARAM WPARAM WPARAM '+'char bool short int __int32 __int64 __int8 __int16 long float double __wchar_t '+'clock_t _complex _dev_t _diskfree_t div_t ldiv_t _exception _EXCEPTION_POINTERS '+'FILE _finddata_t _finddatai64_t _wfinddata_t _wfinddatai64_t __finddata64_t '+'__wfinddata64_t _FPIEEE_RECORD fpos_t _HEAPINFO _HFILE lconv intptr_t '+'jmp_buf mbstate_t _off_t _onexit_t _PNH ptrdiff_t _purecall_handler '+'sig_atomic_t size_t _stat __stat64 _stati64 terminate_function '+'time_t __time64_t _timeb __timeb64 tm uintptr_t _utimbuf '+'va_list wchar_t wctrans_t wctype_t wint_t signed';var keywords='break case catch class const __finally __exception __try '+'const_cast continue private public protected __declspec '+'default delete deprecated dllexport dllimport do dynamic_cast '+'else enum explicit extern if for friend goto inline '+'mutable naked namespace new noinline noreturn nothrow '+'register reinterpret_cast return selectany '+'sizeof static static_cast struct switch template this '+'thread throw true false try typedef typeid typename union '+'using uuid virtual void volatile whcar_t while';this.regexList=[{regex:dp.sh.RegexLib.singleLineCComments,css:'comments'},{regex:dp.sh.RegexLib.multiLineCComments,css:'comments'},{regex:dp.sh.RegexLib.doubleQuotedString,css:'string'},{regex:dp.sh.RegexLib.singleQuotedString,css:'string'},{regex:/^ *#.*/gm,css:'preprocessor'},{regex:new RegExp(this.getKeywords(datatypes),'gm'),css:'color1 bold'},{regex:new RegExp(this.getKeywords(keywords),'gm'),css:'keyword'}];};dp.sh.Brushes.Cpp.prototype=new dp.sh.Highlighter();dp.sh.Brushes.Cpp.aliases=['cpp','c'];dp.sh.Brushes.CSharp=function()
{var keywords='abstract as base bool break byte case catch char checked class const '+'continue decimal default delegate do double else enum event explicit '+'extern false finally fixed float for foreach get goto if implicit in int '+'interface internal is lock long namespace new null object operator out '+'override params private protected public readonly ref return sbyte sealed set '+'short sizeof stackalloc static string struct switch this throw true try '+'typeof uint ulong unchecked unsafe ushort using virtual void while';this.regexList=[{regex:dp.sh.RegexLib.singleLineCComments,css:'comments'},{regex:dp.sh.RegexLib.multiLineCComments,css:'comments'},{regex:dp.sh.RegexLib.doubleQuotedString,css:'string'},{regex:dp.sh.RegexLib.singleQuotedString,css:'string'},{regex:/^\s*#.*/gm,css:'preprocessor'},{regex:new RegExp(this.getKeywords(keywords),'gm'),css:'keyword'}];};dp.sh.Brushes.CSharp.prototype=new dp.sh.Highlighter();dp.sh.Brushes.CSharp.aliases=['c#','c-sharp','csharp'];dp.sh.Brushes.Delphi=function()
{var keywords='abs addr and ansichar ansistring array as asm begin boolean byte cardinal '+'case char class comp const constructor currency destructor div do double '+'downto else end except exports extended false file finalization finally '+'for function goto if implementation in inherited int64 initialization '+'integer interface is label library longint longword mod nil not object '+'of on or packed pansichar pansistring pchar pcurrency pdatetime pextended '+'pint64 pointer private procedure program property pshortstring pstring '+'pvariant pwidechar pwidestring protected public published raise real real48 '+'record repeat set shl shortint shortstring shr single smallint string then '+'threadvar to true try type unit until uses val var varirnt while widechar '+'widestring with word write writeln xor';this.regexList=[{regex:/\(\*[\s\S]*?\*\)/gm,css:'comments'},{regex:/{(?!\$)[\s\S]*?}/gm,css:'comments'},{regex:dp.sh.RegexLib.singleLineCComments,css:'comments'},{regex:dp.sh.RegexLib.singleQuotedString,css:'string'},{regex:/\{\$[a-zA-Z]+ .+\}/g,css:'color1'},{regex:/\b[\d\.]+\b/g,css:'value'},{regex:/\$[a-zA-Z0-9]+\b/g,css:'value'},{regex:new RegExp(this.getKeywords(keywords),'gm'),css:'keyword'}];};dp.sh.Brushes.Delphi.prototype=new dp.sh.Highlighter();dp.sh.Brushes.Delphi.aliases=['delphi','pascal'];dp.sh.Brushes.Vb=function()
{var keywords='AddHandler AddressOf AndAlso Alias And Ansi As Assembly Auto '+'Boolean ByRef Byte ByVal Call Case Catch CBool CByte CChar CDate '+'CDec CDbl Char CInt Class CLng CObj Const CShort CSng CStr CType '+'Date Decimal Declare Default Delegate Dim DirectCast Do Double Each '+'Else ElseIf End Enum Erase Error Event Exit False Finally For Friend '+'Function Get GetType GoSub GoTo Handles If Implements Imports In '+'Inherits Integer Interface Is Let Lib Like Long Loop Me Mod Module '+'MustInherit MustOverride MyBase MyClass Namespace New Next Not Nothing '+'NotInheritable NotOverridable Object On Option Optional Or OrElse '+'Overloads Overridable Overrides ParamArray Preserve Private Property '+'Protected Public RaiseEvent ReadOnly ReDim REM RemoveHandler Resume '+'Return Select Set Shadows Shared Short Single Static Step Stop String '+'Structure Sub SyncLock Then Throw To True Try TypeOf Unicode Until '+'Variant When While With WithEvents WriteOnly Xor';this.regexList=[{regex:/'.*$/gm,css:'comments'},{regex:dp.sh.RegexLib.doubleQuotedString,css:'string'},{regex:/^\s*#.*$/gm,css:'preprocessor'},{regex:new RegExp(this.getKeywords(keywords),'gm'),css:'keyword'}];};dp.sh.Brushes.Vb.prototype=new dp.sh.Highlighter();dp.sh.Brushes.Vb.aliases=['vb','vbnet'];dp.sh.Brushes.Plain=function()
{};dp.sh.Brushes.Plain.prototype=new dp.sh.Highlighter();dp.sh.Brushes.Plain.aliases=['text','plain'];