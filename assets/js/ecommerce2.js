function addJQuery()
{
	var head = document.getElementsByTagName( 'head' )[0];
	var scriptjQuery = document.createElement( 'script' );
	scriptjQuery.type = 'text/javascript';
	scriptjQuery.id = 'jQuery'
	scriptjQuery.src = 'https://code.jquery.com/jquery-3.4.1.min.js';
	var script = document.getElementsByTagName( 'script' )[0];
	head.insertBefore(scriptjQuery, script);
}

$( document ).ready( function() { 

    // $('.phone').mask('(999) 999-9999');           
    // $('.CardExpire').mask('99/99');           
    // $('.CardNumber').mask('9999-9999-9999-9999');   
    // $('.CardExpire').mask('999');   

    $( '.buynow' ).on( 'click', function(){

        localStorage.removeItem( 'device_accessory_cost');
        localStorage.removeItem( 'device_accessory_id');
        
        // console.log( localStorage );

    });

    $( '#CheckMinPlan' ).on( 'click', function() {

            $( '#MinimumPlan' ).slideToggle( 400 );
        
    });

    $( '.selectplan' ).on( 'change', function() {
    
        localStorage.clear();

        var index = $( '.planscreen' );
        // console.log( $( '.planscreen' ) );

        $( '.selectplan' ).each( function( index, value ) {

            // console.log(`device${index}: ${this.value}`);
            var deviceindex   =   $(this).index( '.selectplan');

            $.post( 'scripts/updatePriceOnPlan.php',
                { planid: $( '.selectplan' ).eq( index ).val()  },

                  function( data ) {

                        // console.log( localStorage );

                        if ( localStorage.getItem( 'device_acecssory_cost') == null ) {
                        
                            var devicecost   =     $( '.devicecostactual').eq( index ).val();
                            var totalvat     =     ( Number( devicecost ) ) * .12;
                            var totalamount  =     ( Number( devicecost ) * 1.12 ) + Number( data );

                        } else {

                            var devicecost    =     $( '.devicecostactual').eq( index ).val();
                            var devicecostvat =     ( Number( devicecost ) * .12 );
                            var accycostvat   =     ( Number( localStorage.getItem( 'device_acecssory_cost') ) * .12 );
                            var totalvat      =     ( Number( devicecostvat ) + Number( accycostvat ) );
                            var totalamount   =     ( ( ( Number( devicecost ) + Number( localStorage.getItem( 'device_acecssory_cost') ) + Number( totalvat ) ) * 1.12 ) + Number( data ) );
                               
                        }

                        $( '.plancost' ).eq( index ).html( data );
                        $( '.vatamount' ).eq( index ).html( totalvat.toFixed(2) );
                        $( '.totalamount' ).eq( index ).html( totalamount.toFixed(2) );
                        
                        // capture items into locale storage if a change in the plan occurs
                        localStorage.setItem( `device${index}_plan`, data );
                        localStorage.setItem( 'accessoryplanid', $( '.selectplan' ).eq( deviceindex ).val() );
                        localStorage.setItem( `device${index}_index`, index );
                        localStorage.setItem( `device${index}_cost`, devicecost );
                        localStorage.setItem( `device${index}_vat`, totalvat );
                        localStorage.setItem( `device${index}_total`, totalamount );
                        
                  });

        });
        
    });

    $( '.showaccessories' ).on( 'click', function() {

        var deviceindex   =   $(this).index( '.showaccessories');
        
        // capture items into locale storate if no action occurs
        // $( '.selectplan' ).each( function( index, value ) {

        //     let devicecost   =     $( '.devicecostactual').eq( index ).val();
        //     //let totalvat     =     ( Number( devicecost ) + Number( data ) ) * .12;
        //     //let totalamount  =     ( Number( devicecost ) + Number( data ) ) * 1.12;

        //     // localStorage.setItem( `device${index}_plan`, data );
        //     // localStorage.setItem( `device${index}_cost`, devicecost );
        //     // localStorage.setItem( `device${index}_vat`, totalvat );
        //     // localStorage.setItem( `device${index}_total`, totalamount );

        // });

        var accessorycost   =   localStorage.getItem(`device${deviceindex}_cost`);
        var accessoryplan   =   localStorage.getItem(`device${deviceindex}_plan`);            
        var accessoryindex  =   localStorage.getItem(`device${deviceindex}_index`);            
        var accessoryline   =   localStorage.getItem(`device_accessory_cost`);            
        var accessoryvat    =   localStorage.getItem(`device${deviceindex}_vat`);
        var accessorytotal  =   localStorage.getItem(`device${deviceindex}_total`);

        // $( '.accessoryplan' ).eq( deviceindex ).html( '' );
        // $( '.accessoryplan' ).eq( deviceindex ).html( accessoryplan );

        

        $( '.showaccessories' ).each( function( index, value ) {

            $( '.planscreen').eq( index ).hide().fadeOut(200);
            $( '.accessories').eq( index ).show().fadeIn(200);

            var accessorycost   =   localStorage.getItem(`device${deviceindex}_cost`);
            var accessoryplan   =   localStorage.getItem(`device${deviceindex}_plan`);            
            var accessoryindex  =   localStorage.getItem(`device${deviceindex}_index`);            
            var accessoryline   =   localStorage.getItem(`device_accessory_cost`);            
            var accessoryvat    =   localStorage.getItem(`device${deviceindex}_vat`);
            var accessorytotal  =   localStorage.getItem(`device${deviceindex}_total`);

            if ( localStorage.getItem( 'device_accessory_cost' ) == null ) {

                var device_cost     =       Number( localStorage.getItem(`device${deviceindex}_cost`) );
                var device_cost_vat =       Number( localStorage.getItem(`device${deviceindex}_cost`) ) * 0.12;
                var totalvat        =       device_cost_vat;
                var totalcost       =       Number( device_cost.toFixed(2) ) + Number( device_cost_vat.toFixed(2) ) + Number( accessoryplan );

                localStorage.setItem( 'accessorydevicecost', device_cost );
                localStorage.setItem( 'accessorydevicevat', device_cost_vat );
                localStorage.setItem( 'accessoryplan', accessoryplan );
                localStorage.setItem( 'accessorycombinedtotal', totalcost );

            } else {

                var accessory_vat   =       Number( accessorycost ) * 0.12;
                var device_cost_vat =       Number( localStorage.getItem(`device${index}_cost`) ) * 0.12;
                var totalvat        =       Number( accessory_vat ) + Number( device_cost_vat );
                var totalcost       =       Number( device_cost_vat ) + Number( totalvat ) + Number( localStorage.getItem(`device_accessory_cost`) ) + Number( localStorage.getItem(`device${index}_cost`) )  + Number( accessoryline );

                localStorage.setItem( 'accessorydevicecost', localStorage.getItem(`device${index}_cost`) );
                localStorage.setItem( 'accessorydevicevat', device_cost_vat );
                localStorage.setItem( 'accessorycost', localStorage.getItem(`device_accessory_cost`) );
                localStorage.setItem( 'accessoryvat', accessory_vat );
                localStorage.setItem( 'accessoryplan', accessoryplan );
                localStorage.setItem( 'accessorycombinedtotal', totalcost );

            }

            $( '.accessoryplan' ).html( '' + accessoryplan + '');      
            $( '.accessoryvat' ).html( '' + totalvat.toFixed(2) + '');      
            $( '.accessorytotal' ).html( '' + totalcost.toFixed(2) + '');      
            // console.log( accessoryplan );



            // var accessorycost   =   localStorage.getItem(`device${deviceindex}_cost`);
            // var accessoryplan   =   localStorage.getItem(`device${deviceindex}_plan`);            
            // var accessoryindex  =   localStorage.getItem(`device${deviceindex}_index`);            
            // var accessoryline   =   localStorage.getItem(`device_accessory_cost`);            
            // var accessoryvat    =   localStorage.getItem(`device${deviceindex}_vat`);
            // var accessorytotal  =   localStorage.getItem(`device${deviceindex}_total`);

            // $( '.accessorycost' ).eq( index ).html( accessorycost );
            // $( '.accessoryplan' ).eq( index ).html( accessoryplan );      

            // if ( localStorage.getItem( `device_accessory_cost` ) !== null ) {

            //     $( '.accessoryline').html(  '<div class="mt-3 col-sm-6 text-left"><strong>accessory:</strong></div>' +
            //                                 '<div class="mt-3 col-sm-6 text-right">' + localStorage.getItem( `device_accessory_cost` ) + '</div><div class="small col-sm-12 text-right"><i class="fa fa-trash text-danger"></i> remove accessory</div>');

            // }

            // $( '.accessoryvat' ).eq( index ).html(  accessoryvat );
            // $( '.accessorytotal' ).eq( index ).html( accessorytotal );                                        
            
        });

    });

    $( '.backtoplans' ).on( 'click', function() {

        $( '.backtoplans' ).each( function( index, value ) {

            $( '.accessories').eq( index ).hide().fadeOut();
            $( '.paymentscreen').eq( index ).hide().fadeOut();
            $( '.reviewscreen').eq( index ).hide().fadeOut();
            $( '.customerscreen').eq( index ).hide().fadeOut();
            $( '.planscreen').eq( index ).show().fadeIn( 3000 );

            
        });

    });

    $( '.tocustomerscreen' ).on( 'click', function() {

        $( '.tocustomerscreen' ).each( function( index, value ) {

            $( '.accessories').eq( index ).hide().fadeOut();
            $( '.planscreen').eq( index ).hide().fadeOut();
            $( '.paymentscreen').eq( index ).hide().fadeOut();
            $( '.customerscreen').eq( index ).show().fadeIn( 3000 );
            
            
        });

    });


    $( '.backtoaccessories' ).on( 'click', function() {

        $( '.backtoaccessories' ).each( function( index, value ) {

            $( '.accessories').eq( index ).show().fadeIn( 3000 );
            $( '.planscreen').eq( index ).hide().fadeOut();
            $( '.customerscreen').eq( index ).hide().fadeOut();
            $( '.reviewscreen').eq( index ).hide().fadeOut();
            $( '.paymentscreen').eq( index ).hide().fadeOut();

        });

    });

    $( '.topaymentscreen' ).on( 'click', function() {

        var deviceindex   =   $(this).index( '.topaymentscreen');

        $( '.topaymentscreen' ).each( function( index, value ) {

            var customerFirst   =   $( '.customerFirst' ).eq(index).val();
            var customerLast    =   $( '.customerLast' ).eq(index).val();
            var customerAddrOne =   $( '.customerAddressOne' ).eq(index).val();
            var customerAddrTwo =   $( '.customerAddressTwo' ).eq(index).val();
            var customerCity    =   $( '.customerCity' ).eq(index).val();
            var customerMobile  =   $( '.customerMobile' ).eq(index).val();
            var customerEmail   =   $( '.customerEmail' ).eq(index).val();

            if ( ( customerFirst.length == 0 ) ||
                 ( customerLast.length == 0 ) || 
                 ( customerAddrOne.length == 0 ) ||                  
                 ( customerCity.length == 0 ) ||
                 ( customerMobile.length == 0 ) ||
                 ( customerEmail.length == 0 ) ) {

                $( '.error' ).eq( index ).html('<div class="col-12"><div class="mt-3 alert alert-danger border-danger">One or more required fields do not contain the appropriate values</div></div></div>');

            } else {

                localStorage.setItem( 'CustomerFirstName', $( '.customerFirst' ).eq( deviceindex ).val() );
                localStorage.setItem( 'CustomerLastName', $( '.customerLast' ).eq( deviceindex ).val() );
                localStorage.setItem( 'CustomerAddrOne', $( '.customerAddressOne' ).eq( deviceindex ).val() );
                localStorage.setItem( 'CustomerAddrTwo', $( '.customerAddressTwo' ).eq( deviceindex ).val() );
                localStorage.setItem( 'CustomerCity', $( '.customerCity' ).eq( deviceindex ).val() );
                localStorage.setItem( 'CustomerIsland', $( '.customerIsland' ).eq( deviceindex ).val() );
                localStorage.setItem( 'CustomerCountry', $( '.customerCountry' ).eq( deviceindex ).val() );
                localStorage.setItem( 'CustomerMobile', $( '.customerMobile' ).eq( deviceindex ).val() );
                localStorage.setItem( 'CustomerEmail', $( '.customerEmail' ).eq( deviceindex ).val() );

                console.log( localStorage );

                $( '.error' ).eq( index ).html('');
                $( '.accessories').eq( index ).hide().fadeOut();
                $( '.planscreen').eq( index ).hide().fadeOut();
                $( '.reviewscreen').eq( index ).hide().fadeOut();
                $( '.customerscreen').eq( index ).hide().fadeOut();
                $( '.paymentscreen').eq( index ).show().fadeIn();
                
            }

        });

    });


    $( '.backtocustomer' ).on( 'click', function() {

        $( '.backtocustomer' ).each( function( index, value ) {

            $( '.accessories').eq( index ).hide().fadeOut();
            $( '.planscreen').eq( index ).hide().fadeOut();
            $( '.paymentscreen').eq( index ).hide().fadeOut();
            $( '.reviewscreen').eq( index ).hide().fadeOut();
            $( '.customerscreen').eq( index ).show().fadeIn();
 
        });

    });

    $( '.backtopayment' ).on( 'click', function() {

        $( '.backtopayment' ).each( function( index, value ) {

            // localStorage.setItem( 'CustomerFirstName', $( '.customerFirst' ).eq( deviceindex ).val() );
            // localStorage.setItem( 'CustomerLastName', $( '.customerLast' ).eq( deviceindex ).val() );
            // localStorage.setItem( 'CustomerAddrOne', $( '.customerAddressOne' ).eq( deviceindex ).val() );
            // localStorage.setItem( 'CustomerAddrTwo', $( '.customerAddressTwo' ).eq( deviceindex ).val() );
            // localStorage.setItem( 'CustomerCity', $( '.customerCity' ).eq( deviceindex ).val() );
            // localStorage.setItem( 'CustomerIsland', $( '.customerIsland' ).eq( deviceindex ).val() );
            // localStorage.setItem( 'CustomerCountry', $( '.customerCountry' ).eq( deviceindex ).val() );
            // localStorage.setItem( 'CustomerMobile', $( '.customerMobile' ).eq( deviceindex ).val() );
            // localStorage.setItem( 'CustomerEmail', $( '.customerEmail' ).eq( deviceindex ).val() );

            // console.log( localStorage );
            
            $( '.accessories').eq( index ).hide().fadeOut();
            $( '.planscreen').eq( index ).hide().fadeOut();
            $( '.reviewscreen').eq( index ).hide().fadeOut();
            $( '.customerscreen').eq( index ).hide().fadeOut();
            $( '.paymentscreen').eq( index ).show().fadeIn();
 
        });

    });

    $( '.toreviewscreen' ).on( 'click', function() {

        var deviceindex   =   $(this).index( '.toreviewscreen');

        $( '.toreviewscreen' ).each( function( index, value ) {

            localStorage.setItem( 'CardName', $( '.cardName' ).eq( deviceindex ).val() );
            localStorage.setItem( 'CardNumber', $( '.cardNumber' ).eq( deviceindex ).val() );
            localStorage.setItem( 'CardCVV', $( '.cardCVV' ).eq( deviceindex ).val() );
            localStorage.setItem( 'CardExpire', $( '.cardExpire' ).eq( deviceindex ).val() );

            $( '.accessories').eq( index ).hide().fadeOut();
            $( '.planscreen').eq( index ).hide().fadeOut();
            $( '.customerscreen').eq( index ).hide().fadeOut();
            $( '.paymentscreen').eq( index ).hide().fadeOut();

            $.post( 'scripts/showReview.php',
            { device_cost: localStorage.getItem( 'accessorydevicecost'),
              device_cost_vat: localStorage.getItem( 'accessorydevicevat'),
              accessory_cost: localStorage.getItem( 'accessorycost'),
              accessory_cost_vat: localStorage.getItem( 'accessorycostvat'),              
              accessory_plan: localStorage.getItem( 'accessoryplan'),
              accessory_plan_id: localStorage.getItem( 'accessoryplanid'),
              accessory_combined_total: localStorage.getItem( 'accessorycombinedtotal'),
              accessory_id: localStorage.getItem( 'device_accessory_id' ),
              customer_mobile: localStorage.getItem( 'CustomerMobile'),
              customer_first: localStorage.getItem( 'CustomerFirstName'),
              customer_last: localStorage.getItem( 'CustomerLastName'),
              customer_email: localStorage.getItem( 'CustomerEmail'),
              customer_island: localStorage.getItem( 'CustomerIsland'),
              customer_country: localStorage.getItem( 'CustomerCountry'),
              customer_city: localStorage.getItem( 'CustomerCity'),
              customer_addr: localStorage.getItem( 'CustomerAddrOne'),
              customer_addr_two: localStorage.getItem( 'CustomerAddrTwo'),
              card_name: localStorage.getItem( 'CardName'),
              card_number: localStorage.getItem( 'CardNumber'),
              card_cvv: localStorage.getItem( 'CardCVV'),
              card_expire: localStorage.getItem( 'CardExpire')
            
            
            },
              
            function( data ) { $( '.reviewoutput').html( data ); });


            $( '.reviewscreen').eq( index ).show().fadeIn();
            
        });

    });

    $( '.delitem' ).on( 'click', function() {

        $( '.delitem' ).each( function( index, value ) {

            // $( '.accessoryline' ).eq( index ).html( '' );

            // $( '.accessorytotal' ).html( Number( accessorycombinedtotal.toFixed(2) ) - Number( localStorage.getItem( 'accessorycost') ) - Number( localStorage.getItem( 'accessorycostvat ') ) );

            // localStorage.removeItem( 'accessorycost');
            // localStorage.removeItem( 'accessorycostvat');

            // console.log( Number( accessorycombinedtotal.toFixed(2) ) - Number( localStorage.getItem( 'accessorycost') ) - Number( localStorage.getItem( 'accessorycostvat ') ) );


        });

    });

    $( '.accessoryID' ).on( 'click', function() {

        $( '.accessoryID' ).each( function( index, value ) {

            if ( value.checked == true ) {

                localStorage.removeItem( `device_accessory_id` );                
                localStorage.removeItem( `device_accessory_cost` );               

                localStorage.setItem( `device_accessory_id`, value.value );

                $.post( 'scripts/updateAddAccessory.php',
                { accessoryid: value.value },
                  function( data ) {

                        localStorage.setItem( `device_accessory_cost`, data );

                        $( '.accessoryline' ).eq( index ).html( '' );
                        $( '.accessoryline' ).html( '<div class="mt-3 col-sm-6 text-left"><strong>accessory:</strong></div>' +
                                                    '<div class="mt-3 col-sm-6 text-right">' + localStorage.getItem( `device_accessory_cost` ) + '</div>' );
                        
                        $( '.clearaccessories' ).show();
                                                             
                        localStorage.setItem( 'accessorycost', localStorage.getItem(`device_accessory_cost`) );                   
                        localStorage.setItem( 'accessorycostvat', Number( localStorage.getItem(`device_accessory_cost`) ) * .12 );                   
                        // var accessorytotal = localStorage.setItem( 'accessorytotal', Number( localStorage.getItem( `accessorycombinedtotal` ) + Number( localStorage.getItem( `accessorycost` ) ) + Number( localStorage.getItem( `accessoryvat` ) ) ));                   
                        
                        var accessorycost   =   Number( localStorage.getItem( 'device_accessory_cost' ) );
                        var accessorycostvat   =   Number( localStorage.getItem( 'device_accessory_cost' ) ) * .12;

                        var accessorydevicevat =    Number( localStorage.getItem( 'accessorydevicevat' ) );
                        localStorage.removeItem( 'accessorycost');
                        localStorage.removeItem( 'accessorycostvat');

                        localStorage.setItem( 'accessorycost', accessorycost );
                        localStorage.setItem( 'accessorycostvat', accessorycostvat );
                        
                        var accessorycombinedtotal  =    ( Number( localStorage.getItem( 'accessoryplan' ) ) + 
                                                           Number( localStorage.getItem( 'accessorydevicecost' ) ) + 
                                                           Number( localStorage.getItem( 'accessorydevicevat' ) ) + 
                                                           Number( localStorage.getItem( 'accessorycost' ) )  +
                                                           Number( localStorage.getItem( 'accessorycostvat' ) ) 
                                                           
                                                           );                        


                        //+ Number( localStorage.getItem( 'accessorycostvat' )  ) + Number( localStorage.getItem( 'accessorydevicecost' ) ) + Number( localStorage.getItem( 'accessorydevicevat' ) +
                        
                        $( '.accessorytotal').html( accessorycombinedtotal.toFixed(2) );
                        $( '.accessoryvat').html( Number( accessorycostvat.toFixed(2) ) + Number( accessorydevicevat ) );

                        // $( '.accessorytotal' ).html( accessorytotal );
                        // console.log( localStorage );        

                    // $( '.accessoryline' ).eq( index ).html( '<div class="mt-3 w-100"><div class="row">' + 
                    //                                             '<div class="col-sm-6 text-left"><strong>accessory:</strong></div>' + 
                    //                                             '<div class="col-sm text-right">' +  data + '</div>' +                                                                    
                    //                                         '</div></div>' );
                        
                        //'<div class="row mt-3"><div class="col-sm-6 text-left"><strong>accessory:</strong></div><div class="col-sm-6 text-left"><strong>' +  data  + '</strong></div>'
                        // <div class="row"><div class="col-12"><div class="mt-1 alert alert-warning border-warning"></div></div></div></div>
                        // let devicecost   =     $( '.devicecostactual').eq( index ).val();
                        // let totalvat     =     ( Number( devicecost ) + Number( data ) ) * .12;
                        // let totalamount  =     ( Number( devicecost ) + Number( data ) ) * 1.12;


                        // $( '.plancost' ).eq( index ).html( data );
                        // $( '.vatamount' ).eq( index ).html( totalvat.toFixed(2) );
                        // $( '.totalamount' ).eq( index ).html( totalamount.toFixed(2) );

                        // capture items into locale storage if a change in the plan occurs
                        // localStorage.setItem( `device${index}_plan`, data );
                        // localStorage.setItem( `device${index}_cost`, devicecost );
                        // localStorage.setItem( `device${index}_vat`, totalvat );
                        // localStorage.setItem( `device${index}_total`, totalamount );
                        
                  });

            }

        });

    });

    $( '.clearaccessories' ).on( 'click', function() {

        $( '.clearaccessories' ).hide();
        localStorage.removeItem('accessorycost');
        localStorage.removeItem('accessorycostvat');
        $( '.accessoryline').html( '' ); 

        $( '.accessoryID' ).each( function( index, value ) {

            if ( value.checked == true ) {

                $( this ).prop( 'checked', false );

            }

        });

        var accessoryplan       =       localStorage.getItem( 'accessoryplan' );
        var accessorydevicecost =       localStorage.getItem( 'accessorydevicecost' );
        var accessorydevicevat  =       localStorage.getItem( 'accessorydevicevat' );

        var accessorycombinedtotal  =   ( Number( accessoryplan ) + 
                                          Number( accessorydevicecost ) +
                                          Number( accessorydevicevat ) );

        localStorage.setItem( 'accessorycombinedtotal',  accessorycombinedtotal.toFixed(2) );

        $( '.accessoryvat' ).html( Number( accessorydevicevat ).toFixed(2) );
        $( '.accessorytotal' ).html( Number( accessorycombinedtotal ).toFixed(2) );

        // console.log( localStorage );

    });

});