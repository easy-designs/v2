<?php

/*----------------------------------------------------------------------------------------
Function: docHead()
Purpose:  writes out the stuff needed in the <head> of the doc
----------------------------------------------------------------------------------------*/
function docHead() {
  metaTags();
  links();
  scripts();
} # end head()

/*----------------------------------------------------------------------------------------
Function: metaTags()
Purpose:  writes out the stuff needed in the <head> of the doc
----------------------------------------------------------------------------------------*/
function metaTags() { ?>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="en-us" />
  <meta name="author" content="Aaron Gustafson (aaron at easy-designs dot net)" />
  <meta name="MSSmartTagsPreventParsing" content="true" />
  <meta name="ROBOTS" content="ALL" />
  <meta name="Copyright" content="(CC) <?php ccDate(); ?> Easy Designs, LLC. Except where otherwise noted, this site is licensed under a Creative Commons License." />
  <meta http-equiv="imagetoolbar" content="no" />
  <meta name="Rating" content="General" /> 
<?php
} # end metaTags()

/*----------------------------------------------------------------------------------------
Function: links()
Purpose:  writes out the links for all docs
----------------------------------------------------------------------------------------*/
function links() {
  if( !isNakedDay() ){ ?>
  <link rel="stylesheet" type="text/css" media="screen" href="/css/basic.css" />
  <link rel="stylesheet" type="text/css" media="screen, projection" href="/css/advanced.css" />
  <link rel="stylesheet" type="text/css" media="print" href="/css/print.css" /> 
<?php
  } # naked day ?>
  <link rel="shortcut icon" type="image/ico" href="/favicon.ico" /> 
  <link rel="copyright" href="/license.php" /> 
<?php
} # end links()

/*----------------------------------------------------------------------------------------
Function: scripts()
Purpose:  writes out the scripts for all docs
----------------------------------------------------------------------------------------*/
function scripts() { ?>
  <!--script type="text/javascript" src="/scripts/jsUtilities.js"></script-->
  <script type="text/javascript" src="/scripts/main.js"></script>
  <script type="text/javascript" src="/scripts/pageGlossary.js"></script>
  <script type="text/javascript" src="/scripts/footnoteLinks.js"></script>
  <script type="text/javascript" src="http://www.google-analytics.com/urchin.js"></script>
<?php
} # end links()

/*----------------------------------------------------------------------------------------
Function: message()
Purpose:  write out a site-wide message
----------------------------------------------------------------------------------------*/
function message(){
  if( isNakedDay() ){ ?>
<div id="site_notice">
  <h3>What happened to the design?</h3>
  <p>To know more about why styles are disabled on this website visit the <a href="http://naked.dustindiaz.com" title="Web Standards Naked Day Host Website">Annual <abbr title="Cascading Style Sheets">CSS</abbr> Naked Day</a> website for more information.</p>
</div>
<?php 
  }
}

/*----------------------------------------------------------------------------------------
Function: foot()
Purpose:  write the copyright date
----------------------------------------------------------------------------------------*/
function foot(){ ?>
  <div id="footer">
    <?php cc(); ?>
  </div> 
  <script type="text/javascript">
    // <![CDATA[
    _uacct = 'UA-176472-1';
    urchinTracker();
    // ]]>
  </script> 
<?php
} # end foot()

/*----------------------------------------------------------------------------------------
Function: ccDate()
Purpose:  write the copyright date
----------------------------------------------------------------------------------------*/
function ccDate() {
  echo "1999-".date('Y');
} # end ccDate()

/*----------------------------------------------------------------------------------------
Function: cc()
Purpose:  write the creative commons license paragraph
----------------------------------------------------------------------------------------*/
function cc(){ ?>
  <p class="copyright"><a id="cc" href="http://creativecommons.org/licenses/by-sa/2.0/" title="View the Creative Commons license for this page">(CC)</a> <?php ccDate(); ?> Easy Designs, LLC. Except where otherwise <a href="/license.php">noted</a>, this site is licensed under a <a href="http://creativecommons.org/">Creative Commons</a> License.</p> 
<?php
} # end cc()

/*----------------------------------------------------------------------------------------
Function: is_naked_day()
Purpose:  let's me know if it is naked day
----------------------------------------------------------------------------------------*/
function isNakedDay(){
  $start = date('U', mktime(-12,0,0,04,05,date('Y')));
  $end = date('U', mktime(36,0,0,04,05,date('Y')));
  $now = time();
  if( $now >= $start &&
      $now <= $end ){
    return true;
  } else {
    return false;
  }
}
?>