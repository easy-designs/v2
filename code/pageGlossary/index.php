<?

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Page Glossary &#172; Easy Designs</title>
<?php docHead(); ?>
</head>
<body>
<?php message(); ?>
<div id="content">
  <h1>Page Glossary</h1>
  
  <h2 id="genInfo">General Information</h2>
  <dl>
    <dt>Purpose</dt>
    <dd>A replacement for <a href="/code/makeGlossary/">makeGlossary</a>. This script collects all of the abbreviations (<code>&#60;abbr&#62;</code>), acronyms (<code>&#60;acronym&#62;</code>), and definitions (<code>&#60;dfn&#62;</code>) on a page and builds a definition list (<code>&#60;dl&#62;</code>) of the terms, which is appended to a specified container (identified by its <code>id</code>). The script checks for duplicate terms and also alphabetizes the terms. This script was created as a usability enhancement for webpages.</dd>
    <dt>Current Version</dt>
    <dd>1.0 (27 November 2005)</dd>
    <dt>Requirements</dt>
    <dd>None</dd>
  </dl>
  
  <h2 id="use">Use</h2>
  <p>Simply include the pageGlossary.js file in the head of your document.</p>
  
  <h2 id="changeLog">Change Log</h2>
  <dl>
    <dt>1.0 (27 November 2005)</dt>
    <dd>Initial script &#8211; a rewrite of <code>makeGlossary()</code> as an object literal; all external functions have now been rewritten as object methods.</dd>
  </dl>
  
  <h2 id="downloads">Optimized Releases</h2>
  <p>These releases have been optimized for production by removing unnecessary white space, carriage returns, etc.</p>
  <ul>
    <li><a href="/code/pageGlossary/1.0/pageGlossary-v1.0.zip">Compressed 1.0</a> [1.29<abbr title="kilobytes">kB</abbr> .zip archive]</li>
  </ul>
  
  <h2 id="development">Development Version</h2>
  <p>If you are interested in helping to further develop this script, you can <a href="/code/pageGlossary/working/pageGlossary.js" title="Uncompressed Development Version [3.41Kb]">download the uncompressed JavaScript source file</a>.</p>
  
  <div id="extras">
  </div>
</div>
<?php foot(); ?>

</body>
</html>
