// ---------------------------------------------------------------------
//                             onLoad Handler
// ---------------------------------------------------------------------
var old = window.onload; // catch any existing onload calls 1st
window.onload = function () {
  if (old) { // execute existing onloads
    old();
  };
  for (var ii = 0; arguments.callee.actions.length > ii; ii++) {
    arguments.callee.actions[ii]();
  };
};
window.onload.actions = [];

// ---------------------------------------------------------------------
//                             fixLinks
// ---------------------------------------------------------------------
function fixLinks() {
  if (!document.getElementsByTagName) return null;
  var server = document.location.hostname;
  var anchors = document.getElementsByTagName("a");
  var id, href, title;
  for(var i=0; i < anchors.length; i++){
    if(!anchors[i].href) continue;
    href = anchors[i].href;
    title = anchors[i].title;
    id = anchors[i].id;
    if(href.indexOf(server) == -1){ // Href is not a file on my server
      if(href.indexOf("javascript:") == -1){ // Href is not a javascript call
        if(!anchors[i].onclick){ // Href does not have an onclick event
          if(href.indexOf("mailto:") == -1){ // Href is not a mailto:
            if((href.indexOf("http://") != -1) || (href.indexOf("https://") != -1)){ // Href is not relative (for Safari)
              anchors[i].setAttribute("target","_blank");
              anchors[i].setAttribute("title",title + " [This Link Will Open in a New Window]");
            }
          }
        }
      }
    }
  }
  return null;
}
window.onload.actions.push(fixLinks);

// ---------------------------------------------------------------------
//                             AutoBlink
// (c) 2005 Chris Ridings   http://www.searchguild.com
// Redistribute at will but leave this message intact
// ---------------------------------------------------------------------
var autoBlinkCount;
function autoBlink() {
  if (document.getElementById && document.createElement) {
	autoBlinkCount=document.links.length;
	setTimeout("checklinks()",500);
  }
}
function checklinks() {
  if (!(autoBlinkCount==document.links.length)) {
    // Something changed the links!
    // Iterate for an id of _goog
    for (i=0; i < document.links.length; i++) {
      if (document.links[i].id.substring(0,5)=="_goog") {
        // If we find an id of _goog then remove the link!
        var tr = document.links[i].parentTextEdit.createTextRange();
        tr.moveToElementText(document.links[i]);
        tr.execCommand("Unlink",false);
        tr.execCommand("Unselect",false);
      }
    }
  }
  setTimeout("checklinks()",500);
}
window.onload.actions.push(autoBlink);