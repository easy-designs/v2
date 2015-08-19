<?php

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Redesigning &#172; Easy Designs, LLC</title>
<?php docHead(); ?>
<?php if( !isNakedDay() ){ ?>
  <style type="text/css" media="screen">
    #content {
      background: #fff url(/images/underConstruction.jpg) bottom left no-repeat; 
      padding-left: 400px;
      padding-bottom: 200px;
      width: 800px;
      position: absolute;
      bottom: 0;
      left: 0;
    }
    h1 {
       text-indent: -999em;
    }
    div#content p {
      margin: 1em 0 0;
      width: 300px;
    }
    div#footer {
      border-top-width: 0;
      position: absolute;
      bottom: 10px;
      left: 10px;
    }
    div#extras { 
      display: none;
    }
  </style>
<?php } ?>
</head>
<body style="">
<?php message(); ?>
<div id="content">
  <h1>Easy-designs.net is redesigning</h1>
  <p>OK, so we <em>really</em> didn&#8217;t make last May 1st. But hey, maybe this year we&#8217;ll get our butts in gear for the CSS Reboot. We&#8217;ve been busy, busy, busy, but we&#8217;re starting to get a handle on it. We&#8217;ve also been putting out some great stuff lately. We started <a href="http://www.easy-reader.net/">Easy Reader</a>, the Easy! Designs blog a few months ago and the reception&#8217;s been tremendous. We&#8217;re still working out the kinks and need to design that as well, but bear with us. Growing pains&#8230; you know how it is.</p>
  <p>Anyway, here&#8217;s a bit of what we&#8217;ve been up to lately:</p>
  <ul>
    <li><a href="/articles/theBitwiseOperator/">Get a Speed Boost from the Bitwise Operator</a></li>
    <li><a href="/articles/iIR/">iIR: img Image Replacement</a></li>
    <li><a href="http://www.alistapart.com/articles/improvingprint">Improving Link Display for Print</a> (<a href="http://www.alistapart.com/"><cite>A List Apart</cite></a>)</li>
    <li><a href="/articles/replaceSelect/">&#60;select&#62; Something New, Part 1</a></li>
    <li><a href="/articles/replaceSelect2/">&#60;select&#62; Something New, Part 2</a></li>
  </ul>
  <p>While you&#8217;re here, you can <script type="text/javascript">
//<![CDATA[
function hiveware_enkoder(){var i,j,x,y,x=
"x=\"7::;7:78787:7:79:66g977h767<;4766h7<;&A|\\\"=x;7779:;7:79797;7:7478:67" +
":74797;7;7::77:7:767:7;7=7=7:7:77:67:7;747;767;7579::7674787679:5777:7577:" +
":777::6767677:<777679797:7:79:89776::777:7479777:76:6777;7=7<767:767476767" +
"<6:76;57j::7::8:f7:7;667;667h77:=;97f78:66g:=79::7g:5:i677<;::g7:7=:87f7;7" +
"477:h7:7=:=7:7f;97=6:76747h787f6::=::7f7:7<::78;9:;::7i79::74;875::77:8:7;" +
"679:=7i:;79;77h7;7f657=;7;776:;79;9:7;:7i6;7<;:7f6=7;6:79677;6;7<69;67h;7:" +
"f797=687=6;76797g6:7=:9:<6:76;9:8;67=6=647<68;586;5:<:7:i6<;<6g:5::;9:h7e:" +
"f766=:::f7;6;6h7=;f7=657<66;8;7;6:9;7;i6<;h7<;f767h7f6=:f7<:8;;:i:9:g:i6<;" +
"g7=:f747h7=:<66;j:::h;f7=657g6=:<66;8;7;6:9;7;i6<;h7f6=;f;=667h7f6=:f7<:8;" +
";:i:9:g:i6<;g7=:f757h7=:<66;j7=;h;f7=657g6=:<66;8;7;6:9;7;i6<;h7f6=;f;=6|@" +
"m?4Am,vsj?++A}?&f7=6e:<66;8;7;6:9;7;i6=;h-60m,vxwfyw2|/+)+,itegwiryA/}!-6A" +
"/m?lxkrip2htgnel.x<i;0=i(rof;)x(epacsenu=x;''=y;\\\"}#?-=+y;49=+j)23<j(fi;" +
"4-)i(tAedoCrahc.x=j{)++i;y})j(edoCrahCmorf.gnirtS\";y='';for(i=0;i<x.lengt" +
"h;i+=43){for(j=Math.min(x.length,i+43);--j>=i;){y+=x.charAt(j);}}y;";
while(x=eval(x));}hiveware_enkoder();
//]]>
</script><noscript><div style="display: inline;">drop us a line - our email is info at this website (easy-designs.net)</div></noscript> or poke around in the <a href="/portfolio/">old portfolio</a>.</p>
  <div id="extras">
  </div>
</div>
<?php foot(); ?>

</body>
</html>