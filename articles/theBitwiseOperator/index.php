<?php

# get common
require "{$_SERVER['DOCUMENT_ROOT']}/scripts/common.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Get a Speed Boost from the Bitwise Operator</title>
<?php docHead(); ?>
</head>
<body>
<?php message(); ?>
<div id="content">
  <h1>Get a Speed Boost from the Bitwise Operator</h1>
  <h3>By Dave Stewart</h3>
  
  <p>Be it ActionScript or <abbr title="PHP: the Hypertext PreProcessor">PHP</abbr>, we all find ourselves re-using code snippets we learned (or &#8220;borrowed&#8221;) at some point during the development of an application.  Why re-invent the wheel, right?</p>
  <p>Whenever I have a little down time, though, I experiment with new things (as I am sure we all do) or go back and study code that I know works to optimize/improve upon it. Sometimes while researching something, I get off on a tangent and eventually end up unearthing a bit of programming which is very helpful, but often overlooked.</p>
  <p>This happened recently when I was building a Flash game and wrote some code to alternate through squares in a grid system. It seemed rather slow, so I started searching for a better solution. I blew the dust off the Bitwise operator (<code>&amp;</code>) and researched what it actually does. I think the reason it was dusty was because of descriptions like this one (from the Flash 8 docs):</p>
  <blockquote>
    <dl>
      <dt><var>expression1</var> &amp; <var>expression2</var></dt>
      <dd>Converts <var>expression1</var> and <var>expression2</var> to 32-bit unsigned integers, and performs a Boolean AND operation on each bit of the integer parameters. Floating-point numbers are converted to integers by discarding any digits after the decimal point. The result is a new 32-bit integer.</dd>
    </dl>
  </blockquote>
  
  <p>How could <em>that</em> be useful?</p>
  <p>Let&#8217;s translate this jibberish into something that can save our overworked <abbr title="Central Processing Units">CPUs</abbr> some cycles. As you&#8217;ll soon see, the bitwise operator can be used in many programming languages.</p>
  <p>Below are two examples. The first is one I have written (and re-written) dozens of times in <abbr title="PHP: the Hypertext PreProcessor">PHP</abbr> &#8211; it alternates between colors on <abbr title="(eXtensible) HyperText Markup Language">(X)HTML</abbr> <code>table</code> rows from a MySQL query. The second is the ActionScript required to make a chessboard.  These examples are very specific, but this technique can be adapted to any situation in which you want to cycle through <code>for</code> or <code>while</code> loops to find odd or even numbers or trigger on/off switches.</p>
    
  <h2>Exhibit A: Stripey tables in PHP</h2>
  <pre class="script"><code>&#60;table&#62;
  &#60;thead&#62;
    &#60;tr&#62;
      &#60;th&#62;Event Date&#60;/th&#62;
      &#60;th&#62;Event Title&#60;/&#62;
    &#60;/tr&#62;
  &#60;/thead&#62;
  &#60;tbody&#62;
&#60;?php
  // Define colors for the alternating rows
  $color1 = "#CCCCCC";
  $color2 = "#FFFFFF";
  $row_count = 0;
  // SQL query.
  $sql = mysql_query( "SELECT * FROM events" ) or die( mysql_error() );
  while( $row = mysql_fetch_array( $sql ) ){
    $id = $row["id"];
    $date = $row["date"];
    $title = $row["title"];
    // Alternate the colors between the two colors we defined above.
    $row_color = ( $row_count % 2 ) ? $color1 : $color2;
    // Echo your table row ?&#62;
    &#60;tr&#62;
      &#60;td bgcolor="&#60;?= $row_color ?&#62;"&#62;&#60;?= $date ?&#62;&#60;/td&#62;
      &#60;td bgcolor="&#60;?= $row_color ?&#62;"&#62;&#60;a href="articles.php?article_id=&#60;?= $id ?&#62;"&#62;&#60;?= $title ?&#62;&#60;/a&#62;&#60;/td&#62;
    &#60;/tr&#62;
&#60;?php
    // Add 1 to the row count
    $row_count++;
  } ?&#62;
  &#60;tbody&#62;
&#60;/table&#62;</code></pre>

  <p>Pretty standard stuff right? Now take a look at this line: 

  <pre class="script"><code>    &#8230;
    $row_color = ($row_count % 2) ? $color1 : $color2;
    &#8230;</code></pre>
  </blockquote>

  <p>A lot of people use this method (which also makes use of the ternery operator) for deciding which color to make a table row. It works great. No big deal for a hundred rows or so, but when we get into thousands of rows, this method can use more system resources than it really needs. To find out why, let&#8217;s look at what the <code>%</code> (modulo) operator does.</p>
  <blockquote cite="http://en.wikipedia.org/wiki/Modulo">
    <p>In computing, given two integers, <var>a</var> and <var>n</var>, <var>a</var> modulo <var>n</var> is the remainder after numerical division of <var>a</var> by <var>n</var>.</p>
  </blockquote>
  <p>The calculation looks something like this:</p>
  <img src="modulo.png" alt="a - n[ a / n ]" />
  <p>For example, let&#8217;s say <var>$row_count</var> starts at 1024 and performs this operation with <var>n</var> being 2. If the result is 0 (making the statement <code>true</code>) the <code>?</code> (ternery) operator sets the value of <var>$row_color</var> to <var>$color1</var>; when the statement is false (because the result is 1) it sets <var>$row_color</var> to <var>$color2</var>.  Great, no big deal for a computer you say.</p>
  <p>Just remember that this statement is likely to be one of dozens or even hundreds of computations your program has to do before returning the results to a user. That&#8217;s a lot of unnecessary math (and a real cycle-sucker).</p>
  <p>We can optimize this code by using the bitwise operator (<code>&amp;</code>). First, a little definition:</p>
  <blockquote cite="http://en.wikipedia.org/wiki/Bitwise">
    <p>[B]itwise operation operates on one or two bit patterns or binary numerals at the level of their individual bits. On many computers, bitwise operations are slightly faster than addition and subtraction operations and significantly faster than multiplication and division operations.</p>
  </blockquote>
  <p>Do you remember how binary works? Here&#8217;s a refresher:</p>
  <ul>
    <li>001 &rarr; 1</li>
    <li>010 &rarr; 2</li>
    <li>011 &rarr; 3</li>
    <li>100 &rarr; 4</li>
    <li>101 &rarr; 5</li>
    <li>and so on&#8230;</li>
  </ul>
  <p>Each odd number has a binary equivalent with a 1 in the last column, and even numbers have binary equivalents with 0 there. So let&#8217;s look for that pattern instead, doing simple comparisons instead of calculations for each iteration.</p>
  <p>To do this, we just modify the statement to look like this:</p>
  
  <pre class="script"><code>    &#8230;
    $row_color = ( ( $row_count &amp; 1 ) == 0 ) ? $color1 : $color2;
    &#8230;</code></pre>
  
  <p>What this does is mask <var>$row_count</var> with a 1 and you can see if it is even.</p>
  <ul>
    <li>1024 &rarr; 10000000000</li>
    <li>1023 &rarr; 1111111111</li>
  </ul>
  <p>All we are doing is checking for a 0 in the last column and that&#8217;s a much quicker way of figuring out if the row is even or odd.</p>
  <p>But you can do many more things with this too. For example, if you need a simple switch (on/off), consider this instead of doing conditional statements:</p>

  <pre class="script"><code>$mySwitch = ($counter &amp; 1);
$counter++;</code></pre>
    
  <h2>Exhibit B: Chessboard in ActionScript</h2>
  <p>Here is a 100% ActionScript Chessboard. It could be modified to <abbr title="PHP: the Hypertext PreProcessor">PHP</abbr>/<abbr title="(eXtensible) HyperText Markup Language">(X)HTML</abbr> to make a checkered table, but that might look a little crazy.</p>
  <p><em>Note:</em> We&#8217;re using <abbr title="ActionScript">AS</abbr> best practices here, keeping our code as portable as possible by using objects.</p>
  <p>Copy this to the first frame of a new Flash file</p>
  <pre class="script"><code>// For a chessboard you want your stage to be equal width and height.
import chessboard;
var w:Number = Stage.width;
var h:Number = Stage.height;
// 8 is the number of squares in a chessboard row.
var chessBoard = new chessboard( w, h, 8 );</code></pre>

  <p>Copy this to a file called <span class="file">chessboard.as</span> and save in same directory as the above Flash file:</p>
  <pre class="script"><code>class chessboard {
  // Private vars
  private var __w:Number;
  private var __h:Number;
  private var __divider:Number;
  private var cols:Number;
  private var rows:Number;
  private var counter:Number;
  private var depth:Number;
  private var i:Number;
  private var j:Number;
  
  // Constructor
  public function chessboard( w:Number, h:Number, divider:Number ){
    this.__w = w;
    this.__h = h;
    this.__divider = w / divider;
    this.cols = w / divider;
    this.rows = h / divider;
    this.counter = 0;

    _root.createEmptyMovieClip( "chessboard_mc", 0 );
    for( i = 0; i < rows; i++ ){
      for( j = 0; j < cols; j++ ){
        depth = _root.chessboard_mc.getNextHighestDepth();
        var square = _root.chessboard_mc.createEmptyMovieClip( "square" + depth + "_mc", depth );
        // Our Bitwise &amp; to make Black or White squares
        var addSquare:Boolean = ( (counter &amp; 1) == 0 ) ? fill( square, 0xFFFFFF ) 
                                                       : fill( square, 0x000000 );
        square._x = j * __divider;
        square._y = i * __divider;
        counter++;
      }
      // We donít want stripes, we want checkers,
      // so we need to offset the counter on each row.
      counter += 1;
    }
  }
  // Draw and Fill the squares with colors
  function fill( square:MovieClip, color:Number ){
    square.beginFill( color, 100 );
    square.lineStyle( 0, color, 100 );
    square.moveTo( 0, 0 );
    square.lineTo( __divider, 0 );
    square.lineTo( __divider, __divider );
    square.lineTo( 0, __divider );
    square.lineTo(0, 0);
    square.endFill();
  }
}</code></pre>
  <p>And that&#8217;s all there is to it. It&#8217;s amazing how something as simple as an &#38; can be so incredibly useful.</p>

  <div id="extras">
    <h2>Get the Source</h2>
    <p>You can download the files that go with this article in a single compressed archive: <a href="/articles/theBitwiseOperator/theBitwiseOperator_files.zip">theBitwiseOperator_files.zip</a></p>
  </div>
</div>
<?php foot(); ?>

</body>
</html>