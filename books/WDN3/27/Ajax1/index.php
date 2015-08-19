<?php
# make sure we have the id
if( !empty($_REQUEST['id']) ) {
  # get the requested address
  $id = $_REQUEST['id'];
  switch( $id ){
    case '1':
    $txt = "Bob Smith\n123 School Street\nAnytown, NY 12345";
    break;
  case '2':
    $txt = "Janet Jones\n123 Orange Ave\nSomewhere, IA 54321";
    break;
  default:
    $txt = '';
    break;
  }
  if( empty( $_REQUEST['submit'] ) ){
    echo $txt;
  } else {
    showPage( $id, $txt );
  }
} else {
  showPage();
}
function showPage( $id=false, $address='' ){
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Ajax Address Book (Text Version)</title>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <meta http-equiv="Content-Language" content="en-us" />
  <script type="text/javascript" src="../XHConn.js"></script>
  <script type="text/javascript" src="addressBook.js"></script>
</head>
<body>
  <h1>Simple Ajax Address Book</h1>
  <form action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="POST">
    <fieldset>
      <legend>Please Choose a Person</legend>
      <select id="person" name="person">
        <option value="">Choose Someone</option>
        <option value="1"<?php echo( $id == 1 )? ' selected="selected"' : '' ?>>Bob Smith</option>
        <option value="2"<?php echo( $id == 1 )? ' selected="selected"' : '' ?>>Janet Jones</option>
      </select>
      <input type="submit" id="submit" name="submit" value="Get the Address" />
    </fieldset>
  </form>
  <pre id="address"><?= $address ?></pre>
</body>
</html><?
}
?>