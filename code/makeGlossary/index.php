<?

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Make Glossary &#172; Easy Designs</title>
<?php docHead(); ?>
</head>
<body>
<?php message(); ?>
<div id="content">
  <h1>Make Glossary</h1>
  
  <h2 id="genInfo">General Information</h2>
  <dl>
    <dt>Purpose</dt>
    <dd>This script collects all of the abbreviations (<code>&#60;abbr&#62;</code>), acronyms (<code>&#60;acronym&#62;</code>), and definitions (<code>&#60;dfn&#62;</code>) on a page and builds a definition list (<code>&#60;dl&#62;</code>) of the terms, which is appended to a specified container (identified by its <code>id</code>). The script checks for duplicate terms and also alphabetizes the terms. This script was created as a usability enhancement for webpages.</dd>
    <dt>Current Version</dt>
    <dd>1.1 (21 June 2005)</dd>
    <dt>Requirements</dt>
    <dd>This script uses functions contained in our <a href="/code/jsUtilities/">utilities library</a>.</dd>
  </dl>
  
  <h2 id="use">Use</h2>
  <p>In your <code>onload</code> function, call <code>makeGlossary()</code>, setting <var>targetID</var> to the <code>id</code> of your target container.</p>
  
  <h2 id="changeLog">Change Log</h2>
  <dl>
    <dt>1.0 (7 June 2005)</dt>
    <dd>Initial script</dd>
    <dt>1.1 (21 June 2005)</dt>
    <dd>Added support for <a href="/code/jsUtilities/">jsUtilities 2.1</a>.</dd>
  </dl>
  
  <h2 id="downloads">Optimized Releases</h2>
  <p>These releases have been optimized for production by removing unnecessary white space, carriage returns, etc.</p>
  <ul>
    <li><a href="/code/makeGlossary/1.1/makeGlossary-v1.1.zip">Compressed 1.1</a> [990 byte .zip archive]</li>
    <li><a href="/code/makeGlossary/1.0/makeGlossary-v1.0.zip">Compressed 1.0</a> [991 byte .zip archive]</li>
  </ul>
  
  <h2 id="development">Development Version</h2>
  <p>If you are interested in helping to further develop this script, you can <a href="/code/makeGlossary/working/makeGlossary.js" title="Uncompressed Development Version [2.42Kb]">download the uncompressed JavaScript source file</a>.</p>
  
  <div id="extras">
  </div>
</div>
<?php foot(); ?>

</body>
</html>
