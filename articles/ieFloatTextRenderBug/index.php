<?php

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>IE box model + float = duplicated text</title>
<?php docHead(); ?>
</head>
<body>
<?php message(); ?>
<div id="content">
  <h1>IE box model + float = duplicated text</h1>
  
  <h2>The problem</h2>
  <p>If you are floating elements within a box (in this case <code>&#60;label&#62;</code>s within a <code>&#60;fieldset&#62;</code>), <abbr title="Internet Explorer 6 on Windows">Win/IE6</abbr> appears to have a box model issue (even when rendering in &#8220;standards mode&#8221;) and will duplicate a portion of your text onto a new line:</p>

  <a href="bad.html" title="click to view the live demo [use Win/IE6 to see the error]"><img src="WinIE.gif" width="382" height="183" alt="A screenshot of the issue taken in Win/IE 6" /></a>

  <p>In this example, the width of the conatining <code>&#60;fieldset&#62;</code> is set to 410<abbr title="pixels">px</abbr>. Padding is set to 0<abbr title="pixels">px</abbr>, so the box has an inner width of 410<abbr title="pixels">px</abbr>. The <code>&#60;label&#62;</code>s are each set to 200<abbr title="pixels">px</abbr> wide, with a right-hand margin of 5<abbr title="pixels">px</abbr>. Floating two <code>&#60;label&#62;</code>s next to one another would yield a width of 410<abbr title="pixels">px</abbr> (200 + 5 + 200 + 5 = 410), thereby snuggly fitting within the container box.</p>
  <p>Note: if the elements you are floating do not reach the other side of the container, there is no problem (see the first <code>&#60;fieldset&#62;</code> in the <a href="bad.html" title="click to view the live demo [use Win/IE to see the error]">live demo</a> or above).</p>
  
  <h2>The solution</h2>
  <p>Dropping the width or margin of the <code>&#60;label&#62;</code>s or increasing the width of the <code>&#60;fieldset&#62;</code> seems to <a href="good.html">get rid of the issue</a>. Oddly enough, in the above example, the issue disappears when the <code>&#60;label&#62;</code>s reach 196<abbr title="pixels">px</abbr> wide, meaning that that <abbr title="Internet Explorer 6 on Windows">Win/IE6</abbr> will keep the display issue until the floated elements are at least 8<abbr title="pixels">px</abbr> (410 - 196 - 5 - 196 - 5 = 8) away from the right-hand side of the container.</p>
</div>
<?php foot(); ?>
</body>
</html>