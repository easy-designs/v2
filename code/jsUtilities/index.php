<?

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>JavaScript Utilities Library &#172; Easy Designs</title>
<?php docHead(); ?>
</head>
<body>
<?php message(); ?>
<div id="content">
  <h1>JavaScript Utilities Library</h1>
  
  <h2 id="genInfo">General Information</h2>
  <dl>
    <dt>Purpose</dt>
    <dd>This script provides functions for browsers which do not inherently support the entire JavaScript Core and supplies some useful functions PHP developers might wish they had access to.</dd>
    <dt>Current Version</dt>
    <dd>2.1 (21 June 2005)</dd>
    <dt>Requirements</dt>
    <dd>None.</dd>
  </dl>
  
  <h2 id="use">Use</h2>
  <p>Copy these functions into your main JavaScript file or reference this file in the <code>&#60;head&#62;</code> of your document.</p>
  
  <h2 id="changeLog">Change Log</h2>
  <dl>
    <dt>1.0 (13 May 2005)</dt>
    <dd>Initial script</dd>
    <dt>2.0 (5 June 2005)</dt>
    <dd>Migrated all functions to prototypes (Warning: some of this is unsupported in <abbr title="Internet Explorer 6">IE6</abbr>); added lastChildContainingText(), addClass() and removeClass();</dd>
    <dt>2.1 (21 June 2005)</dt>
    <dd>Fixed <abbr title="Internet Explorer">IE</abbr> incompatibilities.</dd>
  </dl>
  
  <h2 id="downloads">Optimized Releases</h2>
  <p>These releases have been optimized for production by removing unnecessary white space, carriage returns, etc.</p>
  <ul>
    <li><a href="/code/jsUtilities/2.1/jsUtilities-v2.1.zip">Compressed 2.1</a> [1.48<abbr title="Kilobytes">Kb</abbr> .zip archive]</li>
    <li><a href="/code/jsUtilities/2.0/jsUtilities-v2.0.zip">Compressed 2.0</a> [1.43<abbr title="Kilobytes">Kb</abbr> .zip archive]</li>
    <li><a href="/code/jsUtilities/1.0/jsUtilities-v1.0.zip">Compressed 1.0</a> [940 byte .zip archive]</li>
  </ul>
  
  <h2 id="development">Development Version</h2>
  <p>If you are interested in helping to further develop this script, you can <a href="/code/jsUtilities/working/jsUtilities.js" title="Uncompressed Development Version [5.30Kb]">download the uncompressed JavaScript source file</a>.</p>
  
  <div id="extras">
  </div>
</div>
<?php foot(); ?>

</body>
</html>