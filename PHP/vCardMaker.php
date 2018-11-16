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

class vCardMaker {

  // FUNCTION: Gets the version of the vCardMaker class
  // - Parameters: $format -> false = version number, true = version string
  public static function Version($format = false) {
    // Set up the version variables
    $vCardMaker_Name    = 'vCardMaker';
    $vCardMaker_Version = '1.1.0';
    $vCardMaker_String  = $vCardMaker_Name . ' ' . $vCardMaker_Version;
    // Return version number or string
    if ($format) {
      return $vCardMaker_String;
    } else {
      return $vCardMaker_Version;
    }
  }

  // FUNCTION: Makes a vCard after validating input
  // - Parameters: $request -> raw input
  public function Make($request) {
    if ($this->Validate($request, true)) {
      $this->vCard_Ready = true;
      return $this->Deliver($request, true);
    } else {
      $this->vCard_Ready = false;
      return $this->vCardMaker_Errors;
    }
  }

  // FUNCTION: Makes a vCard with no output after validating input
  // - Parameters: $request -> raw input
  public function MakeQuiet($request) {
    if ($this->Validate($request, false)) {
      $this->vCard_Ready = true;
      return $this->Deliver($request, false);
    } else {
      $this->vCard_Ready = false;
      return $this->vCardMaker_Errors;
    }
  }

  // STATIC FUNCTION: Downloads a vCard
  public static function Download($vCard) {
    // Force download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=vCard.vcf');
    echo $vCard;
    return true;
  }

  // STATIC FUNCTION: Emails a vCard
  public static function Email($vCard) {
    // Send an email
    mail($this->vCard_Email, $vCardMaker_Lang['ESubject'], $vCardMaker_Lang['EMessage'] . "\n\n--\n\n" . $this->vCard . "\n\n--\n", 'From: ' . EMAIL_FROM . "\r\n" . 'Reply-To: ' . EMAIL_FROM . "\r\n");
    return true;
  }

  // FUNCTION: Validate raw input
  // - Parameters: $request -> raw input; $format -> true = return HTML, false = return plain-text
  private function Validate($request, $format) {

    // Get the appropriate language file
    require_once 'vCardMaker_Lang.php';

    $vCardMaker_Validate = '';

    // Make sure vCard version is present - defaults to 2.1
    if (!isset($request['vCard_Version'])) {
      $this->vCard_Version = '2.1';
    } else {
      $this->vCard_Version = $request['vCard_Version'];
    }

    // Make sure vCard name and source are present (if appropriate; only 3.0)
    if ($this->vCard_Version == '3.0' && ((trim($request['vCard_Name']) != '' && trim($request['vCard_Source']) == '') || (trim($request['vCard_Name']) == '' && trim($request['vCard_Source']) != ''))) {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoNameSource']."\n";
    }

    // Make sure formatted name is present
    if ($request['Name_Formatted'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoFormattedName']."\n";
    }

    // Make sure forename is present
    if ($request['Name_Forename'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoForename']."\n";
    }

    // Make sure surname is present
    if ($request['Name_Surname'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoSurname']."\n";
    }

    // Make sure quoted-printable photo isn't used for a 3.0 vCard
    if ($this->vCard_Version == '3.0' && $request['Photo_Type'] == 'QUOTED-PRINTABLE') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoPhotoQP']."\n";
    }

    // Make sure the photo source is present (if appropriate)
    if (($request['Photo_Type'] != '' && $request['Photo_Type'] != 'None') && $request['Photo_Source'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoPhotoSource']."\n";
    }

    // Make sure that the birth date is in the correct format
    if (isset($request['Birth_Date']) && $request['Birth_Date'] != '' && preg_match('/^\d{4}-\d{2}-\d{2}/', $request['Birth_Date']) == 0) {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoBirthDate']."\n";
    }

    // Make sure that the birth time is present (if appropriate)
    if ($this->vCard_Version == '3.0' && isset($request['Birth_Time']) && $request['Birth_Time'] != '' && $request['Birth_Date'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoBirthDateTime']."\n";
    }

    // Make sure that the birth time is in the correct format
    if ($this->vCard_Version == '3.0' && isset($request['Birth_Time']) && $request['Birth_Time'] != '' && preg_match('/^\d{2}:\d{2}:\d{2}/', $request['Birth_Time']) == 0) {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoBirthTime']."\n";
    }

    // Make sure that the birth timezone is present (if appropriate)
    if ($this->vCard_Version == '3.0' && isset($request['Birth_Time_Zone']) && $request['Birth_Time_Zone'] != '' && $request['Birth_Time'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoBirthTimeZone']."\n";
    }

    // Make sure the address street is present (if appropriate)
    if (isset($request['DeliveryAddress_Type']) && $request['DeliveryAddress_Type'] != '' && $request['DeliveryAddress_Street'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoDeliveryStreet']."\n";
    }

    // Make sure the address locality is present (if appropriate)
    if (isset($request['DeliveryAddress_Type']) && $request['DeliveryAddress_Type'] != '' && $request['DeliveryAddress_Locality'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoDeliveryLocality']."\n";
    }

    // Make sure the address postal code is present (if appropriate)
    if (isset($request['DeliveryAddress_Type']) && $request['DeliveryAddress_Type'] != '' && $request['DeliveryAddress_PostalCode'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoDeliveryPostCode']."\n";
    }

    // Make sure the address country is present (if appropriate)
    if (isset($request['DeliveryAddress_Type']) && $request['DeliveryAddress_Type'] != '' && $request['DeliveryAddress_Country'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoDeliveryCountry']."\n";
    }

    // Make sure the delivery label street is present (if appropriate)
    if (isset($request['DeliveryLabel_Type']) && $request['DeliveryLabel_Type'] != '' && $request['DeliveryLabel_Street'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoLabelStreet']."\n";
    }

    // Make sure the delivery label locality is present (if appropriate)
    if (isset($request['DeliveryLabel_Type']) && $request['DeliveryLabel_Type'] != '' && $request['DeliveryLabel_Locality'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoLabelLocality']."\n";
    }

    // Make sure the delivery label postal code is present (if appropriate)
    if (isset($request['DeliveryLabel_Type']) && $request['DeliveryLabel_Type'] != '' && $request['DeliveryLabel_PostalCode'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoLabelPostCode']."\n";
    }

    // Make sure the delivery label country is present (if appropriate)
    if (isset($request['DeliveryLabel_Type']) && $request['DeliveryLabel_Type'] != '' && $request['DeliveryLabel_Country'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoLabelCountry']."\n";
    }

    // Make sure the telephone number is present (if appropriate)
    if ($request['TelephoneNumber_Type'] != '' && $request['TelephoneNumber_Number'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoTelNumber']."\n";
    }

    // Make sure the telephone number (2) is present (if appropriate)
    if ($request['TelephoneNumber_Type_2'] != '' && $request['TelephoneNumber_Number_2'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoTelNumber']."\n";
    }

    // Make sure the email address is present
    if ($request['EmailAddress_Type'] == '' || $request['EmailAddress_Address'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoEmailAddress']."\n";
    }

    // Make sure the email address (2) is present (if appropriate)
    if ($request['EmailAddress_Type_2'] != '' && $request['EmailAddress_Address_2'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoEmailAddress']."\n";
    }

    // Make sure the geographical location is present (if appropriate)
    if ((trim($request['GeographicalProperties_Position_Latitude']) != '' && trim($request['GeographicalProperties_Position_Longitude']) == '') || (trim($request['GeographicalProperties_Position_Longitude']) != '' && trim($request['GeographicalProperties_Position_Latitude']) == '')) {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoGeoLoc']."\n";
    }

    // Make sure the geographical location is in the correct format (if appropriate)
    if (trim($request['GeographicalProperties_Position_Latitude']) != '' && preg_match('/^[+-]\d{1,2}.\d{1,2}/', $request['GeographicalProperties_Position_Latitude']) == 0) {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoGeoLoc']."\n";
    }

    // Make sure the geographical location is in the correct format (if appropriate)
    if (trim($request['GeographicalProperties_Position_Longitude']) != '' && preg_match('/^[+-]\d{1,2}.\d{1,2}/', $request['GeographicalProperties_Position_Longitude']) == 0) {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoGeoLoc']."\n";
    }

    // Make sure quoted-printable logo isn't used for a 3.0 vCard
    if ($this->vCard_Version == '3.0' && $request['Logo_Type'] == 'QUOTED-PRINTABLE') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoLogoQP']."\n";
    }

    // Make sure the logo source is present (if appropriate)
    if (($request['Logo_Type'] != '' && $request['Logo_Type'] != 'None') && $request['Logo_Source'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoLogoSource']."\n";
    }

    // Make sure the agent source is present (if appropriate)
    if ($request['Agent_Type'] != '' && $request['Agent_Type'] != 'None' && $request['Agent_Source'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoAgentSource']."\n";
    }

    // Make sure agent URL isn't used for a 2.1 vCard
    if ($this->vCard_Version == '2.1' && $request['Agent_Type'] == 'URL') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoAgentURLType']."\n";
    }

    // Make sure phonetic sound type isn't used for a 3.0 vCard
    if ($this->vCard_Version == '3.0' && $request['Sound_Type'] == 'Phonetic') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoSoundPhonetic']."\n";
    }

    // Make sure the sound phonetic representation is present (if appropriate)
    if ($request['Sound_Type'] == 'Phonetic' && $request['Sound_Source'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoSoundSource']."\n";
    }

    // Make sure the sound URL is present (if appropriate)
    if ($request['Sound_Type'] == 'URL' && $request['Sound_Source'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoSoundSource']."\n";
    }

    // Make sure the sound source is present (if appropriate)
    if ($request['Sound_Type'] == 'BASE64' && $request['Sound_Source'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoSoundSource']."\n";
    }

    // Make sure binary key type isn't used for a 2.1 vCard
    if ($this->vCard_Version == '2.1' && $request['Key_Type'] == 'B') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoKeyBinary']."\n";
    }

    // Make sure PGP and X.509 key types aren't used for a 3.0 vCard
    if ($this->vCard_Version == '3.0' && ($request['Key_Type'] == 'PGP' || $request['Key_Type'] == 'X509')) {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoKeyPGPX509']."\n";
    }

    // Make sure the key source is present (if appropriate)
    if (($request['Key_Type'] == 'PGP' || $request['Key_Type'] == 'X509' || $request['Key_Type'] == 'B') && $request['Key_Source'] == '') {
      $vCardMaker_Validate .= $vCardMaker_Lang['NoKeySource']."\n";
    }

    // Check to see if any errors should be returned
    if ($vCardMaker_Validate != '') {
      // Errors
      if ($format) {
        $vCardMaker_ValidateH = explode("\n", $vCardMaker_Validate);
        $vCardMaker_Validate = '<pre id="result"><strong>'.$vCardMaker_Lang['VErrorsFound'].'</strong><ul>';
        for ($x = 0; $x < (count($vCardMaker_ValidateH) - 1); $x++) {
          $vCardMaker_Validate .= '<li>'.$vCardMaker_ValidateH[$x].'</li>';
        }
        $vCardMaker_Validate .= '</ul></pre>'."\n";
      }
      $this->vCardMaker_Errors = $vCardMaker_Validate;
      return false;
    } else {
      // No errors
      return true;
    }

  }

  // FUNCTION: Makes a vCard
  // - Parameters: $request -> raw input; $format -> true = return HTML, false = return plain-text
  private function Deliver($request, $format) {

    // Get the appropriate language file
    require_once 'vCardMaker_Lang.php';

    // Escape characters
    if (!function_exists('escape')) {
      function escape(&$item, $key) {
        $item = str_replace(':', '\:', $item);
        $item = str_replace(';', '\;', $item);
        $item = str_replace(',', '\,', $item);
      }
    }
    array_walk($request, 'escape');

    // Begin vCard Delimiter
    $this->vCard = 'BEGIN:VCARD'."\n";

    // vCard Version
    switch ($this->vCard_Version) {
      case '3.0':
        $this->vCard .= 'VERSION:3.0'."\n";
        break;
      case '2.1':
      default:
        $this->vCard .= 'VERSION:2.1'."\n";
    }

    // vCard Profile (only 3.0)
    if ($this->vCard_Version == '3.0') {
      $this->vCard .= 'PROFILE:VCARD'."\n";
    }

    // Name and Source (only 3.0)
    if ($this->vCard_Version == '3.0' && trim($request['vCard_Name']) != '' && trim($request['vCard_Source']) != '') {
      $this->vCard .= 'NAME:'.$request['vCard_Name']."\n".'SOURCE:'.$request['vCard_Source']."\n";
    }

    // Formatted Name
    $this->vCard .= 'FN:'.trim($request['Name_Formatted'])."\n";

    // Name
    $this->vCard .= 'N:'.trim($request['Name_Surname']).';'.trim($request['Name_Forename']).';'.trim($request['Name_Additional']).';'.trim($request['Name_Prefix']).';'.trim($request['Name_Suffix'])."\n";

    // Sort (only 3.0)
    if ($this->vCard_Version == '3.0' && $request['Sort'] != '') {
      $this->vCard .= 'SORT-STRING:'.$request['Sort']."\n";
    }

    // Nickname (only 3.0)
    if ($this->vCard_Version == '3.0' && $request['Nickname'] != '') {
      $this->vCard .= 'NICKNAME:'.$request['Nickname']."\n";
    }

    // Photo
    if ($request['Photo_Type'] != '' && $request['Photo_Type'] != 'None') {
      $this->vCard .= 'PHOTO;';
      switch ($request['Photo_Type']) {
        case 'BASE64':
          $this->vCard .= 'ENCODING=';
          if ($this->vCard_Version == '2.1') {
            $this->vCard .= 'BASE64:';
          } else {
            $this->vCard .= 'b:';
          }
          $this->vCard .= ';TYPE='.$request['Photo_Format'].':'.trim($request['Photo_Source'])."\n";
          break;
        case 'QUOTED-PRINTABLE':
          $this->vCard .= 'ENCODING:QUOTED-PRINTABLE;TYPE='.$request['Photo_Format'].':'.trim($request['Photo_Source'])."\n";
          break;
        case 'URL':
        default:
          $this->vCard .= 'VALUE=';
          if ($this->vCard_Version == '2.1') {
            $this->vCard .= 'URL:';
          } else {
            $this->vCard .= 'uri:';
          }
          $this->vCard .= trim($request['Photo_Source'])."\n";
      }
    }

    // Birth date and birth time
    if ($request['Birth_Date'] != '') {
      $this->vCard .= 'BDAY:'.trim($request['Birth_Date']);
      if ($this->vCard_Version == '3.0' && $request['Birth_Time'] != '') {
        $this->vCard .= 'T'.trim($request['Birth_Time']);
        if ($request['Birth_Time_Zone'] != '') {
          $this->vCard .= trim($request['Birth_Time_Zone'])."\n";
        } else {
          $this->vCard .= 'Z'."\n";
        }
      } else {
        $this->vCard .= "\n";
      }
    }

    // Delivery Address
    if (isset($request['DeliveryAddress_Type']) && $request['DeliveryAddress_Type'] != '') {
      $this->vCard .= 'ADR';
      foreach ($request['DeliveryAddress_Type'] as $type) {
        if ($this->vCard_Version == '2.1') {
          $this->vCard .= ';'.$type;
        } else {
          $this->vCard .= ';TYPE='.$type;
        }
      }
      $this->vCard .= ':'.trim($request['DeliveryAddress_PostOfficeAddress']).';'.trim($request['DeliveryAddress_ExtendedAddress']).';'.trim($request['DeliveryAddress_Street']).';'.trim($request['DeliveryAddress_Locality']).';'.trim($request['DeliveryAddress_Region']).';'.trim($request['DeliveryAddress_PostalCode']).';'.$request['DeliveryAddress_Country']."\n";
    }

    // Delivery Label
    if ($this->vCard_Version == '2.1') {
      $separator = '=0D=0A=';
    } else {
      $separator = '\n';
    }
    if (isset($request['DeliveryLabel_Type']) && $request['DeliveryLabel_Type'] != '') {
      $this->vCard .= 'LABEL';
      foreach ($request['DeliveryLabel_Type'] as $type) {
        if ($this->vCard_Version == '2.1') {
          $this->vCard .= ';'.$type;
        } else {
          $this->vCard .= ';TYPE='.$type;
        }
      }
      if ($this->vCard_Version == '2.1') {
        $this->vCard .= ';ENCODING=QUOTED-PRINTABLE';
      }
      $this->vCard .= ':'.trim($request['DeliveryLabel_PostOfficeAddress']).$separator.trim($request['DeliveryLabel_ExtendedAddress']).$separator.trim($request['DeliveryLabel_Street']).$separator.trim($request['DeliveryLabel_Locality']).$separator.trim($request['DeliveryLabel_Region']).$separator.trim($request['DeliveryLabel_PostalCode']).$separator.$request['DeliveryLabel_Country']."\n";
    }

    // Telephone Number (1)
    if ($request['TelephoneNumber_Type'] != '') {
      $this->vCard .= 'TEL;';
      if ($this->vCard_Version == '2.1') {
        $this->vCard .= 'PREF';
      } else {
        $this->vCard .= 'TYPE=PREF';
      }
      if ($request['TelephoneNumber_Type_Msg'] == 'MSG') {
        if ($this->vCard_Version == '2.1') {
          $this->vCard .= ';MSG';
        } else {
          $this->vCard .= ';TYPE=MSG';
        }
      }
      $this->vCard .= ';';
      if ($this->vCard_Version == '3.0') {
        $this->vCard .= 'TYPE=';
      }
      $this->vCard .= $request['TelephoneNumber_Type'].':'.trim($request['TelephoneNumber_Number'])."\n";
    }

    // Telephone Number (2)
    if ($request['TelephoneNumber_Type_2'] != '') {
      $this->vCard .= 'TEL';
      if ($request['TelephoneNumber_Type_Msg_2'] == 'MSG') {
        if ($this->vCard_Version == '2.1') {
          $this->vCard .= ';MSG';
        } else {
          $this->vCard .= ';TYPE=MSG';
        }
      }
      $this->vCard .= ';';
      if ($this->vCard_Version == '3.0') {
        $this->vCard .= 'TYPE=';
      }
      $this->vCard .= $request['TelephoneNumber_Type_2'].':'.trim($request['TelephoneNumber_Number_2'])."\n";
    }

    // Email Address (1)
    if ($request['EmailAddress_Type'] != '') {
      $this->vCard .= 'EMAIL;';
      if ($this->vCard_Version == '3.0') {
        $this->vCard .= 'TYPE=';
      }
      $this->vCard .= $request['EmailAddress_Type'];
      if ($this->vCard_Version == '3.0') {
        $this->vCard .= ';TYPE=PREF:';
      } else {
        $this->vCard .= ':';
      }
      $this->vCard .= trim($request['EmailAddress_Address'])."\n";
    }

    // Email Address (2)
    if ($request['EmailAddress_Type_2'] != '') {
      $this->vCard .= 'EMAIL;';
      if ($this->vCard_Version == '3.0') {
        $this->vCard .= 'TYPE=';
      }
      $this->vCard .= $request['EmailAddress_Type_2'].':'.trim($request['EmailAddress_Address_2'])."\n";
    }

    // Mailer
    if (trim($request['Mailer_Name']) != '') {
      $this->vCard .= 'MAILER:'.trim($request['Mailer_Name'])."\n";
    }

    // Timezone
    if ($request['GeographicalProperties_Timezone'] != '') {
      $this->vCard .= 'TZ:'.$request['GeographicalProperties_Timezone']."\n";
    }

    // Geographic Position
    if (trim($request['GeographicalProperties_Position_Latitude']) != '') {
      $this->vCard .= 'GEO:'.trim($request['GeographicalProperties_Position_Latitude']).','.trim($request['GeographicalProperties_Position_Longitude'])."\n";
    }

    // Title
    if (trim($request['OrganisationalProperties_JobTitle']) != '') {
      $this->vCard .= 'TITLE:'.trim($request['OrganisationalProperties_JobTitle'])."\n";
    }

    // Role
    if (trim($request['OrganisationalProperties_Role']) != '') {
      $this->vCard .= 'ROLE:'.trim($request['OrganisationalProperties_Role'])."\n";
    }

    // Logo
    if ($request['Logo_Type'] != '' && $request['Logo_Type'] != 'None') {
      $this->vCard .= 'LOGO;';
      switch ($request['Logo_Type']) {
        case 'BASE64':
          $this->vCard .= 'ENCODING=';
          if ($this->vCard_Version == '2.1') {
            $this->vCard .= 'BASE64';
          } else {
            $this->vCard .= 'b';
          }
          $this->vCard .= ';TYPE='.$request['Logo_Format'].':'.trim($request['Logo_Source'])."\n";
          break;
        case 'QUOTED-PRINTABLE':
          $this->vCard .= 'ENCODING:QUOTED-PRINTABLE;TYPE='.$request['Logo_Format'].':'.trim($request['Logo_Source'])."\n";
          break;
        case 'URL':
        default:
          $this->vCard .= 'VALUE=';
          if ($this->vCard_Version == '2.1') {
            $this->vCard .= 'URL:';
          } else {
            $this->vCard .= 'uri:';
          }
          $this->vCard .= trim($request['Logo_Source'])."\n";
      }
    }

    // Agent
    if ($request['Agent_Type'] != '' && $request['Agent_Type'] != 'None') {
      $this->vCard .= 'AGENT';
      switch ($request['Agent_Type']) {
        case 'URL':
          if ($this->vCard_Version == '3.0') {
            $this->vCard .= ';VALUE=uri:'.trim($request['Agent_Source'])."\n";
          }
          break;
        case 'vCard':
        default:
          $this->vCard .= ':'."\n".trim($request['Agent_Source'])."\n";
      }
    }

    // Organisation Name and Organisational Unit
    if (trim($request['OrganisationalProperties_OrganisationName']) != '') {
      $this->vCard .= 'ORG:'.trim($request['OrganisationalProperties_OrganisationName']);
      if (trim($request['OrganisationalProperties_OrganisationalUnit']) != '') {
        $this->vCard .= ';'.trim($request['OrganisationalProperties_OrganisationalUnit'])."\n";
      } else {
        $this->vCard .= "\n";
      }
    }

    // Categories (only 3.0)
    if ($this->vCard_Version == '3.0' && $request['Categories'] != '') {
      $this->vCard .= 'CATEGORIES:'.trim($request['Categories'])."\n";
    }

    // Comment
    if (trim($request['Comment']) != '') {
      $this->vCard .= 'NOTE';
      if ($this->vCard_Version == '2.1') {
        $this->vCard .= ';ENCODING=QUOTED-PRINTABLE';
      }
      $this->vCard .= ':'.trim($request['Comment'])."\n";
    }

    // Sound
    if ($request['Sound_Type'] != '' && $request['Sound_Type'] != 'None') {
      $this->vCard .= 'SOUND';
      switch ($request['Sound_Type']) {
        case 'BASE64':
          $this->vCard .= ';';
          if ($this->vCard_Version == '3.0') {
            $this->vCard .= 'TYPE=';
          }
          $this->vCard .= $request['Sound_Format'];
          if ($this->vCard_Version == '2.1') {
            $this->vCard .= ';BASE64:';
          } else {
            $this->vCard .= ';ENCODING=b:';
          }
          $this->vCard .= trim($request['Sound_Source'])."\n";
          break;
        case 'Phonetic':
          $this->vCard .= ':'.trim($request['Sound_Source'])."\n";
          break;
        case 'URL':
        default:
          $this->vCard .= ';VALUE=';
          if ($this->vCard_Version == '2.1') {
            $this->vCard .= 'URL:';
          } else {
            $this->vCard .= 'uri:';
          }
          $this->vCard .= trim($request['Sound_Source'])."\n";
      }
    }

    // URL
    if (trim($request['URL'] != '')) {
      $this->vCard .= 'URL:'.trim($request['URL'])."\n";
    }

    // Class (only 3.0)
    if ($this->vCard_Version == '3.0' && $request['Class'] != '') {
      $this->vCard .= 'CLASS:'.trim($request['Class'])."\n";
    }

    // Key
    if ($request['Key_Type'] != '' && $request['Key_Type'] != 'None') {
      $this->vCard .= 'KEY;';
      switch ($request['Key_Type']) {
        case 'B':
          $this->vCard .= 'ENCODING=b:'.trim($request['Key_Source'])."\n";
          break;
        case 'X509':
          $this->vCard .= 'X509:'.trim($request['Key_Source'])."\n";
          break;
        case 'PGP':
        default:
          $this->vCard .= 'PGP:'.trim($request['Key_Source'])."\n";
      }
    }

    // Unique Identifier
    $this->vCard .= 'UID:'.md5(uniqid(rand(), true))."\n";

    // Last Revision Date
    date_default_timezone_set('Europe/London');
    $this->vCard .= 'REV:'.date('Y-m-d\TH\\\:i\\\:s\Z')."\n";

    // Generator fields
    $this->vCard .= 'X-GENERATOR:'.vCardMaker::Version(true)."\n";
    if ($this->vCard_Version == '3.0') {
      $this->vCard .= 'PRODID:-//RUBENARAKELYAN//NONSGML VCARDMAKER '.vCardMaker::Version(false).'//EN'."\n";
    }

    // End vCard Delimiter
    $this->vCard .= 'END:VCARD';

    // Send the vCard
    if ($format) {
      return '<pre id="result">' . $this->vCard . '</pre>';
    } else {
      return $this->vCard;
    }

  }

  private $vCard;
  private $vCard_Version;
  private $vCard_Email;
  private $vCard_Ready = false;
  private $vCardMaker_Errors;

  // Constants - ** CHANGE THESE **
  private $EMAIL_FROM = 'vcardmaker@example.com';

}

?>