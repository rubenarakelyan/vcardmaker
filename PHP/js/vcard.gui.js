/*
    This file is part of vCardMaker.

    vCardMaker is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    vCardMaker is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with vCardMaker.  If not, see <http://www.gnu.org/licenses/>.
*/

// Global variables
var page1state = "down", page2state = "down", page3state = "down", page4state = "down", page5state = "down";
var vCardMakerHelpWindowReference = null;

// Update the formatted name using the other name fields
function vCardUpdateFormattedName()
{
  var fullname = $("#Name-Prefix").val() + " " + $("#Name-Forename").val() + " " + $("#Name-Additional").val() + " " + $("#Name-Surname").val() + " " + $("#Name-Suffix").val();
  fullname = fullname.replace(/^\s*|\s*$/g, "");
  fullname = fullname.replace(/\s{2,}/, " ");
  $("#Name-Formatted").val(fullname);
}

// Generic show and hide toggle element
function vCardShowHideToggle(element, showhide)
{
  if (showhide == "in")
  {
    $("#" + element).slideDown("slow");
  }
  else if (showhide == "out")
  {
    $("#" + element).slideUp("slow");
  }
  else
  {
    $("#" + element).slideToggle("slow");
  }
}

// Change toggle symbol
function vCardToggleSymbol(element, text, page, showhide) {
  if (showhide == "in")
  {
    switch (page)
    {
      case 1:
        page1state = "up";
        break;
      case 2:
        page2state = "up";
        break;
      case 3:
        page3state = "up";
        break;
      case 4:
        page4state = "up";
        break;
      case 5:
        page5state = "up";
        break;
    }
    $("#" + element).attr("src", "images/up.png");
    $("#" + text).html(toggleFewer);
  }
  else if (showhide == "out")
  {
    switch (page)
    {
      case 1:
        page1state = "down";
        break;
      case 2:
        page2state = "down";
        break;
      case 3:
        page3state = "down";
        break;
      case 4:
        page4state = "down";
        break;
      case 5:
        page5state = "down";
        break;
    }
    $("#" + element).attr("src", "images/down.png");
    $("#" + text).html(toggleMore);
  }
  else
  {
    var state;
    switch (page)
    {
      case 1:
        state = page1state;
        break;
      case 2:
        state = page2state;
        break;
      case 3:
        state = page3state;
        break;
      case 4:
        state = page4state;
        break;
      case 5:
        state = page5state;
        break;
    }
    if (state == "up")
    {
      switch (page)
      {
        case 1:
          page1state = "down";
          break;
        case 2:
          page2state = "down";
          break;
        case 3:
          page3state = "down";
          break;
        case 4:
          page4state = "down";
          break;
        case 5:
          page5state = "down";
          break;
      }
      $("#" + element).attr("src", "images/down.png");
      $("#" + text).html(toggleMore);
    }
    else if (state == "down")
    {
      switch (page)
      {
        case 1:
          page1state = "up";
          break;
        case 2:
          page2state = "up";
          break;
        case 3:
          page3state = "up";
          break;
        case 4:
          page4state = "up";
          break;
        case 5:
          page5state = "up";
          break;
      }
      $("#" + element).attr("src", "images/up.png");
      $("#" + text).html(toggleFewer);
    }
  }
}

// Toggle photo section
function vCardTogglePhotoSection()
{
  var selected = $("#Photo-Type")[0].selectedIndex;
  if (selected == 1)
  {
    // URL
    vCardShowHideToggle("vcard-section-photoincluded-1", "out");
    vCardShowHideToggle("vcard-section-photoincluded-2", "in");
  }
  else if (selected == 2 || selected == 3)
  {
    // Photo included
    vCardShowHideToggle("vcard-section-photoincluded-1", "in");
    vCardShowHideToggle("vcard-section-photoincluded-2", "in");
  }
  else
  {
    vCardShowHideToggle("vcard-section-photoincluded-1", "out");
    vCardShowHideToggle("vcard-section-photoincluded-2", "out");
  }
}

// Toggle logo section
function vCardToggleLogoSection()
{
  var selected = $("#Logo-Type")[0].selectedIndex;
  if (selected == 1)
  {
    // URL
    vCardShowHideToggle("vcard-section-logoincluded-1", "out");
    vCardShowHideToggle("vcard-section-logoincluded-2", "in");
  }
  else if (selected == 2 || selected == 3)
  {
    // Logo included
    vCardShowHideToggle("vcard-section-logoincluded-1", "in");
    vCardShowHideToggle("vcard-section-logoincluded-2", "in");
  }
  else
  {
    vCardShowHideToggle("vcard-section-logoincluded-1", "out");
    vCardShowHideToggle("vcard-section-logoincluded-2", "out");
  }
}

// Toggle agent section
function vCardToggleAgentSection()
{
  var selected = $("#Agent-Type")[0].selectedIndex;
  if (selected == 1 || selected == 2)
  {
    vCardShowHideToggle("vcard-section-agentsource", "in");
  }
  else
  {
    vCardShowHideToggle("vcard-section-agentsource", "out");
  }
}

// Toggle sound section
function vCardToggleSoundSection()
{
  var selected = $("#Sound-Type")[0].selectedIndex;
  if (selected == 1 || selected == 2)
  {
    // Phonetic/URL
    vCardShowHideToggle("vcard-section-soundincluded-1", "out");
    vCardShowHideToggle("vcard-section-soundincluded-2", "in");
  }
  else if (selected == 3)
  {
    // Sound included
    vCardShowHideToggle("vcard-section-soundincluded-1", "in");
    vCardShowHideToggle("vcard-section-soundincluded-2", "in");
  }
  else
  {
    vCardShowHideToggle("vcard-section-soundincluded-1", "out");
    vCardShowHideToggle("vcard-section-soundincluded-2", "out");
  }
}

// Toggle key section
function vCardToggleKeySection()
{
  var selected = $("#Key-Type")[0].selectedIndex;
  if (selected == 1 || selected == 2 || selected == 3)
  {
    // Key included
    vCardShowHideToggle("vcard-section-keyincluded", "in");
  }
  else
  {
    vCardShowHideToggle("vcard-section-keyincluded", "out");
  }
}

// Copy address to delivery label and vice versa
function vCardSetAddress(fromfieldname, tofieldname)
{
  // Set the address type checkboxes
  $("#" + tofieldname + "-Type-DOM").checked = $("#" + fromfieldname + "-Type-DOM").checked;
  $("#" + tofieldname + "-Type-INTL").checked = $("#" + fromfieldname + "-Type-INTL").checked;
  $("#" + tofieldname + "-Type-POSTAL").checked = $("#" + fromfieldname + "-Type-POSTAL").checked;
  $("#" + tofieldname + "-Type-PARCEL").checked = $("#" + fromfieldname + "-Type-PARCEL").checked;
  $("#" + tofieldname + "-Type-HOME").checked = $("#" + fromfieldname + "-Type-HOME").checked;
  $("#" + tofieldname + "-Type-WORK").checked = $("#" + fromfieldname + "-Type-WORK").checked;
  // Copy over the main address details
  $("#" + tofieldname + "-PostOfficeAddress").attr("value", $("#" + fromfieldname + "-PostOfficeAddress").attr("value"));
  $("#" + tofieldname + "-ExtendedAddress").attr("value", $("#" + fromfieldname + "-ExtendedAddress").attr("value"));
  $("#" + tofieldname + "-Street").attr("value", $("#" + fromfieldname + "-Street").attr("value"));
  $("#" + tofieldname + "-Locality").attr("value", $("#" + fromfieldname + "-Locality").attr("value"));
  $("#" + tofieldname + "-Region").attr("value", $("#" + fromfieldname + "-Region").attr("value"));
  $("#" + tofieldname + "-PostalCode").attr("value", $("#" + fromfieldname + "-PostalCode").attr("value"));
  // Set the country
  var fromfield = $("#" + fromfieldname + "-Country option:selected")[0].val();
  $("#" + tofieldname + "-Country option:contains(" + fromfield + ")").attr("selected", "selected");
}

// Submit the vCard form
function vCardSubmit()
{
  // Scroll to the top of the page
  $("html,body").animate({scrollTop: 0}, 400);
  // Display the results overlay
  $("html").css("overflow", "hidden");
  $("#results").css("display", "block");
  // Show the spinner and close button
  $("#results-close").css("display", "block");
  $("#results-spinner").css("display", "block");
  // Get the vCard
  $.ajax({cache: false, data: $("#vCardMaker").serialize(), error: function (XMLHttpRequest, textStatus, errorThrown) { $("#results-spinner").css("display", "none"); $("#results").html(textStatus); }, success: function (data, textStatus) { $("#results-spinner").css("display", "none"); $("#results").html(data); }, type: "POST", url: makeURL});
}

// Close the vCard results
function vCardSubmitClose()
{
  // Hide the results overlay and close button
  $("#results").css("display", "none");
  $("#results-close").css("display", "none");
  $("html").css("overflow", "auto");
  // Clear the vCard
  $("#results").html("");
}

// Provide contextual help
// See http://developer.mozilla.org/en/docs/DOM:window.open
function vCardMakerHelp(topic)
{
  if (vCardMakerHelpWindowReference == null || vCardMakerHelpWindowReference.closed)
  {
    vCardMakerHelpWindowReference = window.open("Help.php?" + topic, "vCardMakerHelpWindow", "left=" + (screen.width - 200) + ",top=0,height=" + screen.height + ",width=200,menubar=no,toolbar=no,location=yes,directories=no,status=yes,resizable=yes,scrollbars=yes");
  }
  else
  {
    vCardMakerHelpWindowReference.focus();
    vCardMakerHelpWindowReference.location.replace("Help.php?" + topic);
  }
}


$(document).ready(function()
{
  // Hide advanced sections
  vCardShowHideToggle("page1advanced", "out");
  vCardShowHideToggle("page2advanced", "out");
  vCardShowHideToggle("page3advanced", "out");
  vCardShowHideToggle("page4advanced", "out");
  vCardShowHideToggle("page5advanced", "out");
  // Hide extra form elements
  vCardTogglePhotoSection();
  vCardToggleLogoSection();
  vCardToggleAgentSection();
  vCardToggleSoundSection();
  vCardToggleKeySection();
  // Add tabs
  $("#tabs").tabs();
  // Events: toggle advanced sections
  $("#page1advancedtoggle").click(function() { vCardToggleSymbol("page1advancedtogglesymbol", "page1advancedtoggletext", 1); vCardShowHideToggle("page1advanced"); return false; });
  $("#page2advancedtoggle").click(function() { vCardToggleSymbol("page2advancedtogglesymbol", "page2advancedtoggletext", 2); vCardShowHideToggle("page2advanced"); return false; });
  $("#page3advancedtoggle").click(function() { vCardToggleSymbol("page3advancedtogglesymbol", "page3advancedtoggletext", 3); vCardShowHideToggle("page3advanced"); return false; });
  $("#page4advancedtoggle").click(function() { vCardToggleSymbol("page4advancedtogglesymbol", "page4advancedtoggletext", 4); vCardShowHideToggle("page4advanced"); return false; });
  $("#page5advancedtoggle").click(function() { vCardToggleSymbol("page5advancedtogglesymbol", "page5advancedtoggletext", 5); vCardShowHideToggle("page5advanced"); return false; });
  // Events: toggle extra form elements
  $("#Photo-Type").change(function() { vCardTogglePhotoSection(); });
  $("#Logo-Type").change(function() { vCardToggleLogoSection(); });
  $("#Agent-Type").change(function() { vCardToggleAgentSection(); });
  $("#Sound-Type").change(function() { vCardToggleSoundSection(); });
  $("#Key-Type").change(function() { vCardToggleKeySection(); });
  // Events: enable enhanced submit button
  $("#vCardMaker").submit(function() { vCardSubmit(); return false; });
  // Events: enable results close buttons
  $("#results-close").click(function() { vCardSubmitClose(); });
  // Add a date picker
  $("#Birth-Date").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd' });
});