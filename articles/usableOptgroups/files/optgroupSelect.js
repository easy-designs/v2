//global variable for new array of options
var select2Options = new Array;

function splitOptgroupSelect()
{
  // make sure document.getElementById & document.getElementByTagName are understood first
  if (!document.getElementsByTagName && !document.getElementById) {
    return null;
  }
  
  // get the fieldset and the original select
  var fieldsetObj = document.getElementById(fieldsetID);
  var originalSelect = document.getElementById(selectID);
  
  // make sure we can add/remove options - thanks PPK!
lgth = originalSelect.options.length - 1;
originalSelect.options[0] = null;
  if (originalSelect.options[lgth])
  {
    return null;
  }
  
  // break out the optgroups into an array
  var optgroups = originalSelect.getElementsByTagName("optgroup");
  
  // create the state select dropdown
  var select1 = document.createElement("select");
  select1.setAttribute("name",select1Name); // set the name = locState
  select1.setAttribute("id",select1Name); // set the id = locState
  
  // create an empty first option
  var emptyOption = document.createElement("option");
  emptyOption.setAttribute("value","");                      // set value = ""
  emptyOption.setAttribute("selected","selected");           // make it selected
  emptyOption.innerHTML = select1Default;                    // set the text node value
  // attach option to select
  select1.appendChild(emptyOption);
  
  // make not applicable option
  if (notApplicable)
  {
    var naOption = document.createElement("option");
    naOption.setAttribute("value","N/A");                      // set value = "N/A"
    naOption.innerHTML = "Not Applicable";                    // set the text node value
    // attach option to select
    select1.appendChild(naOption);
  }
  
  // loop through the optgroup array
  for(var i=0; i < optgroups.length; i++)
  {
    // take 1 optgroup at a time
    var optgroup = optgroups[i];
    
    // extract the label
    var label = optgroup.label;

    // IE 5.x doesnot allow us to collect these options, so we need to stop
    if (optgroup.getElementsByTagName("option").length == 0)
    {
      return null;
    }
    
    // make an array of its options
    select2Options[label] = new Array;
    var options = optgroup.getElementsByTagName("option");
    for (j=0; j < options.length; j++)
    {
      select2Options[label][j] = new Array;
      select2Options[label][j]["value"] = options[j]["value"];
      select2Options[label][j]["text"] = options[j].innerHTML;
    }
    
    // create an option of this state
    var select1Option = document.createElement("option");
    select1Option.setAttribute("value",label);
    select1Option.innerHTML = label;
    
    // connect option to select
    select1.appendChild(select1Option);
  }
  
  // create a select for the locations
  var select2 = document.createElement("select");
  select2.setAttribute("name",select2Name);
  select2.setAttribute("id",select2Name);
  
  // add a placeholder option & attach
  var select2Option = document.createElement("option");
  select2Option.setAttribute("value",label);
  select2Option.setAttribute("selected","selected");
  select2Option.innerHTML = "&#60;--";
  select2.appendChild(select2Option);
  
  // create the new legend
  var newLegend = document.createElement("legend");
  newLegend.innerHTML = newLegendText;
  
  // assign some state and location labels
  var select1Label = document.createElement("label");
  select1Label.innerHTML = select1LabelText;
  select1Label.className = newSelectClass;
  var select2Label = document.createElement("label")
  select2Label.innerHTML = select2LabelText;
  select2Label.className = newSelectClass;
 
  // attach the selects to the labels
  select1Label.appendChild(select1);
  select2Label.appendChild(select2);
  
  // now replace the existing content of the fieldset with our new content
  removeContents(fieldsetObj);
  fieldsetObj.appendChild(newLegend);
  fieldsetObj.appendChild(select1Label);
  fieldsetObj.appendChild(select2Label);
  
  // attach the onchange event to the state select box
  document.getElementById(select1Name).onchange = changeOptions;
}

function changeOptions()
{
  var select1Obj = document.getElementById(select1Name);
  var select2Obj = document.getElementById(select2Name);
  
  // collect the value of the selected state
  var select1SelectedOption = select1Obj.options[select1Obj.selectedIndex].value;
  
  // get the array of options for it
  var newOptions = new Array;
  newOptions = select2Options[select1SelectedOption];
  
  // remove existing options from the select
  removeContents(select2Obj);
  
  // make not applicable option
  if (select1SelectedOption == "N/A")
  {
    var newOption = document.createElement("option");
    newOption.setAttribute("value","N/A");
    newOption.setAttribute("selected","selected");
    newOption.innerHTML = "Not Applicable";
    select2Obj.appendChild(newOption);
  } else { // add a blank 1st option
    var emptyOption = document.createElement("option");
    emptyOption.setAttribute("value","");
    // if the selected option is empty, revert to the <--
    if (select1SelectedOption == "")
    {
      emptyOption.innerHTML = "&#60;--";
    } else {
      emptyOption.innerHTML = select2Active;
    }
    select2Obj.appendChild(emptyOption);
  }
  if ((select1SelectedOption == "") ||
      (select1SelectedOption == "N/A")) // there's nothing else to do, stop now
  {
    return null;
  }

  // attach the new options to the select
  for (i=0; i < newOptions.length; i++)
  {
    var newOption = document.createElement("option");
    newOption.setAttribute("value",newOptions[i]["value"]);
    newOption.innerHTML = newOptions[i]["text"];
    select2Obj.appendChild(newOption);
  }
}

function removeContents(thisObj)
{
  while (thisObj.firstChild)
  {
    thisObj.removeChild(thisObj.firstChild);
  }
}

window.onload = function()
{
  if (!browser.isIEMac)
  {
    splitOptgroupSelect();
  }
}