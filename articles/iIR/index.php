<?php

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>iIR: img Image Replacement</title>
<?php docHead(); ?>
</head>
<body>
<?php message(); ?>
<div id="content">
  <h1><abbr title="img Image Replacement">iIR</abbr>: <code>img</code> Image Replacement</h1>
  <h3>By Aaron Gustafson</h3>
  
  <p>There&#8217;s been lots of discussion with regard to best practices when replacing text with an image using <abbr title="Cascading Style Sheets">CSS</abbr>, but very little discussion of replacing one image with another in media-specific instances. Ross Howard explored the concept in <a href="http://www.alistapart.com/articles/hiresprinting">his <cite><abbr title="A List Apart">ALA</abbr></cite> article on hi-res images for print</a>, but beyond that it isn&#8217;t a topic that has come up much.</p>
  <p>While working on a project for <a href="http://www.twinings.com">a purveyor of fine teas</a>, I decided to experiment with some image replacement of my own. The design called for a header graphic with a ripple effect, upon which the logo and some navigational elements were placed:</p>
  <img src="images/design.jpg" alt="A sample from the design I needed to recreate" />
  <p>I wanted to accomplish this with as little markup as possible and here&#8217;s what I came up with:</p>
  <pre class="html"><code>&#60;h1 id=&#34;branding&#34;&#62;
  &#60;img src=&#34;/images/logo-print.jpg&#34; alt=&#34;Twinings of London&#34; /&#62;
&#60;/h1&#62;</code></pre>
  <p>This markup sets up the print-friendly logo (logo-print.jpg) as the default image <em>and</em> as the most important heading on the page (which, as this example is from the homepage, it is). Consider it a bit of a nod to <a href="http://www.simplebits.com/notebook/2005/10/05/bplogos.html">Dan Cederholm&#8217;s bulletprof logos</a> too. This is also the image we will be replacing using what I call <abbr title="img Image Replacement">iIR</abbr> (<code>img</code> Image Replacement).</p>
  <p>In the past, I would have added extra markup to create the header (perhaps a <code>div</code>) and simply moved the image out of view by applying <a href="http://phark.typepad.com/phark/2003/08/accessible_imag.html">the Phark method</a> to the <code>h1</code> (which works well on <code>img</code>s set to <code>display: inline</code>). The problem with this technique was that you lose the <code>alt</code> text if images are turned off but <abbr title="Cascading Style Sheets">CSS</abbr> is on. Also, in an effort to keep the markup clean, I was already planning to use the <code>h1</code> to set up the header graphic:</p>
  <pre class="style"><code>#branding {
  background: #ad0910 url(/images/layout/header.jpg) top left no-repeat;
  margin: 0;
  height: 99px;
}</code></pre>
  <p>I was determined to add no additional markup, so I decided to explore other options. The <a href="http://www.moronicbajebus.com/playground/cssplay/image-replacement/">Leahy</a>/<a href="http://www.kryogenix.org/code/browser/lir/">Langridge</a> Method came to mind. I wasn&#8217;t sure how it would work on a <a href="http://www.w3.org/2003/glossary/keyword/All/?keywords=replaced%20element">replaced element</a> like <code>img</code>, but decided to give it a shot. I started with the print-friendly logo positioned where I wanted it (borders have been added to outline the size of the <code>img</code> element):</p>
  <pre class="style"><code>#branding img {
  position: absolute;
  top: 3px;
  left: 10px;
}</code></pre>
  <img src="images/image-positioned.jpg" alt="A screenshot of the print-friendly image positioned over the background (borders added for emphasis)" />
  <p>The next step was to set the img to <code>display: block</code>, apply the screen version of the logo as a background image and pad the top of the <code>img</code> to push the print version down to reveal the screen version (<code>width</code> is also set for good measure):</p>
  <pre class="style"><code>#branding img {
<strong>  background: url(/images/logo.png) top left no-repeat;
  display: block;
  padding-top: 93px;
  width: 129px;</strong>
  position: absolute;
  top: 3px;
  left: 10px;
}</code></pre>
  <img src="images/image-padded.jpg" alt="A screenshot of the print-friendly image pushed down by padding-top to reveal the background image of the screen logo (borders added for emphasis)" />
  <p>Finally, I cropped out the print version by setting the <code>height</code> of the <code>img</code> to 0:</p>
  <pre class="style"><code>#branding img {
  background: url(/images/logo.png) top left no-repeat;
  display: block;
  padding-top: 93px;
  <strong>height: 0;</strong>
  width: 129px;
  position: absolute;
  top: 3px;
  left: 10px;
}</code></pre>
  <img src="images/image-cropped.jpg" alt="A screenshot of the print-friendly image cropped out of view to show only the screen logo (borders added for emphasis, print-image opacity reduced to imply it not being seen)" />
  <p>Much to my surprise, this technique is widely supported in all modern browsers, including <abbr title="Internet Explorer 6">IE6</abbr>. And, the best part is that the <code>alt</code> text is still available with <abbr title="Cascading Style Sheets">CSS</abbr> on and images turned off:</p>
  <img src="images/images_off.jpg" alt="A screenshot of the page with CSS on, but images turned off" />
  <p>I think the concept of <abbr title="img Image Replacement">iIR</abbr> can be explored a lot more in-depth, possibly as an alternative to Russ&#8217; approach to using hi-res, print-friendly images on our sites. The bonus of this approach (as opposed to Russ&#8217;) is that we don&#8217;t have to resort to adding extra markup to do it.</p>
  <p>Here&#8217;s the final version, <dfn lang="la" title="without">sans</dfn> borders:</p>
  <img src="images/design.jpg" alt="A screenshot of the final layout." />
  <div id="extras">
    <h2>Questions/Comments</h2>
    <p>I will be happy to take any questions or comments about this article in <a href="http://www.easy-reader.net/archives/2006/01/09/repetition-and-replacement/">it&#8217;s associated blog entry</a>.</p>
  </div>
</div>
<?php foot(); ?>

</body>
</html>