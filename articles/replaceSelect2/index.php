<?php

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>&#60;select&#62; Something New, Part 2</title>
<?php docHead(); ?>
</head>
<body>
<?php message(); ?>
<div id="content">
  <h1><code>&#60;select&#62;</code> Something New, Part 2</h1>
  <h3>By Aaron Gustafson</h3>
  
  <p>When we last left our faux-<code>&#60;select&#62;</code>, we had a <a href="/articles/replaceSelect/files/final.html">highly usable select replacement</a>, but it wasn&#8217;t quite as accessible as it should be. In order to make the faux-<code>&#60;select&#62;</code> truly accessible, users need to be able to use it with more than just a mouse. Keyboard controls are the most widely supported mouse alternative, so this article will address supporting them within the framework of our faux-<code>&#60;select&#62;</code>.</p>
  
  <h2>Setting the stage</h2>
  <p>In order to best demonstrate this technique in action, we should start with a <a href="/articles/replaceSelect2/files/1.html">more complete form example</a>. Our goal is to support keyboard control for our faux-<code>&#60;select&#62;</code>, which translates to the following specific goals:</p>
  <ol>
    <li>support <kbd>tab</kbd>-ing to/from the faux-<code>&#60;select&#62;</code> (using <code>tabindex</code>)</li>
    <li>allow users to &#8220;navigate&#8221; the faux-<code>&#60;select&#62;</code> using only the keyboard</li>
  </ol>
  <p>It is important to note that, as of the writing of this article, <a href="http://www.apple.com/macosx/features/safari/">Safari</a> ignores <code>tabindex</code> on a <code>&#60;select&#62;</code> and, rather than looking for some hack-ish way to force <a href="http://www.apple.com/macosx/features/safari/">Safari</a> to do what it should be doing already, we will operate under the assumption that the developers will fix this issue shortly. It is also important to note that there are many differences in the ways browsers implement keyboard &#8220;navigation&#8221; within a <code>&#60;select&#62;</code>. Every one I&#8217;ve tested supports the up and down arrow keys for moving forward and backward in the list, but support varies for the following:</p>
  <ul>
    <li>left/right arrow for moving backward/forward (respectively)</li>
    <li><kbd>page up</kbd>/<kbd>page down</kbd> to go to the beginning/end (respectively)</li>
    <li><kbd>home</kbd>/<kbd>end</kbd> to go to the beginning/end of the list (respectively)</li>
  </ul>
  <p>I am not going to bother chronicling the supported keystrokes for each browser, as that is beyond the scope of this article, but you can rest assured that this script will be able to tie into whatever keystrokes are normally supported in a user&#8217;s browser of choice.</p>

  <h2>A little tidying up</h2>
  <p>After finishing <a href="/articles/replaceSelect/">Part 1</a>, I revisited some of the code to further optimize it. The major change was dumping</p>

  <pre class="script"><code>function selectReplacement(obj) {
  &#8230;
  // iterate through them to look for the selected one
  for (var i=0; i&#60;opts.length; i++) {
    // create a variable to store the selected option
    var selectedOpt;
    // check for the selected option (defaults to the first option)
    if (opts[i].selected) { // this option is selected
      // store the option's position in the array
      selectedOpt = i;
      // leave the loop so we don't lose the value
      break;
    } else { // no selected option
             // the first one should show
      selectedOpt = 0;
    }
  }
  &#8230;
}</code></pre>

  <p>in favor of</p>

  <pre class="script"><code>function selectReplacement(obj) {
  &#8230;
  <strong>// grab the selected option or default to 0
  var selectedOpt = (!obj.selectedIndex) ? 0 : obj.selectedIndex;</strong>
  &#8230;
}</code></pre>

  <p><a href="/articles/replaceSelect2/files/2.html">The change</a> does not affect behavior in the least; it does, however, save some time and <abbr title="Central Processing Unit">CPU</abbr> cycles. For those unfamiliar with <a href="http://en.wikipedia.org/wiki/%3F:">ternary operators</a>, this line sets our variable <var>selectedOpt</var> equal to <var>obj</var>&#8217;s <code>selectedIndex</code> if it has one, or to 0 if it doesn&#8217;t.</p>

  <h2>The plan</h2>
  <p>Alright, before we begin the first new line of code, we need to construct a logical, goal-oriented plan for this project.</p>
  <p>The first task is to allow focus to be brought to the faux-<code>&#60;select&#62;</code>. Now, since we want to have the faux-<code>&#60;select&#62;</code> respond to keystrokes while focused, it makes the most sense to tie its behavior to that of our replaced <code>&#60;select&#62;</code>. Therefore, we need some way to provide feedback to the user when they are &#8220;focused&#8221; on the faux-<code>&#60;select&#62;</code>. We can leave the <code>tabindex</code> assigned to the replaced <code>&#60;select&#62;</code> and trigger events with <code>onfocus</code> and <code>onblur</code> to change the visual appearance of the faux-<code>&#60;select&#62;</code>. This way, we are providing visual feedback to people who use keyboard navigation for forms while still allowing vision-impaired users to have the same experience they normally would from a <code>&#60;select&#62;</code> (<code>label</code> reading, <abbr lang="la" title="et cetera meaning &#8220;and so forth&#8221;">etc.</abbr>).</p>
  <p>The second part of this project involves updating the faux-<code>&#60;select&#62;</code>&#8217;s displayed value (providing visual feedback) as a user &#8220;navigates&#8221; it with his/her keyboard. The best way to provide this feedback is to hook into the <code>onchange</code> event for the replaced <code>&#60;select&#62;</code>, so that it triggers the faux-<code>&#60;select&#62;</code> to update each time a user moves up or down in the list. There are some hurdles to overcome in performing this (due to browser differences) and those will be discussed further on in this article.</p>

  <h2>Taking care of <code>tabindex</code></h2>
  <p>As our plan calls for the <code>onfocus</code> and <code>onblur</code> events of the replaced <code>&#60;select&#62;</code> to trigger a visual cue that the faux-<code>&#60;select&#62;</code> is active, we need to bring the replaced <code>&#60;select&#62;</code> back into the tab order. In the previous article, we hid the replaced <code>&#60;select&#62;</code> by styling it as <code>display: none</code>, which causes it to be skipped in the <kbd>tab</kbd> order. To put it back in the flow, we need it to be visible, but still hidden from view. There are numerous ways to accomplish this. For this article&#8217;s purposes, we&#8217;ll change the <code>select.replaced</code> rule to the following:</p>

  <pre class="style"><code>select.replaced {
  <strong>width: 1px;
  position: absolute;
  left: -999em;</strong>
}</code></pre>

  <p>which removes it from sight, but keeps it <kbd>tab</kbd>-able.</p>

  <p>Now that <a href="/articles/replaceSelect2/files/3.html">we can <kbd>tab</kbd> to the replaced <code>&#60;select&#62;</code></a>, we can go about adding the behavior necessary to offer the user a visual cue that the faux-<code>&#60;select&#62;</code> is active. We can do this in our <code>selectReplacement</code> function by having the select add a class to the faux-<code>&#60;select&#62;</code> <code>&#60;ul&#62;</code> when the replaced select (<var>obj</var>) is focused, and resetting the class on the <code>&#60;ul&#62;</code> when the <code>&#60;select&#62;</code> is blurred:</p>
  
  <pre class="script"><code>function selectReplacement(obj) {
  &#8230;
  <strong>// add the selectFocused class to the faux-&#60;select&#62; 
  // when the real &#60;select&#62; is focused
  obj.onfocus = function() {
    ul.className += ' selectFocused';
  };
  // reset the class on the faux-&#60;select&#62; 
  // when the real &#60;select&#62; is blurred
  obj.onblur = function() {
    ul.className = 'selectReplacement';
  };</strong>
  &#8230;
}</code></pre>

  <p>In this particular example, we&#8217;ll make the visual cue a change of background for the faux-<code>&#60;select&#62;</code>:</p>
  <pre class="style"><code>ul.selectFocused {
  background-image: url(top-focus.jpg);
}</code></pre>

  <p>And there you have it, <a href="/articles/replaceSelect2/files/4.html">a faux-<code>&#60;select&#62;</code> which mimics focus when its associated <code>&#60;select&#62;</code> is <kbd>tab</kbd>-ed to</a>.</p>

  <h2>Updating the faux-<code>&#60;select&#62;</code></h2>
  <p>In the <a href="/articles/replaceSelect/">Part 1</a>, our data flow was in one direction, from the faux-<code>&#60;select&#62;</code> to the replaced one; now, we are going in the other direction. As mentioned in our plan, we want to hook into the <code>onchange</code> event for the replaced <code>&#60;select&#62;</code> so we can grab the current value and update the faux-<code>&#60;select&#62;</code> to mirror it. This can be accomplished by adding this short event function to <code>selectReplacement()</code>:</p>

  <pre class="script"><code>function selectReplacement(obj) {
  &#8230;
  <strong>// when the user changes the item within the &#60;select&#62;, 
  // update the faux-&#60;select&#62; accordingly
  obj.onchange = function() {
    // get the selectedIndex and...
    var idx = this.selectedIndex;
    // pass it to the selectMe function
    selectMe(ul.childNodes[idx]);
  };</strong>
  &#8230;
}</code></pre>

  <p>At this point <a href="/articles/replaceSelect2/files/5.html">things get a little hairy</a>.</p>

  <h3>Aside: the <code>&#60;select&#62;</code> and <code>onchange</code></h3>
  <p>I prefer to do much of my initial development testing in <a href="http://www.mozilla.org/products/firefox/">Firefox</a>, primarily because I find the <a href="http://chrispederick.com/work/firefox/webdeveloper/">Web Developer Toolbar</a>, <a href="https://addons.update.mozilla.org/extensions/moreinfo.php?application=firefox&category=Developer%20Tools&numpg=10&id=271">ColorZilla</a>, JavaScript Console and <a href="http://www.mozilla.org/projects/inspector/"><abbr title="Document Object Model">DOM</abbr> Inspector</a> to be indispensable tools. For the most part, <a href="http://www.mozilla.org/products/firefox/">Firefox</a> (and <a href="http://www.mozilla.org/">Mozilla</a> browsers in general) has great support for web standards and accessibility, but I did come across one oddity that threw me for a loop. It seems <a href="http://www.mozilla.org/">Mozilla</a> has the only family of modern browsers (in my experience, at least) which does not register the <code>onchange</code> event when the keyboard is used to change the value of a <code>&#60;select&#62;</code>. These browsers only register an <code>onchange</code> event when focus is taken away from the <code>&#60;select&#62;</code>. This follows the guidelines in the <a href="http://www.w3.org/TR/html401/"><abbr title="HyperText Markup Language">HTML</abbr> 4.01 <abbr title="specification">spec</abbr></a>:</p>
  <blockquote cite="http://www.w3.org/TR/html401/interact/scripts.html#h-18.2.3">
    <p>The <code>onchange</code> event occurs when a control loses the input focus and its value has been modified since gaining focus. This attribute applies to the following elements: <code>INPUT</code>, <code>SELECT</code>, and <code>TEXTAREA</code>.</p>
  </blockquote>
  <p>but it does not follow the accessibility recommendations set forth in <a href="http://www.w3.org/WAI/UA/TS/html401/Overview.html"><abbr title="User Agent Accessibility Guidelines">UAAG</abbr> 1.0 Test Suite for HTML 4.01</a> in <a href="http://www.w3.org/WAI/UA/TS/html401/cp0102/0102-ONCHANGE-SELECT.html">Checkpoint 1.2, Provision 1</a>:</p>
  <blockquote cite="http://www.w3.org/WAI/UA/TS/html401/cp0102/0102-ONCHANGE-SELECT.html">
    <dl>
      <dt>Checkpoint 1.2 Activate event handlers (Priority 1)</dt>
      <dd>Provision 1: Allow the user to activate, through keyboard input alone, all input device event handlers that are explicitly associated with the element designated by the content focus.
Using the keyboard or an assistive technology that emulates the keyboard, select a value from the menu to trigger the onChange event.</dd>
    </dl>
  </blockquote>
  <p><a href="http://www.w3.org/WAI/UA/TS/html401/cp0905/0905-ONCHANGE.html">Checkpoint 9.5, Provision 1</a> also touches on a related, though contradictory, premise:</p>
  <blockquote cite="http://www.w3.org/WAI/UA/TS/html401/cp0905/0905-ONCHANGE.html">
    <dl>
      <dt>Checkpoint 9.5 No events on focus change (Priority 2)</dt>
      <dd>Provision 1: Allow configuration so that moving the content focus to or from an enabled element does not automatically activate any explicitly associated event handlers of any event type.</dd>
    </dl>
  </blockquote>
  <p>What&#8217;s a web developer to do? Well, it is my opinion that in the case of a conflict between the <abbr title="specification">spec</abbr> and accessibility, assuming a good case can be made for the accessibility side, accessibility should win.</p>
  <p>That said, we need a way to make <a href="http://www.mozilla.org/">Mozilla</a> browsers behave like the other browsers do, so we can tie into the <code>onchange</code> event of the original <code>&#60;select&#62;</code>. At first, I created a function to run when the <code>onkeydown</code> event took place on the <code>&#60;select&#62;</code>. It checked for certain keys (<kbd>up</kbd>, <kbd>down</kbd>, <kbd>left</kbd>, <kbd>right</kbd>, <kbd>home</kbd>, <kbd>end</kbd>, <abbr lang="la" title="et cetera meaning &#8220;and so forth&#8221;">etc.</abbr>) and then triggered the faux-<code>&#60;select&#62;</code> to change the displayed list item accordingly:</p>
  
  <pre class="script"><code>function selectReplacement(obj) {
  ...
  // when a key is pressed, get its keyCode and perform
  // the required actions to update the faux-&#60;select&#62;
  obj.onkeydown = function(event) {
    // grab the selectedIndex
    var idx = this.selectedIndex;
    // decide what do do based on the keyCode
    switch (event.keyCode) {
      // move to previous item
      case 37: // left
      case 38: // up
        if (this.prev &#62;= 0) {
          selectMe(ul.childNodes[idx-1]);
        }
        break;
      // move to next item
      case 39: // right
      case 40: // down
        if (this.next &#60; ul.childNodes.length) {
          selectMe(ul.childNodes[idx+1]);
        }
        break;
      // go to the beginning of the list
      case 33: // page up
      case 36: // home
        selectMe(ul.firstChild);
        break;
      // go to the end of the list
      case 34: // page down
      case 35: // end
        selectMe(ul.lastChild);
        break;
    } 
  };
  &#8230;
}</code></pre>

  <p>This worked fine in every browser but Opera, which for some reason kept <a href="/articles/replaceSelect2/files/6.html">jumping to every other item, up and down the list</a>. Obviously, this won&#8217;t do, so I began looking for another way to make <a href="http://www.mozilla.org/">Mozilla</a> behave the way we need it to (and, in my opinion, feel it should) and, after banging my head against the wall for nearly a day, I came up with this simple way of equalizing the event models:</p>

  <pre class="script"><code>function selectReplacement(obj) {
  &#8230;
  <strong>// equalize the event models of onkeypress and onchange
  // for the replaced &#60;select&#62;
  obj.onkeypress = obj.onchange;</strong>
  &#8230;
}</code></pre>

  <p>It&#8217;s my experience that the simplest solutions often aren&#8217;t the most obvious and forthcoming ones, at least not in my brain.</p>
  
  <h2>Conclusion</h2>
  <p>All told, <a href="/articles/replaceSelect2/files/final.html">making the faux-<code>&#60;select&#62;</code> more accessible</a> is not all that taxing (apart from working around a few browser deficiencies/idiosyncrasies). It just goes to show that accessibility can be a quick win if you make smart decisions.</p>
  <p>As mentioned in <a href="/articles/replaceSelect/">Part 1</a>, we&#8217;re not stopping here: Part 3 will explore a faux-<code>&#60;select&#62;</code> with organizational <code>&#60;optgroup&#62;</code>s and Part 4 will examine a faux multiple-<code>&#60;select&#62;</code>s. We received an email asking for a Part 5, to address the creation of a combo box (a <code>&#60;select&#62;</code> which switches to an input when you select a value like &#8220;other&#8221;), and we&#8217;ve decided to grant that request, so there is even more to come in this series. I better get cracking.</p>

  <div id="extras">
    <h2>Get the Source</h2>
    <p>You can download the files that go with this article in a single compressed archive: <a href="/articles/replaceSelect2/replaceSelect2_files.zip">replaceSelect2_files.zip</a></p>
  </div>
</div>
<?php foot(); ?>

</body>
</html>