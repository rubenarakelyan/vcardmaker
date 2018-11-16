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

$vCardMaker_Lang = array();

// Validator strings
$vCardMaker_Lang['NoVersion']            = 'The vCard version is blank.';
$vCardMaker_Lang['NoFormattedName']      = 'The full name is blank.';
$vCardMaker_Lang['NoForename']           = 'The forename is blank.';
$vCardMaker_Lang['NoSurname']            = 'The surname is blank.';
$vCardMaker_Lang['NoNameSource']         = 'If name or source are used, then both must be provided.';
$vCardMaker_Lang['NoBirthDate']          = 'The birth date is not in the correct format.';
$vCardMaker_Lang['NoBirthDateTime']      = 'If the birth time is provided then the birth date must be provided.';
$vCardMaker_Lang['NoBirthTime']          = 'The birth time is not in the correct format.';
$vCardMaker_Lang['NoBirthTimeZone']      = 'If the birth timezone is provided then the birth time must be provided.';
$vCardMaker_Lang['NoSoundPhonetic']      = 'The phonetic type for a sound cannot be used in a 3.0 vCard.';
$vCardMaker_Lang['NoSoundSource']        = 'The sound source is blank.';
$vCardMaker_Lang['NoPhotoSource']        = 'The photo source is blank.';
$vCardMaker_Lang['NoPhotoQP']            = 'The Quoted-Printable type for a photo cannot be used in a 3.0 vCard.';
$vCardMaker_Lang['NoDeliveryStreet']     = 'The street name for your address is blank.';
$vCardMaker_Lang['NoDeliveryLocality']   = 'The locality for your address is blank.';
$vCardMaker_Lang['NoDeliveryPostCode']   = 'The postal code for your address is blank.';
$vCardMaker_Lang['NoDeliveryCountry']    = 'The country for your address is blank.';
$vCardMaker_Lang['NoLabelStreet']        = 'The street name for your delivery label is blank.';
$vCardMaker_Lang['NoLabelLocality']      = 'The locality for your delivery label is blank.';
$vCardMaker_Lang['NoLabelPostCode']      = 'The postal code for your delivery label is blank.';
$vCardMaker_Lang['NoLabelCountry']       = 'The country for your delivery label is blank.';
$vCardMaker_Lang['NoTelNumber']          = 'The telephone number is blank.';
$vCardMaker_Lang['NoEmailAddress']       = 'The email address is blank.';
$vCardMaker_Lang['NoGeoLoc']             = 'The geographical location is incorrect.';
$vCardMaker_Lang['NoLogoSource']         = 'The logo source is blank.';
$vCardMaker_Lang['NoLogoQP']             = 'The Quoted-Printable type for a logo cannot be used in a 3.0 vCard.';
$vCardMaker_Lang['NoAgentSource']        = 'The agent source is blank.';
$vCardMaker_Lang['NoAgentURLType']       = 'The URL agent type cannot be used in a 2.1 vCard.';
$vCardMaker_Lang['NoKeyBinary']          = 'The binary key type cannot be used in a 2.1 vCard.';
$vCardMaker_Lang['NoKeyPGPX509']         = 'The PGP and X.509 key types cannot be used in a 3.0 vCard.';
$vCardMaker_Lang['NoKeySource']          = 'The key source is blank.';
$vCardMaker_Lang['VErrorsFound']         = 'The following errors were found:';

// Email strings
$vCardMaker_Lang['ESubject']             = 'Your vCard from vCardMaker';
$vCardMaker_Lang['EMessage']             = "Hello!\n\nYou recently created a vCard using vCardMaker and asked us to email it to you. Your vCard is included below between the dashes. If you didn't request this message, please reply to this email and we'll do our best to make sure it doesn't happen again.\n\nThank you for using vCardMaker!";

?>