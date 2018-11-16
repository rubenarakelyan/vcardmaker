<?php

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

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>vCardMaker Help</title>
<link rel="stylesheet" type="text/css" href="styles.css" media="all">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js"></script>
<script type="text/javascript">
// <![CDATA[
// Generic show and hide toggle element
var state;
function vCardShowHideToggle(element, showhide) {
  if (showhide == 'in') {
    state = 'up';
    document.getElementById(element+'toggleicon').src = 'images/up.png';
    $('#'+element).slideDown('slow');
  } else if (showhide == 'out') {
    state = 'down';
    document.getElementById(element+'toggleicon').src = 'images/down.png';
    $('#'+element).slideUp('slow');
  } else {
    if (state == 'down') {
      state = 'up';
      document.getElementById(element+'toggleicon').src = 'images/up.png';
    } else {
      state = 'down';
      document.getElementById(element+'toggleicon').src = 'images/down.png';
    }
    $('#'+element).slideToggle('slow');
  }
}

$(document).ready(function() {
  // Hide the more info section
  vCardShowHideToggle('moreinfo', 'out');
  // Add toggle behaviour to the more info section
  $('a#moreinfotoggle').click(function() {
    vCardShowHideToggle('moreinfo');
    return false;
  });
  // Open certain links in a new window
  $('a._new_window').click(function() {
    window.open(this.href, '', '');
    return false;
  });
});
// ]]>
</script>
</head>

<body class="help">

<div id="staticcontent">

<h2>vCardMaker Help</h2>

<?php
    
    $isValid = false;

    switch ($_SERVER['QUERY_STRING'])
    {
        case 'Forename':
            echo '<div class="versioninfo">This field is required.</div><p>Enter your given name.</p>';
            $isValid = true;
            break;
        case 'Surname':
            echo '<div class="versioninfo">This field is required</div><p>Enter your family name.</p>';
            $isValid = true;
            break;
        case 'Photo':
            echo '<div class="versioninfo"><span class="vcard-only21">Some options in this field are only available in version 2.1 vCards.</span></div><p>Select either <strong>URL</strong> to provide an address to a photo or <strong>Base64</strong>/<strong class="vcard-only21">Quoted-Printable</strong> to enter an inline image. For the latter you must also select the type of photo from the list.</p>';
            $isValid = true;
            break;
        case 'BirthDate':
            echo '<p>Enter your date of birth, using the calendar if required. The correct format is <strong>YYYY-MM-DD</strong>.</p>';
            $isValid = true;
            break;
        case 'Version':
            echo '<div class="versioninfo">This field is required.</div><p>Select either <strong class="vcard-only21">2.1</strong> or <strong class="vcard-only30">3.0</strong> depending on the vCard version you require. If you\'re not sure, select <strong class="vcard-only21">2.1</strong>.</p>';
            $isValid = true;
            break;
        case 'vCardName':
            echo '<div class="versioninfo"><span class="vcard-only30">This field is only available in version 3.0 vCards.</span></div><p>Enter a name for this vCard. This is useful if you have multiple vCards.</p>';
            $isValid = true;
            break;
        case 'vCardSourceURL':
            echo '<div class="versioninfo"><span class="vcard-only30">This field is only available in version 3.0 vCards.</span></div><p>Enter the URL where a copy of the vCard may be found and downloaded.</p>';
            $isValid = true;
            break;
        case 'FullName':
            echo '<div class="versioninfo">This field is required.</div><p>Enter your full name as you would like it to be displayed including any titles, middle names and suffixes. <strong>This field is filled out automatically when you enter your forename, surname, middles names, title and suffix.</strong></p>';
            $isValid = true;
            break;
        case 'Title':
            echo '<p>Enter your title (such as Mr., Sir etc.)</p>';
            $isValid = true;
            break;
        case 'MiddleNames':
            echo '<p>Enter your middle name(s).</p>';
            $isValid = true;
            break;
        case 'Suffix':
            echo '<p>Enter any suffixes to your name (such as organisational memberships, qualifications etc.)</p>';
            $isValid = true;
            break;
        case 'SortOrder':
            echo '<div class="versioninfo"><span class="vcard-only30">This field is only available in version 3.0 vCards.</span></div><p>Enter your forename or surname to specify where your vCard should appear when sorted alphabetically alongside other vCards.</p>';
            $isValid = true;
            break;
        case 'Nicknames':
            echo '<div class="versioninfo"><span class="vcard-only30">This field is only available in version 3.0 vCards.</span></div><p>Enter any nickname(s) by which you are known.</p>';
            $isValid = true;
            break;
        case 'BirthTime':
            echo '<div class="versioninfo"><span class="vcard-only30">This field is only available in version 3.0 vCards.</span></div><p>Enter your time of birth. The correct format is <strong>HH:MM:SS</strong>. Seconds may be left out.</p>';
            $isValid = true;
            break;
        case 'BirthTimezone':
            echo '<div class="versioninfo"><span class="vcard-only30">This field is only available in version 3.0 vCards.</span></div><p>Select the time zone of your time of birth.</p>';
            $isValid = true;
            break;
        case 'DeliveryAddressType':
            echo '<p>Select the type of address you will be entering below. You may choose one or more types.</p>';
            $isValid = true;
            break;
        case 'DeliveryAddressPOAddress':
            echo '<p>Enter the PO Box details of this address.</p>';
            $isValid = true;
            break;
        case 'DeliveryAddressBuildingName':
            echo '<p>Enter the building name or number of this address.</p>';
            $isValid = true;
            break;
        case 'DeliveryAddressStreet':
            echo '<p>Enter the street name of this address.</p>';
            $isValid = true;
            break;
        case 'DeliveryAddressLocality':
            echo '<p>Enter the town/city of this address.</p>';
            $isValid = true;
            break;
        case 'DeliveryAddressRegion':
            echo '<p>Enter the county/state of this address.</p>';
            $isValid = true;
            break;
        case 'DeliveryAddressPostalCode':
            echo '<p>Enter the postal code of this address.</p>';
            $isValid = true;
            break;
        case 'DeliveryAddressCountry':
            echo '<p>Select the country of this address.</p>';
            $isValid = true;
            break;
        case 'DeliveryLabelType':
            echo '<p>Select the type of address you will be entering below. You may choose one or more types.</p>';
            $isValid = true;
            break;
        case 'DeliveryLabelPOAddress':
            echo '<p>Enter the PO Box details of this address.</p>';
            $isValid = true;
            break;
        case 'DeliveryLabelBuildingName':
            echo '<p>Enter the building name or number of this address.</p>';
            $isValid = true;
            break;
        case 'DeliveryLabelStreet':
            echo '<p>Enter the street name of this address.</p>';
            $isValid = true;
            break;
        case 'DeliveryLabelLocality':
            echo '<p>Enter the town/city of this address.</p>';
            $isValid = true;
            break;
        case 'DeliveryLabelRegion':
            echo '<p>Enter the county/state of this address.</p>';
            $isValid = true;
            break;
        case 'DeliveryLabelPostalCode':
            echo '<p>Enter the postal code of this address.</p>';
            $isValid = true;
            break;
        case 'DeliveryLabelCountry':
            echo '<p>Select the country of this address.</p>';
            $isValid = true;
            break;
        case 'TelephoneNumberType':
            echo '<p>Select the type of telephone number you will be entering below.</p>';
            $isValid = true;
            break;
        case 'TelephoneNumberPreferred':
            echo '<p>Select this option to show that this telephone number is your preferred one. This option is automatically selected for the first telephone number and cannot be selected for any other telephone number.</p>';
            $isValid = true;
            break;
        case 'TelephoneNumberMessaging':
            echo '<p>Select this option to show that there is a messaging service (e.g. answering machine or voicemail) active on this telephone number.</p>';
            $isValid = true;
            break;
        case 'TelephoneNumber':
            echo '<p>Enter your telephone number.</p>';
            $isValid = true;
            break;
        case 'EmailAddressType':
            echo '<p>Select the type of email address you will be entering below. The type of the first email address is always "Internet SMTP".</p>';
            $isValid = true;
            break;
        case 'EmailAddressPreferred':
            echo '<div class="versioninfo"><span class="vcard-only30">This field is only available in version 3.0 vCards.</span></div><p>Select this option to show that this email address is your preferred one. This option is automatically selected for the first email address and cannot be selected for any other email address.</p>';
            $isValid = true;
            break;
        case 'EmailAddress':
            echo '<div class="versioninfo">The first instance of this field is required.</div><p>Enter your email address.</p>';
            $isValid = true;
            break;
        case 'Mailer':
            echo '<p>Enter the name of the application/service you mainly use to send email.</p>';
            $isValid = true;
            break;
        case 'OrganisationName':
            echo '<p>Enter the name of the organisation you work for.</p>';
            $isValid = true;
            break;
        case 'JobTitle':
            echo '<p>Enter your job title.</p>';
            $isValid = true;
            break;
        case 'OrganisationalUnit':
            echo '<p>Enter the name of the unit (i.e. department) you work in within your organisation.</p>';
            $isValid = true;
            break;
        case 'JobRole':
            echo '<p>Enter a slightly expanded version of your job title.</p>';
            $isValid = true;
            break;
        case 'OrganisationLogo':
            echo '<div class="versioninfo"><span class="vcard-only21">Some options in this field are only available in version 2.1 vCards.</span></div><p>Select either <strong>URL</strong> to provide an address to a logo or <strong>Base64</strong>/<strong class="vcard-only21">Quoted-Printable</strong> to enter an inline logo. For the latter you must also select the type of logo from the list.</p>';
            $isValid = true;
            break;
        case 'Agent':
            echo '<div class="versioninfo"><span class="vcard-only30">Some options in this field are only available in version 3.0 vCards.</span></div><p>Select either <strong class="vcard-only30">URL</strong> to provide an address to the vCard of a person who should be contacted for enquiries in your absence or <strong>vCard</strong> to include their vCard directly in yours.</p>';
            $isValid = true;
            break;
        case 'URL':
            echo '<p>Enter your personal website address or that of your employer.</p>';
            $isValid = true;
            break;
        case 'Timezone':
            echo '<p>Select the time zone of your address.</p><p>For help with working out your time zone, see the <a href="http://en.wikipedia.org/wiki/List_of_time_zones" class="_new_window">list of time zones</a> along with principal cities.</p>';
            $isValid = true;
            break;
        case 'AddressPosition':
            echo '<p>Enter the geographical location of your address.</p>';
            $isValid = true;
            break;
        case 'Categories':
            echo '<div class="versioninfo"><span class="vcard-only30">This field is only available in version 3.0 vCards.</span></div><p>Enter a comma-separated list of categories that this vCard fits into (e.g. work, home etc.)</p>';
            $isValid = true;
            break;
        case 'Comments':
            echo '<p>Enter any additional comments to be attached to this vCard.</p>';
            $isValid = true;
            break;
        case 'Sound':
            echo '<div class="versioninfo"><span class="vcard-only21">Some options in this field are only available in version 2.1 vCards.</span></div><p>Select either <strong class="vcard-only21">Phonetic</strong> to enter a phonetic representation of your full name, <strong>URL</strong> to provide an address to a sound file of the pronunciation or <strong>Base64</strong> to enter an inline sound file.</p>';
            $isValid = true;
            break;
        case 'Class':
            echo '<div class="versioninfo"><span class="vcard-only30">This field is only available in version 3.0 vCards.</span></div><p>Select a classification for your vCard. <strong>Note that this is purely informational and DOES NOT provide any actual protection for your vCard.</strong></p>';
            $isValid = true;
            break;
        case 'EncryptionKey':
            echo '<div class="versioninfo"><span class="vcard-only30">Some options in this field are only available in <span class="vcard-only21">version 2.1</span> or version 3.0 vCards.</span></div><p>Select a key type (either <strong class="vcard-only21">PGP</strong>, <strong class="vcard-only21">X.509</strong> or <strong class="vcard-only30">Binary</strong> and enter your public key. <strong>Do not enter your private key here.</strong></p>';
            $isValid = true;
            break;
        default:
            echo '<div class="versioninfo">This help topic cannot be found.</div>';
            break;
    }

    if ($isValid)
    {

?>

<a href="#" id="moreinfotoggle"><img src="images/down.png" width="25" height="30" alt="" style="vertical-align: middle;" id="moreinfotoggleicon"> More information on alerts</a>
<div id="moreinfo">
<p>Fields or options coloured <strong class="vcard-only21">blue</strong> are only available when creating version 2.1 vCards while <strong class="vcard-only30">red</strong> ones are only available when creating version 3.0 vCards. All other options are universally available.</p>
<p>Possible alerts are:</p>
<ul>
<li><strong>This field is required</strong>: The field that this topic refers to is compulsory for your vCard.</li>
<li><strong>The first instance of this field is required</strong>: Where there is more than one instance of a particular field (such as email address), then one is compulsory and the rest are optional.</li>
<li><strong>This field is only available in version <em>version number</em> vCards</strong>: You can only enter data in this field if you have chosen to make a <em>version number</em> vCard.</li>
<li><strong>Some options in this field are only available in version <em>version number</em> [or version <em>version number</em>] vCards</strong>: If you have chosen certain options for this field (coloured blue or red), then you can only enter data if you have chosen to make a <em>version number</em> vCard. In this case, options which require a specific vCard version are coloured either blue or red in the help topic.</li>
</ul>
</div>

<?php
    }
?>

</div>

</body>
</html>