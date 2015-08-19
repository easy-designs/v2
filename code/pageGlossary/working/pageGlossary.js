/*------------------------------------------------------------------------------
Object:         pageGlossary (formerly makeGlossary)
Author:         Aaron Gustafson (aaron at easy-designs dot net)
Creation Date:  27 November 2005
Version:        1.0
Homepage:       http://www.easy-designs.net/code/pageGlossary/
License:        Creative Commons Attribution-ShareAlike 2.0 License
                http://creativecommons.org/licenses/by-sa/2.0/
Note:           If you change or improve on this script, please let us know by 
                emailing the author (above) with a link to your demo page.
------------------------------------------------------------------------------*/
var pageGlossary = {
  getFrom:  false,
  buildIn:  false,
  glossArr: [],
  usedArr:  [],
  init:     function( fromId, toId ){
    if( !document.getElementById || 
        !document.getElementsByTagName || 
        !document.getElementById( fromId ) || 
        !document.getElementById( toId ) ) return;
    pageGlossary.getFrom = document.getElementById( fromId );
    pageGlossary.buildIn = document.getElementById( toId );
    pageGlossary.collect();
    if( pageGlossary.usedArr.length < 1 ) return;
    pageGlossary.glossArr = pageGlossary.ksort( pageGlossary.glossArr );
    pageGlossary.build();
  },
  collect:  function(){
    var dfns  = pageGlossary.getFrom.getElementsByTagName('dfn');
    var abbrs = pageGlossary.getFrom.getElementsByTagName('abbr');
    var acros = pageGlossary.getFrom.getElementsByTagName('acronym');
    var arr = [];
    arr = arr.concat( dfns, abbrs, acros );
    if( ( arr[0].length == 0 ) &&
        ( arr[1].length == 0 ) && 
        ( arr[2].length == 0 ) ) return;
    var arrLength = arr.length;
    for( var i=0; i < arrLength; i++ ){
      var nestedLength = arr[i].length;
      if( nestedLength < 1 ) continue;
      for( var j=0; j < nestedLength; j++ ){
        if( !arr[i][j].hasChildNodes() ) continue;
        var trm = arr[i][j].firstChild.nodeValue;
        var dfn = arr[i][j].getAttribute( 'title' );
        if( !pageGlossary.inArray( trm, pageGlossary.usedArr ) ){
          pageGlossary.usedArr.push( trm );
          pageGlossary.glossArr[trm] = dfn;
        }
      }
    }
  },
  build:    function(){
    var h2 = document.createElement('h2');
    h2.appendChild( document.createTextNode( 'Page Glossary' ) );
    var dl = document.createElement('dl');
    dl.className = 'glossary';
    for( key in pageGlossary.glossArr ){
      var dt = document.createElement( 'dt' );
      dt.appendChild( document.createTextNode( key ) );
      dl.appendChild( dt );
      var dd = document.createElement('dd');
      dd.appendChild( document.createTextNode( pageGlossary.glossArr[key] ) );
      dl.appendChild( dd );
    }
    pageGlossary.buildIn.appendChild( h2 );
    pageGlossary.buildIn.appendChild( dl );
  },
  addEvent: function( obj, type, fn ){  // the add event function
    if (obj.addEventListener) obj.addEventListener( type, fn, false );
    else if (obj.attachEvent) {
      obj['e'+type+fn] = fn;
      obj[type+fn] = function() {
        obj['e'+type+fn]( window.event );
      };
      obj.attachEvent( 'on'+type, obj[type+fn] );
    }
  },
  ksort:    function( arr ){
    var rArr = [], tArr = [], n=0, i=0, el;
    for( el in arr ) tArr[n++] = el + '|' + arr[el];
    tArr = tArr.sort();
    var arrLength = tArr.length;
    for( var i=0; i < arrLength; i++ ){
      var x = tArr[i].split( '|' );
      rArr[x[0]] = x[1];
    }
    return rArr;
  },
  inArray:  function( needle, haystack ){
    var arrLength = haystack.length;
    for( var i=0; i < arrLength; i++ ){
      if( haystack[i] === needle ) return true;
    }
    return false;
  }
};
pageGlossary.addEvent( window, 'load', function(){
                                         pageGlossary.init( 'content',
                                                            'extras' );
                                       } );