window.resizeTo(750,532);function clearText()
{document.getElementById("sourceCode").value="";document.getElementById("htmlCode").value="";document.getElementById("preview").innerHTML="";}
function generateCode()
{if(document.getElementById("sourceCode").value.trim()=="")
{return;}
dp.SyntaxHighlighter.HighlightAll("sourceCode",document.getElementById("showGutter").checked,document.getElementById("showControls").checked,document.getElementById("collapseAll").checked,document.getElementById("firstLine").checked,document.getElementById("showColumns").checked);}
function docopy(src)
{if(src=='source')
{if(document.getElementById("sourceCode").value!="")
window.clipboardData.setdata("Text",document.getElementById("sourceCode").value);else
alert("Content is empty, can't copy!")}
else if(src=='html')
{if(document.getElementById("sourceCode").value!="")
window.clipboardData.setdata("Text",document.getElementById("htmlCode").value);else
alert("Content is empty, can't copy!")}
else
{if(document.getElementById("preview").innerHTML!="")
window.clipboardData.setdata("Text",document.getElementById("htmlCode").value);else
alert("Content is empty, can't copy!")}}
function dopasted(dst)
{if(dst=='source')
{if(window.clipboardData.getdata("Text")!=null)
document.getElementById("sourceCode").value=window.clipboardData.getdata("Text");}
else if(dst=='html')
{if(window.clipboardData.getdata("Text")!=null)
document.getElementById("htmlCode").value=window.clipboardData.getdata("Text");}
else
{if(window.clipboardData.getdata("Text")!=null)
document.getElementById("preview").innerHTML=window.clipboardData.getdata("Text");}}
function doclear(dst)
{if(dst=='source')
{document.getElementById("sourceCode").value="";}
else if(dst=='html')
{document.getElementById("htmlCode").value="";}
else
{document.getElementById("preview").innerHTML="";}}
String.prototype.trim=function(){return this.replace(/(^\s*)|(\s*ก็)/g,"");}
var highlightdiv=null;dp.sh.HighlightAll=function(name,showGutter,showControls,collapseAll,firstLine,showColumns)
{function FindValue()
{var a=arguments;for(var i=0;i<a.length;i++)
{if(a[i]==null)
continue;if(typeof(a[i])=='string'&&a[i]!='')
return a[i]+'';if(typeof(a[i])=='object'&&a[i].value!='')
return a[i].value+'';}
return null;}
function IsoptionSet(value,list)
{for(var i=0;i<list.length;i++)
if(list[i]==value)
return true;return false;}
function GetoptionValue(name,list,defaultValue)
{var regex=new RegExp('^'+name+'\\[(\\w+)\\]ก็','gi');var matches=null;for(var i=0;i<list.length;i++)
if((matches=regex.exec(list[i]))!=null)
return matches[1];return defaultValue;}
var elements=document.getElementsByName(name);var highlighter=null;var registered=new Object();var propertyName='value';if(elements==null)
return;for(var brush in dp.sh.Brushes)
{var aliases=dp.sh.Brushes[brush].Aliases;if(aliases==null)
continue;for(var i=0;i<aliases.length;i++)
registered[aliases[i]]=brush;}
for(var i=0;i<elements.length;i++)
{var element=elements[i];var options=FindValue(element.attributes['class'],element.className,element.attributes['language'],element.language);var language='';if(options==null)
continue;options=options.split(':');language=options[0].toLowerCase();if(registered[language]==null)
continue;highlighter=new dp.sh.Brushes[registered[language]]();highlighter.noGutter=(showGutter==null)?IsoptionSet('nogutter',options):!showGutter;highlighter.addControls=(showControls==null)?!IsoptionSet('nocontrols',options):showControls;highlighter.collapse=(collapseAll==null)?IsoptionSet('collapse',options):collapseAll;highlighter.showColumns=(showColumns==null)?IsoptionSet('showcolumns',options):showColumns;highlighter.firstLine=(firstLine==null)?parseInt(GetoptionValue('firstline',options,1)):firstLine;highlighter.Highlight(element[propertyName]);document.getElementById("htmlCode").value=highlighter.div.outerHTML.substring();highlightdiv=highlighter;document.getElementById("preview").innerHTML=highlighter.div.outerHTML.trim();}}
dp.sh.Toolbar.Command=function(name,sender)
{var n=sender;dp.sh.Toolbar.Commands[name].func(sender,highlightdiv);}