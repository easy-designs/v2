<?php

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>IE Underscore Bug</title>
<?php docHead(); ?>
  <style type="text/css" media="screen">
    span.rating {
      background: url(stars.jpg) top left repeat-x;
      display: block;
      height: 19px;
      text-indent: -999em;
    }
    span._2 {
      width: 42px;
    }
    span#_2 {
      width: 42px;
    }
  </style>
</head>
<body>
<?php message(); ?>
<div id="content">
  <h1>IE Underscore Bug Test</h1>
  <p><a href="http://www.w3.org/TR/REC-html40/struct/global.html#h-7.5.2">HTML Specification</a> does not allow use of a number in a <code>class</code> or <code>id</code>, it is suggested that you preceed a leading number with an underscore (_). Windows IE does not obey the rules set for a <code>class</code> or <code>id</code> beginning with an underscore.</p>

  <h2>Example 1: Underscore in <code>class</code></h2>
  <dl>
    <dt>Style Applied</dt>
    <dd><pre class="style"><code>
span.rating {
  border: 1px solid #fff;
  background: url(stars.jpg) top left repeat-x;
  display: block;
  height: 19px;
  text-indent: -999em;
}
span._2 {
  width: 42px;
}
</code></pre></dd>
    <dt>Code</dt>
    <dd><pre class="html"><code>
&#60;dl&#62;
  &#60;dt&#62;Your Rating:&#60;/dt&#62;
  &#60;dd&#62;&#60;span class=&#34;rating _2&#34;&#62;2 Stars&#60;/span&#62;&#60;/dd&#62;
&#60;/dl&#62;
</code></pre></dd>
    <dt>Example</dt>
    <dd>
      <dl>
        <dt>Your Rating:</dt>
        <dd><span class="rating _2">2 Stars</span></dd>
      </dl>
    </dd>
  </dl>
  
  <h2>Example 2: Underscore in <code>id</code></h2>
  <dl>
    <dt>Style Applied</dt>
    <dd><pre class="style"><code>
span.rating {
  border: 1px solid #fff;
  background: url(stars.jpg) top left repeat-x;
  display: block;
  height: 19px;
  text-indent: -999em;
}
span#_2 {
  width: 42px;
}
</code></pre></dd>
    <dt>Code</dt>
    <dd><pre class="html"><code>
&#60;dl&#62;
  &#60;dt&#62;Your Rating:&#60;/dt&#62;
  &#60;dd&#62;&#60;span id=&#34;_2&#34; class=&#34;rating&#34;&#62;2 Stars&#60;/span&#62;&#60;/dd&#62;
&#60;/dl&#62;
</code></pre></dd>
    <dt>Example</dt>
    <dd>
      <dl>
        <dt>Your Rating:</dt>
        <dd><span id="_2" class="rating">2 Stars</span></dd>
      </dl>
    </dd>
  </dl>

  <h2>Solution</h2>
  <p>None as of now&#8230; suggested that you avoid using an underscore to lead a <code>class</code> or <code>id</code>.</p>

</div>
<?php foot(); ?>
</body>
</html>