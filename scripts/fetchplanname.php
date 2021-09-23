<?php 

ini_set( 'display_errors', 1 );
    $connect                    =                   mysqli_connect( 'localhost', 'root', 'root', 'AlivCommerce' );
    $query                      =                   mysqli_query( $connect, 'SELECT PlanEligible.* FROM PlanEligible WHERE PlanID = "'. $_POST['planid'] .'"' );
    $result                     =                   mysqli_fetch_assoc( $query );
    mysqli_close( $connect );

    echo $result['PlanName'];

?>