var addressBook = {
  myConn:      false,
  body:        false,
  control:     false,
  target:      false,
  loader:      false,
  init:        function( controlId, sbmtBtnId, targetId ){
    if( !document.getElementById ||
        !document.getElementsByTagName ||
        !document.getElementById( controlId ) ||
        !document.getElementById( sbmtBtnId )  ||
        !document.getElementById( targetId ) ) return;
    addressBook.myConn = new XHConn();
    if( !addressBook.myConn ) return;
    addressBook.body    = document.getElementsByTagName( 'body' )[0];
    addressBook.control = document.getElementById( controlId );
    var sbmtBtn = document.getElementById( sbmtBtnId );
    sbmtBtn.parentNode.removeChild( sbmtBtn );
    addressBook.target  = document.getElementById( targetId );
    addressBook.addEvent( addressBook.control,
                          'change',
                          function(){
                            if( this.value != '' ){
                              addressBook.getAddress( this.value );
                            } else {
                              addressBook.target.innerHTML = '';
                            }
                          } );
  },
  getAddress:  function( id ){
    addressBook.buildLoader();
    var fnWhenDone = function(oXML) {
      addressBook.killLoader();
      addressBook.target.innerHTML = oXML.responseText;
    };
    addressBook.myConn.connect("index.php", "POST", "id="+id, fnWhenDone);
  },
  buildLoader: function(){
    addressBook.loader = document.createElement( 'div' );
    addressBook.loader.setAttribute( 'id', 'loading' );
    addressBook.loader.style.position   = 'absolute';
    addressBook.loader.style.top        = '50%';
    addressBook.loader.style.left       = '50%';
    addressBook.loader.style.width      = '300px';
    addressBook.loader.style.lineHeight = '100px';
    addressBook.loader.style.margin     = '-50px 0 0 -150px';
    addressBook.loader.style.textAlign  = 'center';
    addressBook.loader.style.border     = '1px solid #870108';
    addressBook.loader.style.background = '#fff';
    addressBook.loader.appendChild( document.createTextNode( 'Loading Data, please wait\u2026' ) );
    addressBook.body.appendChild( addressBook.loader );
  },
  killLoader:  function(){
    addressBook.body.removeChild( addressBook.loader );
  },
  addEvent: function( obj, type, fn ){  // the add event function
    if (obj.addEventListener) obj.addEventListener( type, fn, false );
    else if (obj.attachEvent) {
      obj["e"+type+fn] = fn;
      obj[type+fn] = function() {
        obj["e"+type+fn]( window.event );
      };
      obj.attachEvent( "on"+type, obj[type+fn] );
    }
  }
};
addressBook.addEvent( window, 'load', function(){
                                        addressBook.init( 'person',
                                                          'submit',
                                                          'address' );
                                      } );