<?php

    class GPLogicStore extends gpLogic {
        
        public function __construct() {
            parent::__construct();            
        }

        public function GetDeviceBySKU( string $SKU )  {

            # get elible plans
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Devices.*,
                                                                                                Makes.MakeName,
                                                                                                DeviceImages.ImageName AS DeviceCoverName
                                                                                
                                                                                      FROM      Devices
                                                                                      LEFT JOIN Makes
                                                                                      ON        Makes.MakeID = Devices.DeviceMake
                                                                                      
                                                                                      LEFT JOIN DeviceImages
                                                                                      ON        DeviceImages.DeviceID = Devices.DeviceID
                                                                                      
                                                                                      WHERE     Devices.DeviceSKU = "'. $SKU .'"
                                                                                      AND       Devices.DeviceStatus = "A"
                                                                                      ' );

            return $getData;

        }

        public function GetDeviceByID( $DeviceID )  {

            # get elible plans
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Devices.*,
                                                                                                Makes.MakeName,
                                                                                                DeviceImages.ImageName AS DeviceCoverName
                                                                                
                                                                                      FROM      Devices
                                                                                      LEFT JOIN Makes
                                                                                      ON        Makes.MakeID = Devices.DeviceMake
                                                                                      
                                                                                      LEFT JOIN DeviceImages
                                                                                      ON        DeviceImages.DeviceID = Devices.DeviceID
                                                                                      
                                                                                      WHERE     Devices.DeviceID = "'. $DeviceID .'"
                                                                                      AND       Devices.DeviceStatus = "A"
                                                                                      ' );

            return $getData;

        }

        public function GetOrder( string $GUID )  {

            # get elible plans
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Orders.*
                                                                                
                                                                                      FROM      Orders                                                                                     
                                                                                      WHERE     Orders.OrderGUID = "'. $GUID.'"' );

            return $getData;

        }

        public function GetAccessory( $AccessoryID )  {

            # get elible plans
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    DeviceAccessories.*
                                                                                
                                                                                      FROM      DeviceAccessories                                                                                     
                                                                                      WHERE     DeviceAccessories.AccessoryID = "'. $AccessoryID.'"' );

            return $getData;

        }

        public function GetOrderPlan( $PlanID )  {

            # get elible plans
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Plans.*
                                                                                
                                                                                      FROM      Plans                                                                                     
                                                                                      WHERE     Plans.PlanID = "'. $PlanID.'"' );

                                                                                      

            return $getData;

        }

        public function GetEligiblePlans() {

            # get elible plans
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    PlanEligible.*
                                                                                
                                                                                      FROM      PlanEligible
                                                                                      ORDER BY  PlanEligible.PlanPriority ASC, PlanEligible.PlanCost ASC' );

            return $getData;

        }
        
        public function GetRequiredPlan( $PlanID ) {

            # get elible plans
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    PlanEligible.PlanPriority,
                                                                                                PlanEligible.PlanCost,
                                                                                                PlanEligible.PlanID
                                                                                
                                                                                      FROM      PlanEligible
                                                                                      WHERE     PlanEligible.PlanID = "'. $PlanID .'"' );

            return $getData;

        }

        public function GetDevices() {

            # get devices
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Devices.*,
                                                                                                Makes.MakeName,
                                                                                                DeviceImages.ImageName AS DeviceCoverName
                                                                                
                                                                                      FROM      Devices

                                                                                      LEFT JOIN Makes
                                                                                      ON        Makes.MakeID = Devices.DeviceMake
                                                                                      
                                                                                      LEFT JOIN DeviceImages
                                                                                      ON        DeviceImages.DeviceID = Devices.DeviceID

                                                                                      WHERE     Devices.DeviceStatus =  "A"
                                                                                      ORDER BY  Devices.DeviceName ASC' );

            return $getData;

        } 

        
        public function GetAttribute( $AttributeID ) {

            # attribute ID
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Attributes.*
                                                                                                
                                                                                      FROM      Attributes

                                                                                      WHERE     Attributes.AttributeStatus =  "A"
                                                                                      AND       Attributes.AttributeID = "'. $AttributeID .'"' );

            return $getData;

        } 
        
        public function GetAccessories( $DeviceID ) {

            # attribute ID
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    DeviceAccessories.*
                                                                                                
                                                                                      FROM      DeviceAccessories

                                                                                      WHERE     DeviceAccessories.AccessoryStatus =  "A"
                                                                                      AND       DeviceAccessories.DeviceID = "'. $DeviceID .'"' );

            return $getData;

        } 

        public function FindOrder() {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Orders.*
                                                                                                
                                                                                      FROM      Orders

                                                                                      WHERE     UPPER( Orders.OrderCustLast ) =  "'. strtoupper( $_POST['OrderLast'] ) .'"
                                                                                      AND       LOWER( LEFT( Orders.OrderGUID, 8 ) ) =  "'. $_POST['OrderTracking'] .'"' );


            if ( $getData['count'] == 0 ) :
                
                return 2;

            endif;

            header( 'Location: '. gpConfig['URLPATH'] .'store/tracking/'. $getData['data'][0]['OrderGUID']  );


        }

    }