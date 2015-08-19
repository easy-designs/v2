<?

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>jsTrace &#172; Easy Designs</title>
<?php docHead(); ?>
</head>
<body>
<?php message(); ?>
<div id="content">
  <h1>jsTrace</h1>
  
  <h2 id="genInfo">General Information</h2>
  <dl>
    <dt>Purpose</dt>
    <dd>This script is an attempt to replicate the functionality of ActionScript&#8217;s Trace window in JavaScript (to get rid of those nasty alert boxes usually used when debugging).</dd>
    <dt>Current Version</dt>
    <dd>1.3 (1 November 2005)</dd>
    <dt>Requirements</dt>
    <dd>If you would like a draggable window, it requires <a href="http://www.youngpup.net/">Aaron Boodman</a>&#8217;s <a href="http://www.youngpup.net/2001/domdrag"><abbr title="Document Object Model">DOM</abbr> Drag Library</a> (included with the &#8220;drag&#8221; distribution)</dd>
  </dl>
  
  <h2 id="use">Use</h2>
  <p>In the head of your document, include the JavaScript file(s):</p>
  <pre class="html"><code>&#60;script type=&#34;text/javascript&#34; src=&#34;/path/to/jsTrace.js&#34;&#62;&#60;/script&#62;
&#60;script type=&#34;text/javascript&#34; src=&#34;/path/to/dom-drag.js&#34;&#62;&#60;/script&#62;</code></pre>
  <p>Then, simply add the following function to your main JavaScript file (or a library you use) to allow you to trace messages to the window:</p>
  <pre class="script"><code>function trace( msg ){
  if( typeof( jsTrace ) != 'undefined' ){
    jsTrace.send( msg );
  }
}</code></pre>
  <p>Whenever you want to trace something to the window, simply call <code>trace()</code>:</p>
  <pre class="script"><code>trace( 'This message goes to the window' );</code></pre>
  <p>The best part is, when you are finished debugging, you leave the <code>trace</code> calls in your code and can simply delete the references to the two JavaScript files from the head of your document and it will not cause JavaScript errors.</p>
  
  <h2 id="demo">Demo</h2>
  <p>You can <a href="/code/jsTrace/demo.html">view this script in action</a> if you have a modern browser. The window is draggable and resizable. You can also clear the window or set a delimeter to mark your place.</p>

  <h2 id="changeLog">Change Log</h2>
  <dl>
    <dt>1.0 (26 October 2005)</dt>
    <dd>Initial script</dd>
    <dt>1.1 (29 October 2005)</dt>
    <dd>
      <ul>
        <li>&#8220;Memory&#8221; enhancement (by <a href="">Joe Shelby</a>) added (position &#38; size remembered via an open cookie).</li>
        <li>Size of additional tools text increased</li>
        <li>Streamlined creation of new tools (for future development)</li>
        <li>Added generic timer function (for future development)</li>
        <li><code>jsTrace.kill</code> renamed <code>jsTrace.killWindow</code></li>
      </ul>
    </dd>
    <dt>1.2 (30 October 2005)</dt>
    <dd>Added buffer for traces executed before the window is drawn</dd>
    <dt>1.3 (1 November 2005)</dt>
    <dd>Buffer fix for IE and viewport now scrolls with the content (newest lines show by default)</dd>
  </dl>
  
  <h2 id="downloads">Optimized Releases</h2>
  <p>These releases have been optimized for production by removing unnecessary white space, carriage returns, <abbr lang="la" title="et cetera meaning &#8220;and so forth&#8221;">etc.</abbr></p>
  <ul>
    <li><a href="/code/jsTrace/1.3/jsTrace-v1.3-drag.zip">Compressed 1.3 (Draggable)</a> [3.54<abbr title="kilobytes">kB</abbr> .zip archive]</li>
    <li><a href="/code/jsTrace/1.3/jsTrace-v1.3-nodrag.zip">Compressed 1.3 (Not Draggable)</a> [2.43<abbr title="kilobytes">kB</abbr> .zip archive]</li>
    <li><a href="/code/jsTrace/1.2/jsTrace-v1.2-drag.zip">Compressed 1.2 (Draggable)</a> [3.48<abbr title="kilobytes">kB</abbr> .zip archive]</li>
    <li><a href="/code/jsTrace/1.2/jsTrace-v1.2-nodrag.zip">Compressed 1.2 (Not Draggable)</a> [2.36<abbr title="kilobytes">kB</abbr> .zip archive]</li>
    <li><a href="/code/jsTrace/1.1/jsTrace-v1.1-drag.zip">Compressed 1.1 (Draggable)</a> [3.43<abbr title="kilobytes">kB</abbr> .zip archive]</li>
    <li><a href="/code/jsTrace/1.1/jsTrace-v1.1-nodrag.zip">Compressed 1.1 (Not Draggable)</a> [2.32<abbr title="kilobytes">kB</abbr> .zip archive]</li>
    <li><a href="/code/jsTrace/1.0/jsTrace-v1.0-drag.zip">Compressed 1.0 (Draggable)</a> [3.03<abbr title="kilobytes">kB</abbr> .zip archive]</li>
    <li><a href="/code/jsTrace/1.0/jsTrace-v1.0-nodrag.zip">Compressed 1.0 (Not Draggable)</a> [1.91<abbr title="kilobytes">kB</abbr> .zip archive]</li>
  </ul>
  
  <h2 id="development">Development Version</h2>
  <p>If you are interested in helping to further develop this script, you can <a href="/code/jsTrace/working/jsTrace.js" title="Uncompressed Development Version [11.1Kb]">download the uncompressed JavaScript source file</a>.</p>
  
  <div id="extras">
  </div>
</div>
<?php foot(); ?>

</body>
</html>
