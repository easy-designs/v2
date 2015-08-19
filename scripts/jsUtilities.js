/*------------------------------------------------------------------------------
Filename:       jsUtilities Library
Author:         Aaron Gustafson (aaron at easy-designs dot net)
                unless otherwise noted
Creation Date:  4 June 2005
Version:        2.0
Homepage:       http://www.easy-designs.net/code/jsUtilities/
License:        Creative Commons Attribution-ShareAlike 2.0 License
                http://creativecommons.org/licenses/by-sa/2.0/
Note:           If you change or improve on this script, please let us know by 
                emailing the author (above) with a link to your demo page.
------------------------------------------------------------------------------*/
// ---------------------------------------------------------------------
//                      array.push (if unsupported)
// ---------------------------------------------------------------------
if(Array.prototype.push == null) { Array.prototype.push = function(item) { this[this.length] = item; return this.length;};};
// ---------------------------------------------------------------------
//                      array.shift (if unsupported)
// ---------------------------------------------------------------------
 if (Array.prototype.shift == null) { Array.prototype.shift = function() { var response = this[0]; for (var i=0; i < this.length-1; i++) { this[i] = this[i + 1];}; this.length--; return response;};};
// ---------------------------------------------------------------------
//                  function.apply (if unsupported)
//           Courtesy of Aaron Boodman - http://youngpup.net
// ---------------------------------------------------------------------
if (!Function.prototype.apply) { Function.prototype.apply = function(oScope, args) { var sarg = []; var rtrn, call; if (!oScope) oScope = window; if (!args) args = []; for (var i = 0; i < args.length; i++) { sarg[i] = "args["+i+"]";}; call = "oScope.__applyTemp__(" + sarg.join(",") + ");"; oScope.__applyTemp__ = this; rtrn = eval(call); oScope.__applyTemp__ = null; return rtrn;};}; 
// ---------------------------------------------------------------------
//                               inArray()
//                           [Port from PHP]
//               Hunts for a value in the specified array
// ---------------------------------------------------------------------
Array.prototype.inArray = function(needle) { for (var i=0; i < this.length; i++) { if (this[i] === needle) { return i;} } return false;}
// ---------------------------------------------------------------------
//                               isArray()
//                           [Port from PHP]
//                  verifies if something is an array
// ---------------------------------------------------------------------
Array.prototype.isArray = function() { return (typeof(this.length)=="undefined") ? false : true;}; 
// ---------------------------------------------------------------------
//                               ksort()
//                           [Port from PHP]
//                     sorts an array by key names
// ---------------------------------------------------------------------
Array.prototype.ksort = function() { var sArr = []; var tArr = []; var n = 0; for (i in this)
tArr[n++] = i+"|"+this[i]; tArr = tArr.sort(); for (var i=0; i<tArr.length; i++) { var x = tArr[i].split("|"); sArr[x[0]] = x[1];} return sArr;}
// ---------------------------------------------------------------------
//                             addClass()
//                 appends the specified class to the object
// ---------------------------------------------------------------------
Object.prototype.addClass = function(theClass) { if (this.getAttribute('class')) { this.setAttribute('class',this.getAttribute('class')+' '+theClass);} else { this.setAttribute('class',theClass);} }
// ---------------------------------------------------------------------
//                           removeClass()
//                 removes the specified class to the object
// ---------------------------------------------------------------------
Object.prototype.removeClass = function(theClass) { var oldClass = this.getAttribute('class'); var regExp = new RegExp('\\s?'+theClass+'\\b'); if (oldClass.indexOf(theClass) != -1) { this.setAttribute('class',oldClass.replace(regExp,''));} }
// ---------------------------------------------------------------------
//                      lastChildContainingText()
//  finds the last block-level text-containing element within an object
// ---------------------------------------------------------------------
Object.prototype.lastChildContainingText = function() { var testChild = this.lastChild; var contentCntnr = ['p','li','dd']; do { testChild = testChild.previousSibling;} while (testChild.nodeType != 1)
var tag = testChild.tagName.toLowerCase(); var tagInArr = contentCntnr.inArray(tag); if (!tagInArr && tagInArr!==0) { testChild = testChild.lastChildContainingText();} return testChild;}