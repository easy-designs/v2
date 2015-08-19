<?

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Footnote Links &#172; Easy Designs</title>
<?php docHead(); ?>
</head>
<body>
<?php message(); ?>
<div id="content">
  <h1>Footnote Links</h1>
  
  <h2 id="genInfo">General Information</h2>
  <dl>
    <dt>Purpose</dt>
    <dd>This script builds a list of <abbr title="Uniform Resource Indicators">URIs</abbr> (<code>href</code>s or citations) from any tags within a specified container and appends the list (as footnotes) to the document in a specified location. Any referenced elements are given a dynamically-assigned number (in the form of a superscript) which corresponds to the link in the footnote list. The script checks for duplicate links and associates them with the same number. This script was created as a usability enhancement for printed webpages.</dd>
    <dt>Current Version</dt>
    <dd>1.3 (21 June 2005)</dd>
    <dt>Requirements</dt>
    <dd>This script uses functions contained in our <a href="/code/jsUtilities/">utilities library</a>.</dd>
  </dl>
  
  <h2 id="use">Use</h2>
  <p>In your <code>onload</code> function, call <code>footnoteLinks()</code>, setting <var>containerID</var> and <var>targetID</var> to the ids your desired containers.</p>
  <p>In your screen <abbr title="Cascading Style Sheets">CSS</abbr> (and anywhere else you want to hide the list and superscripts), create a rule for <code>.printOnly</code>:</p>
  <pre class="style"><code>.printOnly {
  display: none;
}</code></pre>
  <p>You can <code>class</code> links as ignore to have them not be picked up by the script:</p>
  <pre class="html"><code>&#60;a href=&#34;http://foo.bar.com&#34; class=&#34;ignore&#34;&#62;link&#60;/a&#62;</code></pre>
  <p>You can also use the content generation from <abbr title="Cascading Style Sheets Level 2">CSS2</abbr> as a fall-back for the script. When the script runs, it will <code>class</code> the <code>&#60;html&#62;</code> as &#8220;noted&#8221;. You simply supply the following rules to add the content generation and then remove it when the script runs:</p>
  <pre class="style"><code>a:link:after,
a:visited:after {
  content: &#34; (&#34; attr(href) &#34;) &#34;;
  font-size: 90%;
}
html.noted a:link:after,
html.noted a:visited:after {
  content: &#34;&#34;;
}</code></pre>
  
  <h2 id="changeLog">Change Log</h2>
  <dl>
    <dt>1.0 (8 May 2005)</dt>
    <dd>Initial script</dd>
    <dt>1.1 (12 May 2005)</dt>
    <dd>Added search for ignore <code>class</code> to avoid listing certain links</dd>
    <dt>1.2 (5 June 2005)</dt>
    <dd>Added support for <a href="/code/jsUtilities/">jsUtilities 2.0</a> &#38; fall-back <abbr title="Cascading Style Sheets Level 2">CSS2</abbr> support.</dd>
    <dt>1.3 (21 June 2005)</dt>
    <dd>Added support for <a href="/code/jsUtilities/">jsUtilities 2.1</a> &#38; fixed <abbr title="Internet Explorer">IE</abbr> incompatibilities.</dd>
  </dl>
  
  <h2 id="downloads">Optimized Releases</h2>
  <p>These releases have been optimized for production by removing unnecessary white space, carriage returns, etc.</p>
  <ul>
    <li><a href="/code/footnoteLinks/1.3/footnoteLinks-v1.3.zip">Compressed 1.3</a> [1<abbr title="Kilobytes">Kb</abbr> .zip archive]</li>
    <li><a href="/code/footnoteLinks/1.2/footnoteLinks-v1.2.zip">Compressed 1.2</a> [1<abbr title="Kilobytes">Kb</abbr> .zip archive]</li>
    <li><a href="/code/footnoteLinks/1.1/footnoteLinks-v1.1.zip">Compressed 1.1</a> [988 byte .zip archive]</li>
    <li><a href="/code/footnoteLinks/1.0/footnoteLinks-v1.0.zip">Compressed 1.0</a> [965 byte .zip archive]</li>
  </ul>
  
  <h2 id="development">Development Version</h2>
  <p>If you are interested in helping to further develop this script, you can <a href="/code/footnoteLinks/working/footnoteLinks.js" title="Uncompressed Development Version [2.64Kb]">download the uncompressed JavaScript source file</a>.</p>
  
  <div id="extras">
  </div>
</div>
<?php foot(); ?>

</body>
</html>