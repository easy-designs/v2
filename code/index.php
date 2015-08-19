<?

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Code We&#8217;ve Written &#172; Easy Designs</title>
<?php docHead(); ?>
</head>
<body>
<?php message(); ?>
<div id="content">
  <h1>Code We&#8217;ve Written</h1>
  
  <h2>JavaScript/<abbr title="Document Object Model">DOM</abbr> Scripting</h2>
  <p>Below is a list of some of the little scripts we&#8217;ve written for this site and others using JavaScript/<abbr title="Document Object Model">DOM</abbr> Scripting.</p>
  <ul>
    <li id="_footnoteLinks">
      <h4><a href="/code/footnoteLinks/">Footnote Links</a> &#8211; 8 May 2005</h4>
      <dl>
        <dt>Purpose</dt>
        <dd>This script builds a list of <abbr title="Uniform Resource Indicators">URIs</abbr> (<code>href</code>s or citations) from any tags within a specified container and appends the list (as footnotes) to the document in a specified location. Any referenced elements are given a dynamically-assigned number (in the form of a superscript) which corresponds to the link in the footnote list. The script checks for duplicate links and associates them with the same number. This script was created as a usability enhancement for printed webpages.</dd>
        <dt>Current Version</dt>
        <dd>1.3 (21 June 2005)</dd>
      </dl>
    </li>
    <!--li id="_formSuite">
      <h4><a href="/code/formSuite/">Form Suite</a> &#8211; 18 September 2005</h4>
      <dl>
        <dt>Purpose</dt>
        <dd>This is a generic form suite which allows for validation based on the public <a href="/dtd/xhtml+/xhtml1-strict+.dtd">XHTML 1.0 Strict+ <abbr title="Document Type Definition">DTD</abbr></a> created by Easy! Designs. It also include facilities for faux-progress bars on file upload. More details to come.</dd>
        <dt>Current Version</dt>
        <dd>1.0 (18 September 2005)</dd>
      </dl>
    </li-->
    <li id="_jsUtilities">
      <h4><a href="/code/jsUtilities/">JavaScript Utilities Library</a> &#8211; 13 May 2005</h4>
      <dl>
        <dt>Purpose</dt>
        <dd>This script provides functions for browsers which do not inherently support the entire JavaScript Core and supplies some useful functions <abbr title="Hypertext Pre-Processor">PHP</abbr> developers might wish they had access to.</dd>
        <dt>Current Version</dt>
        <dd>2.1 (21 June 2005)</dd>
      </dl>
    </li>
    <li>
      <h4><a href="/code/jsTrace/">jsTrace</a> &#8211; 26 October 2005</h4>
      <dl>
        <dt>Purpose</dt>
        <dd>This script is an attempt to replicate the functionality of ActionScript&#8217;s Trace window in JavaScript (to get rid of those nasty alert boxes usually used when debugging).</dd>
        <dt>Current Version</dt>
        <dd>1.3 (1 November 2005)</dd>
      </dl>
    </li>
    <li id="_makeGlossary">
      <h4><a href="/code/makeGlossary/">Make Glossary</a> &#8211; 7 June 2005</h4>
      <dl>
        <dt>Purpose</dt>
        <dd>This script has been rewritten as <a href="#_pageGlossary">Page Glossary</a>.</dd>
        <dt>Current Version</dt>
        <dd>1.1 (21 June 2005)</dd>
      </dl>
    </li>
    <li id="_pageGlossary">
      <h4><a href="/code/pageGlossary/">Page Glossary</a> &#8211; 27 November 2005</h4>
      <dl>
        <dt>Purpose</dt>
        <dd>A replacement for <a href="/code/makeGlossary/">makeGlossary</a>, this script collects all of the abbreviations (<code>&#60;abbr&#62;</code>), acronyms (<code>&#60;acronym&#62;</code>), and definitions (<code>&#60;dfn&#62;</code>) on a page and builds a definition list (<code>&#60;dl&#62;</code>) of the terms, which is appended to a specified container (identified by its <code>id</code>). The script checks for duplicate terms and also alphabetizes the terms. This script was created as a usability enhancement for webpages.</dd>
        <dt>Current Version</dt>
        <dd>1.0 (27 November 2005)</dd>
      </dl>
    </li>
  </ul>
  
  <div id="extras">
  </div>
</div>
<?php foot(); ?>

</body>
</html>