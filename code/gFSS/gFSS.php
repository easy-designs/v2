<?php

# start the XML
open_gFSS_XML();
# verify the required variable ($f)
if ( !empty($_REQUEST['f']) ) {
  get_gFSS( $_REQUEST['f'] );
} else {
  xml_error( 'Error - No file supplied as variable "f"' );
}
# close the XML
close_gFSS_XML();

function get_gFSS( $f ) {
  # get the active css file
  $css_file = urldecode( $_REQUEST['f'] );
  
  # read the content into a variable & close the file
  $content  = read_file_to_var( $css_file );
  
  # standardize the coding style
  $content  = standardize_code( $content );
  
  # strip any comments
  $content  = strip_comments( $content );
  
  # get the array of gFSS-related CSS data
  $gFSS_arr = get_gFSS_array( $content );
  
  # output the final array as XML
  output_gFSS_XML( $gFSS_arr );
}

function xml_error( $msg ) {
  echo "<error>$msg</error>";
  close_gFSS_XML();
  die;
}

function open_gFSS_XML() {
  header('Content-type: application/xml');
  echo '<?xml version="1.0" encoding="UTF-8"?>';
  echo '<gfss>';
}

function close_gFSS_XML() {
  echo '</gfss>';
}

function read_file_to_var( $file ) {
  # open the file
  $fh  = fopen( $file, 'r' ) or xml_error('Error - File: '.__FILE__.' on line: '.__LINE__);
  # read it into a string
  $str = fread( $fh, filesize_url( $file ) ) or 
           xml_error('Error - File: '.__FILE__.' on line: '.__LINE__);
  #return the string
  return $str;
}

function filesize_url( $url ){
  return ( $data = @file_get_contents($url) ) ? strlen($data) : false;
}

function standardize_code( $str ) {
  # removing newlines
  $str = remove_all( "\n",  $str );
  $str = remove_all( "\r",  $str );
  # removing tabs
  $str = remove_all( '	',  $str );
  # removing multiple spaces
  $str = remove_all( '   ', $str );
  $str = remove_all( '  ',  $str );
  # removing empty lines
  $str = remove_all( " \r", $str );
  # removing starting spaces
  $str = str_replace( "\r ",    "\r",  $str );
  # standardize curly braces
  $str = str_replace( ' {',     "{",   $str );
  $str = str_replace( '{ \r',   "{",   $str );
  $str = str_replace( '{ ',     "{",   $str );
  $str = str_replace( ' }',     "\r}", $str );
  $str = str_replace( "}\r\r",  "}\r", $str );
  # standardize colons
  $str = str_replace( ' :',     ":",   $str );
  $str = str_replace( ': ',     ":",   $str );
  # replace multiple returns
  $str = str_replace( "\r\r\r", "\r",  $str );
  $str = str_replace( "\r\r",   "\r",  $str );
  $str = str_replace( ";\r\r",  ";\r", $str );
  # move each declaration to one line
  $str = str_replace( "{\r",     "{",  $str );
  $str = str_replace( ";\r",     ";",  $str );
  $str = str_replace( "\r}",     "}",  $str );
  # removing returns
  $str = remove_all( "\r",  $str );
  # return the string
  return $str;
}

function strip_comments( $str ) {
  while ( strstr( $str, '/*' ) ) {
    $start = strpos( $str, '/*' );
    $end   = strpos( $str, '*/', $start );
    $a = ( $start != 0 ) ? substr( $str, 0, $start ) : '';
    $b = ( $end != strlen($str) ) ? substr( $str, $end+2 ) : '';
    $str = $a.$b;
  }
  return $str;
}

function remove_all( $match, $str ) {
  while ( strstr( $str, $match ) ) {
    $str = str_replace( $match, '', $str);
  }
  return $str;
}

function get_gFSS_array( $str ) {
  # break it into an array by declaration block
  $arr = explode( "}", $str );
  
  # remove the empty last element
  if ( empty($arr[count($arr)-1]) ) { array_pop( $arr ) ; }
  
  # parse the declaration blocks looking for -gFSS rules
  # dropping any blocks without them
  # create a new array from the remaining declarations,
  $newArr =  array();
  foreach ( $arr as $block ) {
    if ( strstr( $block, '-gfss-' ) ) {
      $bArr = explode( '{', $block );
      # using the selectors as the keys and the rules as the values
      $newArr[$bArr[0]] = $bArr[1];
    }
  }
  
  # break the individual rules into key/val pairs, dropping any 
  # that aren't led by -gFSS indicator
  foreach ( $newArr as $key => $val ) {
    $newArr[$key] =  array();
    $ruleArr = explode( ';', $val);
    foreach ( $ruleArr as $rule ) {
      if ( strstr( $rule, '-gfss-' ) ) {
        $rule = explode( ':', $rule );
        $newArr[$key][$rule[0]] = $rule[1];
      }
    }
  }
  
  return $newArr;
}

function output_gFSS_XML( $arr ) {
  foreach ( $arr as $key => $val ) {
    $selArr     = explode( ' ', $key );
    $gFSSsel    = $selArr[ count( $selArr )-1 ];
    $pSel       = $selArr[ count( $selArr )-2 ];
    $gFSS       = get_selector_details( $gFSSsel );
    $parent     = get_selector_details( $pSel );
    $gFSSparams = $val;
    echo '<gfss-item>';
    foreach ( $gFSS as $key => $val ) {
      echo "<{$key}>$val</{$key}>";
    }
    foreach ( $gFSSparams as $key => $val ) {
      $key = substr( $key, 6 );
      if ( strstr( $val, 'url(' ) ) {
        $val = substr( $val, 4, strlen( $val )-5 );
      }
      echo "<{$key}>$val</{$key}>";
    }
    echo '<parent>';
    foreach ( $parent as $key => $val ) {
      echo "<parent-{$key}>$val</parent-{$key}>";
    }
    echo '</parent>';
    echo '</gfss-item>';
  }
}

function get_selector_details( $selector ) {
  $selDetails = array();
  $selector = str_replace( '#', ';#', $selector );
  $selector = str_replace( '.', ';.', $selector );
  $selector = str_replace( ':', ';:', $selector );
  $sArr = explode( ';', $selector );
  $selDetails['tag'] = $selDetails['id'] = $selDetails['class'] = $selDetails['pseudo-class'] = '';
  foreach ( $sArr as $piece ) {
    # tag
    $selDetails['tag']          = ( !strstr( $piece, '#' ) &&
                                    !strstr( $piece, '.' ) &&
                                    !strstr( $piece, ':' ) ) ? $piece 
                                                             : $selDetails['tag'];
    # id
    $selDetails['id']           = ( strstr( $piece, '#' ) ) ? substr($piece, 1) 
                                                            : $selDetails['id'];
    # class
    $selDetails['class']        = ( strstr( $piece, '.' ) ) ? substr($piece, 1) 
                                                            : $selDetails['class'];
    # pseudo-class
    $selDetails['pseudo-class'] = ( strstr( $piece, ':' ) ) ? substr($piece, 1) 
                                                            : $selDetails['pseudo-class'];
  }
  return $selDetails;
}

function varDump( $var ) {
  echo '<pre>';
  print_r( $var );
  echo '</pre>';
}

?>