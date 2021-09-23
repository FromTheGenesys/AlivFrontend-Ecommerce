
$( document ).ready( function() { 

    // if the plan is changed, then change the plan cost display and the total price
    $( '#selectplan' ).on( 'change', function() {

        $.post( '../../scripts/fetchplandetails.php',                
                { planid: $( '#selectplan' ).val()  },
                function( data ) {  

                    $( '.planCostValue' ).html( data );
                    
                    var deviceCostVal   =       Number( $( '.deviceCostAmount' ).val() );
                    var planCostVal     =       data;
                    var totalCost       =       Number( ( deviceCostVal * 1.12 ) + Number( planCostVal ) ).toFixed(2); 

                    $( '.totalCostValue' ).html( totalCost );

                    localStorage.setItem( 'planid', $( '#selectplan' ).val() );
                    localStorage.setItem( 'plancost', data );
                    localStorage.setItem( 'devicecost', $( '.deviceCostAmount' ).val() );
                    localStorage.setItem( 'deviceid', $( '.deviceID' ).val() );
                    localStorage.setItem( 'totalcost', totalCost );

                }
        
        );

        $.post( '../../scripts/fetchplanname.php',                
                { planid: $( '#selectplan' ).val()  },
                function( data ) {  

                    localStorage.setItem( 'planname', data );
                    
                }
        
        );

        $.post( '../../scripts/fetchplandesc.php',                
                { planid: $( '#selectplan' ).val()  },
                function( data ) {  

                    localStorage.setItem( 'plandesc', data );
                    
                }
        
        );

        // console.log( localStorage );

    });

    $( '.toaccessories' ).on( 'click', function() {

        localStorage.setItem( 'devicecost', $( '.deviceCostAmount' ).val() );
        localStorage.setItem( 'deviceid', $( '.deviceID' ).val() );

        $( '.selectplan' ).hide().fadeOut();
        $( '.paymentdetails' ).hide().fadeOut();
        $( '.customerdetails' ).hide().fadeOut();
        $( '.reviewdetails' ).hide().fadeOut();
        $( '.selectaccessories' ).show().fadeIn(1000);

        console.log( localStorage );

    });

    $( '.toplans' ).on( 'click', function() {

        $( '.selectaccessories' ).hide().fadeOut();
        $( '.paymentdetails' ).hide().fadeOut();
        $( '.customerdetails' ).hide().fadeOut();
        $( '.reviewdetails' ).hide().fadeOut();
        $( '.selectplan' ).show().fadeIn(1000);

    });

    $( '.todetails' ).on( 'click', function() {

        localStorage.setItem( 'devicecost', $( '.deviceCostAmount' ).val() );
        localStorage.setItem( 'deviceid', $( '.deviceID' ).val() );

        $( '.selectaccessories' ).hide().fadeOut();
        $( '.selectplan' ).hide().fadeOut();
        $( '.paymentdetails' ).hide().fadeOut();
        $( '.reviewdetails' ).hide().fadeOut();
        $( '.customerdetails' ).show().fadeIn(1000);

    });

    $( '.topayment' ).on( 'click', function() {

        // determine if the necessary fields are in place
        var FirstName           =           $( '.customerFirst' ).val();
        var LastName            =           $( '.customerLast' ).val();
        var AddressOne          =           $( '.customerAddressOne' ).val();
        var AddressTwo          =           $( '.customerAddressTwo' ).val();
        var City                =           $( '.customerCity' ).val();
        var Mobile              =           $( '.customerMobile' ).val();
        var Email               =           $( '.customerEmail' ).val();
        var emailReg            =           /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var setError            =           false;
        $( '.error' ).html('');

        if ( ( FirstName.length < 2 ) || 
             ( LastName.length < 2 ) ) {

            var setError    =   true;
            var setErrMsg   =   "Customer First Name and/or Last Name is invalid";
            $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
            return null;

        }

        if  ( AddressOne.length < 5 ) {

            var setError    =   true;
            var setErrMsg   =   "The  Address Line 1 does not contain a valid entry";
            $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
            return null;

        }

        if  ( City.length < 3 ) {

            var setError    =   true;
            var setErrMsg   =   "The City / Settlement field does not contain a valid entry";
            $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
            return null;

        }

        if  ( Mobile.length != 14 ) {

            var setError    =   true;
            var setErrMsg   =   "The Mobile Phone number provided is invalid";
            $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
            return null;

        }

        if  ( Email.length < 8 ) {

            var setError    =   true;
            var setErrMsg   =   "Please specificy a valid email address";
            $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
            return null;

        }

        if  ( !emailReg.test( Email ) ) {

            var setError    =   true;
            var setErrMsg   =   "Please specificy a valid email address";
            $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
            return null;

        }

        $( '.error' ).html('');

        localStorage.setItem('custFirst', FirstName );
        localStorage.setItem('custLast', LastName );
        localStorage.setItem('custAddrOne', AddressOne );
        localStorage.setItem('custAddrTwo', AddressTwo );
        localStorage.setItem('custCity', City );
        localStorage.setItem('custIsland', $( '.customerIsland' ).val() );
        localStorage.setItem('custCountry', $( '.customerCountry' ).val() );
        localStorage.setItem('custMobile', Mobile );
        localStorage.setItem('custEmail', Email );

        $( '.selectaccessories' ).hide().fadeOut();
        $( '.selectplan' ).hide().fadeOut();
        $( '.customerdetails' ).hide().fadeOut();
        $( '.paymentdetails' ).show().fadeIn(1000);

    });

    $( '.tocustomer' ).on( 'click', function() {

        $( '.selectaccessories' ).hide().fadeOut();
        $( '.selectplan' ).hide().fadeOut();        
        $( '.paymentdetails' ).hide().fadeOut();
        $( '.customerdetails' ).show().fadeIn(1000);

    });

    $( '.toreview' ).on( 'click', function() {

        $( '.error' ).html('');

        var CardName        =       $( '.cardName' ).val();
        var CardNumber      =       $( '.cardNumber' ).val().replace( /-/g, '');
        var CardExpire      =       $( '.cardExpire' ).val();
        var CardCVV         =       $( '.cardCVV' ).val();

        var d               =       new Date;        
        var year            =       d.getFullYear();
        var month           =       ( d.getMonth() + 1 );
        var shortyear       =       year.toString().substr( 2, 2 );
        var shortmonth      =       month.toString();

        var setError    =   false;

        if ( CardExpire.substring( 3, 5 ) < shortyear ) {

            var setError    =   true;
            var setErrMsg   =   "Credit Card provided has expired";
            $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
            return null;

        }

        if ( CardExpire.substring( 3, 5 ) == shortyear) {

            // make sure that the month if valid
            if ( Number( shortmonth ) < Number( CardExpire.substring( 0, 2 ) ) ) {

                var setError    =   true;
                var setErrMsg   =   "Credit Card provided has expired";
                $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
                return null;

            } 
            
        }

        if ( CardExpire.substring( 0, 2 ) > '12' ) {

            var setError    =   true;
            var setErrMsg   =   "Credit Card provided is invalid";
            $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
            return null;

        }

        if( CardName.length < 3 ) {

            var setError    =   true;
            var setErrMsg   =   "Please specify a valid card name";
            $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
            return null;

        }
        
        if( $.isNumeric( CardNumber ) == false ) {

            var setError    =   true;
            var setErrMsg   =   "Card Number must be a numeric value";
            $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
            return null;

        }

        if( CardNumber.length != 16 ) {

            var setError    =   true;
            var setErrMsg   =   "Card Number specified is invalid";
            $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
            return null;

        }

        if( CardExpire.length != 5 ) {

            var setError    =   true;
            var setErrMsg   =   "Card CVV specified is invalid";
            $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
            return null;

        }

        if( $.isNumeric( CardCVV ) == false ) {

            var setError    =   true;
            var setErrMsg   =   "Card CVV must be a numeric value";
            $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
            return null;

        }

        if( CardCVV.length != 3 ) {

            var setError    =   true;
            var setErrMsg   =   "Card CVV specified is invalid";
            $( '.error' ).html( '<div class="alert alert-danger border-danger">' + setErrMsg  + '</div>' );
            return null;

        }

        // card details to local storage
        localStorage.setItem('cardName', CardName );
        localStorage.setItem('cardNumber', CardNumber );
        localStorage.setItem('cardExp', CardExpire );
        localStorage.setItem('cardCVV', CardCVV );
                
        $( '.error' ).html('');
        $( '.selectaccessories' ).hide().fadeOut();
        $( '.selectplan' ).hide().fadeOut();        
        $( '.paymentdetails' ).hide().fadeOut();
        $( '.customerdetails' ).hide().fadeOut();
        $( '.reviewdetails' ).show().fadeIn(1000);

        $.post( '../../scripts/showreview.php',                
                { planid: localStorage.getItem('planid'),
                  planname: localStorage.getItem('planname'),
                  plancost: localStorage.getItem('plancost'),
                  plandesc: localStorage.getItem('plandesc'),

                  accid: localStorage.getItem('accessoryid'),
                  accname: localStorage.getItem('accessoryname'),
                  acccost: localStorage.getItem('accessorycost'),
                  accdesc: localStorage.getItem('accessorydesc'),

                  custFirst: localStorage.getItem('custFirst'),
                  custLast: localStorage.getItem('custLast'),
                  custAddrOne: localStorage.getItem('custAddrOne'),
                  custAddrTwo: localStorage.getItem('custAddrTwo'),
                  custCity: localStorage.getItem('custCity'),
                  custIsland: localStorage.getItem('custIsland'),
                  custCountry: localStorage.getItem('custCountry'),
                  custMobile: localStorage.getItem('custMobile'),
                  custEmail: localStorage.getItem('custEmail'),

                  cardName: localStorage.getItem('cardName'),
                  cardNumber: localStorage.getItem('cardNumber'),
                  cardCVV: localStorage.getItem('cardCVV'),
                  cardExp: localStorage.getItem('cardExp')
                  
                },
                function( data ) {  
                    
                    $( '.reviewcomponents').html( data );
                    
                }
        
        );

    });

    // if the accessory ID is clicked 

    $( '.accessory' ).on( 'click', function() {

        $( '.accessory' ).each( function( index, value ) {

            if ( value.checked ) {

                // add accessory line
                $( '.accessoryCostLabel ' ).html('** Accessory');

                $.post( '../../scripts/fetchaccessorycost.php',                
                        { accid: value.value },
                        function( data ) {  

                            localStorage.setItem( 'accessoryid', value.value );
                            localStorage.setItem( 'accessorycost', data );

                            $( '.accessoryCostValue ' ).html( data );

                            var totalVAT            =      Number( Number( Number( localStorage.getItem('devicecost') ) +  Number( localStorage.getItem('accessorycost') ) ) * .12 ).toFixed(2); 
                            var totalCost           =       Number( Number( localStorage.getItem('devicecost') ) + 
                                                                    Number( localStorage.getItem('accessorycost') ) +   
                                                                    ( Number( Number( localStorage.getItem('devicecost') ) +  Number( localStorage.getItem('accessorycost') ) ) * .12 ) + 
                                                                    Number( localStorage.getItem('plancost') ) ).toFixed(2);

                            $( '.totalVATValue' ).html( totalVAT );                
                            $( '.totalCostValue' ).html( totalCost );                

                            localStorage.setItem( 'totalvat', totalVAT );
                            localStorage.setItem( 'totalcost', totalCost );

                        }
                
                );

                $.post( '../../scripts/fetchaccessoryname.php',                
                        { accid: value.value },
                        function( data ) {  

                            localStorage.setItem( 'accessoryname', data );
                            
                        }
                
                );

                $.post( '../../scripts/fetchaccessorydesc.php',                
                        { accid: value.value },
                        function( data ) {  

                            localStorage.setItem( 'accessorydesc', data );
                            
                        }
                
                );

            }

        });
        
        $( '.accessoryRemove' ).show();

    }); 

    // if remove accessory is clicked, hide the button and clear accessory id
    $( '.accessoryRemove' ).on( 'click', function() {

        localStorage.removeItem( 'accessoryid' );
        localStorage.removeItem( 'accessoryname' );
        localStorage.removeItem( 'accessorycost' );
        localStorage.removeItem( 'accessorydesc' );

        var totalVAT            =      Number( Number( Number( localStorage.getItem('devicecost') ) ) * .12 ).toFixed(2); 
        localStorage.setItem( 'totalvat', totalVAT );
        $( '.totalVATValue' ).html( totalVAT );  

        // remove from display
        $( '.accessoryCostLabel ' ).html('');
        $( '.accessoryCostValue ' ).html( '' );

        var totalCost           =       Number( Number( localStorage.getItem('devicecost') ) + 
                                                ( Number( Number( localStorage.getItem('devicecost') ) ) * .12 ) + 
                                                Number( localStorage.getItem('plancost') ) ).toFixed(2);
        $( '.totalCostValue' ).html( totalCost );  
        localStorage.setItem( 'totalcost', totalCost );


        $( '.accessory' ).prop( 'checked', false );
        $( '.accessoryRemove' ).hide();

    })

    $( '.toprocess' ).on( 'click', function() {

        $( '.selectaccessories' ).hide().fadeOut();
        $( '.selectplan' ).hide().fadeOut();        
        $( '.paymentdetails' ).hide().fadeOut();
        $( '.customerdetails' ).hide().fadeOut();
        $( '.reviewdetails' ).hide().fadeOut();
        $( '.process' ).show().fadeIn(1000);

        $.post( '../../scripts/processpayment.php',                
              { planid: localStorage.getItem('planid'),
                planname: localStorage.getItem('planname'),
                plancost: localStorage.getItem('plancost'),
                plandesc: localStorage.getItem('plandesc'),
 
                accid: localStorage.getItem('accessoryid'),
                accname: localStorage.getItem('accessoryname'),
                acccost: localStorage.getItem('accessorycost'),
                accdesc: localStorage.getItem('accessorydesc'),

                custFirst: localStorage.getItem('custFirst'),
                custLast: localStorage.getItem('custLast'),
                custAddrOne: localStorage.getItem('custAddrOne'),
                custAddrTwo: localStorage.getItem('custAddrTwo'),
                custCity: localStorage.getItem('custCity'),
                custIsland: localStorage.getItem('custIsland'),
                custCountry: localStorage.getItem('custCountry'),
                custMobile: localStorage.getItem('custMobile'),
                custEmail: localStorage.getItem('custEmail'),

                cardName: localStorage.getItem('cardName'),
                cardNumber: localStorage.getItem('cardNumber'),
                cardCVV: localStorage.getItem('cardCVV'),
                cardExp: localStorage.getItem('cardExp'),

                devicecost: localStorage.getItem('devicecost'),
                deviceid: localStorage.getItem('deviceid')
            
                },

               function( data ) {  

                    $( '.result' ).html( data );

                    console.log( data );

                    if ( data == 0 ) {

                        $( '.error' ).html( '<div class="alert alert-danger border-danger">there is an issue with the payment method provided. please update your payment details then try again.</div>');
                        $( '.selectaccessories' ).hide().fadeOut();
                        $( '.selectplan' ).hide().fadeOut();        
                        $( '.process' ).hide().fadeOut();
                        $( '.customerdetails' ).hide().fadeOut();
                        $( '.reviewdetails' ).hide().fadeOut();
                        $( '.paymentdetails' ).show().fadeIn(1000);

                    } else {
                    
                        var url = 'http://localhost/projects/aliv/ecommerce-demo/store/ordercomplete/' + data;
                        $( location ).attr( 'href', url);

                    }
                            
               });

    });

    $( '.cancelOrder' ).on( 'click', function() {

        localStorage.clear();

    });

});