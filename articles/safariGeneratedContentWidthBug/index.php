<?php

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Safari Enlarged Text + Generated Content Width Bug</title>
<?php docHead(); ?>
  <style type="text/css" media="screen">
    #glossary {
      border: 1px solid #999;
      width: 200px;
      margin: 10px 0;
    }
    #glossary dt,
    #glossary dd {
      display: inline;
    }
    #glossary dt:after {
      content: '\00A0\2013\00A0';
    }
    #glossary dd:after {
      content: '\A';
      white-space: pre;
    }
  </style>
</head>
<body>
<?php message(); ?>
<div id="content">
  <h1>Safari Enlarged Text + Generated Content Width Bug</h1>
  <p>When text is enlarged in Safari, generated content can cause text to be pushed outside of its bounding box.</p>
  <h2>Example</h2>
  <dl>
    <dt>Style Applied</dt>
    <dd><pre class="style"><code>
#glossary {
  border: 1px solid #999;
  width: 200px;
}
#glossary dt,
#glossary dd {
  display: inline;
}
#glossary dt:after {
  content: '\00A0\2013\00A0';
}
#glossary dd:after {
  content: '\A';
  white-space: pre;
}
</code></pre></dd>
    <dt><abbr title="eXtensible HyperText Markup Language">XHTML</abbr></dt>
    <dd><pre class="html"><code>
&#60;dl id=&#34;glossary&#34;&#62;
  &#60;dt&#62;XHTML&#60;/dt&#62;
  &#60;dd&#62;eXtensible HyperText Markup Language&#60;/dd&#62;
  &#60;dt&#62;KB&#60;/dt&#62;
  &#60;dd&#62;kilobytes&#60;/dd&#62;
  &#60;dt&#62;PDF&#60;/dt&#62;
  &#60;dd&#62;Portable Document Format&#60;/dd&#62;
&#60;/dl&#62;
</code></pre></dd>
    <dt>Working Example <em>(remember to enlarge your text)</em></dt>
    <dd>
      <dl id="glossary">
        <dt>XHTML</dt>
        <dd>eXtensible HyperText Markup Language</dd>
        <dt>KB</dt>
        <dd>kilobytes</dd>
        <dt>PDF</dt>
        <dd>Portable Document Format</dd>
      </dl>
    </dd>
    <dt>Screenshot (Safari 1.3 with text enlarged one step)</dt>
    <dd><img src="screenshot.png" width="230" height="102" alt="A screenshot of the error, taken in Safari 1.3 with text enlarged one step" /></dd>
  </dl>

  <h2>Solution</h2>
  <p>None as of now&#8230;</p>
  
</div>
<?php foot(); ?>
</body>
</html>