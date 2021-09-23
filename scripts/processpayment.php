<?php

    include 'XmlToArray.php';

    function GenerateGUID() {
               
        if ( function_exists( 'com_create_guid' ) ) :
             
             return com_create_guid();
             
        else :
             
             mt_srand( (double)microtime() * 10000 ); //optional for php 4.2.0 and up.
             $charid   =    strtolower(md5(uniqid(rand(), true)));
             $hyphen   =    chr(45); // "-"
             
             $uuid     =     substr($charid, 0, 8 )  . $hyphen
                            .substr($charid, 8, 4 )  . $hyphen
                            .substr($charid, 12, 4 ) . $hyphen
                            .substr($charid, 16, 4 ) . $hyphen
                            .substr($charid, 20,12 );
             
             return $uuid;
        
        endif; 
        
    }

    function _setFACAmount( $Amount ) {

        $Amount         =           str_replace( '.', '', str_replace( ',', '', number_format( $Amount, 2 ) ) );
        $PreZeroCount   =           1;
        $PreZero        =           '0';

        while( $PreZeroCount < intval( 12 - strlen( $Amount ) ) )  :

            $PreZero    .=          '0';
            ++ $PreZeroCount;

        endwhile;

        return $PreZero . $Amount;

    }

    $CardNumber         =       str_replace( '-', '', $_POST['cardNumber'] );
    $CardName           =       trim( $_POST['cardName'] );
    $CardCVV            =       $_POST['cardCVV'];
    $CardExpire         =       str_replace( '/', '', $_POST['cardExp'] );


    $AccCost                    =                   ( empty( $_POST['acccost'] ) ? 0 : $_POST['acccost'] );
    $AccVAT                     =                   $AccCost * .12;

    $TotalCost          =       floatval( $_POST['devicecost'] + 
                                          ( $_POST['devicecost'] * .12 ) + 
                                          $AccCost + 
                                          ( $AccVAT  ) + 
                                          $_POST['plancost'] );

    $Session            =       GenerateGUID();
    
    $_CURRENCY          =       '044';
    $_PASSWORD          =       '6LzN5wxU';
    $_MERCHANTID        =       '88802094';
    $_ACQUIRERID        =       '464748';
    $_AMOUNT            =       _setFACAmount( $TotalCost );
    $_ORDERNUMBER       =       date('YmdHis');

    $_SIGNATURE         =       urlencode( base64_encode( pack( 'H*', sha1( $_PASSWORD . $_MERCHANTID . $_ACQUIRERID . $_ORDERNUMBER . $_AMOUNT . $_CURRENCY ) ) ) );

    $payload            =       '<?xml version="1.0"?>
                                <AuthorizeRequest xmlns="http://schemas.firstatlanticcommerce.com/gateway/data">
                                    <BillingDetails>
                                        <BillToAddress/>
                                        <BillToAddress2/>
                                        <BillToCity/>
                                        <BillToCountry/>
                                        <BillToEmail/>
                                        <BillToFirstName/>
                                        <BillToLastName/>
                                        <BillToState/>
                                        <BillToTelephone/>
                                        <BillToZipPostCode/>
                                        <BillToCountry/>
                                        <BillToMobile/>
                                    </BillingDetails>
                                    <CardDetails>
                                        <CardCVV2>'. $CardCVV .'</CardCVV2>
                                        <CardExpiryDate>'. $CardExpire .'</CardExpiryDate>
                                        <CardNumber>'. $CardNumber .'</CardNumber>
                                        <Installments>0</Installments>
                                    </CardDetails>
                                    <TransactionDetails>
                                        <AcquirerId>'. $_ACQUIRERID .'</AcquirerId>
                                        <Amount>'. $_AMOUNT .'</Amount>
                                        <Currency>'. $_CURRENCY .'</Currency>
                                        <CurrencyExponent>2</CurrencyExponent>
                                        <IPAddress/>
                                        <MerchantId>'. $_MERCHANTID .'</MerchantId>
                                        <OrderNumber>'. $_ORDERNUMBER .'</OrderNumber>
                                        <Signature>'. $_SIGNATURE .'</Signature>
                                        <SignatureMethod>SHA1</SignatureMethod>
                                        <TransactionCode>8</TransactionCode>        
                                        <CustomerReference/>
                                    </TransactionDetails>
                                    <FraudDetails>
                                        <AuthResponseCode/>
                                        <CVVResponseCode/>
                                        <SessionId>'. $Session .'</SessionId>
                                    </FraudDetails>
                                </AuthorizeRequest>';

    # setup cURL connection to payment gateway
    ### PRODUCTION ENVIRONMENT ###
    // $PaymentGW     =   curl_init('https://marlin.firstatlanticcommerce.com/PGServiceXML/Authorize');

    ### TEST ENVIRONMENT ###
    $request     =   curl_init();

    curl_setopt( $request, CURLOPT_URL, 'https://ecm.firstatlanticcommerce.com/PGServiceXML/Authorize' );                    
    curl_setopt( $request, CURLOPT_POST, TRUE);                    
    curl_setopt( $request, CURLOPT_RETURNTRANSFER, TRUE );
    
    # sends the soap server url, along with the soap envelope and required headers                    
    curl_setopt( $request, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $request, CURLOPT_HEADER, 0);
    curl_setopt( $request, CURLOPT_HTTPHEADER, [ 'Content-type: text/xml; charset=utf-8' ] );

    # execute transaction and return result
    $response = curl_exec( $request );

    // closes the thread and frees up resources for the next
    // time a connection attempt is made. ( avoid memory leaks ).
    curl_close( $request );

    $PaymentResponse                    =                   XmlToArray::parse( $response, false, false );

    if ( $PaymentResponse['AuthorizeResponse']['CreditCardTransactionResults']['ReasonCode']['value'] != 1 ) :

        echo '0';

    else:

        ini_set( 'display_errors', 1 );
        $connect                    =                   mysqli_connect( 'localhost', 'root', 'root', 'AlivCommerce' );

        $OrderGUID                  =                   GenerateGUID();
        $sql                        =                   ' INSERT INTO ORDERS ( OrderGUID, 
                                                                               OrderCustFirst,
                                                                               OrderCustLast,
                                                                               OrderCustEmail,
                                                                               OrderCustMobile,
                                                                               OrderCustAddr, 
                                                                               OrderCustAddrTwo, 
                                                                               OrderCustIsland, 
                                                                               OrderCustCity, 
                                                                               OrderCustCountry, 
                                                                               OrderCardFour, 
                                                                               OrderSignature, 
                                                                               OrderReference, 
                                                                               OrderCardType, 
                                                                               OrderCardAuth,                                                                                
                                                                               OrderDevice, 
                                                                               OrderPlan,                                                                                
                                                                               OrderAccessories, 
                                                                               OrderVAT, 
                                                                               OrderTotal, 
                                                                               OrderStatus, 
                                                                               OrderCreated )
        
                                                          VALUES ( "'. $OrderGUID .'",
                                                                   "'. strtoupper( $_POST['custFirst'] ) .'",
                                                                   "'. strtoupper( $_POST['custLast'] ) .'",                                                                   
                                                                   "'. strtolower( $_POST['custEmail'] ) .'",                                                                                                                                      
                                                                   "'. $_POST['custMobile'] .'",                                                                                                                                      
                                                                   "'. strtoupper( $_POST['custAddrOne'] ) .'",                                                                                                                                      
                                                                   "'. strtoupper( $_POST['custAddrTwo'] ) .'",                                                                                                                                                                                                         
                                                                   "'. $_POST['custIsland'] .'",                                                                                                                                      
                                                                   "'. strtoupper( $_POST['custCity'] ) .'",                                                                                                                                      
                                                                   "'. $_POST['custCountry'] .'",                                                                                                                                      
                                                                   "'. substr( $_POST['cardNumber'], 12, 4 ) .'",                                                                                                                                      
                                                                   "'. $PaymentResponse['AuthorizeResponse']['Signature']['value'] .'",
                                                                   "'. $PaymentResponse['AuthorizeResponse']['CreditCardTransactionResults']['ReferenceNumber']['value'] .'",
                                                                   "'. ( ( substr( $_POST['cardNumber'], 0, 1 ) == '4' ) ? 'VISA' : 'MASTERCARD' ) .'",
                                                                   "'. $PaymentResponse['AuthorizeResponse']['CreditCardTransactionResults']['AuthCode']['value'] .'",                                                                   
                                                                   "'. $_POST['deviceid'] .'",
                                                                   "'. $_POST['planid'] .'",
                                                                   "'. $_POST['accid'] .'",
                                                                   "'. round( floatval( $_POST['devicecost'] + $AccCost  ) * .12, 2 ) .'",
                                                                   "'. $TotalCost .'",
                                                                   "1",
                                                                   "'. date('Y-m-d H:i:s') .'");';

        $query                      =                   mysqli_query( $connect, $sql );


        ### TEST ENVIRONMENT ###
        $payload     =   '{ "APILogin" : "MTc2MGYxMWQyMGY0ZWU2MWY5MTAxNzg5MzM5ZDQzNGI=", "APIPswd" : "8dc0684d0d86c05a52afb85949c0a5c2" }';
        $request     =   curl_init();

        curl_setopt( $request, CURLOPT_URL, 'https://sandbox.gnstudios.dev/projects/api/v1/session/login' );                    
        curl_setopt( $request, CURLOPT_POST, TRUE);                    
        curl_setopt( $request, CURLOPT_RETURNTRANSFER, TRUE );
        
        # sends the soap server url, along with the soap envelope and required headers                    
        curl_setopt( $request, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $request, CURLOPT_HEADER, 0);
        curl_setopt( $request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );      
        curl_setopt( $request, CURLOPT_HTTPHEADER, [ 'Content-type: text/json; charset=utf-8',
                                                     'GN-OPToken: 0891efb1-c21e-4ec9-f11c-860341ed6aa8' ] );

        # execute transaction and return result
        $response = curl_exec( $request );

        // closes the thread and frees up resources for the next
        // time a connection attempt is made. ( avoid memory leaks ).
        curl_close( $request );

        $jresponse      =       json_decode( $response );


        // $payload4     =   '{ "LoginURL" : "https://www.genesysnow.com/" }';

        // $request4     =   curl_init();
        // curl_setopt( $request4, CURLOPT_URL, 'https://sandbox.gnstudios.dev/projects/api/v1/url/shortener' );                    
        // curl_setopt( $request4, CURLOPT_POST, TRUE);                    
        // curl_setopt( $request4, CURLOPT_RETURNTRANSFER, TRUE );
        
        // # sends the soap server url, along with the soap envelope and required headers                    
        // curl_setopt( $request4, CURLOPT_POSTFIELDS, $payload4 );
        // curl_setopt( $request4, CURLOPT_HEADER, 0);
        // curl_setopt( $request4, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );      
        // curl_setopt( $request4, CURLOPT_HTTPHEADER, [ 'Content-type: text/json', 'GN-AccessToken: '. $jresponse->{'GN-AccessToken'}  ] );

        // # execute transaction and return result
        // $response4 = curl_exec( $request4 );    

        // $jresponse4  =   json_decode( $response4 );


        // print_r( $jresponse4 );



        $Number         =       str_replace( "-", "", str_replace( "(", "", str_replace( ")", "", str_replace( " ", "", $_POST['custMobile'] ) ) ) );

        $payload     =   '{ "Destination" : "1'. $Number .'", 
                            "Message" : "thank you for choosing aliv! your order #'.  mysqli_insert_id( $connect )  .' has been submitted for processing." }';

        $payload2     =   '{ "Destination" : "1'. $Number .'", 
                            "Message" : "thank you for choosing aliv! please click the link to retrieve your receipt for order #'.  mysqli_insert_id( $connect )  .'. " }';

       
        $payload3     =   '{ "Destination" : "1'. $Number .'", 
                             "Message" : "track your recent aliv order #'.  mysqli_insert_id( $connect )  .' with the following details. lastname: '. strtoupper( $_POST['custLast'] )  .' and tracking no: '. explode( '-', $OrderGUID )[0] .'" }';

       
        $request     =   curl_init();
        curl_setopt( $request, CURLOPT_URL, 'https://sandbox.gnstudios.dev/projects/api/v1/sms/send' );                    
        curl_setopt( $request, CURLOPT_POST, TRUE);                    
        curl_setopt( $request, CURLOPT_RETURNTRANSFER, TRUE );
        
        # sends the soap server url, along with the soap envelope and required headers                    
        curl_setopt( $request, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $request, CURLOPT_HEADER, 0);
        curl_setopt( $request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );      
        curl_setopt( $request, CURLOPT_HTTPHEADER, [ 'Content-type: text/json', 'GN-AccessToken: '. $jresponse->{'GN-AccessToken'}  ] );

        # execute transaction and return result
        $response = curl_exec( $request );

        // closes the thread and frees up resources for the next
        // time a connection attempt is made. ( avoid memory leaks ).

        curl_setopt( $request, CURLOPT_URL, 'https://sandbox.gnstudios.dev/projects/api/v1/sms/send' );                    
        curl_setopt( $request, CURLOPT_POST, TRUE);                    
        curl_setopt( $request, CURLOPT_RETURNTRANSFER, TRUE );
        
        # sends the soap server url, along with the soap envelope and required headers                    
        curl_setopt( $request, CURLOPT_POSTFIELDS, $payload2 );
        curl_setopt( $request, CURLOPT_HEADER, 0);
        curl_setopt( $request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );      
        curl_setopt( $request, CURLOPT_HTTPHEADER, [ 'Content-type: text/json', 'GN-AccessToken: '. $jresponse->{'GN-AccessToken'}  ] );

        # execute transaction and return result
        $response = curl_exec( $request );
        curl_setopt( $request, CURLOPT_URL, 'https://sandbox.gnstudios.dev/projects/api/v1/sms/send' );                    
        curl_setopt( $request, CURLOPT_POST, TRUE);                    
        curl_setopt( $request, CURLOPT_RETURNTRANSFER, TRUE );
        
        # sends the soap server url, along with the soap envelope and required headers                    
        curl_setopt( $request, CURLOPT_POSTFIELDS, $payload3 );
        curl_setopt( $request, CURLOPT_HEADER, 0);
        curl_setopt( $request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );      
        curl_setopt( $request, CURLOPT_HTTPHEADER, [ 'Content-type: text/json', 'GN-AccessToken: '. $jresponse->{'GN-AccessToken'}  ] );

        # execute transaction and return result
        $response = curl_exec( $request );

        curl_close( $request );

        echo $OrderGUID;
        // header( 'Location: http://localhost/projects/aliv/ecommerce-demo/store/ordercomplete/'. $OrderGUID );

    endif;

    