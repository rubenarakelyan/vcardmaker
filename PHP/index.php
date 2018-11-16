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

    // Include the appropriate language file
    require_once 'vCardMaker_GUI_Lang.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>vCardMaker: Make electronic business cards quickly and easily</title>
<link rel="stylesheet" type="text/css" href="styles.css" media="all">
<!--[if IE]><link rel="stylesheet" type="text/css" href="styles-ie.css" media="all"><![endif]-->
<link rel="stylesheet" type="text/css" href="images/blitzer/jquery-ui-1.7.2.custom.css" media="all">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/vcard.gui.js"></script>
<script type="text/javascript">
var makeURL = "Make.php";
var toggleMore = "<?php echo $vCardMaker_GUI_Lang['CToggleAdvanced']; ?>";
var toggleFewer = "<?php echo $vCardMaker_GUI_Lang['CToggleAdvancedClose']; ?>";
</script>
</head>

<body>

<div id="header"><h1>vCardMaker</h1></div>

<form action="Make.php" method="post" id="vCardMaker">

<div id="tabs">

<ul><li><a href="#page1"><?php echo $vCardMaker_GUI_Lang['CInstructions1']; ?></a></li><li><a href="#page2"><?php echo $vCardMaker_GUI_Lang['CInstructions2']; ?></a></li><li><a href="#page3"><?php echo $vCardMaker_GUI_Lang['CInstructions3']; ?></a></li><li><a href="#page4"><?php echo $vCardMaker_GUI_Lang['CInstructions4']; ?></a></li><li><a href="#page5"><?php echo $vCardMaker_GUI_Lang['CInstructions5']; ?></a></li></ul>

<!-- Page 1 - Personal -->
<fieldset id="page1">
<ol>
<li><label for="Name-Forename"><em><?php echo $vCardMaker_GUI_Lang['CForename']; ?></em> <a href="#" onclick="vCardMakerHelp('Forename'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="Name.Forename" value="" size="35" maxlength="255" id="Name-Forename" onblur="vCardUpdateFormattedName();"></li>
<li><label for="Name-Surname"><em><?php echo $vCardMaker_GUI_Lang['CSurname']; ?></em> <a href="#" onclick="vCardMakerHelp('Surname'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="Name.Surname" value="" size="35" maxlength="255" id="Name-Surname" onblur="vCardUpdateFormattedName();"></li>
<li><label for="Photo-Type"><?php echo $vCardMaker_GUI_Lang['CPhotoType']; ?> <a href="#" onclick="vCardMakerHelp('Photo'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br>
<select name="Photo.Type" id="Photo-Type">
<option value="None" selected="selected"></option>
<option value="URL"><?php echo $vCardMaker_GUI_Lang['CPhotoTypeURL']; ?></option>
<option value="BASE64"><?php echo $vCardMaker_GUI_Lang['CPhotoTypeBase64']; ?></option>
<option value="QUOTED-PRINTABLE" class="vcard-only21"><?php echo $vCardMaker_GUI_Lang['CPhotoTypeQP']; ?></option>
</select></li>
<li id="vcard-section-photoincluded-1"><label for="Photo-Format"><?php echo $vCardMaker_GUI_Lang['CPhotoFormat']; ?></label><br>
<select name="Photo.Format" id="Photo-Format">
<option value="GIF">Graphics Interchange Format (GIF)</option>
<option value="CGM">ISO Computer Graphics Metafile (CGM)</option>
<option value="WMF">Microsoft Windows Metafile (WMF)</option>
<option value="BMP">Microsoft Windows Bitmap (BMP)</option>
<option value="MET">IBM PM Metafile (MET)</option>
<option value="PMB">IBM PM Bitmap (PMB)</option>
<option value="DIB">Microsoft Windows DIB (DIB)</option>
<option value="PICT">Apple Picture (PICT)</option>
<option value="TIFF">Tagged Image File Format (TIFF)</option>
<option value="PS">Adobe PostScript (PS)</option>
<option value="PDF">Adobe Portable Document Format (PDF)</option>
<option value="JPEG">ISO Joint Photographic Experts Group (JPEG)</option>
<option value="MPEG">ISO Moving Picture Experts Group (MPEG)</option>
<option value="MPEG2">ISO Moving Picture Experts Group version 2 (MPEG2)</option>
<option value="AVI">Intel Audio/Video Interleave (AVI)</option>
<option value="QTIME">Apple QuickTime (QTIME)</option>
</select></li>
<li id="vcard-section-photoincluded-2"><label for="Photo-Source"><?php echo $vCardMaker_GUI_Lang['CPhoto']; ?></label><br><textarea cols="40" rows="15" name="Photo.Source" id="Photo-Source"></textarea></li>
<li><label for="Birth-Date"><?php echo $vCardMaker_GUI_Lang['CBirthdate']; ?> <a href="#" onclick="vCardMakerHelp('BirthDate'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="Birth.Date" value="" size="10" maxlength="10" id="Birth-Date"></li>
</ol>
<p><a href="#" id="page1advancedtoggle"><img src="images/down.png" width="25" height="30" alt="" id="page1advancedtogglesymbol" class="togglesymbol"> <span id="page1advancedtoggletext"><?php echo $vCardMaker_GUI_Lang['CToggleAdvanced']; ?></span></a></p>
<div id="page1advanced">
<ol>
<li><?php echo $vCardMaker_GUI_Lang['CVersion']; ?> <a href="#" onclick="vCardMakerHelp('Version'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a><br><input type="radio" name="vCard.Version" value="2.1" id="vCard-Version-2.1" class="radio" checked="checked"> <label for="vCard-Version-2.1" class="vcard-only21"><em><?php echo $vCardMaker_GUI_Lang['CVersion21']; ?></em></label> <input type="radio" name="vCard.Version" value="3.0" id="vCard-Version-3.0" class="radio"> <label for="vCard-Version-3.0" class="vcard-only30"><em><?php echo $vCardMaker_GUI_Lang['CVersion30']; ?></em></label></li>
<li><label for="vCard-Name"><span class="vcard-only30"><?php echo $vCardMaker_GUI_Lang['CName']; ?></span> <a href="#" onclick="vCardMakerHelp('vCardName'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="vCard.Name" value="" size="35" maxlength="255" id="vCard-Name"></li>
<li><label for="vCard-Source"><span class="vcard-only30"><?php echo $vCardMaker_GUI_Lang['CSource']; ?></span> <a href="#" onclick="vCardMakerHelp('vCardSourceURL'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="vCard.Source" value="" size="35" maxlength="255" id="vCard-Source"></li>
<li><label for="Name-Formatted"><em><?php echo $vCardMaker_GUI_Lang['CFormattedName']; ?></em> <a href="#" onclick="vCardMakerHelp('FullName'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="Name.Formatted" value="" size="35" maxlength="255" id="Name-Formatted"></li>
<li><label for="Name-Prefix"><?php echo $vCardMaker_GUI_Lang['CPrefix']; ?> <a href="#" onclick="vCardMakerHelp('Title'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="Name.Prefix" value="" size="10" maxlength="10" id="Name-Prefix" onblur="vCardUpdateFormattedName();"></li>
<li><label for="Name-Additional"><?php echo $vCardMaker_GUI_Lang['CMiddleNames']; ?> <a href="#" onclick="vCardMakerHelp('MiddleNames'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="Name.Additional" value="" size="35" maxlength="255" id="Name-Additional" onblur="vCardUpdateFormattedName();"></li>
<li><label for="Name-Suffix"><?php echo $vCardMaker_GUI_Lang['CSuffix']; ?> <a href="#" onclick="vCardMakerHelp('Suffix'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="Name.Suffix" value="" size="10" maxlength="10" id="Name-Suffix" onblur="vCardUpdateFormattedName();"></li>
<li><label for="Sort"><span class="vcard-only30"><?php echo $vCardMaker_GUI_Lang['CSort']; ?></span> <a href="#" onclick="vCardMakerHelp('SortOrder'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="Sort" value="" size="35" maxlength="255" id="Sort"></li>
<li><label for="Nickname"><span class="vcard-only30"><?php echo $vCardMaker_GUI_Lang['CNickname']; ?></span> <a href="#" onclick="vCardMakerHelp('Nicknames'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="Nickname" value="" size="35" maxlength="255" id="Nickname"></li>
<li><label for="Birth-Time"><span class="vcard-only30"><?php echo $vCardMaker_GUI_Lang['CBirthtime']; ?></span> <a href="#" onclick="vCardMakerHelp('BirthTime'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="Birth.Time" value="" size="10" maxlength="10" id="Birth-Time"></li>
<li><label for="Birth-Time-Zone"><span class="vcard-only30"><?php echo $vCardMaker_GUI_Lang['CBirthtimezone']; ?></span> <a href="#" onclick="vCardMakerHelp('BirthTimezone'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br>
<!-- Information from http://en.wikipedia.org/wiki/List_of_time_zones -->
<select name="Birth.Time.Zone" id="Birth-Time-Zone">
<option value=""></option>
<option value="-12:00">-12:00</option>
<option value="-11:00">-11:00</option>
<option value="-10:00">-10:00</option>
<option value="-09:30">-09:30</option>
<option value="-09:00">-09:00</option>
<option value="-08:00">-08:00</option>
<option value="-07:00">-07:00</option>
<option value="-06:00">-06:00</option>
<option value="-05:00">-05:00</option>
<option value="-04:30">-04:30</option>
<option value="-04:00">-04:00</option>
<option value="-03:30">-03:30</option>
<option value="-03:00">-03:00</option>
<option value="-02:00">-02:00</option>
<option value="-01:00">-01:00</option>
<option value="+00:00">+00:00</option>
<option value="+01:00">+01:00</option>
<option value="+02:00">+02:00</option>
<option value="+03:00">+03:00</option>
<option value="+03:30">+03:30</option>
<option value="+04:00">+04:00</option>
<option value="+04:30">+04:30</option>
<option value="+05:00">+05:00</option>
<option value="+05:30">+05:30</option>
<option value="+05:45">+05:45</option>
<option value="+06:00">+06:00</option>
<option value="+06:30">+06:30</option>
<option value="+07:00">+07:00</option>
<option value="+08:00">+08:00</option>
<option value="+08:45">+08:45</option>
<option value="+09:00">+09:00</option>
<option value="+09:30">+09:30</option>
<option value="+10:00">+10:00</option>
<option value="+10:30">+10:30</option>
<option value="+11:00">+11:00</option>
<option value="+11:30">+11:30</option>
<option value="+12:00">+12:00</option>
<option value="+12:45">+12:45</option>
<option value="+13:00">+13:00</option>
<option value="+14:00">+14:00</option>
</select></li>
</ol>
</div>
</fieldset>

<!-- Page 2 - Address -->
<fieldset id="page2">
<ol>
<li><input type="checkbox" name="DeliveryAddress.Type[]" value="DOM" id="DeliveryAddress-Type-DOM" class="checkbox"> <label for="DeliveryAddress-Type-DOM"><?php echo $vCardMaker_GUI_Lang['CDeliveryAddressDom']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryAddressType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><input type="checkbox" name="DeliveryAddress.Type[]" value="INTL" id="DeliveryAddress-Type-INTL" class="checkbox"> <label for="DeliveryAddress-Type-INTL"><?php echo $vCardMaker_GUI_Lang['CDeliveryAddressInt']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryAddressType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><input type="checkbox" name="DeliveryAddress.Type[]" value="POSTAL" id="DeliveryAddress-Type-POSTAL" class="checkbox"> <label for="DeliveryAddress-Type-POSTAL"><?php echo $vCardMaker_GUI_Lang['CDeliveryAddressPos']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryAddressType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><input type="checkbox" name="DeliveryAddress.Type[]" value="PARCEL" id="DeliveryAddress-Type-PARCEL" class="checkbox"> <label for="DeliveryAddress-Type-PARCEL"><?php echo $vCardMaker_GUI_Lang['CDeliveryAddressPar']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryAddressType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><input type="checkbox" name="DeliveryAddress.Type[]" value="HOME" id="DeliveryAddress-Type-HOME" class="checkbox"> <label for="DeliveryAddress-Type-HOME"><?php echo $vCardMaker_GUI_Lang['CDeliveryAddressHome']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryAddressType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><input type="checkbox" name="DeliveryAddress.Type[]" value="WORK" id="DeliveryAddress-Type-WORK" class="checkbox"> <label for="DeliveryAddress-Type-WORK"><?php echo $vCardMaker_GUI_Lang['CDeliveryAddressWork']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryAddressType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><label for="DeliveryAddress-PostOfficeAddress"><?php echo $vCardMaker_GUI_Lang['CDeliveryAddressPOAd']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryAddressPOAddress'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="DeliveryAddress.PostOfficeAddress" value="" size="35" maxlength="255" id="DeliveryAddress-PostOfficeAddress"></li>
<li><label for="DeliveryAddress-ExtendedAddress"><?php echo $vCardMaker_GUI_Lang['CDeliveryAddressExtA']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryAddressBuildingName'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="DeliveryAddress.ExtendedAddress" value="" size="35" maxlength="255" id="DeliveryAddress-ExtendedAddress"></li>
<li><label for="DeliveryAddress-Street"><?php echo $vCardMaker_GUI_Lang['CDeliveryAddressStr']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryAddressStreet'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="DeliveryAddress.Street" value="" size="35" maxlength="255" id="DeliveryAddress-Street"></li>
<li><label for="DeliveryAddress-Locality"><?php echo $vCardMaker_GUI_Lang['CDeliveryAddressLoc']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryAddressLocality'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="DeliveryAddress.Locality" value="" size="35" maxlength="255" id="DeliveryAddress-Locality"></li>
<li><label for="DeliveryAddress-Region"><?php echo $vCardMaker_GUI_Lang['CDeliveryAddressReg']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryAddressRegion'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="DeliveryAddress.Region" value="" size="35" maxlength="255" id="DeliveryAddress-Region"></li>
<li><label for="DeliveryAddress-PostalCode"><?php echo $vCardMaker_GUI_Lang['CDeliveryAddressPC']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryAddressPostalCode'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="DeliveryAddress.PostalCode" value="" size="15" maxlength="15" id="DeliveryAddress-PostalCode"></li>
<li><label for="DeliveryAddress-Country"><?php echo $vCardMaker_GUI_Lang['CDeliveryAddressCoun']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryAddressCountry'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br>
<select name="DeliveryAddress.Country" id="DeliveryAddress-Country">
<option value=""></option>
<option value="AFGHANISTAN">AFGHANISTAN</option>
<option value="&Aring;LAND ISLANDS">&Aring;LAND ISLANDS</option>
<option value="ALBANIA">ALBANIA</option>
<option value="ALGERIA">ALGERIA</option>
<option value="AMERICAN SAMOA">AMERICAN SAMOA</option>
<option value="ANDORRA">ANDORRA</option>
<option value="ANGOLA">ANGOLA</option>
<option value="ANGUILLA">ANGUILLA</option>
<option value="ANTARCTICA">ANTARCTICA</option>
<option value="ANTIGUA AND BARBUDA">ANTIGUA AND BARBUDA</option>
<option value="ARGENTINA">ARGENTINA</option>
<option value="ARMENIA">ARMENIA</option>
<option value="ARUBA">ARUBA</option>
<option value="AUSTRALIA">AUSTRALIA</option>
<option value="AUSTRIA">AUSTRIA</option>
<option value="AZERBAIJAN">AZERBAIJAN</option>
<option value="BAHAMAS">BAHAMAS</option>
<option value="BAHRAIN">BAHRAIN</option>
<option value="BANGLADESH">BANGLADESH</option>
<option value="BARBADOS">BARBADOS</option>
<option value="BELARUS">BELARUS</option>
<option value="BELGIUM">BELGIUM</option>
<option value="BELIZE">BELIZE</option>
<option value="BENIN">BENIN</option>
<option value="BERMUDA">BERMUDA</option>
<option value="BHUTAN">BHUTAN</option>
<option value="BOLIVIA">BOLIVIA</option>
<option value="BOSNIA AND HERZEGOVINA">BOSNIA AND HERZEGOVINA</option>
<option value="BOTSWANA">BOTSWANA</option>
<option value="BOUVET ISLAND">BOUVET ISLAND</option>
<option value="BRAZIL">BRAZIL</option>
<option value="BRITISH INDIAN OCEAN TERRITORY">BRITISH INDIAN OCEAN TERRITORY</option>
<option value="BRUNEI DARUSSALAM">BRUNEI DARUSSALAM</option>
<option value="BULGARIA">BULGARIA</option>
<option value="BURKINA FASO">BURKINA FASO</option>
<option value="BURUNDI">BURUNDI</option>
<option value="CAMBODIA">CAMBODIA</option>
<option value="CAMEROON">CAMEROON</option>
<option value="CANADA">CANADA</option>
<option value="CAPE VERDE">CAPE VERDE</option>
<option value="CAYMAN ISLANDS">CAYMAN ISLANDS</option>
<option value="CENTRAL AFRICAN REPUBLIC">CENTRAL AFRICAN REPUBLIC</option>
<option value="CHAD">CHAD</option>
<option value="CHILE">CHILE</option>
<option value="CHINA">CHINA</option>
<option value="CHRISTMAS ISLAND">CHRISTMAS ISLAND</option>
<option value="COCOS (KEELING) ISLANDS">COCOS (KEELING) ISLANDS</option>
<option value="COLOMBIA">COLOMBIA</option>
<option value="COMOROS">COMOROS</option>
<option value="CONGO">CONGO</option>
<option value="CONGO, THE DEMOCRATIC REPUBLIC OF THE">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option>
<option value="COOK ISLANDS">COOK ISLANDS</option>
<option value="COSTA RICA">COSTA RICA</option>
<option value="C&Ocirc;TE D'IVOIRE">C&Ocirc;TE D'IVOIRE</option>
<option value="CROATIA">CROATIA</option>
<option value="CUBA">CUBA</option>
<option value="CYPRUS">CYPRUS</option>
<option value="CZECH REPUBLIC">CZECH REPUBLIC</option>
<option value="DENMARK">DENMARK</option>
<option value="DJIBOUTI">DJIBOUTI</option>
<option value="DOMINICA">DOMINICA</option>
<option value="DOMINICAN REPUBLIC">DOMINICAN REPUBLIC</option>
<option value="ECUADOR">ECUADOR</option>
<option value="EGYPT">EGYPT</option>
<option value="EL SALVADOR">EL SALVADOR</option>
<option value="EQUATORIAL GUINEA">EQUATORIAL GUINEA</option>
<option value="ERITREA">ERITREA</option>
<option value="ESTONIA">ESTONIA</option>
<option value="ETHIOPIA">ETHIOPIA</option>
<option value="FALKLAND ISLANDS (MALVINAS)">FALKLAND ISLANDS (MALVINAS)</option>
<option value="FAROE ISLANDS">FAROE ISLANDS</option>
<option value="FIJI">FIJI</option>
<option value="FINLAND">FINLAND</option>
<option value="FRANCE">FRANCE</option>
<option value="FRENCH GUIANA">FRENCH GUIANA</option>
<option value="FRENCH POLYNESIA">FRENCH POLYNESIA</option>
<option value="FRENCH SOUTHERN TERRITORIES">FRENCH SOUTHERN TERRITORIES</option>
<option value="GABON">GABON</option>
<option value="GAMBIA">GAMBIA</option>
<option value="GEORGIA">GEORGIA</option>
<option value="GERMANY">GERMANY</option>
<option value="GHANA">GHANA</option>
<option value="GIBRALTAR">GIBRALTAR</option>
<option value="GREECE">GREECE</option>
<option value="GREENLAND">GREENLAND</option>
<option value="GRENADA">GRENADA</option>
<option value="GUADELOUPE">GUADELOUPE</option>
<option value="GUAM">GUAM</option>
<option value="GUATEMALA">GUATEMALA</option>
<option value="GUERNSEY">GUERNSEY</option>
<option value="GUINEA">GUINEA</option>
<option value="GUINEA-BISSAU">GUINEA-BISSAU</option>
<option value="GUYANA">GUYANA</option>
<option value="HAITI">HAITI</option>
<option value="HEARD ISLAND AND MCDONALD ISLANDS">HEARD ISLAND AND MCDONALD ISLANDS</option>
<option value="HOLY SEE (VATICAN CITY STATE)">HOLY SEE (VATICAN CITY STATE)</option>
<option value="HONDURAS">HONDURAS</option>
<option value="HONG KONG">HONG KONG</option>
<option value="HUNGARY">HUNGARY</option>
<option value="ICELAND">ICELAND</option>
<option value="INDIA">INDIA</option>
<option value="INDONESIA">INDONESIA</option>
<option value="IRAN, ISLAMIC REPUBLIC OF">IRAN, ISLAMIC REPUBLIC OF</option>
<option value="IRAQ">IRAQ</option>
<option value="IRELAND">IRELAND</option>
<option value="ISLE OF MAN">ISLE OF MAN</option>
<option value="ISRAEL">ISRAEL</option>
<option value="ITALY">ITALY</option>
<option value="JAMAICA">JAMAICA</option>
<option value="JAPAN">JAPAN</option>
<option value="JERSEY">JERSEY</option>
<option value="JORDAN">JORDAN</option>
<option value="KAZAKHSTAN">KAZAKHSTAN</option>
<option value="KENYA">KENYA</option>
<option value="KIRIBATI">KIRIBATI</option>
<option value="KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF">KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF</option>
<option value="KOREA, REPUBLIC OF">KOREA, REPUBLIC OF</option>
<option value="KUWAIT">KUWAIT</option>
<option value="KYRGYZSTAN">KYRGYZSTAN</option>
<option value="LAO PEOPLE'S DEMOCRATIC REPUBLIC">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option>
<option value="LATVIA">LATVIA</option>
<option value="LEBANON">LEBANON</option>
<option value="LESOTHO">LESOTHO</option>
<option value="LIBERIA">LIBERIA</option>
<option value="LIBYAN ARAB JAMAHIRIYA">LIBYAN ARAB JAMAHIRIYA</option>
<option value="LIECHTENSTEIN">LIECHTENSTEIN</option>
<option value="LITHUANIA">LITHUANIA</option>
<option value="LUXEMBOURG">LUXEMBOURG</option>
<option value="MACAO">MACAO</option>
<option value="MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF</option>
<option value="MADAGASCAR">MADAGASCAR</option>
<option value="MALAWI">MALAWI</option>
<option value="MALAYSIA">MALAYSIA</option>
<option value="MALDIVES">MALDIVES</option>
<option value="MALI">MALI</option>
<option value="MALTA">MALTA</option>
<option value="MARSHALL ISLANDS">MARSHALL ISLANDS</option>
<option value="MARTINIQUE">MARTINIQUE</option>
<option value="MAURITANIA">MAURITANIA</option>
<option value="MAURITIUS">MAURITIUS</option>
<option value="MAYOTTE">MAYOTTE</option>
<option value="MEXICO">MEXICO</option>
<option value="MICRONESIA, FEDERATED STATES OF">MICRONESIA, FEDERATED STATES OF</option>
<option value="MOLDOVA, REPUBLIC OF">MOLDOVA, REPUBLIC OF</option>
<option value="MONACO">MONACO</option>
<option value="MONGOLIA">MONGOLIA</option>
<option value="MONTENEGRO">MONTENEGRO</option>
<option value="MONTSERRAT">MONTSERRAT</option>
<option value="MOROCCO">MOROCCO</option>
<option value="MOZAMBIQUE">MOZAMBIQUE</option>
<option value="MYANMAR">MYANMAR</option>
<option value="NAMIBIA">NAMIBIA</option>
<option value="NAURU">NAURU</option>
<option value="NEPAL">NEPAL</option>
<option value="NETHERLANDS">NETHERLANDS</option>
<option value="NETHERLANDS ANTILLES">NETHERLANDS ANTILLES</option>
<option value="NEW CALEDONIA">NEW CALEDONIA</option>
<option value="NEW ZEALAND">NEW ZEALAND</option>
<option value="NICARAGUA">NICARAGUA</option>
<option value="NIGER">NIGER</option>
<option value="NIGERIA">NIGERIA</option>
<option value="NIUE">NIUE</option>
<option value="NORFOLK ISLAND">NORFOLK ISLAND</option>
<option value="NORTHERN MARIANA ISLANDS">NORTHERN MARIANA ISLANDS</option>
<option value="NORWAY">NORWAY</option>
<option value="OMAN">OMAN</option>
<option value="PAKISTAN">PAKISTAN</option>
<option value="PALAU">PALAU</option>
<option value="PALESTINIAN TERRITORY, OCCUPIED">PALESTINIAN TERRITORY, OCCUPIED</option>
<option value="PANAMA">PANAMA</option>
<option value="PAPUA NEW GUINEA">PAPUA NEW GUINEA</option>
<option value="PARAGUAY">PARAGUAY</option>
<option value="PERU">PERU</option>
<option value="PHILIPPINES">PHILIPPINES</option>
<option value="PITCAIRN">PITCAIRN</option>
<option value="POLAND">POLAND</option>
<option value="PORTUGAL">PORTUGAL</option>
<option value="PUERTO RICO">PUERTO RICO</option>
<option value="QATAR">QATAR</option>
<option value="REUNION">REUNION</option>
<option value="ROMANIA">ROMANIA</option>
<option value="RUSSIAN FEDERATION">RUSSIAN FEDERATION</option>
<option value="RWANDA">RWANDA</option>
<option value="SAINT BARTH&Eacute;LEMY">SAINT BARTH&Eacute;LEMY</option>
<option value="SAINT HELENA">SAINT HELENA</option>
<option value="SAINT KITTS AND NEVIS">SAINT KITTS AND NEVIS</option>
<option value="SAINT LUCIA">SAINT LUCIA</option>
<option value="SAINT MARTIN">SAINT MARTIN</option>
<option value="SAINT PIERRE AND MIQUELON">SAINT PIERRE AND MIQUELON</option>
<option value="SAINT VINCENT AND THE GRENADINES">SAINT VINCENT AND THE GRENADINES</option>
<option value="SAMOA">SAMOA</option>
<option value="SAN MARINO">SAN MARINO</option>
<option value="SAO TOME AND PRINCIPE">SAO TOME AND PRINCIPE</option>
<option value="SAUDI ARABIA">SAUDI ARABIA</option>
<option value="SENEGAL">SENEGAL</option>
<option value="SERBIA">SERBIA</option>
<option value="SEYCHELLES">SEYCHELLES</option>
<option value="SIERRA LEONE">SIERRA LEONE</option>
<option value="SINGAPORE">SINGAPORE</option>
<option value="SLOVAKIA">SLOVAKIA</option>
<option value="SLOVENIA">SLOVENIA</option>
<option value="SOLOMON ISLANDS">SOLOMON ISLANDS</option>
<option value="SOMALIA">SOMALIA</option>
<option value="SOUTH AFRICA">SOUTH AFRICA</option>
<option value="SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option>
<option value="SPAIN">SPAIN</option>
<option value="SRI LANKA">SRI LANKA</option>
<option value="SUDAN">SUDAN</option>
<option value="SURINAME">SURINAME</option>
<option value="SVALBARD AND JAN MAYEN">SVALBARD AND JAN MAYEN</option>
<option value="SWAZILAND">SWAZILAND</option>
<option value="SWEDEN">SWEDEN</option>
<option value="SWITZERLAND">SWITZERLAND</option>
<option value="SYRIAN ARAB REPUBLIC">SYRIAN ARAB REPUBLIC</option>
<option value="TAIWAN, PROVINCE OF CHINA">TAIWAN, PROVINCE OF CHINA</option>
<option value="TAJIKISTAN">TAJIKISTAN</option>
<option value="TANZANIA, UNITED REPUBLIC OF">TANZANIA, UNITED REPUBLIC OF</option>
<option value="THAILAND">THAILAND</option>
<option value="TIMOR-LESTE">TIMOR-LESTE</option>
<option value="TOGO">TOGO</option>
<option value="TOKELAU">TOKELAU</option>
<option value="TONGA">TONGA</option>
<option value="TRINIDAD AND TOBAGO">TRINIDAD AND TOBAGO</option>
<option value="TUNISIA">TUNISIA</option>
<option value="TURKEY">TURKEY</option>
<option value="TURKMENISTAN">TURKMENISTAN</option>
<option value="TURKS AND CAICOS ISLANDS">TURKS AND CAICOS ISLANDS</option>
<option value="TUVALU">TUVALU</option>
<option value="UGANDA">UGANDA</option>
<option value="UKRAINE">UKRAINE</option>
<option value="UNITED ARAB EMIRATES">UNITED ARAB EMIRATES</option>
<option value="UNITED KINGDOM">UNITED KINGDOM</option>
<option value="UNITED STATES">UNITED STATES</option>
<option value="UNITED STATES MINOR OUTLYING ISLANDS">UNITED STATES MINOR OUTLYING ISLANDS</option>
<option value="URUGUAY">URUGUAY</option>
<option value="UZBEKISTAN">UZBEKISTAN</option>
<option value="VANUATU">VANUATU</option>
<option value="VENEZUELA">VENEZUELA</option>
<option value="VIET NAM">VIET NAM</option>
<option value="VIRGIN ISLANDS, BRITISH">VIRGIN ISLANDS, BRITISH</option>
<option value="VIRGIN ISLANDS, U.S.">VIRGIN ISLANDS, U.S.</option>
<option value="WALLIS AND FUTUNA">WALLIS AND FUTUNA</option>
<option value="WESTERN SAHARA">WESTERN SAHARA</option>
<option value="YEMEN">YEMEN</option>
<option value="ZAMBIA">ZAMBIA</option>
<option value="ZIMBABWE">ZIMBABWE</option>
</select></li>
</ol>
<p><a href="#" id="page2advancedtoggle"><img src="images/down.png" width="25" height="30" alt="" id="page2advancedtogglesymbol" class="togglesymbol"> <span id="page2advancedtoggletext"><?php echo $vCardMaker_GUI_Lang['CToggleAdvanced']; ?></span></a></p>
<div id="page2advanced">
<ol>
<li><input type="checkbox" name="DeliveryLabel.Type[]" value="DOM" id="DeliveryLabel-Type-DOM" class="checkbox"> <label for="DeliveryLabel-Type-DOM"><?php echo $vCardMaker_GUI_Lang['CDeliveryLabelDom']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryLabelType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><input type="checkbox" name="DeliveryLabel.Type[]" value="INTL" id="DeliveryLabel-Type-INTL" class="checkbox"> <label for="DeliveryLabel-Type-INTL"><?php echo $vCardMaker_GUI_Lang['CDeliveryLabelInt']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryLabelType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><input type="checkbox" name="DeliveryLabel.Type[]" value="POSTAL" id="DeliveryLabel-Type-POSTAL" class="checkbox"> <label for="DeliveryLabel-Type-POSTAL"><?php echo $vCardMaker_GUI_Lang['CDeliveryLabelPos']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryLabelType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><input type="checkbox" name="DeliveryLabel.Type[]" value="PARCEL" id="DeliveryLabel-Type-PARCEL" class="checkbox"> <label for="DeliveryLabel-Type-PARCEL"><?php echo $vCardMaker_GUI_Lang['CDeliveryLabelPar']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryLabelType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><input type="checkbox" name="DeliveryLabel.Type[]" value="HOME" id="DeliveryLabel-Type-HOME" class="checkbox"> <label for="DeliveryLabel-Type-HOME"><?php echo $vCardMaker_GUI_Lang['CDeliveryLabelHome']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryLabelType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><input type="checkbox" name="DeliveryLabel.Type[]" value="WORK" id="DeliveryLabel-Type-WORK" class="checkbox"> <label for="DeliveryLabel-Type-WORK"><?php echo $vCardMaker_GUI_Lang['CDeliveryLabelWork']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryLabelType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><label for="DeliveryLabel-PostOfficeAddress"><?php echo $vCardMaker_GUI_Lang['CDeliveryLabelPOAd']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryLabelPOAddress'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="DeliveryLabel.PostOfficeAddress" value="" size="35" maxlength="255" id="DeliveryLabel-PostOfficeAddress"></li>
<li><label for="DeliveryLabel-ExtendedAddress"><?php echo $vCardMaker_GUI_Lang['CDeliveryLabelExtA']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryLabelBuildingName'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="DeliveryLabel.ExtendedAddress" value="" size="35" maxlength="255" id="DeliveryLabel-ExtendedAddress"></li>
<li><label for="DeliveryLabel-Street"><?php echo $vCardMaker_GUI_Lang['CDeliveryLabelStr']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryLabelStreet'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="DeliveryLabel.Street" value="" size="35" maxlength="255" id="DeliveryLabel-Street"></li>
<li><label for="DeliveryLabel-Locality"><?php echo $vCardMaker_GUI_Lang['CDeliveryLabelLoc']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryLabelLocality'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="DeliveryLabel.Locality" value="" size="35" maxlength="255" id="DeliveryLabel-Locality"></li>
<li><label for="DeliveryLabel-Region"><?php echo $vCardMaker_GUI_Lang['CDeliveryLabelReg']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryLabelRegion'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="DeliveryLabel.Region" value="" size="35" maxlength="255" id="DeliveryLabel-Region"></li>
<li><label for="DeliveryLabel-PostalCode"><?php echo $vCardMaker_GUI_Lang['CDeliveryLabelPC']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryLabelPostalCode'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="DeliveryLabel.PostalCode" value="" size="15" maxlength="15" id="DeliveryLabel-PostalCode"></li>
<li><label for="DeliveryLabel-Country"><?php echo $vCardMaker_GUI_Lang['CDeliveryLabelCoun']; ?> <a href="#" onclick="vCardMakerHelp('DeliveryLabelCountry'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br>
<select name="DeliveryLabel.Country" id="DeliveryLabel-Country">
<option value=""></option>
<option value="AFGHANISTAN">AFGHANISTAN</option>
<option value="&Aring;LAND ISLANDS">&Aring;LAND ISLANDS</option>
<option value="ALBANIA">ALBANIA</option>
<option value="ALGERIA">ALGERIA</option>
<option value="AMERICAN SAMOA">AMERICAN SAMOA</option>
<option value="ANDORRA">ANDORRA</option>
<option value="ANGOLA">ANGOLA</option>
<option value="ANGUILLA">ANGUILLA</option>
<option value="ANTARCTICA">ANTARCTICA</option>
<option value="ANTIGUA AND BARBUDA">ANTIGUA AND BARBUDA</option>
<option value="ARGENTINA">ARGENTINA</option>
<option value="ARMENIA">ARMENIA</option>
<option value="ARUBA">ARUBA</option>
<option value="AUSTRALIA">AUSTRALIA</option>
<option value="AUSTRIA">AUSTRIA</option>
<option value="AZERBAIJAN">AZERBAIJAN</option>
<option value="BAHAMAS">BAHAMAS</option>
<option value="BAHRAIN">BAHRAIN</option>
<option value="BANGLADESH">BANGLADESH</option>
<option value="BARBADOS">BARBADOS</option>
<option value="BELARUS">BELARUS</option>
<option value="BELGIUM">BELGIUM</option>
<option value="BELIZE">BELIZE</option>
<option value="BENIN">BENIN</option>
<option value="BERMUDA">BERMUDA</option>
<option value="BHUTAN">BHUTAN</option>
<option value="BOLIVIA">BOLIVIA</option>
<option value="BOSNIA AND HERZEGOVINA">BOSNIA AND HERZEGOVINA</option>
<option value="BOTSWANA">BOTSWANA</option>
<option value="BOUVET ISLAND">BOUVET ISLAND</option>
<option value="BRAZIL">BRAZIL</option>
<option value="BRITISH INDIAN OCEAN TERRITORY">BRITISH INDIAN OCEAN TERRITORY</option>
<option value="BRUNEI DARUSSALAM">BRUNEI DARUSSALAM</option>
<option value="BULGARIA">BULGARIA</option>
<option value="BURKINA FASO">BURKINA FASO</option>
<option value="BURUNDI">BURUNDI</option>
<option value="CAMBODIA">CAMBODIA</option>
<option value="CAMEROON">CAMEROON</option>
<option value="CANADA">CANADA</option>
<option value="CAPE VERDE">CAPE VERDE</option>
<option value="CAYMAN ISLANDS">CAYMAN ISLANDS</option>
<option value="CENTRAL AFRICAN REPUBLIC">CENTRAL AFRICAN REPUBLIC</option>
<option value="CHAD">CHAD</option>
<option value="CHILE">CHILE</option>
<option value="CHINA">CHINA</option>
<option value="CHRISTMAS ISLAND">CHRISTMAS ISLAND</option>
<option value="COCOS (KEELING) ISLANDS">COCOS (KEELING) ISLANDS</option>
<option value="COLOMBIA">COLOMBIA</option>
<option value="COMOROS">COMOROS</option>
<option value="CONGO">CONGO</option>
<option value="CONGO, THE DEMOCRATIC REPUBLIC OF THE">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option>
<option value="COOK ISLANDS">COOK ISLANDS</option>
<option value="COSTA RICA">COSTA RICA</option>
<option value="C&Ocirc;TE D'IVOIRE">C&Ocirc;TE D'IVOIRE</option>
<option value="CROATIA">CROATIA</option>
<option value="CUBA">CUBA</option>
<option value="CYPRUS">CYPRUS</option>
<option value="CZECH REPUBLIC">CZECH REPUBLIC</option>
<option value="DENMARK">DENMARK</option>
<option value="DJIBOUTI">DJIBOUTI</option>
<option value="DOMINICA">DOMINICA</option>
<option value="DOMINICAN REPUBLIC">DOMINICAN REPUBLIC</option>
<option value="ECUADOR">ECUADOR</option>
<option value="EGYPT">EGYPT</option>
<option value="EL SALVADOR">EL SALVADOR</option>
<option value="EQUATORIAL GUINEA">EQUATORIAL GUINEA</option>
<option value="ERITREA">ERITREA</option>
<option value="ESTONIA">ESTONIA</option>
<option value="ETHIOPIA">ETHIOPIA</option>
<option value="FALKLAND ISLANDS (MALVINAS)">FALKLAND ISLANDS (MALVINAS)</option>
<option value="FAROE ISLANDS">FAROE ISLANDS</option>
<option value="FIJI">FIJI</option>
<option value="FINLAND">FINLAND</option>
<option value="FRANCE">FRANCE</option>
<option value="FRENCH GUIANA">FRENCH GUIANA</option>
<option value="FRENCH POLYNESIA">FRENCH POLYNESIA</option>
<option value="FRENCH SOUTHERN TERRITORIES">FRENCH SOUTHERN TERRITORIES</option>
<option value="GABON">GABON</option>
<option value="GAMBIA">GAMBIA</option>
<option value="GEORGIA">GEORGIA</option>
<option value="GERMANY">GERMANY</option>
<option value="GHANA">GHANA</option>
<option value="GIBRALTAR">GIBRALTAR</option>
<option value="GREECE">GREECE</option>
<option value="GREENLAND">GREENLAND</option>
<option value="GRENADA">GRENADA</option>
<option value="GUADELOUPE">GUADELOUPE</option>
<option value="GUAM">GUAM</option>
<option value="GUATEMALA">GUATEMALA</option>
<option value="GUERNSEY">GUERNSEY</option>
<option value="GUINEA">GUINEA</option>
<option value="GUINEA-BISSAU">GUINEA-BISSAU</option>
<option value="GUYANA">GUYANA</option>
<option value="HAITI">HAITI</option>
<option value="HEARD ISLAND AND MCDONALD ISLANDS">HEARD ISLAND AND MCDONALD ISLANDS</option>
<option value="HOLY SEE (VATICAN CITY STATE)">HOLY SEE (VATICAN CITY STATE)</option>
<option value="HONDURAS">HONDURAS</option>
<option value="HONG KONG">HONG KONG</option>
<option value="HUNGARY">HUNGARY</option>
<option value="ICELAND">ICELAND</option>
<option value="INDIA">INDIA</option>
<option value="INDONESIA">INDONESIA</option>
<option value="IRAN, ISLAMIC REPUBLIC OF">IRAN, ISLAMIC REPUBLIC OF</option>
<option value="IRAQ">IRAQ</option>
<option value="IRELAND">IRELAND</option>
<option value="ISLE OF MAN">ISLE OF MAN</option>
<option value="ISRAEL">ISRAEL</option>
<option value="ITALY">ITALY</option>
<option value="JAMAICA">JAMAICA</option>
<option value="JAPAN">JAPAN</option>
<option value="JERSEY">JERSEY</option>
<option value="JORDAN">JORDAN</option>
<option value="KAZAKHSTAN">KAZAKHSTAN</option>
<option value="KENYA">KENYA</option>
<option value="KIRIBATI">KIRIBATI</option>
<option value="KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF">KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF</option>
<option value="KOREA, REPUBLIC OF">KOREA, REPUBLIC OF</option>
<option value="KUWAIT">KUWAIT</option>
<option value="KYRGYZSTAN">KYRGYZSTAN</option>
<option value="LAO PEOPLE'S DEMOCRATIC REPUBLIC">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option>
<option value="LATVIA">LATVIA</option>
<option value="LEBANON">LEBANON</option>
<option value="LESOTHO">LESOTHO</option>
<option value="LIBERIA">LIBERIA</option>
<option value="LIBYAN ARAB JAMAHIRIYA">LIBYAN ARAB JAMAHIRIYA</option>
<option value="LIECHTENSTEIN">LIECHTENSTEIN</option>
<option value="LITHUANIA">LITHUANIA</option>
<option value="LUXEMBOURG">LUXEMBOURG</option>
<option value="MACAO">MACAO</option>
<option value="MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF</option>
<option value="MADAGASCAR">MADAGASCAR</option>
<option value="MALAWI">MALAWI</option>
<option value="MALAYSIA">MALAYSIA</option>
<option value="MALDIVES">MALDIVES</option>
<option value="MALI">MALI</option>
<option value="MALTA">MALTA</option>
<option value="MARSHALL ISLANDS">MARSHALL ISLANDS</option>
<option value="MARTINIQUE">MARTINIQUE</option>
<option value="MAURITANIA">MAURITANIA</option>
<option value="MAURITIUS">MAURITIUS</option>
<option value="MAYOTTE">MAYOTTE</option>
<option value="MEXICO">MEXICO</option>
<option value="MICRONESIA, FEDERATED STATES OF">MICRONESIA, FEDERATED STATES OF</option>
<option value="MOLDOVA, REPUBLIC OF">MOLDOVA, REPUBLIC OF</option>
<option value="MONACO">MONACO</option>
<option value="MONGOLIA">MONGOLIA</option>
<option value="MONTENEGRO">MONTENEGRO</option>
<option value="MONTSERRAT">MONTSERRAT</option>
<option value="MOROCCO">MOROCCO</option>
<option value="MOZAMBIQUE">MOZAMBIQUE</option>
<option value="MYANMAR">MYANMAR</option>
<option value="NAMIBIA">NAMIBIA</option>
<option value="NAURU">NAURU</option>
<option value="NEPAL">NEPAL</option>
<option value="NETHERLANDS">NETHERLANDS</option>
<option value="NETHERLANDS ANTILLES">NETHERLANDS ANTILLES</option>
<option value="NEW CALEDONIA">NEW CALEDONIA</option>
<option value="NEW ZEALAND">NEW ZEALAND</option>
<option value="NICARAGUA">NICARAGUA</option>
<option value="NIGER">NIGER</option>
<option value="NIGERIA">NIGERIA</option>
<option value="NIUE">NIUE</option>
<option value="NORFOLK ISLAND">NORFOLK ISLAND</option>
<option value="NORTHERN MARIANA ISLANDS">NORTHERN MARIANA ISLANDS</option>
<option value="NORWAY">NORWAY</option>
<option value="OMAN">OMAN</option>
<option value="PAKISTAN">PAKISTAN</option>
<option value="PALAU">PALAU</option>
<option value="PALESTINIAN TERRITORY, OCCUPIED">PALESTINIAN TERRITORY, OCCUPIED</option>
<option value="PANAMA">PANAMA</option>
<option value="PAPUA NEW GUINEA">PAPUA NEW GUINEA</option>
<option value="PARAGUAY">PARAGUAY</option>
<option value="PERU">PERU</option>
<option value="PHILIPPINES">PHILIPPINES</option>
<option value="PITCAIRN">PITCAIRN</option>
<option value="POLAND">POLAND</option>
<option value="PORTUGAL">PORTUGAL</option>
<option value="PUERTO RICO">PUERTO RICO</option>
<option value="QATAR">QATAR</option>
<option value="REUNION">REUNION</option>
<option value="ROMANIA">ROMANIA</option>
<option value="RUSSIAN FEDERATION">RUSSIAN FEDERATION</option>
<option value="RWANDA">RWANDA</option>
<option value="SAINT BARTH&Eacute;LEMY">SAINT BARTH&Eacute;LEMY</option>
<option value="SAINT HELENA">SAINT HELENA</option>
<option value="SAINT KITTS AND NEVIS">SAINT KITTS AND NEVIS</option>
<option value="SAINT LUCIA">SAINT LUCIA</option>
<option value="SAINT MARTIN">SAINT MARTIN</option>
<option value="SAINT PIERRE AND MIQUELON">SAINT PIERRE AND MIQUELON</option>
<option value="SAINT VINCENT AND THE GRENADINES">SAINT VINCENT AND THE GRENADINES</option>
<option value="SAMOA">SAMOA</option>
<option value="SAN MARINO">SAN MARINO</option>
<option value="SAO TOME AND PRINCIPE">SAO TOME AND PRINCIPE</option>
<option value="SAUDI ARABIA">SAUDI ARABIA</option>
<option value="SENEGAL">SENEGAL</option>
<option value="SERBIA">SERBIA</option>
<option value="SEYCHELLES">SEYCHELLES</option>
<option value="SIERRA LEONE">SIERRA LEONE</option>
<option value="SINGAPORE">SINGAPORE</option>
<option value="SLOVAKIA">SLOVAKIA</option>
<option value="SLOVENIA">SLOVENIA</option>
<option value="SOLOMON ISLANDS">SOLOMON ISLANDS</option>
<option value="SOMALIA">SOMALIA</option>
<option value="SOUTH AFRICA">SOUTH AFRICA</option>
<option value="SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option>
<option value="SPAIN">SPAIN</option>
<option value="SRI LANKA">SRI LANKA</option>
<option value="SUDAN">SUDAN</option>
<option value="SURINAME">SURINAME</option>
<option value="SVALBARD AND JAN MAYEN">SVALBARD AND JAN MAYEN</option>
<option value="SWAZILAND">SWAZILAND</option>
<option value="SWEDEN">SWEDEN</option>
<option value="SWITZERLAND">SWITZERLAND</option>
<option value="SYRIAN ARAB REPUBLIC">SYRIAN ARAB REPUBLIC</option>
<option value="TAIWAN, PROVINCE OF CHINA">TAIWAN, PROVINCE OF CHINA</option>
<option value="TAJIKISTAN">TAJIKISTAN</option>
<option value="TANZANIA, UNITED REPUBLIC OF">TANZANIA, UNITED REPUBLIC OF</option>
<option value="THAILAND">THAILAND</option>
<option value="TIMOR-LESTE">TIMOR-LESTE</option>
<option value="TOGO">TOGO</option>
<option value="TOKELAU">TOKELAU</option>
<option value="TONGA">TONGA</option>
<option value="TRINIDAD AND TOBAGO">TRINIDAD AND TOBAGO</option>
<option value="TUNISIA">TUNISIA</option>
<option value="TURKEY">TURKEY</option>
<option value="TURKMENISTAN">TURKMENISTAN</option>
<option value="TURKS AND CAICOS ISLANDS">TURKS AND CAICOS ISLANDS</option>
<option value="TUVALU">TUVALU</option>
<option value="UGANDA">UGANDA</option>
<option value="UKRAINE">UKRAINE</option>
<option value="UNITED ARAB EMIRATES">UNITED ARAB EMIRATES</option>
<option value="UNITED KINGDOM">UNITED KINGDOM</option>
<option value="UNITED STATES">UNITED STATES</option>
<option value="UNITED STATES MINOR OUTLYING ISLANDS">UNITED STATES MINOR OUTLYING ISLANDS</option>
<option value="URUGUAY">URUGUAY</option>
<option value="UZBEKISTAN">UZBEKISTAN</option>
<option value="VANUATU">VANUATU</option>
<option value="VENEZUELA">VENEZUELA</option>
<option value="VIET NAM">VIET NAM</option>
<option value="VIRGIN ISLANDS, BRITISH">VIRGIN ISLANDS, BRITISH</option>
<option value="VIRGIN ISLANDS, U.S.">VIRGIN ISLANDS, U.S.</option>
<option value="WALLIS AND FUTUNA">WALLIS AND FUTUNA</option>
<option value="WESTERN SAHARA">WESTERN SAHARA</option>
<option value="YEMEN">YEMEN</option>
<option value="ZAMBIA">ZAMBIA</option>
<option value="ZIMBABWE">ZIMBABWE</option>
</select></li>
</ol>
</div>
</fieldset>

<!-- Page 3 - Contact -->
<fieldset id="page3">
<ol>
<li><label for="TelephoneNumber-Type"><?php echo $vCardMaker_GUI_Lang['CTelNumType']; ?> (1)  <a href="#" onclick="vCardMakerHelp('TelephoneNumberType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br>
<select name="TelephoneNumber.Type" id="TelephoneNumber-Type">
<option value=""></option>
<option value="WORK"><?php echo $vCardMaker_GUI_Lang['CTelNumWork']; ?></option>
<option value="HOME"><?php echo $vCardMaker_GUI_Lang['CTelNumHome']; ?></option>
<option value="VOICE"><?php echo $vCardMaker_GUI_Lang['CTelNumVoice']; ?></option>
<option value="FAX"><?php echo $vCardMaker_GUI_Lang['CTelNumFax']; ?></option>
<option value="CELL"><?php echo $vCardMaker_GUI_Lang['CTelNumCell']; ?></option>
<option value="PAGER"><?php echo $vCardMaker_GUI_Lang['CTelNumPager']; ?></option>
<option value="BBS"><?php echo $vCardMaker_GUI_Lang['CTelNumBBS']; ?></option>
<option value="MODEM"><?php echo $vCardMaker_GUI_Lang['CTelNumModem']; ?></option>
<option value="CAR"><?php echo $vCardMaker_GUI_Lang['CTelNumCarphone']; ?></option>
<option value="ISDN"><?php echo $vCardMaker_GUI_Lang['CTelNumISDN']; ?></option>
<option value="VIDEO"><?php echo $vCardMaker_GUI_Lang['CTelNumVideophone']; ?></option>
</select></li>
<li><input type="checkbox" name="TelephoneNumber.Type.Preferred" value="PREF" id="TelephoneNumber-Type-Preferred" checked="checked" disabled="disabled" class="checkbox"> <label for="TelephoneNumber-Type-Preferred"><?php echo $vCardMaker_GUI_Lang['CTelNumPref']; ?>  <a href="#" onclick="vCardMakerHelp('TelephoneNumberPreferred'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><input type="checkbox" name="TelephoneNumber.Type.Msg" value="MSG" id="TelephoneNumber-Type-Msg-MSG" class="checkbox"> <label for="TelephoneNumber-Type-Msg-MSG"><?php echo $vCardMaker_GUI_Lang['CTelNumMsg']; ?> <a href="#" onclick="vCardMakerHelp('TelephoneNumberMessaging'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><label for="TelephoneNumber-Number"><?php echo $vCardMaker_GUI_Lang['CTelNumTelNum']; ?> (1) <a href="#" onclick="vCardMakerHelp('TelephoneNumber'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="TelephoneNumber.Number" value="" size="20" maxlength="20" id="TelephoneNumber-Number"></li>
<li><label for="EmailAddress-Address"><em><?php echo $vCardMaker_GUI_Lang['CEmailAddress']; ?> (1)</em> <a href="#" onclick="vCardMakerHelp('EmailAddress'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="hidden" name="EmailAddress.Type" value="INTERNET" id="EmailAddress-Type"><input type="text" name="EmailAddress.Address" value="" size="35" maxlength="255" id="EmailAddress-Address"></li>
<li><label for="EmailAddress-Type-Preferred"><input type="checkbox" name="EmailAddress.Type.Preferred" value="PREF" id="EmailAddress-Type-Preferred" checked="checked" disabled="disabled" class="checkbox"> <span class="vcard-only30"><?php echo $vCardMaker_GUI_Lang['CEmailPref']; ?></span> <a href="#" onclick="vCardMakerHelp('EmailAddressPreferred'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
</ol>
<p><a href="#" id="page3advancedtoggle"><img src="images/down.png" width="25" height="30" alt="" id="page3advancedtogglesymbol" class="togglesymbol"> <span id="page3advancedtoggletext"><?php echo $vCardMaker_GUI_Lang['CToggleAdvanced']; ?></span></a></p>
<div id="page3advanced">
<ol>
<li><label for="TelephoneNumber-Type-2"><?php echo $vCardMaker_GUI_Lang['CTelNumType']; ?> (2) <a href="#" onclick="vCardMakerHelp('TelephoneNumberType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br>
<select name="TelephoneNumber.Type.2" id="TelephoneNumber-Type-2">
<option value=""></option>
<option value="WORK"><?php echo $vCardMaker_GUI_Lang['CTelNumWork']; ?></option>
<option value="HOME"><?php echo $vCardMaker_GUI_Lang['CTelNumHome']; ?></option>
<option value="VOICE"><?php echo $vCardMaker_GUI_Lang['CTelNumVoice']; ?></option>
<option value="FAX"><?php echo $vCardMaker_GUI_Lang['CTelNumFax']; ?></option>
<option value="CELL"><?php echo $vCardMaker_GUI_Lang['CTelNumCell']; ?></option>
<option value="PAGER"><?php echo $vCardMaker_GUI_Lang['CTelNumPager']; ?></option>
<option value="BBS"><?php echo $vCardMaker_GUI_Lang['CTelNumBBS']; ?></option>
<option value="MODEM"><?php echo $vCardMaker_GUI_Lang['CTelNumModem']; ?></option>
<option value="CAR"><?php echo $vCardMaker_GUI_Lang['CTelNumCarphone']; ?></option>
<option value="ISDN"><?php echo $vCardMaker_GUI_Lang['CTelNumISDN']; ?></option>
<option value="VIDEO"><?php echo $vCardMaker_GUI_Lang['CTelNumVideophone']; ?></option>
</select></li>
<li><input type="checkbox" name="TelephoneNumber.Type.Msg.2" value="MSG" id="TelephoneNumber-Type-Msg-MSG-2" class="checkbox"> <label for="TelephoneNumber-Type-Msg-MSG-2"><?php echo $vCardMaker_GUI_Lang['CTelNumMsg']; ?> <a href="#" onclick="vCardMakerHelp('TelephoneNumberMessaging'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label></li>
<li><label for="TelephoneNumber-Number-2"><?php echo $vCardMaker_GUI_Lang['CTelNumTelNum']; ?> (2) <a href="#" onclick="vCardMakerHelp('TelephoneNumber'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="TelephoneNumber.Number.2" value="" size="20" maxlength="20" id="TelephoneNumber-Number-2"></li>
<li><label for="EmailAddress-Type-2"><?php echo $vCardMaker_GUI_Lang['CEmailType']; ?> (2) <a href="#" onclick="vCardMakerHelp('EmailAddressType'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br>
<select name="EmailAddress.Type.2" id="EmailAddress-Type-2">
<option value=""></option>
<option value="AOL">America Online</option>
<option value="AppleLink">AppleLink</option>
<option value="ATTMail">AT&amp;T Mail</option>
<option value="CIS">CompuServe Information Service</option>
<option value="eWorld">eWorld</option>
<option value="INTERNET">Internet SMTP (Default)</option>
<option value="IBMMail">IBM Mail</option>
<option value="MCIMail">MCI Mail</option>
<option value="POWERSHARE">PowerShare</option>
<option value="PRODIGY">Prodigy Information Service</option>
<option value="TLX">Telex number</option>
<option value="X400">X.400 Service</option>
</select></li>
<li><label for="EmailAddress-Address-2"><?php echo $vCardMaker_GUI_Lang['CEmailAddress']; ?> (2) <a href="#" onclick="vCardMakerHelp('EmailAddress'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="EmailAddress.Address.2" value="" size="35" maxlength="255" id="EmailAddress-Address-2"></li>
<li><label for="Mailer-Name"><?php echo $vCardMaker_GUI_Lang['CMailer']; ?> <a href="#" onclick="vCardMakerHelp('Mailer'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br> <input type="text" name="Mailer.Name" value="" size="25" maxlength="255" id="Mailer-Name"></li>
</ol>
</div>
</fieldset>

<!-- Page 4 - Work -->
<fieldset id="page4">
<ol>
<li><label for="OrganisationalProperties-OrganisationName"><?php echo $vCardMaker_GUI_Lang['COrgName']; ?> <a href="#" onclick="vCardMakerHelp('OrganisationName'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="OrganisationalProperties.OrganisationName" value="" size="35" maxlength="255" id="OrganisationalProperties-OrganisationName"></li>
<li><label for="OrganisationalProperties-JobTitle"><?php echo $vCardMaker_GUI_Lang['COrgTitle']; ?> <a href="#" onclick="vCardMakerHelp('JobTitle'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="OrganisationalProperties.JobTitle" value="" size="35" maxlength="255" id="OrganisationalProperties-JobTitle"></li>
</ol>
<p><a href="#" id="page4advancedtoggle"><img src="images/down.png" width="25" height="30" alt="" id="page4advancedtogglesymbol" class="togglesymbol"> <span id="page4advancedtoggletext"><?php echo $vCardMaker_GUI_Lang['CToggleAdvanced']; ?></span></a></p>
<div id="page4advanced">
<ol>
<li><label for="OrganisationalProperties-OrganisationalUnit"><?php echo $vCardMaker_GUI_Lang['COrgUnit']; ?> <a href="#" onclick="vCardMakerHelp('OrganisationalUnit'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="OrganisationalProperties.OrganisationalUnit" value="" size="35" maxlength="255" id="OrganisationalProperties-OrganisationalUnit"></li>
<li><label for="OrganisationalProperties-Role"><?php echo $vCardMaker_GUI_Lang['COrgRole']; ?> <a href="#" onclick="vCardMakerHelp('JobRole'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="OrganisationalProperties.Role" value="" size="35" maxlength="255" id="OrganisationalProperties-Role"></li>
<li><label for="Logo-Type"><?php echo $vCardMaker_GUI_Lang['CLogoType']; ?> <a href="#" onclick="vCardMakerHelp('OrganisationLogo'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br>
<select name="Logo.Type" id="Logo-Type">
<option value="None" selected="selected"></option>
<option value="URL"><?php echo $vCardMaker_GUI_Lang['CLogoTypeURL']; ?></option>
<option value="BASE64"><?php echo $vCardMaker_GUI_Lang['CLogoTypeBase64']; ?></option>
<option value="QUOTED-PRINTABLE" class="vcard-only21"><?php echo $vCardMaker_GUI_Lang['CLogoTypeQP']; ?></option>
</select></li>
<li id="vcard-section-logoincluded-1"><label for="Logo-Format"><?php echo $vCardMaker_GUI_Lang['CLogoFormat']; ?></label><br>
<select name="Logo.Format" id="Logo-Format">
<option value="GIF">Graphics Interchange Format (GIF)</option>
<option value="CGM">ISO Computer Graphics Metafile (CGM)</option>
<option value="WMF">Microsoft Windows Metafile (WMF)</option>
<option value="BMP">Microsoft Windows Bitmap (BMP)</option>
<option value="MET">IBM PM Metafile (MET)</option>
<option value="PMB">IBM PM Bitmap (PMB)</option>
<option value="DIB">Microsoft Windows DIB (DIB)</option>
<option value="PICT">Apple Picture (PICT)</option>
<option value="TIFF">Tagged Image File Format (TIFF)</option>
<option value="PS">Adobe PostScript (PS)</option>
<option value="PDF">Adobe Portable Document Format (PDF)</option>
<option value="JPEG">ISO Joint Photographic Experts Group (JPEG)</option>
<option value="MPEG">ISO Moving Picture Experts Group (MPEG)</option>
<option value="MPEG2">ISO Moving Picture Experts Group version 2 (MPEG2)</option>
<option value="AVI">Intel Audio/Video Interleave (AVI)</option>
<option value="QTIME">Apple QuickTime (QTIME)</option>
</select></li>
<li id="vcard-section-logoincluded-2"><label for="Logo-Source"><?php echo $vCardMaker_GUI_Lang['CLogo']; ?></label><br><textarea cols="40" rows="15" name="Logo.Source" id="Logo-Source"></textarea></li>
<li><label for="Agent-Type"><?php echo $vCardMaker_GUI_Lang['CAgentType']; ?> <a href="#" onclick="vCardMakerHelp('Agent'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br>
<select name="Agent.Type" id="Agent-Type">
<option value="None" selected="selected"></option>
<option value="vCard"><?php echo $vCardMaker_GUI_Lang['CAgentTypevCard']; ?></option>
<option value="URL" class="vcard-only30"><?php echo $vCardMaker_GUI_Lang['CAgentTypeURL']; ?></option>
</select></li>
<li id="vcard-section-agentsource"><label for="Agent-Source"><?php echo $vCardMaker_GUI_Lang['CAgentvCard']; ?></label><br><textarea cols="40" rows="10" name="Agent.Source" id="Agent-Source"></textarea></li>
</ol>
</div>
</fieldset>

<!-- Page 5 - Miscellaneous -->
<fieldset id="page5">
<ol>
<li><label for="URL"><?php echo $vCardMaker_GUI_Lang['CURL']; ?> <a href="#" onclick="vCardMakerHelp('URL'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="URL" value="" size="35" maxlength="255" id="URL"></li>
<li><label for="GeographicalProperties-Timezone"><?php echo $vCardMaker_GUI_Lang['CGeoTimezone']; ?> <a href="#" onclick="vCardMakerHelp('Timezone'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br>
<!-- Information from http://en.wikipedia.org/wiki/List_of_time_zones -->
<select name="GeographicalProperties.Timezone" id="GeographicalProperties-Timezone">
<option value=""></option>
<option value="-12:00">-12:00</option>
<option value="-11:00">-11:00</option>
<option value="-10:00">-10:00</option>
<option value="-09:30">-09:30</option>
<option value="-09:00">-09:00</option>
<option value="-08:00">-08:00</option>
<option value="-07:00">-07:00</option>
<option value="-06:00">-06:00</option>
<option value="-05:00">-05:00</option>
<option value="-04:30">-04:30</option>
<option value="-04:00">-04:00</option>
<option value="-03:30">-03:30</option>
<option value="-03:00">-03:00</option>
<option value="-02:00">-02:00</option>
<option value="-01:00">-01:00</option>
<option value="+00:00">+00:00</option>
<option value="+01:00">+01:00</option>
<option value="+02:00">+02:00</option>
<option value="+03:00">+03:00</option>
<option value="+03:30">+03:30</option>
<option value="+04:00">+04:00</option>
<option value="+04:30">+04:30</option>
<option value="+05:00">+05:00</option>
<option value="+05:30">+05:30</option>
<option value="+05:45">+05:45</option>
<option value="+06:00">+06:00</option>
<option value="+06:30">+06:30</option>
<option value="+07:00">+07:00</option>
<option value="+08:00">+08:00</option>
<option value="+08:45">+08:45</option>
<option value="+09:00">+09:00</option>
<option value="+09:30">+09:30</option>
<option value="+10:00">+10:00</option>
<option value="+10:30">+10:30</option>
<option value="+11:00">+11:00</option>
<option value="+11:30">+11:30</option>
<option value="+12:00">+12:00</option>
<option value="+12:45">+12:45</option>
<option value="+13:00">+13:00</option>
<option value="+14:00">+14:00</option>
</select></li>
</ol>
<p><a href="#" id="page5advancedtoggle"><img src="images/down.png" width="25" height="30" alt="" id="page5advancedtogglesymbol" class="togglesymbol"> <span id="page5advancedtoggletext"><?php echo $vCardMaker_GUI_Lang['CToggleAdvanced']; ?></span></a></p>
<div id="page5advanced">
<ol>
<li><label for="GeographicalProperties-Position-Latitude"><?php echo $vCardMaker_GUI_Lang['CGeoPos']; ?> <a href="#" onclick="vCardMakerHelp('AddressPosition'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br>
<input type="text" name="GeographicalProperties.Position.Latitude" value="" size="5" maxlength="5" id="GeographicalProperties-Position-Latitude">,
<input type="text" name="GeographicalProperties.Position.Longitude" value="" size="5" maxlength="5" id="GeographicalProperties-Position-Longitude"></li>
<li><label for="Categories"><span class="vcard-only30"><?php echo $vCardMaker_GUI_Lang['CCategories']; ?></span> <a href="#" onclick="vCardMakerHelp('Categories'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><input type="text" name="Categories" value="" size="35" maxlength="255" id="Categories"></li>
<li><label for="Comment"><?php echo $vCardMaker_GUI_Lang['CComment']; ?> <a href="#" onclick="vCardMakerHelp('Comments'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br><textarea cols="40" rows="10" name="Comment" id="Comment"></textarea></li>
<li><label for="Sound-Type"><?php echo $vCardMaker_GUI_Lang['CSoundType']; ?> <a href="#" onclick="vCardMakerHelp('Sound'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br>
<select name="Sound.Type" id="Sound-Type">
<option value="None" selected="selected"></option>
<option value="Phonetic" class="vcard-only21"><?php echo $vCardMaker_GUI_Lang['CSoundTypePhonetic']; ?></option>
<option value="URL"><?php echo $vCardMaker_GUI_Lang['CSoundTypeURL']; ?></option>
<option value="BASE64"><?php echo $vCardMaker_GUI_Lang['CSoundTypeBase64']; ?></option>
</select></li>
<li id="vcard-section-soundincluded-1"><label for="Sound-Format"><?php echo $vCardMaker_GUI_Lang['CSoundFormat']; ?></label><br>
<select name="Sound.Format" id="Sound-Format">
<option value="WAVE">Wave format (WAVE)</option>
<option value="PCM">MIME basic audio type (PCM)</option>
<option value="AIFF">AIFF format (AIFF)</option>
</select></li>
<li id="vcard-section-soundincluded-2"><label for="Sound-Source"><?php echo $vCardMaker_GUI_Lang['CSound']; ?></label><br><textarea cols="40" rows="15" name="Sound.Source" id="Sound-Source"></textarea></li>
<li><label for="Class"><span class="vcard-only30"><?php echo $vCardMaker_GUI_Lang['CClass']; ?></span> <a href="#" onclick="vCardMakerHelp('Class'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br>
<select name="Class" id="Class">
<option value=""></option>
<option value="PUBLIC">Public</option>
<option value="PRIVATE">Private</option>
<option value="CONFIDENTIAL">Confidential</option>
</select></li>
<li><label for="Key-Type"><?php echo $vCardMaker_GUI_Lang['CKeyType']; ?> <a href="#" onclick="vCardMakerHelp('EncryptionKey'); return false" class="help"><img src="images/question-16x16.png" width="16" height="16" alt="Help"></a></label><br>
<select name="Key.Type" id="Key-Type">
<option value="None" selected="selected"></option>
<option value="PGP" class="vcard-only21"><?php echo $vCardMaker_GUI_Lang['CKeyTypePGP']; ?></option>
<option value="X509" class="vcard-only21"><?php echo $vCardMaker_GUI_Lang['CKeyTypeX509']; ?></option>
<option value="B" class="vcard-only30"><?php echo $vCardMaker_GUI_Lang['CKeyTypeBinary']; ?></option>
</select></li>
<li id="vcard-section-keyincluded"><label for="Key-Source"><?php echo $vCardMaker_GUI_Lang['CKey']; ?></label><br><textarea cols="40" rows="15" name="Key.Source" id="Key-Source"></textarea></li>
</ol>
</div>
</fieldset>

</div>

<div id="results"></div>
<div id="results-close">&times;</div>
<div id="results-spinner"></div>

<p id="buttons"><input type="submit" value="<?php echo $vCardMaker_GUI_Lang['CvCardSubmitButton']; ?>" class="button"></p>

</form>

<p id="footer"><a href="http://tools.rubenarakelyan.com/vcardmaker/">vCardMaker</a>.</p>

</body>
</html>
