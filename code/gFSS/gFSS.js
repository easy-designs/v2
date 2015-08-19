/* Interfaces */
function gFSS_switchStyles(title) {
  gFSS_cleanup();
  gFSS_set_css(title);
}
function gFSS_set_css( cssTitle ) {
  if ( !document.getElementsByTagName ||
       !Element.getAttribute ) return false;
  var links = document.getElementsByTagName('link');
  for (var i=0; i<links.length; i++) {
    if ( links[i].getAttribute('rel').indexOf('style') != -1 &&
         links[i].getAttribute('title') ) {
      links[i].disabled = true;
      if ( links[i].getAttribute('title') == cssTitle ) {
        links[i].disabled = false;
        var src = gFSS_get_uri( links[i].getAttribute('href') );
        gFSS_load( src );
      }
    }
  }
  return true;
}
function gFSS_cleanup() {
  var i,
      ptrn  = /gFSS/,
      junk  = [],
      objs  = document.getElementsByTagName('object'),
      embds = document.getElementsByTagName('embed');
  for (i=0; i<objs.length; i++) {
    if ( objs[i].className.match(ptrn) ) {
      junk.push( objs[i] );
    }
  }
  for (i=0; i<embds.length; i++) {
    if ( embds[i].className.match( ptrn ) ) {
      junk.push( embds[i] );
    }
  }
  for(i=0; i<junk.length; i++) {
    junk[i].parentNode.removeChild( junk[i] );
  }
}
function gFSS_load( src ) {
  var myConn = new XHConn();
  if (!myConn) alert("XMLHTTP not available. Try a newer/better browser.");
  var fnWhenDone = gFSS_build;
  myConn.connect("gFSS.php", "POST", "f=" + encodeURI( src ), fnWhenDone);
}


/* gFSS Building Tools */
function gFSS_build_flash( s, // source filename
                           b, // background color
                           v, // flash version
                           w, // width
                           h, // height
                           q, // quality
                           i, // id
                           c  // class
                         ) {
  if (b.length == 4) { // expanding color shorthand
    b = b.substr(0,2)+ b.substr(1,1) +
        b.substr(2,1)+ b.substr(2,1) +
        b.substr(3,1)+ b.substr(3,1);
  }
  var bg = ( b != 'transparent' ) ? b : '#ffffff';
  if ( window.ActiveXObject && 
       navigator.userAgent.indexOf('Mac') == -1 ) {
    var obj = document.createElement('object');
    obj.setAttribute('id',     i);
    obj.setAttribute('data',    s);
    obj.setAttribute('classid',"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000");
    obj.setAttribute('codebase',
                     "http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0");
    if ( w != '' ) obj.setAttribute('width',  w);
    if ( h != '' ) obj.setAttribute('height',  h);
    obj.className = ( c == '' ) ? 'gFSS' : 'gFSS '+c;
    obj.appendChild( gFSS_build_param( 'movie',   s ) );
    obj.appendChild( gFSS_build_param( 'quality', q ) );
    obj.appendChild( gFSS_build_param( 'bgcolor', bg ) );
    if ( b == 'transparent' ) {
      obj.appendChild( gFSS_build_param( 'wmode', b ) );
    }
    return obj;
  } else {
    var embed = document.createElement('embed');
    embed.setAttribute('id',     i);
    embed.setAttribute('type',   'application/x-shockwave-flash');
    embed.setAttribute('src',    s);
    if ( w != '' ) embed.setAttribute('width',  w);
    if ( h != '' ) embed.setAttribute('height',  h);
    embed.className = ( c == '' ) ? 'gFSS' : 'gFSS '+c;
    embed.setAttribute('quality', q);
    embed.setAttribute('bgcolor', bg);
    if ( b == 'transparent' ) {
      embed.setAttribute('wmode', b );
    }
    return embed;
  }
}
function gFSS_build_param( n, v ) {
  var param = document.createElement('param');
  param.setAttribute('name',  n);
  param.setAttribute('value', v);
  return param;
}

/* gFSS Utility Functions */
function gFSS_get_uri( uri ) {
  var protocol = window.location.protocol;
  var host     = window.location.host;
  var path     = window.location.pathname;
  if ( uri.indexOf('/') == 0 ) { // absolute
    uri = protocol + '//' + host + uri;
  } else {                       // relative
    if ( uri.indexOf('./') == 0 ) {
      uri = uri.substr( 2 );
    }
    if ( path.indexOf('/') != (path.length-1) ) {
      var tmpArr = path.split('/');
      tmpArr.pop();
      path = tmpArr.join('/');
      path += '/';
    }
    uri = protocol + '//' + host + path + uri;
  }
  return uri;
}
function gFSS_build(oXML) {
  var myXML = oXML.responseXML;
  var gFSS_arr = myXML.getElementsByTagName('gfss-item');
  var gFSS, s, b, v, w, h, q, id, c;
  var parent, p_id, p_class, p_tag;
  for (var i=0; i<gFSS_arr.length; i++) {
    // get flash params
    s    = getSimpleXMLElementText(gFSS_arr[i], 'source');
    b    = getSimpleXMLElementText(gFSS_arr[i], 'background-color');
    v    = getSimpleXMLElementText(gFSS_arr[i], 'flash-version');
    w    = getSimpleXMLElementText(gFSS_arr[i], 'width');
    h    = getSimpleXMLElementText(gFSS_arr[i], 'height');
    q    = getSimpleXMLElementText(gFSS_arr[i], 'quality');
    id   = getSimpleXMLElementText(gFSS_arr[i], 'id');
    c    = getSimpleXMLElementText(gFSS_arr[i], 'class');
    gFSS = gFSS_build_flash( s, b, v, w, h, q, id, c );
    // get parent params
    p_id    = getSimpleXMLElementText(gFSS_arr[i], 'parent-id');
    p_class = getSimpleXMLElementText(gFSS_arr[i], 'parent-class');
    p_tag   = getSimpleXMLElementText(gFSS_arr[i], 'parent-tag');
    if ( p_id != '' ) {
      parent = document.getElementById( p_id );
      if ( p_tag != '') {
        if ( parent.nodeName.toLowerCase() == p_tag ) {
          parent.appendChild( gFSS );
        }
      } else {
        parent.appendChild( gFSS );
      }
    } else if ( p_class != '' ) {
      var tmpArr;
      if ( p_tag != '' ) {
        tmpArr = document.getElementsByClassName( p_class );
        var newArr = [];
        for (var j=0; j<tmpArr.length; j++) {
          if ( tmpArr[j].nodeName.toLowerCase() == p_tag ) {
            newArr.push( tmpArr[j] );
          }
        }
        tmpArr = newArr;
      }
      for (var k=0; k<tmpArr.length; k++ ) {
        tmpArr[k].appendChild(gFSS);
      }
    } else if ( p_tag != '') {
      tmpArr = document.getElementsByTagName( p_tag );
      for (var l=0; l<tmpArr.length; l++) {
        tmpArr[l].appendChild(gFSS);
      }
    } else {
      document.getElementsByTagName('body')[0].appendChild(gFSS);
    }
  }
}

/* Generic Utility Functions */
function getSimpleXMLElementText(theXML, element) {
  var val = '';
  if ( theXML.getElementsByTagName(element)[0] &&
       theXML.getElementsByTagName(element)[0].firstChild ) {
    val = theXML.getElementsByTagName(element)[0].firstChild.nodeValue;
  }
  return val;
}

