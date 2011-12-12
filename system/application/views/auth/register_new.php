<h1>Welcome to Hospital Entrepreneur</h1>
    
    <p>Welcome to Hospital Entrepreneur. To be able to play Hospital Entrepreneur you'll have to fill out this registration form</p>

    <form action="/index.php/auth/register" class="uniForm" id="register" method="POST">
<?php
echo "<br /><div class=\"ui-widget\">
					<div class=\"ui-state-error ui-corner-all\" style=\"padding: 0 .7em;\"> 
						<p><span class=\"ui-icon ui-icon-alert\" style=\"float: left; margin-right: .3em;\"></span> 
						<strong>Alert:</strong>{$o}</p>
					</div>
				</div><br />";
?> 
           
      <fieldset>
        <legend>Registration</legend>
        
        <div class="ctrlHolder">
          <label for="user_name"><em>*</em> Username:</label>
          <input name="user_name" id="user_name" value="" size="35" maxlength="50" type="text" class="textInput large"/>
          <p class="formHint"><span><em>*</em> You may not change your username after registration. Your Username must be more then 6 characters.</span></p>

        </div>
        
        <div class="ctrlHolder" id="error1">
          <label for="hospital_name"><em>*</em> Hospital Name</label>
          <input name="hospital_name" id="hospital_name" value="" size="35" maxlength="50" type="text" class="textInput large"/>
          <p class="formHint"><span><em>*</em> Your Hospital Name may not include: <ul><li>Racistic Terms</li><li>Known trademarks</li><li>Inappropriate terms related to, but not limited to: Pornography, Racism, Political hatered</li></ul></span></p>
        </div>

        <div class="ctrlHolder">
          <label for="email"><em>*</em> E-Mail Address:</label>
          <input name="email" id="email" value="" size="35" maxlength="50" type="text" class="textInput large"/>
          <p class="formHint"><span><em>*</em> Please provide a valid Email Address as you will have to validate your account. Also important in-game information will be sent to your Email.</span></p>
        </div>
        
        <div class="ctrlHolder">
          <label for="password"><em>*</em> Password</label>
          <input name="password" id="password" value="" size="35" maxlength="50" type="text" class="textInput large"/>
          <p class="formHint"><span><em>*</em> Your Password must be more then 8 characters, can not be your username or any top 100 known passwords. Such as 123456, 123qwe, etc.</span></p>
        </div>
        
        <div class="ctrlHolder">
          <label for="repeat_password"><em>*</em> Repeat Password</label>
          <input name="repeat_password" id="repeat_password" value="" size="35" maxlength="50" type="text" class="textInput large"/>
          <p class="formHint"><span><em>*</em> You must repeat your password exactly as written in the former field.</span></p>
        </div>

       
        <div class="ctrlHolder">
          <label for="country">Country</label>
          <select name="country" id="country" class="selectInput large">
            <option value="">Choose your country</option>
            <option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AS">American Samoa</option><option value="AD">Andorra</option><option value="AI">Anguilla</option><option value="AG">Antigua &amp; Barbuda</option><option value="AR">Argentina</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AP">Azores</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BO">Bolivia</option><option value="BL">Bonaire</option><option value="BA">Bosnia and Herzegovina</option><option value="BW">Botswana</option><option value="BR">Brazil</option><option value="VG">British Virgin Is.</option><option value="BN">Brunei</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="IC">Canary Islands</option><option value="CV">Cape Verde Islands</option><option value="KY">Cayman Islands</option><option value="CF">Central African Rep.</option><option value="TD">Chad</option><option value="CD">Channel Islands</option><option value="CL">Chile</option><option value="CN">China</option><option value="CO">Colombia</option><option value="CG">Congo</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="HR">Croatia</option><option value="CB">Curacao</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="EN">England</option><option value="GQ">Equitorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FO">Faeroe Islands</option><option value="FM">Fed.States of Micronesia</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HO">Holland</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Ireland</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="CI">Ivory Coast</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="KO">Kosrae</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Laos</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macau</option><option value="MK">Macedonia</option><option value="MG">Madagascar</option><option value="ME">Madeira</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="MX">Mexico</option><option value="MD">Moldova</option><option value="MC">Monaco</option><option value="MN">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="AN">Netherlands Antilles</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NF">Norfolk Island</option><option value="NB">N. Ireland</option><option value="MP">N. Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PL">Poland</option><option value="PO">Ponape</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="IE">Republic of Ireland</option><option value="YE">Republic of Yemen</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RT">Rota</option><option value="RU">Russia</option><option value="RW">Rwanda</option><option value="SS">Saba</option><option value="SP">Saipan</option><option value="SA">Saudi Arabia</option><option value="SF">Scotland</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="ZA">South Africa</option><option value="KR">South Korea</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="NT">St.Barthelemy</option><option value="SW">St.Christopher</option><option value="SX">St.Croix</option><option value="EU">St.Eustatius</option><option value="UV">St.John</option><option value="KN">St.Kitts &amp; Nevis</option><option value="LC">St.Lucia</option><option value="MB">St.Maarten</option><option value="TB">St.Martin</option><option value="VL">St.Thomas</option><option value="VC">St.Vincent &amp; Grenadines</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syria</option><option value="TA">Tahiti</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania</option><option value="TH">Thailand</option><option value="TI">Tinian</option><option value="TG">Togo</option><option value="TO">Tonga</option><option value="TL">Tortola</option><option value="TT">Trinidad &amp; Tobago</option><option value="TU">Truk</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TC">Turks &amp; Caicos Is.</option><option value="TV">Tuvalu</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="UI">Union Island</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom</option><option value="US" selected="selected">United States</option><option value="UY">Uruguay</option><option value="VI">US Virgin Islands</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VE">Venezuela</option><option value="VN">Vietnam</option><option value="VR">Virgin Gorda</option><option value="WK">Wake Island</option><option value="WL">Wales</option><option value="WF">Wallis &amp; Futuna Is.</option><option value="WS">Western Samoa</option><option value="YA">Yap</option><option value="ZR">Zaire</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option>

          </select>
          <p class="formHint"><span><em>*</em> The reason why we ask for your country is for statistical reasons. Please provide the correct country, we will NOT restrict any parts of our website to a specific country.</span></p>
        </div>
        
        <div class="ctrlHolder">
          <p class="label">
            <em>*</em> Choose your sex
          </p>
          <div class="multiField">
            <label for="gender_male" class="inlineLabel"><input name="gender" id="gender_male" value="1" type="radio" checked="checked"/> <span>Male</span></label>
            <label for="gender_female" class="inlineLabel"><input name="gender" id="gender_female" value="1" type="radio"/> <span>Female</span></label>

          </div>
        </div>
        
        <div class="ctrlHolder">
          <p class="label">
            <em>*</em> Terms of Conditions
          </p>

	<p style=" width: 98%; padding-left: 2%"><?php echo nl2br($this->lang->line('sentry_terms_of_service_message')); ?></p>

          <div class="multiField">
            <label for="tos_agree" class="inlineLabel"><input name="tos_agree" id="tos_agree" value="1" type="checkbox" checked="checked"/> <span>I have read and agree with the terms and conditions</span></label>
            <label for="newsletter" class="inlineLabel"><input name="bl_newsletter" id="bl_newsletter" value="1" type="checkbox" checked="checked"/> <span>I accept to receive Newsletters about competitions, events and in-game action</span></label>
          </div>

        </div>

      <div class="buttonHolder">
        <button type="submit" class="secondaryAction">Cancel and go back</button>
        <button type="submit" class="primaryAction">Submit</button>
      </div>


      </fieldset>

</form>
<br />
