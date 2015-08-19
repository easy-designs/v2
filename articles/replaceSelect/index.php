<?php

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title> &#60;select&#62; Something New Part 1</title>
<?php docHead(); ?>
</head>
<body>
<?php message(); ?>
<div id="content">
  <h1><code>&#60;select&#62;</code> Something New, Part 1</h1>
  <h3>By Aaron Gustafson</h3>

  <p>So you&#8217;ve built a beautiful, standards-compliant site utilizing the latest and greatest <acronym title="Cascading Style Sheets">CSS</acronym> techniques. You&#8217;ve mastered control of styling every element, but in the back of your mind, a little voice is nagging you about how ugly your <code>&#60;select&#62;</code>s are. Well, today we&#8217;re going to explore a way to silence that little voice and truly complete our designs. With a little <acronym title="Document Object Model">DOM</acronym> scripting and some creative <acronym title="Cascading Style Sheets">CSS</acronym>, you too can make your <code>&#60;select&#62;</code>s beautiful&#8230; and you won&#8217;t have to sacrifice accessibility, usability or graceful degradation.</p>

  <h2>The Problem</h2>
  <p>We all know the <code>&#60;select&#62;</code> is just plain ugly. In fact, many try to limit its use to avoid its classic web circa 1994 inset borders. We should not avoid using the <code>&#60;select&#62;</code> though&#8212;it is an important part of the current form toolset; we should embrace it. That said, some creative thinking can improve it.</p>

  <h2>The <code>&#60;select&#62;</code></h2>
  <p>We&#8217;ll use a simple &#60;select&#62; for our example:</p>
  
  <pre class="html"><code>&#60;select id=&#34;something&#34; name=&#34;something&#34;&#62;
  &#60;option value=&#34;1&#34;&#62;This is option 1&#60;/option&#62;
  &#60;option value=&#34;2&#34;&#62;This is option 2&#60;/option&#62;
  &#60;option value=&#34;3&#34;&#62;This is option 3&#60;/option&#62;
  &#60;option value=&#34;4&#34;&#62;This is option 4&#60;/option&#62;
  &#60;option value=&#34;5&#34;&#62;This is option 5&#60;/option&#62;
&#60;/select&#62;</code></pre>
  
  <p>[Note: It is implied that this <code>&#60;select&#62;</code> is in the context of a <a href="files/1.html">complete form</a>.]</p>
  <p>So we have five <code>&#60;option&#62;</code>s within a <code>&#60;select&#62;</code>. This <code>&#60;select&#62;</code> has a uniquely assigned <code>id</code> of &#8220;something.&#8221; Depending on the browser/platform you&#8217;re viewing it on, your <code>&#60;select&#62;</code> likely looks roughly like this:</p>
  
  <img src="images/ffSelect.png" alt="A &#60;select&#62; as rendered in Windows XP/Firefox 1.0.2." />
  
  <p>or this</p>
  
  <img src="images/safariSelect.png" alt="A &#60;select&#62; as rendered in Mac OSX/Safari 1.2." />
  
  <p>Let&#8217;s say we want to make it look a little more modern, perhaps like this:</p>
  
  <img src="images/desiredSelect.png" alt="Our concept of a nicely-styled &#60;select&#62;." />
  
  <p>So how do we do it? Keeping the basic <code>&#60;select&#62;</code> is not an option. Apart from basic background color, font and color adjustments, you don&#8217;t really have a lot of control over the &#60;select&#62;.</p>
  <p>However, we can mimic the superb functionality of a <code>&#60;select&#62;</code> in a new form control without sacrificing semantics, usability or accessibility. In order to do that, we need to examine the nature of a <code>&#60;select&#62;</code>.</p>
  <p>A <code>&#60;select&#62;</code> is, essentially, an unordered list of choices in which you can choose a single value to submit along with the rest of a form. So, in essence, it&#8217;s a <code>&#60;ul&#62;</code> on steroids. Continuing with that line of thinking, we can replace the <code>&#60;select&#62;</code> with an unordered list, as long as we give it some enhanced functionality. As <code>&#60;ul&#62;</code>s can be styled in a myriad of different ways, we&#8217;re almost home free. Now the questions becomes &#8220;how to ensure that we maintain the functionality of the <code>&#60;select&#62;</code> when using a <code>&#60;ul&#62;</code>?&#8221; In other words, how do we submit the correct &#60;option&#62; value along with the form, if we are no longer using a form control?</p>

  <h2>The solution</acronym></h2>
  <p>Enter the <acronym title="Document Object Model">DOM</acronym>. The final step in the process is making the <code>&#60;ul&#62;</code> function/feel like a <code>&#60;select&#62;</code>, and we can accomplish that with JavaScript/<acronym title="Euopean Computer Manufacturers Association">ECMA</acronym> Script and a little clever <acronym title="Cascading Style Sheets">CSS</acronym>. Here is the basic list of requirements we need to have a functional faux <code>&#60;select&#62;</code>:</p>
  <ul>
    <li>click the list to open it,</li>
    <li>click on list items to change the value assigned &#38; close the list,</li>
    <li>show the default value when nothing is selected, and</li>
    <li>show the chosen list item when something is selected.</li>
  </ul>
  <p>With this plan, we can begin to tackle each part in succession.</p>
  
  <h3>Building the list</h3>
  <p>So first we need to collect all of the attributes and &#60;option&#62;s out of the &#60;select&#62; and rebuild it as a &#60;ul&#62;. We accomplish this by running the following <abbr title="JavaScript">JS</abbr>:</p>
  
  <pre class="script"><code>function selectReplacement(obj) {
  var ul = document.createElement('ul');
  ul.className = 'selectReplacement';
  // collect our object&#8217;s options
  var opts = obj.options;
  // iterate through them, creating &#60;li&#62;s
  for (var i=0; i&#60;opts.length; i++) {
    var li = document.createElement('li');
    var txt = document.createTextNode(opts[i].text);
    li.appendChild(txt);
    ul.appendChild(li);
  }
  // add the ul to the form
  obj.parentNode.appendChild(ul);
}</code></pre>
  
  <p>You might be thinking &#8220;now what happens if there is a selected <code>&#60;option&#62;</code> already?&#8221; We can account for this by adding another loop before we create the <code>&#60;li&#62;</code>s to look for the selected <code>&#60;option&#62;</code>, and then store that value in order to <code>class</code> our selected <code>&#60;li&#62;</code> as &#8220;selected&#8221;:</p>
  
  <pre class="script"><code>&#8230;
  var opts = obj.options;
  <strong>// check for the selected option (default to the first option)
  for (var i=0; i&#60;opts.length; i++) {
    var selectedOpt;
    if (opts[i].selected) {
      selectedOpt = i;
      break; // we found the selected option, leave the loop
    } else {
      selectedOpt = 0;
    }
  }</strong>
  for (var i=0; i&#60;opts.length; i++) {
    var li = document.createElement('li');
    var txt = document.createTextNode(opts[i].text);
    li.appendChild(txt);
    <strong>if (i == selectedOpt) {
      li.className = 'selected';
    }</strong>
    ul.appendChild(li);
&#8230;</code></pre>
  <p>[Note: From here on out, option 5 will be selected, to demonstrate this functionality.]</p>
  <p>Now, we can run this function on every <code>&#60;select&#62;</code> on the page (in our case, one) with the following:</p>

  <pre class="script"><code>function setForm() {
  var s = document.getElementsByTagName('select');
  for (var i=0; i&#60;s.length; i++) {
    selectReplacement(s[i]);
  }
}
window.onload = function() {
  setForm();
}</code></pre>
  
  <p>We are <a href="files/2.html">nearly there</a>; let&#8217;s add some style.</p>
  
  <h3>Some clever <acronym title="Cascading Style Sheets">CSS</acronym></h3>
  <p>I don&#8217;t know about you, but I am a huge fan of <acronym title="Cascading Style Sheets">CSS</acronym> dropdowns (especially the <a href="http://htmldog.com/articles/suckerfish/" title="Check out the Suckerfish family at HTMLDog.com.">Suckerfish</a> variety). I&#8217;ve been working with them for some time now and it finally dawned on me that a <code>&#60;select&#62;</code> is pretty much like a dropdown menu, albeit with a little more going on under the hood. Why not apply the same stylistic theory to our faux-<code>&#60;select&#62;</code>? The basic style goes something like this:</p>
    <pre class="style"><code>ul.selectReplacement {
  margin: 0;
  padding: 0;
  height: 1.65em;
  width: 300px;
}
ul.selectReplacement li {
  background: #cf5a5a;
  color: #fff;
  cursor: pointer;
  display: none;
  font-size: 11px;
  line-height: 1.7em;
  list-style: none;
  margin: 0;
  padding: 1px 12px;
  width: 276px;
}
ul.selectOpen li {
  display: block;
}
ul.selectOpen li:hover {
  background: #9e0000;
  color: #fff;
}</code></pre>
  
  <p>Now, to handle the &#8220;selected&#8221; list item, we need to get a little craftier:</p>
  
  <pre class="style"><code>ul.selectOpen li {
  display: block;
}
<strong>ul.selectReplacement li.selected {
  color: #fff;
  display: block;
}
ul.selectOpen li.selected {
  background: #9e0000;
  display: block;
}</strong>
ul.selectOpen li:hover<strong>,
ul.selectOpen li.selected:hover</strong> {
  background: #9e0000;
  color: #fff;
}</code></pre>

  <p>Notice that we are not using the :hover pseudo-class for the <code>&#60;ul&#62;</code> to make it open, instead we are <code>class</code>-ing it as &#8220;selectOpen&#8221;. The reason for this is two-fold:</p>
  <ol>
    <li><acronym title="Cascading Style Sheets">CSS</acronym> is for presentation, not behavior; and</li>
    <li>we want our faux-<code>&#60;select&#62;</code> behave like a real <code>&#60;select&#62;</code>, we need the list to open in an <code>onclick</code> event and not on a simple mouse-over.</li>
  </ol>
  <p>To implement this, we can take what we learned from Suckerfish and apply it to our own JavaScript by dynamically assigning and removing this <code>class</code> in <code></code>onclick</code> events for the list items. To do this right, we will need the ability to change the <code>onclick</code> events for each list item on the fly to switch between the following two actions:</p>
  <ol>
    <li>show the complete faux-<code>&#60;select&#62;</code> when clicking the selected/default option when the list is collapsed; and</li>
    <li>&#8220;select&#8221; a list item when it is clicked &#38; collapse the faux-<code>&#60;select&#62;</code>.</li>
  </ol>
  <p>We will create a function called <code>selectMe()</code> to handle the reassignment of the &#8220;selected&#8221; <code>class</code>, reassignment of the <code>onclick</code> events for the list items, and the collapsing of the faux-<code>&#60;select&#62;</code>:</p>

  <pre class="script"><code></code></pre>
  
  <p>As the original Suckerfish taught us, <acronym title="Internet Explorer">IE</acronym> will not recognize a hover state on anything apart from an <code>&#60;a&#62;</code>, so we need to account for that by augmenting some of our code with what we learned from them. We can attach onmouseover and onmouseout events to the &#8220;selectReplacement&#8221; <code>class</code>-ed <code>&#60;ul&#62;</code> and its <code>&#60;li&#62;</code>s:</p>

  <pre class="script"><code>function selectReplacement(obj) {
  &#8230;
  // create list for styling
  var ul = document.createElement('ul');
  ul.className = 'selectReplacement';
  <strong>if (window.attachEvent) {
    ul.onmouseover = function() {
      ul.className += ' selHover';
    }
    ul.onmouseout = function() {
      ul.className = 
        ul.className.replace(new RegExp(&#34; selHover\\b&#34;), '');
    }
  }</strong>
  &#8230;
  for (var i=0; i&#60;opts.length; i++) {
    &#8230;
    if (i == selectedOpt) {
      li.className = 'selected';
    }
    <strong>if (window.attachEvent) {
      li.onmouseover = function() {
        this.className += ' selHover';
      }
      li.onmouseout = function() {
        this.className = 
          this.className.replace(new RegExp(" selHover\\b"), '');
      }
    }</strong>
  ul.appendChild(li);
}</code></pre>
  
  <p>Then, we can modify a few selectors in the <acronym title="Cascading Style Sheets">CSS</acronym>, to handle the hover for <acronym title="Internet Explorer">IE</acronym>:</p>
  
  <pre class="style"><code>ul.selectReplacement:hover li<strong>,
ul.selectOpen li</strong> {
  display: block;
}
ul.selectReplacement li.selected {
  color: #fff;
  display: block;
}
ul.selectReplacement:hover li.selected<strong>,
ul.selectOpen li.selected</strong> {
  background: #9e0000;
  display: block;
}
ul.selectReplacement li:hover,
<strong>ul.selectReplacement li.selectOpen,</strong>
ul.selectReplacement li.selected:hover {
  background: #9e0000;
  color: #fff;
  cursor: pointer;
}</code></pre>
    
  <p>Now we have a <a href="files/3.html">list behaving like a <code>&#60;select&#62;</code></a>; but we still need a means of changing the selected list item and updating the value of the associated form element.</p>
  
  <h3>JavaScript fu</h3>
  <p>We already have a &#8220;selected&#8221; <code>class</code> we can apply to our selected list item, but we need a way to go about applying it to a <code>&#60;li&#62;</code> when it is clicked on and removing it from any of its previously &#8220;selected&#8221; siblings. Here&#8217;s the <abbr title="JavaScript">JS</abbr> to accomplish this:</p>

  <pre class="script"><code>function selectMe(obj) {
  // get the &#60;li&#62;&#8217;s siblings
  var lis = obj.parentNode.getElementsByTagName('li');
  // loop through
  for (var i=0; i&#60;lis.length; i++) {
    // not the selected &#60;li&#62;, remove selected class
    if (lis[i] != obj) {
      lis[i].className='';
    } else { // our selected &#60;li&#62;, add selected class
      lis[i].className='selected';
    }
  }
}</code></pre>
  <p>[Note: we can use simple <code>className</code> assignment and emptying because we are in complete control of the <code>&#60;li&#62;</code>s. If you (for some reason) needed to assign additional classes to your list items, I recommend modifying the code to append and remove the &#8220;selected&#8221; class to your <code>className</code> property.]</p>
  <p>Finally, we add a little function to set the value of the original <code>&#60;select&#62;</code> (which will be submitted along with the form) when an <code>&#60;li&#62;</code> is clicked:</p>
  
  <pre class="script"><code>function setVal(objID, selIndex) {
  var obj = document.getElementById(objID);
  obj.selectedIndex = selIndex;
}</code></pre>
  
  <p>We can then add these functions to the <code>onclick</code> event of our <code>&#60;li&#62;</code>s:</p>
  
  <pre class="script"><code>&#8230;
  for (var i=0; i&#60;opts.length; i++) {
    var li = document.createElement('li');
    var txt = document.createTextNode(opts[i].text);
    li.appendChild(txt);
    <strong>li.selIndex = opts[i].index;
    li.selectID = obj.id;
    li.onclick = function() {
      setVal(this.selectID, this.selIndex);
      selectMe(this);
    }</strong>
    if (i == selectedOpt) {
      li.className = 'selected';
    }
    ul.appendChild(li);
  }
&#8230;</code></pre>
  
  <p>There you have it. We have created our functional faux-&#60;select&#62;</code>. As we have not hidden the original <code>&#60;select&#62;</code> yet, we can <a href="files/4.html">watch how it behaves</a> as we choose different options from our faux-<code>&#60;select&#62;</code>. Of course, in the final version, we don&#8217;t want the original <code>&#60;select&#62;</code> to show, so we can hide it by <code>class</code>-ing it as &#8220;replaced,&#8221; adding that to the <abbr title="JavaScript">JS</abbr> here:</p>
  
  <pre class="script"><code>function selectReplacement(obj) {
  <strong>// append a class to the select
  obj.className += ' replaced';</strong>
  // create list for styling
  var ul = document.createElement('ul');
&#8230;</code></pre>
  
  <p>Then, add a new <acronym title="Cascading Style Sheets">CSS</acronym> rule to hide the &#60;select&#62;</p>
  
  <pre class="style"><code>select.replaced {
  display: none;
}</code></pre>
  
  <p>With the application of a few images to <a href="files/final.html">finalize the design</a>, we are good to go!</p>

  <h2>Taking it further</h2>
  <p>We have created a solution that will work for the majority of users, but we aren&#8217;t stopping there. Part 2 in this series will explore how to make the faux-<code>&#60;select&#62;</code> more accessible, part 3 will explore this technique as it applies to <code>&#60;select&#62;</code>s with organizational <code>&#60;optgroup&#62;</code>s, and part 4 will examine this technique as it applies to multiple <code>&#60;select&#62;</code>s.</p>

  <div id="extras">
    <h2>Get the Source</h2>
    <p>You can download the files that go with this article in a single compressed archive: <a href="replaceSelect_files.zip">replaceSelect_files.zip</a></p>
  </div>
</div>
<?php foot(); ?>

</body>
</html>