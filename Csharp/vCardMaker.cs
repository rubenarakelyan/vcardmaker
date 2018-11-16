using System;
using System.Data;
using System.Collections.Specialized;
using System.Configuration;
using System.Net.Mail;
using System.Security.Cryptography;
using System.Text;
using System.Text.RegularExpressions;
using System.Web;
using System.Web.Security;
using System.Web.UI;
using System.Web.UI.HtmlControls;
using System.Web.UI.WebControls;

namespace vCardMaker
{
    /// <summary>
    /// This file is part of vCardMaker.
    /// 
    /// vCardMaker is free software: you can redistribute it and/or modify
    /// it under the terms of the GNU General Public License as published by
    /// the Free Software Foundation, either version 3 of the License, or
    /// (at your option) any later version.
    /// 
    /// vCardMaker is distributed in the hope that it will be useful,
    /// but WITHOUT ANY WARRANTY; without even the implied warranty of
    /// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    /// GNU General Public License for more details.
    /// 
    /// You should have received a copy of the GNU General Public License
    /// along with vCardMaker.  If not, see <http://www.gnu.org/licenses/>.
    /// </summary>
    public class vCardMaker : System.Web.UI.Page
    {
        /// <summary>
        /// Gets the version of the vCardMaker class
        /// </summary>
        /// <param name="format">if <code>true</code> then version string is returned, otherwise version number is returned</param>
        /// <returns>version string or number</returns>
        public static String Version(bool format)
        {
            // Set up the version variables
            String vCardMaker_Name = "vCardMaker";
            String vCardMaker_Version = "1.1.0";
            String vCardMaker_String = vCardMaker_Name + " " + vCardMaker_Version;
            // Return version number or string
            if (format)
            {
                return vCardMaker_String;
            }
            else
            {
                return vCardMaker_Version;
            }
        }

        /// <summary>
        /// Gets the version number of the vCardMaker class
        /// </summary>
        /// <returns>version number</returns>
        public static String Version()
        {
            return vCardMaker.Version(false);
        }

        /// <summary>
        /// Makes a vCard after validating input
        /// </summary>
        /// <param name="request">raw input</param>
        /// <returns>vCard</returns>
        public String Make(NameValueCollection request)
        {
            if (this.Validate(request, true))
            {
                this.vCard_Ready = true;
                return this.Deliver(request, true);
            }
            else
            {
                this.vCard_Ready = false;
                return this.vCardMaker_Errors;
            }
        }

        /// <summary>
        /// Makes a vCard with no output after validating input
        /// </summary>
        /// <param name="request">raw input</param>
        /// <returns>vCard</returns>
        public String MakeQuiet(NameValueCollection request)
        {
            if (this.Validate(request, false))
            {
                this.vCard_Ready = true;
                return this.Deliver(request, false);
            }
            else
            {
                this.vCard_Ready = false;
                return this.vCardMaker_Errors;
            }
        }

        /// <summary>
        /// Downloads a vCard
        /// </summary>
        public static bool Download()
        {
            // Force download
            Response.ContentType = "application/octet-stream";
            Response.AddHeader("Content-Disposition", "attachment; filename=vCard.vcf");
            Response.BinaryWrite(new ASCIIEncoding().GetBytes(this.vCard));
            return true;
        }

        /// <summary>
        /// Emails a vCard
        /// </summary>
        /// <returns></returns>
        public static bool Email()
        {
            // Send an email
            // See http://weblogs.asp.net/dfindley/archive/2006/04/23/Migrating-from-System.Web.Mail-to-System.Net.Mail.aspx
            MailMessage message = new MailMessage();
            message.From = new MailAddress(EMAIL_FROM);
            message.ReplyTo = new MailAddress(EMAIL_FROM);
            message.To.Add(this.vCard_Email);
            message.Subject = vCardMaker_Lang["ESubject"];
            message.Body = vCardMaker_Lang["EMessage"] + "\n\n--\n\n" + this.vCard + "\n\n--\n";
            // SMTP server defined in Web.config
            new SmtpClient().Send(message);
            return true;
        }

        /// <summary>
        /// Validates raw input
        /// </summary>
        /// <param name="request">raw input</param>
        /// <param name="format">if <code>true</code> then HTML is returned, otherwise plain-text vCard is returned</param>
        /// <returns><code>true</code> if input is valid, <code>false</code> otherwise</returns>
        private bool Validate(NameValueCollection request, bool format)
        {
            String vCardMaker_Validate = "";

            // Make sure vCard version is present - defaults to 2.1
            if (request["Version.vCard"] == null)
            {
                vCard_Version = "2.1";
            }
            else
            {
                vCard_Version = request["Version.vCard"];
            }

            // Make sure vCard name and source are present (if appropriate; only 3.0)
            if (vCard_Version == "3.0" && ((request["Name"].Trim() != "" && request["Source"].Trim() == "") || (request["Name"].Trim() == "" && request["Source"].Trim() != "")))
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoNameSource") + "\n";
            }
            
            // Make sure formatted name is present
            if (request["Formatted.Name"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoFormattedName") + "\n";
            }
            
            // Make sure forename is present
            if (request["Name.Forename"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoForename") + "\n";
            }
            
            // Make sure surname is present
            if (request["Name.Surname"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoSurname") + "\n";
            }
            
            // Make sure quoted-printable photo isn't used for a 3.0 vCard
            if (vCard_Version == "3.0" && request["Photo.Type"] == "QUOTED-PRINTABLE")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoPhotoQP") + "\n";
            }
            
            // Make sure the photo URL is present (if appropriate)
            if (request["Photo.Type"] == "URL" && request["Photo.Source.URL"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoPhotoURL") + "\n";
            }
            
            // Make sure the photo source is present (if appropriate)
            if ((request["Photo.Type"] == "BASE64" || request["Photo.Type"] == "QUOTED-PRINTABLE") && request["Photo.Source.Quoted"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoPhotoSource") + "\n";
            }
            
            // Make sure that the birth date is in the correct format
            if (request["Birthdate"] != "" && !new Regex("^\\d{4}-\\d{2}-\\d{2}$").IsMatch(request["Birthdate"]))
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoBirthdate") + "\n";
            }
            
            // Make sure that the birth time is present (if appropriate)
            if (vCard_Version == "3.0" && request["Birthtime"] != "" && request["Birthdate"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoBirthdatetime") + "\n";
            }
            
            // Make sure that the birth time is in the correct format
            if (vCard_Version == "3.0" && request["Birthtime"] != "" && !new Regex("^\\d{2}:\\d{2}:\\d{2}$").IsMatch(request["Birthtime"]))
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoBirthtime") + "\n";
            }
            
            // Make sure that the birth timezone is present (if appropriate)
            if (vCard_Version == "3.0" && request["Birthtimezone"] != "" && request["Birthtime"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoBirthtimezone") + "\n";
            }
            
            // Make sure the address street is present (if appropriate)
            if (request["DeliveryAddress.Type"] != null && request["DeliveryAddress.Type"] != "" && request["DeliveryAddress.Street"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoDeliveryStreet") + "\n";
            }
            
            // Make sure the address locality is present (if appropriate)
            if (request["DeliveryAddress.Type"] != null && request["DeliveryAddress.Type"] != "" && request["DeliveryAddress.Locality"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoDeliveryLocality") + "\n";
            }
            
            // Make sure the address postal code is present (if appropriate)
            if (request["DeliveryAddress.Type"] != null && request["DeliveryAddress.Type"] != "" && request["DeliveryAddress.PostalCode"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoDeliveryPostCode") + "\n";
            }
            
            // Make sure the address country is present (if appropriate)
            if (request["DeliveryAddress.Type"] != null && request["DeliveryAddress.Type"] != "" && request["DeliveryAddress.Country"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoDeliveryCountry") + "\n";
            }
            
            // Make sure the delivery label street is present (if appropriate)
            if (request["DeliveryLabel.Type"] != null && request["DeliveryLabel.Type"] != "" && request["DeliveryLabel.Street"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoLabelStreet") + "\n";
            }
            
            // Make sure the delivery label locality is present (if appropriate)
            if (request["DeliveryLabel.Type"] != null && request["DeliveryLabel.Type"] != "" && request["DeliveryLabel.Locality"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoLabelLocality") + "\n";
            }
            
            // Make sure the delivery label postal code is present (if appropriate)
            if (request["DeliveryLabel.Type"] != null && request["DeliveryLabel.Type"] != "" && request["DeliveryLabel.PostalCode"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoLabelPostCode") + "\n";
            }
            
            // Make sure the delivery label country is present (if appropriate)
            if (request["DeliveryLabel.Type"] != null && request["DeliveryLabel.Type"] != "" && request["DeliveryLabel.Country"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoLabelCountry") + "\n";
            }
            
            // Make sure the telephone number is present (if appropriate)
            if (request["TelephoneNumber.Type"] != "" && request["TelephoneNumber.Number"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoTelNumber") + "\n";
            }
            
            // Make sure the telephone number (2) is present (if appropriate)
            if (request["TelephoneNumber.Type.2"] != "" && request["TelephoneNumber.Number.2"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoTelNumber") + "\n";
            }
            
            // Make sure the email address is present
            if (request["EmailAddress.Type"] == "" || request["EmailAddress.Address"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoEmailAddress") + "\n";
            }
            
            // Make sure the email address (2) is present (if appropriate)
            if (request["EmailAddress.Type.2"] != "" && request["EmailAddress.Address.2"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoEmailAddress") + "\n";
            }
            
            // Make sure the whole geographical location is present (if appropriate)
            if (request["GeographicalProperties.Position.Latitude.Whole"].Trim() != "" && request["GeographicalProperties.Position.Latitude.Fraction"].Trim() == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoGeoLoc") + "\n";
            }
            
            // Make sure the whole geographical location is present (if appropriate)
            if (request["GeographicalProperties.Position.Longitude.Whole"].Trim() != "" && request["GeographicalProperties.Position.Longitude.Fraction"].Trim() == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoGeoLoc") + "\n";
            }
            
            // Make sure the whole geographical location is present (if appropriate)
            if (request["GeographicalProperties.Position.Latitude.Whole"].Trim() != "" && request["GeographicalProperties.Position.Longitude.Whole"].Trim() == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoGeoLoc") + "\n";
            }
            
            // Make sure quoted-printable logo isn't used for a 3.0 vCard
            if (vCard_Version == "3.0" && request["Logo.Type"] == "QUOTED-PRINTABLE")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoLogoQP") + "\n";
            }
            
            // Make sure the logo URL is present (if appropriate)
            if (request["Logo.Type"] == "URL" && request["Logo.Source.URL"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoLogoURL") + "\n";
            }
            
            // Make sure the logo source is present (if appropriate)
            if ((request["Logo.Type"] == "BASE64" || request["Logo.Type"] == "QUOTED-PRINTABLE") && request["Logo.Source.Quoted"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoLogoSource") + "\n";
            }
            
            // Make sure the agent vCard is present (if appropriate)
            if (request["Agent.Type"] == "vCard" && request["Agent"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoAgentvCard") + "\n";
            }
            
            // Make sure the agent URL is present (if appropriate)
            if (request["Agent.Type"] == "URL" && request["Agent.URL"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoAgentURL") + "\n";
            }
            
            // Make sure agent URL isn't used for a 2.1 vCard
            if (vCard_Version == "2.1" && request["Agent.Type"] == "URL")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoAgentURLType") + "\n";
            }
            
            // Make sure binary key type isn't used for a 2.1 vCard
            if (vCard_Version == "2.1" && request["Key.Type"] == "B")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoKeyBinary") + "\n";
            }
            
            // Make sure phonetic sound type isn't used for a 3.0 vCard
            if (vCard_Version == "3.0" && request["Sound.Type"] == "Phonetic")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoSoundPhonetic") + "\n";
            }
            
            // Make sure the sound phonetic representation is present (if appropriate)
            if (request["Sound.Type"] == "Phonetic" && request["Sound.Source.Phonetic"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoSoundPhoneticR") + "\n";
            }
            
            // Make sure the sound URL is present (if appropriate)
            if (request["Sound.Type"] == "URL" && request["Sound.Source.URL"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoSoundURL") + "\n";
            }
            
            // Make sure the sound source is present (if appropriate)
            if (request["Sound.Type"] == "BASE64" && request["Sound.Source.Quoted"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoSoundSource") + "\n";
            }
            
            // Make sure PGP and X.509 key types aren't used for a 3.0 vCard
            if (vCard_Version == "3.0" && (request["Key.Type"] == "PGP" || request["Key.Type"] == "X509"))
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoKeyPGPX509") + "\n";
            }
            
            // Make sure the key source is present (if appropriate)
            if ((request["Key.Type"] == "PGP" || request["Key.Type"] == "X509" || request["Key.Type"] == "B") && request["Key.Quoted"] == "")
            {
                vCardMaker_Validate += vCardMaker_Lang.Get("NoKeySource") + "\n";
            }
            
            // Check to see if any errors should be returned
            if (vCardMaker_Validate != "")
            {
                // Errors
                if (format)
                {
                    vCardMaker_Validate = vCardMaker_Validate.Replace("\n", ";");
                    String[] vCardMaker_ValidateH = vCardMaker_Validate.Split(';');
                    vCardMaker_Validate = "<pre id=\"result\"><strong>" + vCardMaker_Lang.Get("VErrorsFound") + "</strong><ul>";
                    for (int x = 0; x < (vCardMaker_ValidateH.Length - 1); x++)
                    {
                        vCardMaker_Validate += "<li>" + vCardMaker_ValidateH[x] + "</li>";
                    }
                    vCardMaker_Validate += "</ul></pre>\n";
                }
                this.vCardMaker_Errors = vCardMaker_Validate;
                return false;
            }
            else
            {
                // No errors
                return true;
            }
        }

        /// <summary>
        /// Makes a vCard
        /// </summary>
        /// <param name="request">raw input</param>
        /// <param name="format">if <code>true</code> then HTML is returned, otherwise plain-text vCard is returned</param>
        /// <returns>vCard</returns>
        private String Deliver(NameValueCollection request, bool format)
        {
            // Escape characters
            for (int x = 0; x < request.Count; x++)
            {
                request[x].Replace(":", "\\:");
                request[x].Replace(";", "\\;");
                request[x].Replace(",", "\\,");
            }
            
            // Begin vCard Delimiter
            String vCard = "BEGIN:VCARD\n";
            
            // vCard Version
            switch (this.vCard_Version)
            {
                case "3.0":
                    vCard += "VERSION:3.0\n";
                    break;
                case "2.1":
                default:
                    vCard += "VERSION:2.1\n";
                    break;
            }
            
            // vCard Profile (only 3.0)
            if (vCard_Version == "3.0")
            {
                vCard += "PROFILE:VCARD\n";
            }
            
            // Name and Source (only 3.0)
            if (vCard_Version == "3.0" && request["Name"].Trim() != "" && request["Source"].Trim() != "")
            {
                vCard += "NAME:" + request["Name"] + "\nSOURCE:" + request["Source"] + "\n";
            }
            
            // Formatted Name
            vCard += "FN:" + request["Formatted.Name"].Trim() + "\n";
            
            // Name
            vCard += "N:" + request["Name.Surname"].Trim() + ";" + request["Name.Forename"].Trim() + ";" + request["Name.AdditionalNames"].Trim() + ";" + request["Name.Prefix"].Trim() + ";" + request["Name.Suffix"].Trim() + "\n";
            
            // Sort (only 3.0)
            if (vCard_Version == "3.0" && request["Sort"] != "")
            {
                vCard += "SORT-STRING:" + request["Sort"] + "\n";
            }
            
            // Nickname (only 3.0)
            if (vCard_Version == "3.0" && request["Nickname"] != "")
            {
                vCard += "NICKNAME:" + request["Nickname"] + "\n";
            }
            
            // Photo
            if (request["Photo.Type"] != "" && request["Photo.Type"] != "None")
            {
                vCard += "PHOTO;";
                switch (request["Photo.Type"])
                {
                    case "BASE64":
                        vCard += "ENCODING=";
                        if (vCard_Version == "2.1")
                        {
                            vCard += "BASE64:";
                        }
                        else
                        {
                            vCard += "b:";
                        }
                        vCard += ";TYPE=" + request["Photo.Format"] + ":" + request["Photo.Source.Quoted"].Trim() + "\n";
                        break;
                    case "QUOTED-PRINTABLE":
                        vCard += "ENCODING:QUOTED-PRINTABLE;TYPE=" + request["Photo.Format"] + ":" + request["Photo.Source.Quoted"].Trim() + "\n";
                        break;
                    case "URL":
                    default:
                        vCard += "VALUE=";
                        if (vCard_Version == "2.1")
                        {
                            vCard += "URL:";
                        }
                        else
                        {
                            vCard += "uri:";
                        }
                        vCard += request["Photo.Source.URL"].Trim() + "\n";
                        break;
                }
            }
            
            // Birthdate and birthtime
            if (request["Birthdate"] != "")
            {
                vCard += "BDAY:" + request["Birthdate"].Trim();
                if (vCard_Version == "3.0" && request["Birthtime"] != "")
                {
                    vCard += "T" + request["Birthtime"].Trim();
                    if (request["Birthtimezone"] != "")
                    {
                        vCard += request["Birthtimezone"].Trim() + "\n";
                    }
                    else
                    {
                        vCard += "Z\n";
                    }
                }
                else
                {
                    vCard += "\n";
                }
            }
            
            // Delivery Address
            if (request["DeliveryAddress.Type"] != null && request["DeliveryAddress.Type"] != "")
            {
                vCard += "ADR";
                String[] addressTypes = request["DeliveryAddress.Type"].Split(',');
                foreach (String type in addressTypes)
                {
                    if (vCard_Version == "2.1")
                    {
                        vCard += ";" + type;
                    }
                    else
                    {
                        vCard += ";TYPE=" + type;
                    }
                }
                vCard += ":" + request["DeliveryAddress.PostOfficeAddress"].Trim() + ";" + request["DeliveryAddress.ExtendedAddress"].Trim() + ";" + request["DeliveryAddress.Street"].Trim() + ";" + request["DeliveryAddress.Locality"].Trim() + ";" + request["DeliveryAddress.Region"].Trim() + ";" + request["DeliveryAddress.PostalCode"].Trim() + ";" + request["DeliveryAddress.Country"] + "\n";
            }
            
            // Delivery Label
            String separator;
            if (vCard_Version == "2.1")
            {
                separator = "=0D=0A=";
            }
            else
            {
                separator = "\n"; // **TODO**
            }
            if (request["DeliveryLabel.Type"] != null && request["DeliveryLabel.Type"] != "")
            {
                vCard += "LABEL";
                String[] labelTypes = request["DeliveryLabel.Type"].Split(',');
                foreach (String type in labelTypes)
                {
                    if (vCard_Version == "2.1")
                    {
                        vCard += ";" + type;
                    }
                    else
                    {
                        vCard += ";TYPE=" + type;
                    }
                }
                if (vCard_Version == "2.1")
                {
                    vCard += ";ENCODING=QUOTED-PRINTABLE";
                }
                vCard += ":" + request["DeliveryLabel.PostOfficeAddress"].Trim() + separator + request["DeliveryLabel.ExtendedAddress"].Trim() + separator + request["DeliveryLabel.Street"].Trim() + separator + request["DeliveryLabel.Locality"].Trim() + separator + request["DeliveryLabel.Region"].Trim() + separator + request["DeliveryLabel.PostalCode"].Trim() + separator + request["DeliveryLabel.Country"] + "\n";
            }
            
            // Telephone Number (1)
            if (request["TelephoneNumber.Type"] != "")
            {
                vCard += "TEL;";
                if (vCard_Version == "2.1")
                {
                    vCard += "PREF";
                }
                else
                {
                    vCard += "TYPE=PREF";
                }
                if (request["TelephoneNumber.Type.Msg"] == "MSG")
                {
                    if (vCard_Version == "2.1")
                    {
                        vCard += ";MSG";
                    }
                    else
                    {
                        vCard += ";TYPE=MSG";
                    }
                }
                vCard += ";";
                if (vCard_Version == "3.0")
                {
                    vCard += "TYPE=";
                }
                vCard += request["TelephoneNumber.Type"] + ":" + request["TelephoneNumber.Number"].Trim() + "\n";
            }
            
            // Telephone Number (2)
            if (request["TelephoneNumber.Type.2"] != "")
            {
                vCard += "TEL";
                if (request["TelephoneNumber.Type.Msg.2"] == "MSG")
                {
                    if (vCard_Version == "2.1")
                    {
                        vCard += ";MSG";
                    }
                    else
                    {
                        vCard += ";TYPE=MSG";
                    }
                }
                vCard += ";";
                if (vCard_Version == "3.0")
                {
                    vCard += "TYPE=";
                }
                vCard += request["TelephoneNumber.Type.2"] + ":" + request["TelephoneNumber.Number.2"].Trim() + "\n";
            }
            
            // Email Address (1)
            if (request["EmailAddress.Type"] != "")
            {
                this.vCard_Email = request["EmailAddress.Address"].Trim();
                vCard += "EMAIL;";
                if (vCard_Version == "3.0")
                {
                    vCard += "TYPE=";
                }
                vCard += request["EmailAddress.Type"];
                if (vCard_Version == "3.0")
                {
                    vCard += ";TYPE=PREF:";
                }
                else
                {
                    vCard += ":";
                }
                vCard += request["EmailAddress.Address"].Trim() + "\n";
            }
            
            // Email Address (2)
            if (request["EmailAddress.Type.2"] != "")
            {
                vCard += "EMAIL;";
                if (vCard_Version == "3.0")
                {
                    vCard += "TYPE=";
                }
                vCard += request["EmailAddress.Type.2"] + ":" + request["EmailAddress.Address.2"].Trim() + "\n";
            }
            
            // Mailer
            if (request["Mailer.Name"].Trim() != "")
            {
                vCard += "MAILER:" + request["Mailer.Name"].Trim() + "\n";
            }
            
            // Timezone
            if (request["GeographicalProperties.Timezone"] != "")
            {
                vCard += "TZ:" + request["GeographicalProperties.Timezone"] + "\n";
            }
            
            // Geographic Position
            if (request["GeographicalProperties.Position.Latitude.Whole"].Trim() != "")
            {
                vCard += "GEO:" + request["GeographicalProperties.Position.Latitude.Sign"] + request["GeographicalProperties.Position.Latitude.Whole"].Trim() + "." + request["GeographicalProperties.Position.Latitude.Fraction"].Trim() + "," + request["GeographicalProperties.Position.Longitude.Sign"] + request["GeographicalProperties.Position.Longitude.Whole"].Trim() + "." + request["GeographicalProperties.Position.Longitude.Fraction"].Trim() + "\n";
            }
            
            // Title
            if (request["OrganisationalProperties.JobTitle"].Trim() != "")
            {
                vCard += "TITLE:" + request["OrganisationalProperties.JobTitle"].Trim() + "\n";
            }
            
            // Role
            if (request["OrganisationalProperties.Role"].Trim() != "")
            {
                vCard += "ROLE:" + request["OrganisationalProperties.Role"].Trim() + "\n";
            }
            
            // Logo
            if (request["Logo.Type"] != "" && request["Logo.Type"] != "None")
            {
                vCard += "LOGO;";
                switch (request["Logo.Type"])
                {
                    case "BASE64":
                        vCard += "ENCODING=";
                        if (vCard_Version == "2.1")
                        {
                            vCard += "BASE64";
                        }
                        else
                        {
                            vCard += "b";
                        }
                        vCard += ";TYPE=" + request["Logo.Format"] + ":" + request["Logo.Source.Quoted"].Trim() + "\n";
                        break;
                    case "QUOTED-PRINTABLE":
                        vCard += "ENCODING:QUOTED-PRINTABLE;TYPE=" + request["Logo.Format"] + ":" + request["Logo.Source.Quoted"].Trim() + "\n";
                        break;
                    case "URL":
                    default:
                        vCard += "VALUE=";
                        if (vCard_Version == "2.1")
                        {
                            vCard += "URL:";
                        }
                        else
                        {
                            vCard += "uri:";
                        }
                        vCard += request["Logo.Source.URL"].Trim() + "\n";
                        break;
                }
            }
            
            // Agent
            if (request["Agent.Type"] != "" && request["Agent.Type"] != "None")
            {
                vCard += "AGENT";
                switch (request["Agent.Type"])
                {
                    case "URL":
                        if (vCard_Version == "3.0")
                        {
                            vCard += ";VALUE=uri:" + request["Agent.URL"].Trim() + "\n";
                        }
                        break;
                    case "vCard":
                    default:
                        vCard += ":\n" + request["Agent"].Trim() + "\n";
                        break;
                }
            }
            
            // Organisation Name and Organisational Unit
            if (request["OrganisationalProperties.OrganisationName"].Trim() != "")
            {
                vCard += "ORG:" + request["OrganisationalProperties.OrganisationName"].Trim();
                if (request["OrganisationalProperties.OrganisationalUnit"].Trim() != "")
                {
                    vCard += ";" + request["OrganisationalProperties.OrganisationalUnit"].Trim() + "\n";
                }
                else
                {
                    vCard += "\n";
                }
            }
            
            // Categories (only 3.0)
            if (vCard_Version == "3.0" && request["Categories"] != "")
            {
                vCard += "CATEGORIES:" + request["Categories"].Trim() + "\n";
            }
            
            // Comment
            if (request["Comment.Quoted"].Trim() != "")
            {
                vCard += "NOTE";
                if (vCard_Version == "2.1")
                {
                    vCard += ";ENCODING=QUOTED-PRINTABLE";
                }
                vCard += ":" + request["Comment.Quoted"].Trim() + "\n";
            }
            
            // Sound
            if (request["Sound.Type"] != "" && request["Sound.Type"] != "None")
            {
                vCard += "SOUND";
                switch (request["Sound.Type"].Trim())
                {
                    case "BASE64":
                        vCard += ";";
                        if (vCard_Version == "3.0")
                        {
                            vCard += "TYPE=";
                        }
                        vCard += request["Sound.Format"];
                        if (vCard_Version == "2.1")
                        {
                            vCard += ";BASE64:";
                        }
                        else
                        {
                            vCard += ";ENCODING=b:";
                        }
                        vCard += request["Sound.Source.Quoted"].Trim() + "\n";
                        break;
                    case "Phonetic":
                        vCard += ":" + request["Sound.Source.Phonetic"].Trim() + "\n";
                        break;
                    case "URL":
                    default:
                        vCard += ";VALUE=";
                        if (vCard_Version == "2.1")
                        {
                            vCard += "URL:";
                        }
                        else
                        {
                            vCard += "uri:";
                        }
                        vCard += request["Sound.Source.URL"].Trim() + "\n";
                        break;
                }
            }
            
            // URL
            if (request["URL"].Trim() != "")
            {
                vCard += "URL:" + request["URL"].Trim() + "\n";
            }
            
            // Class (only 3.0)
            if (vCard_Version == "3.0" && request["Class"] != "")
            {
                vCard += "CLASS:" + request["Class"].Trim() + "\n";
            }
            
            // Key
            if (request["Key.Type"] != "" && request["Key.Type"] != "None")
            {
                vCard += "KEY;";
                switch (request["Key.Type"])
                {
                    case "B":
                        vCard += "ENCODING=b:" + request["Key.Quoted"].Trim() + "\n";
                        break;
                    case "X509":
                        vCard += "X509:" + request["Key.Quoted"].Trim() + "\n";
                        break;
                    case "PGP":
                    default:
                        vCard += "PGP:" + request["Key.Quoted"].Trim() + "\n";
                        break;
                }
            }
            
            // Unique Identifier
            vCard += "UID:" + BitConverter.ToString(new MD5CryptoServiceProvider().ComputeHash(new ASCIIEncoding().GetBytes(new Random().Next().ToString()))).ToLower().Replace("-", "") + "\n";
            
            // Last Revision Date
            DateTime date = DateTime.Now;
            vCard += "REV:" + date.Year + "-" + date.Month + "-" + date.Day + "T" + date.Hour + "\\:" + date.Minute + "\\:" + date.Second + "Z\n";
            
            // Generator fields
            vCard += "X-GENERATOR:" + vCardMaker.Version(true) + "\n";
            if (vCard_Version == "3.0")
            {
                vCard += "PRODID:-//RUBENARAKELYAN//NONSGML VCARDMAKER " + vCardMaker.Version(false) + "//EN\n";
            }
            
            // End vCard Delimiter
            vCard += "END:VCARD";
            
            // Send the vCard
            this.vCard = vCard;
            if (format)
            {
                return "<pre id=\"result\">" + vCard + "</pre>";
            }
            else
            {
                return vCard;
            }
        }

        private NameValueCollection vCardMaker_Lang = vCardMaker_Lang_EN.GetStrings();
        private String vCard;
        private String vCard_Version;
        private String vCard_Email;
        private bool vCard_Ready = false;
        private String vCardMaker_Errors;

        // Constants - ** CHANGE THESE **
        private const String EMAIL_FROM = "vcardmaker@example.com";
    }

    public class vCardMaker_Lang_EN
    {
        public static NameValueCollection GetStrings()
        {
            NameValueCollection vCardMaker_Lang = new NameValueCollection();

            // Validator strings
            vCardMaker_Lang.Add("NoVersion", "The vCard version is blank.");
            vCardMaker_Lang.Add("NoFormattedName", "The full name is blank.");
            vCardMaker_Lang.Add("NoForename", "The forename is blank.");
            vCardMaker_Lang.Add("NoSurname", "The surname is blank.");
            vCardMaker_Lang.Add("NoNameSource", "If name or source are used, then both must be provided.");
            vCardMaker_Lang.Add("NoBirthdate", "The birth date is not in the correct format.");
            vCardMaker_Lang.Add("NoBirthdatetime", "If the birth time is provided then the birth date must be provided.");
            vCardMaker_Lang.Add("NoBirthtime", "The birth time is not in the correct format.");
            vCardMaker_Lang.Add("NoBirthtimezone", "If the birth timezone is provided then the birth time must be provided.");
            vCardMaker_Lang.Add("NoSoundPhonetic", "The phonetic type for a sound cannot be used in a 3.0 vCard.");
            vCardMaker_Lang.Add("NoSoundPhoneticR", "The phonetic representation for your sound is blank.");
            vCardMaker_Lang.Add("NoSoundURL", "The URL for your sound is blank.");
            vCardMaker_Lang.Add("NoSoundSource", "The sound source is blank.");
            vCardMaker_Lang.Add("NoPhotoURL", "The photo URL is blank.");
            vCardMaker_Lang.Add("NoPhotoSource", "The photo source is blank.");
            vCardMaker_Lang.Add("NoPhotoQP", "The Quoted-Printable type for a photo cannot be used in a 3.0 vCard.");
            vCardMaker_Lang.Add("NoDeliveryStreet", "The street name for your address is blank.");
            vCardMaker_Lang.Add("NoDeliveryLocality", "The locality for your address is blank.");
            vCardMaker_Lang.Add("NoDeliveryPostCode", "The postal code for your address is blank.");
            vCardMaker_Lang.Add("NoDeliveryCountry", "The country for your address is blank.");
            vCardMaker_Lang.Add("NoLabelStreet", "The street name for your delivery label is blank.");
            vCardMaker_Lang.Add("NoLabelLocality", "The locality for your delivery label is blank.");
            vCardMaker_Lang.Add("NoLabelPostCode", "The postal code for your delivery label is blank.");
            vCardMaker_Lang.Add("NoLabelCountry", "The country for your delivery label is blank.");
            vCardMaker_Lang.Add("NoTelNumber", "The telephone number is blank.");
            vCardMaker_Lang.Add("NoEmailAddress", "The email address is blank.");
            vCardMaker_Lang.Add("NoGeoLoc", "The geographical location is incorrect.");
            vCardMaker_Lang.Add("NoLogoURL", "The URL for your logo is blank.");
            vCardMaker_Lang.Add("NoLogoSource", "The logo source is blank.");
            vCardMaker_Lang.Add("NoLogoQP", "The Quoted-Printable type for a logo cannot be used in a 3.0 vCard.");
            vCardMaker_Lang.Add("NoAgentvCard", "The vCard for your agent is blank.");
            vCardMaker_Lang.Add("NoAgentURL", "The URL for your agent is blank.");
            vCardMaker_Lang.Add("NoAgentURLType", "The URL agent type cannot be used in a 2.1 vCard.");
            vCardMaker_Lang.Add("NoKeyBinary", "The binary key type cannot be used in a 2.1 vCard.");
            vCardMaker_Lang.Add("NoKeyPGPX509", "The PGP and X.509 key types cannot be used in a 3.0 vCard.");
            vCardMaker_Lang.Add("NoKeySource", "The key is blank.");
            vCardMaker_Lang.Add("VErrorsFound", "The following errors were found:");

            // Email strings
            vCardMaker_Lang.Add("ESubject", "Your vCard from vCardMaker");
            vCardMaker_Lang.Add("EMessage", "Hello!\n\nYou recently created a vCard using vCardMaker and asked us to email it to you. Your vCard is included below between the dashes. If you didn't request this message, please reply to this email and we'll do our best to make sure it doesn't happen again.\n\nThank you for using vCardMaker!");

            return vCardMaker_Lang;
        }
    }
}
