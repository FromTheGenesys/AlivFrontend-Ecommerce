<?php 

ini_set( 'display_errors', 1 );

    $connect                    =                   mysqli_connect( 'localhost', 'root', 'root', 'AlivCommerce' );
    $query                      =                   mysqli_query( $connect, 'SELECT DeviceAccessories.* FROM DeviceAccessories WHERE AccessoryID = "'. $_POST['accid'] .'"' );
    $result                     =                   mysqli_fetch_assoc( $query );
    mysqli_close( $connect );

    echo $result['AccessoryName'];

?>