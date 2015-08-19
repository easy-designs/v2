function makeGlossary(targetID) {
  if (!document.getElementById || !document.getElementsByTagName) return false;
  if (!document.getElementById(targetID)) return false;
  var target = document.getElementById(targetID);
  var arr = [];
  var dfns  = document.getElementsByTagName('dfn');
  var abbrs = document.getElementsByTagName('abbr');
  var acros = document.getElementsByTagName('acronym');
  arr = arr.concat(dfns, abbrs, acros);
  if ( (arr[0].length==0) &&
       (arr[1].length==0) && 
       (arr[2].length==0) ) {
    return false;
  }
  var glossArr = [];
  var used = [];
  for (var i=0; i<arr.length; i++) {
    if (arr[i].length < 1) continue;
    for (var j=0; j<arr[i].length; j++) {
      if (!arr[i][j].hasChildNodes()) continue;
      var trm = arr[i][j].firstChild.nodeValue;
      var dfn = arr[i][j].getAttribute('title');
      if (!used.inArray(trm)) {
        used.push(trm);
        glossArr[trm] = dfn;
      }
    }
  }
  if (used.length < 1) return false;
  glossArr = glossArr.ksort();
  var dl = buildDL(glossArr,'glossary');
  var h2     = document.createElement('h2');
  var h2_txt = document.createTextNode('Page Glossary');
  h2.appendChild(h2_txt);
  target.appendChild(h2);
  target.appendChild(dl);
  return true;
}
function buildDL(arr,cls) {
  var dl = document.createElement('dl');
  dl.className = cls;
  for (key in arr) {
    // strips out functions applied using prototypes
    // this should be replaced by something better 
    // at a later date - I'm open to suggestions
    if (arr[key].indexOf('function (') != -1 ||
        arr[key].indexOf('function(') != -1) continue;
    var dt     = document.createElement('dt');
    var dt_txt = document.createTextNode(key);
    dt.appendChild(dt_txt);
    dl.appendChild(dt);
    var dd     = document.createElement('dd');
    var dd_txt = document.createTextNode(arr[key]);
    dd.appendChild(dd_txt);
    dl.appendChild(dd);
  }
  return dl;
}
function setGlossary() {
  makeGlossary('extras');
}
window.onload.actions.push(setGlossary);