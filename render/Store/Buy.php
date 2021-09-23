<div class="container-fluid mt-5  ">

    <div class="animated fadeIn">

        <div class="row text-center">

            <div class="row justify-content-center w-100">

                <div class="col-md-8 mt-3 mb-3 text-left">

                    <i class="fa fa-arrow-left"></i> <a href="<?php echo gpConfig['URLPATH']; ?>"><strong>back to store</strong></a>
                    
                </div>

            </div>

            <div class="row justify-content-center w-100">

                <div class="col-8">

                    <div class="card">

                        <div class="card-body">

                            <h1><strong><?php echo $this->GetDevice['data'][0]['DeviceName']; ?></strong></h1>
                           
                        </div>

                    </div>

                </div>

            </div>

            <div class="row justify-content-center w-100">

                <div class="col-8">

                    <div class="card">

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-5">       

                                    <img class="img-fluid w-75 border-dark" src="<?php echo gpConfig['BURLPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS']; ?>Devices/<?php echo $this->GetDevice['data'][0]['DeviceID']; ?>/<?php echo $this->GetDevice['data'][0]['DeviceCoverName']; ?>" />


                                    <div class="">

                                        <div class="deviceCost row pricing">
                                            <div class="costLabel text-right col-6 font-weight-bold">** Device Cost</div>
                                            <div class="deviceCostValue text-left"><?php echo $this->GetDevice['data'][0]['DeviceCost']; ?>
                                                <input type="hidden" value="<?php echo $this->GetDevice['data'][0]['DeviceCost']; ?>" class="deviceCostAmount" />
                                                <input type="hidden" value="<?php echo $this->GetDevice['data'][0]['DeviceID']; ?>" class="deviceID" />
                                            </div>
                                        </div>

                                        <div class="planCost row pricing">
                                            <div class="costLabel text-right col-6 font-weight-bold">Plan Cost</div>
                                            <div class="planCostValue text-left"><?php echo $this->GetRequiredPlan['data'][0]['PlanCost']; ?></div>
                                        </div>

                                        <div class="accessoryCost row pricing">
                                            <div class="accessoryCostLabel text-right col-6 font-weight-bold"></div>
                                            <div class="accessoryCostValue text-left"></div>
                                        </div>

                                        <div class="vatCost row pricing">
                                            <div class="costLabel text-right col-6 font-weight-bold">VAT</div>
                                            <div class="totalVATValue text-left"><?php echo number_format( $this->GetDevice['data'][0]['DeviceCost'] * .12, 2 ); ?></div>
                                        </div>

                                        <div class="totalCost row pricing">
                                            <div class="costLabel text-right col-6 font-weight-bold">Total</div>
                                            <div class="totalCostValue text-left"><?php echo number_format( floatval( ( $this->GetDevice['data'][0]['DeviceCost'] * 1.12 ) + $this->GetRequiredPlan['data'][0]['PlanCost'] ), 2 ); ?></div>
                                        </div>
                                  
                                    </div>

                                    <div class="small">
                                        * One device per order. 
                                    </div>
                                    <div class="small">
                                        ** Pricing does not include VAT
                                    </div>
                                </div>

                                <div class="col-md-7 selectplan">
                                    
                                    <div class="col-md-11">
                                        
                                        <div class="text-left mt-5">
                                            <strong>description</strong>
                                        </div>
                                        
                                        <div class="description text-dark text-left mt-3">                                        
                                            <?php echo $this->GetDevice['data'][0]['DeviceDescription']; ?>        
                                        </div>


                                        <?php if ( !empty( $this->GetDevice['data'][0]['DeviceAttributes'] ) ) : ?>

                                            <div class="row mt-4 text-left">

                                                <div class="col-sm-12">
                                                    <strong>key features</strong>
                                                </div>

                                                <div class="col-sm-12 mt-1">

                                                    <div class="row">

                                                        <?php foreach( explode( ',', $this->GetDevice['data'][0]['DeviceAttributes'] ) as $AttributeID ) : 
                                                            
                                                                $GetAttribute       =           $this->LogicStore->GetAttribute( $AttributeID );
                                                            ?>

                                                            <?php if ( $GetAttribute['count'] > 0) : ?>

                                                                <div class="col-sm-6">
                                                                    <div class="mt-3 text-primary">
                                                                        <?php echo $GetAttribute['data'][0]['AttributeName']; ?>
                                                                    </div>

                                                                    <div class="mt-1">
                                                                        <?php echo strtolower( $GetAttribute['data'][0]['AttributeDescription'] ); ?>
                                                                    </div>
                                                                </div>

                                                            <?php endif; ?>

                                                        <?php endforeach; ?>

                                                    </div>

                                                </div>

                                            </div>

                                            <?php endif; ?>



                                        <div class="text-left mt-5">
                                            <strong>select a plan ***</strong>
                                        </div>

                                        <div class="description text-dark text-left font-lg mt-2">                                        
                                            
                                            <select class="form-control form-control-lg custom-select" id="selectplan">

                                                <?php 
                                                
                                                    foreach( $this->GetEligiblePlans['data'] as $PlanSet ) : if ( $PlanSet['PlanPriority'] >= $this->GetRequiredPlan['data'][0]['PlanPriority'] ) :

                                                        
                                                        echo '<option value="'. $PlanSet['PlanID'] .'" ';


                                                        echo '>'. $PlanSet['PlanName'] .' - $'. number_format( $PlanSet['PlanCost'], 2 ) .'</option>';

                                                    endif; endforeach; 

                                                ?>

                                            </select>

                                        </div>

                                        <?php if ( !empty( $this->GetDevice['data'][0]['DevicePlanRequired'] ) ) : ?>

                                            <div class="text-left mt-3">
                                                <strong>***</strong> - Minimun plan purchase required for this device.
                                            </div>

                                        <?php endif; ?>


                                        <div class="text-right mt-5">
                                            <!-- <button class="btn-lg btn-danger font-sm" data-target="#CancelOrder" data-toggle="modal"><i class="fa fa-trash"></i> cancel</button> -->
                                            <button class="btn-lg btn-success font-sm toaccessories">next <i class="fa fa-arrow-right"></i> </button>
                                        </div>

                                    </div>

                                </div>


                                <div class="col-md-7 selectaccessories" style="display: none">
                                    
                                    <div class="col-md-11">
                                        
                                        <div class="row mt-5">
                                        
                                            <div class="col-12 text-right">  
                                                <a class="todetails">
                                                    <strong>skip accessories <i class="fa fa-forward"></i></strong>
                                                </a>
                                            </div>
                                        </div>    

                                        <div class="text-left mt-5">
                                            <strong>device accessories</strong>
                                        </div>

                                        <div class="alert alert-warning border-warning description text-left mt-3">                                        
                                            select from the available device accessories below. 
                                        </div>

                                        <?php if ( $this->GetAccessories['count'] > 0 ) : ?>

                                            <div class="row">

                                                <?php foreach( $this->GetAccessories['data'] as $AccessorySet ) : ?>

                                                    <div class="col-sm-4">
                                                        
                                                        <div class="w-100 mt-2 border-dark p2">
                                                            <img class="img-fluid w-100 border-dark" src="<?php echo gpConfig['BURLPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS']; ?>Accessories/<?php echo $AccessorySet['AccessoryID']; ?>/<?php echo $AccessorySet['AccessoryCover']; ?>" />
                                                        </div>

                                                        <div class="w-100 mt-2 text-center">
                                                            <strong><?php echo $AccessorySet['AccessoryName']; ?></strong>
                                                        </div>

                                                        <div class="w-100 mt-2 text-center">
                                                            <?php echo $AccessorySet['AccessoryCost']; ?>
                                                        </div>

                                                        <div class="w-100 mt-2 text-center small">
                                                            <input type="radio" class="form-control accessory" name="addaccessory" value="<?php echo $AccessorySet['AccessoryID']; ?>" /> add to order <i class="fa fa-shopping-cart"></i>
                                                        </div>

                                                    </div>

                                                <?php endforeach; ?>

                                            </div>      

                                        <?php endif; ?>
                                        
                                        <div class="row mt-5">
                                            <div class="col-2 text-left">
                                                <button class="btn-lg btn-danger font-sm" data-target="#CancelOrder" data-toggle="modal"><i class="fa fa-trash"></i> cancel</button>
                                            </div>
                                            <div class="col-10 text-right">                                                
                                                <button class="btn-lg btn-info font-sm accessoryRemove" style="display: none;"><i class="fa fa-recycle"></i> remove accessory </button>
                                                <button class="btn-lg btn-warning font-sm toplans"><i class="fa fa-arrow-left"></i> back </button>
                                                <button class="btn-lg btn-success font-sm todetails">next <i class="fa fa-arrow-right"></i> </button>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-7 customerdetails" style="display: none">
                                    
                                    <div class="col-md-11">
                                        
                                        
                                        <div class="text-left mt-5">
                                            <strong>add customer details</strong>
                                        </div>

                                        <div class="alert alert-warning border-warning description text-left mt-3">                                        
                                            please enter customer details in the spaces provided below.
                                        </div>


                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control customerFirst" autocomplete="off" placeholder="First Name" name="FirstName"  tabindex="1"/>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control customerLast" autocomplete="off" placeholder="Last Name" name="LastName" tabindex="2" />
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control customerAddressOne" autocomplete="off" placeholder="Address Line 1" name="AddressOne" tabindex="3"/>
                                            </div>                                       
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control customerAddressTwo" autocomplete="off" placeholder="Address Line 2" name="AddressTwo" tabindex="4" />
                                            </div>                                       
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control customerCity" autocomplete="off" placeholder="City / Settlement" name="CitySettlement" tabindex="5" />
                                            </div>
                                            <div class="col-sm-6">
                                                <select name="Island" class="form-control custom-select customerIsland" tabindex="6">
                                                    <option value="ABAC">Abaco</option>
                                                    <option value="ACKL">Acklins</option>
                                                    <option value="ANDR">Andros</option>
                                                    <option value="BERR">Berry Islands</option>
                                                    <option value="BIMI">Bimini</option>
                                                    <option value="CAT">Cat Island</option>
                                                    <option value="CROO">Crooked Island</option>
                                                    <option value="ELEU">Eleuthera</option>
                                                    <option value="EXUM">Exuma</option>
                                                    <option value="GRAN">Grand Bahama</option>
                                                    <option value="INAG">Inagua</option>
                                                    <option value="LONG">Long Island</option>
                                                    <option value="MAYA">Mayaguana</option>
                                                    <option value="NEW">New Providence</option>
                                                    <option value="RAGG">Ragged Island</option>
                                                    <option value="RUM">Rum Cay</option>
                                                    <option value="SAN">San Salvador</option>
                                                    <option value="NA">Not Applicable</option>
                                                </select>
                                            </div>                                                                                       
                                        </div>
                                        <div class="row mt-3">
                                            
                                            <div class="col-sm-6">
                                                <select name="Country" class="form-control custom-select customerCountry" tabindex="7">
                                                    <option value="BAH">Bahamas</option>
                                                    <option value="AFG">Afghanistan</option>
                                                    <option value="ALB">Albania</option>
                                                    <option value="ALG">Algeria</option>
                                                    <option value="AME">American_Samoa</option>
                                                    <option value="AND">Andorra</option>
                                                    <option value="ANG">Angola</option>
                                                    <option value="ANG">Anguilla</option>
                                                    <option value="ANT">Antarctica</option>
                                                    <option value="ANT">Antigua</option>
                                                    <option value="ARG">Argentina</option>
                                                    <option value="ARM">Armenia</option>
                                                    <option value="ARU">Aruba</option>
                                                    <option value="ASC">Ascension_Island</option>
                                                    <option value="AUS">Australia</option>
                                                    <option value="AUS">Austria</option>
                                                    <option value="AZE">Azerbaijan</option>
                                                    <option value="BAR">Bahrain</option>
                                                    <option value="BAN">Bangladesh</option>
                                                    <option value="BAR">Barbados</option>
                                                    <option value="BEL">Belarus</option>
                                                    <option value="BEL">Belgium</option>
                                                    <option value="BEL">Belize</option>
                                                    <option value="BEN">Benin</option>
                                                    <option value="BER">Bermuda</option>
                                                    <option value="BHU">Bhutan</option>
                                                    <option value="BOL">Bolivia</option>
                                                    <option value="BOS">Bosnia_Hercegovina</option>
                                                    <option value="BOT">Botswana</option>
                                                    <option value="BRA">Brazil</option>
                                                    <option value="BRI">British_Virgin_Islands</option>
                                                    <option value="BRU">Brunei</option>
                                                    <option value="BUL">Bulgaria</option>
                                                    <option value="BUR">Burkina_Faso</option>
                                                    <option value="BUR">Burundi</option>
                                                    <option value="CAM">Cambodia</option>
                                                    <option value="CAM">Cameroon</option>
                                                    <option value="CAN">Canada</option>
                                                    <option value="CAP">Cape_Verde_Islands</option>
                                                    <option value="CAY">Cayman_Islands</option>
                                                    <option value="CEN">Central_African_Republic</option>
                                                    <option value="CHA">Chad_Republic</option>
                                                    <option value="CHI">Chile</option>
                                                    <option value="CHI">China</option>
                                                    <option value="CHR">Christmas_Island</option>
                                                    <option value="CNM">CNMI</option>
                                                    <option value="COL">Colombia</option>
                                                    <option value="COM">Comoros</option>
                                                    <option value="CON">Congo</option>
                                                    <option value="COO">Cook_Islands</option>
                                                    <option value="COS">Costa_Rica</option>
                                                    <option value="CRO">Croatia</option>
                                                    <option value="CUB">Cuba</option>
                                                    <option value="CYP">Cyprus</option>
                                                    <option value="CZE">Czech_Republic</option>
                                                    <option value="DEN">Denmark</option>
                                                    <option value="DIE">Diego_Garcia</option>
                                                    <option value="DJI">Djibouti</option>
                                                    <option value="DOM">Dominica</option>
                                                    <option value="DOM">Dominican_Republic</option>
                                                    <option value="ECU">Ecuador</option>
                                                    <option value="EGY">Egypt</option>
                                                    <option value="EL_">El_Salvador</option>
                                                    <option value="EQU">Equatorial_Guinea</option>
                                                    <option value="ERI">Eritrea</option>
                                                    <option value="EST">Estonia</option>
                                                    <option value="ETH">Ethiopia</option>
                                                    <option value="FAE">Faeroe_Islands</option>
                                                    <option value="FAL">Falkland_Islands</option>
                                                    <option value="FIJ">Fiji_Islands</option>
                                                    <option value="FIN">Finland</option>
                                                    <option value="FRA">France</option>
                                                    <option value="FRE">French_Antilles</option>
                                                    <option value="FRE">French_Guiana</option>
                                                    <option value="FRE">French_Polynesia</option>
                                                    <option value="GAB">Gabon</option>
                                                    <option value="GAM">Gambia</option>
                                                    <option value="GEO">Georgia</option>
                                                    <option value="GER">Germany</option>
                                                    <option value="GHA">Ghana</option>
                                                    <option value="GIB">Gibraltar</option>
                                                    <option value="GRE">Greece</option>
                                                    <option value="GRE">Greenland</option>
                                                    <option value="GRE">Grenada</option>
                                                    <option value="GUA">Guadeloupe</option>
                                                    <option value="GUA">Guam</option>
                                                    <option value="GUA">Guantanamo_Bay</option>
                                                    <option value="GUA">Guatemala</option>
                                                    <option value="GUI">Guinea</option>
                                                    <option value="GUI">Guinea_Bissau</option>
                                                    <option value="GUY">Guyana</option>
                                                    <option value="HAI">Haiti</option>
                                                    <option value="HON">Honduras</option>
                                                    <option value="HON">Hong_Kong</option>
                                                    <option value="HUN">Hungary</option>
                                                    <option value="ICE">Iceland</option>
                                                    <option value="IND">India</option>
                                                    <option value="IND">Indonesia</option>
                                                    <option value="INM">Inmarsat___East_Atlantic_Ocean</option>
                                                    <option value="INM">Inmarsat___Indian_Ocean</option>
                                                    <option value="INM">Inmarsat___Pacific_Ocean</option>
                                                    <option value="INM">Inmarsat___West_Atlantic_Ocean</option>
                                                    <option value="IRA">Iran</option>
                                                    <option value="IRA">Iraq</option>
                                                    <option value="IRE">Ireland</option>
                                                    <option value="ISR">Israel</option>
                                                    <option value="ITA">Italy</option>
                                                    <option value="IVO">Ivory_Coast</option>
                                                    <option value="JAM">Jamaica</option>
                                                    <option value="JAP">Japan</option>
                                                    <option value="JOR">Jordan</option>
                                                    <option value="KAZ">Kazakhstan</option>
                                                    <option value="KEN">Kenya</option>
                                                    <option value="KIR">Kiribati</option>
                                                    <option value="KUW">Kuwait</option>
                                                    <option value="KYR">Kyrgyzstan</option>
                                                    <option value="LAO">Laos</option>
                                                    <option value="LAT">Latvia</option>
                                                    <option value="LEB">Lebanon</option>
                                                    <option value="LES">Lesotho</option>
                                                    <option value="LIB">Liberia</option>
                                                    <option value="LIB">Libya</option>
                                                    <option value="LIE">Liechtenstein</option>
                                                    <option value="LIT">Lithuania</option>
                                                    <option value="LUX">Luxembourg</option>
                                                    <option value="MAC">Macau</option>
                                                    <option value="MAE">Macedonia</option>
                                                    <option value="MAD">Madagascar</option>
                                                    <option value="MAL">Malawi</option>
                                                    <option value="MAY">Malaysia</option>
                                                    <option value="MAI">Maldives</option>
                                                    <option value="MAL">Mali_Republic</option>
                                                    <option value="MAL">Malta</option>
                                                    <option value="MAR">Marshall_Islands</option>
                                                    <option value="MAU">Mauritania</option>
                                                    <option value="MAT">Mauritius</option>
                                                    <option value="MAY">Mayotte_Island</option>
                                                    <option value="MEX">Mexico</option>
                                                    <option value="MIC">Micronesia</option>
                                                    <option value="MOL">Moldova</option>
                                                    <option value="MON">Monaco</option>
                                                    <option value="MOG">Mongolia</option>
                                                    <option value="MOS">MontSerrat</option>
                                                    <option value="MOR">Morocco</option>
                                                    <option value="MOZ">Mozambique</option>
                                                    <option value="MYA">Myanmar</option>
                                                    <option value="NAM">Namibia</option>
                                                    <option value="NAU">Nauru</option>
                                                    <option value="NEP">Nepal</option>
                                                    <option value="NET">Netherlands</option>
                                                    <option value="NEA">Netherlands_Antilles</option>
                                                    <option value="NEV">Nevis</option>
                                                    <option value="NEC">New_Caledonia</option>
                                                    <option value="NEW">New_Zealand</option>
                                                    <option value="NIC">Nicaragua</option>
                                                    <option value="NIR">Niger_Republic</option>
                                                    <option value="NIG">Nigeria</option>
                                                    <option value="NIU">Niue</option>
                                                    <option value="NOR">Norfolk_Island</option>
                                                    <option value="NOR">North_Korea</option>
                                                    <option value="NOR">Norway</option>
                                                    <option value="OMA">Oman</option>
                                                    <option value="PAK">Pakistan</option>
                                                    <option value="PAL">Palau</option>
                                                    <option value="PAE">Palestine</option>
                                                    <option value="PAN">Panama</option>
                                                    <option value="PAP">Papua_New_Guinea</option>
                                                    <option value="PAR">Paraguay</option>
                                                    <option value="PER">Peru</option>
                                                    <option value="PHI">Philippines</option>
                                                    <option value="POL">Poland</option>
                                                    <option value="POR">Portugal</option>
                                                    <option value="PUE">Puerto_Rico</option>
                                                    <option value="QAT">Qatar</option>
                                                    <option value="REU">Reunion_Island</option>
                                                    <option value="ROM">Romania</option>
                                                    <option value="RUS">Russia</option>
                                                    <option value="RWA">Rwanda</option>
                                                    <option value="SAI">Saipan</option>
                                                    <option value="SAN">San_Marino</option>
                                                    <option value="SAO">Sao_Tome</option>
                                                    <option value="SAU">Saudi_Arabia</option>
                                                    <option value="SEN">Senegal_Republic</option>
                                                    <option value="SER">Serbia_Montenegro</option>
                                                    <option value="SEY">Seychelles_Islands</option>
                                                    <option value="SIE">Sierra_Leone</option>
                                                    <option value="SIN">Singapore</option>
                                                    <option value="SLO">Slovakia</option>
                                                    <option value="SLN">Slovenia</option>
                                                    <option value="SOL">Solomon_Islands</option>
                                                    <option value="SOM">Somalia</option>
                                                    <option value="SOU">South_Africa</option>
                                                    <option value="SOU">South_Korea</option>
                                                    <option value="SPA">Spain</option>
                                                    <option value="SRI">Sri_Lanka</option>
                                                    <option value="STK">St__Kitts_Nevis</option>
                                                    <option value="STL">St__Lucia</option>
                                                    <option value="STP">St__Pierre_Miquelon</option>
                                                    <option value="STV">St__Vincent_Grenadines</option>
                                                    <option value="STH">St_Helena</option>
                                                    <option value="SUD">Sudan</option>
                                                    <option value="SUR">Suriname</option>
                                                    <option value="SWA">Swaziland</option>
                                                    <option value="SWE">Sweden</option>
                                                    <option value="SWI">Switzerland</option>
                                                    <option value="SYR">Syria</option>
                                                    <option value="TAI">Taiwan</option>
                                                    <option value="TAJ">Tajikistan</option>
                                                    <option value="TAN">Tanzania</option>
                                                    <option value="THA">Thailand</option>
                                                    <option value="TOG">Togo</option>
                                                    <option value="TON">Tonga_Islands</option>
                                                    <option value="TOR">Tongolese_Republic</option>
                                                    <option value="TRI">Trinidad_Tobago</option>
                                                    <option value="TUN">Tunisia</option>
                                                    <option value="TUR">Turkey</option>
                                                    <option value="TUM">Turkmenistan</option>
                                                    <option value="TUR">Turks_Caicos_Islands</option>
                                                    <option value="TUV">Tuvalu</option>
                                                    <option value="UGA">Uganda</option>
                                                    <option value="UKR">Ukraine</option>
                                                    <option value="UNI">United_Arab_Emirates</option>
                                                    <option value="UK"> United_Kingdom</option>
                                                    <option value="URU">Uruguay</option>
                                                    <option value="USI">US_Virgin_Islands</option>
                                                    <option value="USA">USA</option>
                                                    <option value="UZB">Uzbekistan</option>
                                                    <option value="VAN">Vanuatu</option>
                                                    <option value="VAT">Vatican_City</option>
                                                    <option value="VEN">Venezuela</option>
                                                    <option value="VIE">Vietnam</option>
                                                    <option value="WAL">Wallis_Futuna_Islands</option>
                                                    <option value="WES">Western_Samoa</option>
                                                    <option value="YEM">Yemen</option>
                                                    <option value="ZAI">Zaire</option>
                                                    <option value="ZAM">Zambia</option>
                                                    <option value="ZIM">Zimbabwe</option>
                                                </select>
                                            </div>   
                                            
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control customerMobile phone" autocomplete="off" placeholder="Mobile Phone" name="MobilePhone" tabindex="8" />
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <input type="email" class="form-control customerEmail" autocomplete="off" placeholder="Email Address" name="EmailAddress" tabindex="9" />
                                            </div>                                       
                                        </div>

                                        <div class="row mt-3">
                                            <div class="error col-12">
                                            
                                            </div>
                                        </div>
                                        
                                        

                                        <div class="row mt-5">
                                            <div class="col-4 text-left">
                                                <button class="btn-lg btn-danger font-sm" data-target="#CancelOrder" data-toggle="modal"><i class="fa fa-trash"></i> cancel</button>
                                            </div>
                                            <div class="col-8 text-right">                                                
                                                <button class="btn-lg btn-warning font-sm toaccessories"><i class="fa fa-arrow-left"></i> back </button>
                                                <button class="btn-lg btn-success font-sm topayment">next <i class="fa fa-arrow-right"></i> </button>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-7 paymentdetails" style="display: none">
                                    
                                    <div class="col-md-11">
                                        
                                        
                                        <div class="text-left mt-5">
                                            <strong>add payment details</strong>
                                        </div>

                                        <div class="alert alert-warning border-warning description text-left mt-3">                                        
                                            please enter the payment details in the spaces provided below.
                                        </div>

                                        <div class="row mt-3">                                           
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control cardName" autocomplete="off" placeholder="Card Name" name="CardName" tabindex="1" />
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control cardNumber CardNumber" autocomplete="off" placeholder="Card Number" name="CardNumber" tabindex="2"/>
                                            </div>                                       
                                        </div>
                                       

                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control cardExpire CardExpire" autocomplete="off" placeholder="Expiration" name="Expire" tabindex="3" />
                                            </div>                                             
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control cardCVV CardCVV" autocomplete="off" placeholder="CVV" name="CVV" maxlength="3" tabindex="4" />
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="error col-12">
                                            
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-5">
                                            <div class="col-4 text-left">
                                                <button class="btn-lg btn-danger font-sm" data-target="#CancelOrder" data-toggle="modal"><i class="fa fa-trash"></i> cancel</button>
                                            </div>
                                            <div class="col-8 text-right">                                                
                                                <button class="btn-lg btn-warning font-sm tocustomer"><i class="fa fa-arrow-left"></i> back</button>
                                                <button class="btn-lg btn-success font-sm toreview">next <i class="fa fa-arrow-right"></i> </button>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-7 reviewdetails" style="display: none">
                                    
                                    <div class="col-md-11">
                                        
                                        <div class="text-left mt-5">
                                            <strong>review your order</strong>
                                        </div>

                                        <div class="alert alert-warning border-warning description text-left mt-3">                                        
                                            please review the details of your order below.
                                        </div>

                                        <div class="mt-5 reviewcomponents">

                                        </div>

                                        <div class="row mt-5">
                                            <div class="col-4 text-left">
                                                <button class="btn-lg btn-danger font-sm" data-target="#CancelOrder" data-toggle="modal"><i class="fa fa-trash"></i> cancel</button>
                                            </div>
                                            <div class="col-8 text-right">                                                
                                                <button class="btn-lg btn-warning font-sm topayment"><i class="fa fa-arrow-left"></i> back </button>
                                                <button class="btn-lg btn-success font-sm toprocess"><i class="fa fa-check"></i> purchase device</button>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-7 process" style="display: none">
                                    
                                    <div class="col-md-11">
                                        
                                        <div class="showprocessing"> 

                                            <div class="text-center mt-5 mb-5">
                                                <strong>we are processing your order</strong>
                                            </div>
                                        
                                            <div class="text-center mt-5 mb-5">
                                                <img class="mt-5 border-dark" src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/preloader.gif" />                
                                            </div>

                                            <div class="alert alert-warning border-warning description text-center mt-3">                                        
                                                please do not hit the back button and please do not refresh your browser
                                            </div>

                                            <div class="result">                                        
                                                
                                            </div>

                                            <div class="row mt-5">
                                                <!-- <div class="col-4 text-left">
                                                    <button class="btn-lg btn-danger font-sm"><i class="fa fa-trash"></i> cancel</button>
                                                </div>
                                                <div class="col-8 text-right">                                                
                                                    <button class="btn-lg btn-warning font-sm topayment"><i class="fa fa-arrow-left"></i> back to payment </button>
                                                    <button class="btn-lg btn-success font-sm toprocess">purchase device <i class="fa fa-checkout"></i> </button>
                                                </div> -->
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>       

</div>       