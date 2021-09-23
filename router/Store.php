<?php

    class Store extends gpRouter {
        
        public function __construct() {

            parent::__construct();
            $this->render->LogicStore        =      new GPLogicStore();
            $this->render->setParams         =      ['header'  =>  'Store/Header',
                                                     'footer'  =>  'Store/Footer'];
            
        }
        
        public function getindex() {
            
            $this->render->page( 'Store/Index', $this->render->setParams );
            
        }


        public function buy() {

            $this->render->GetSKU            =              func_get_arg( 0 );
            $this->render->GetDevice         =              $this->render->LogicStore->GetDeviceBySKU( $this->render->GetSKU );
            $this->render->GetEligiblePlans  =              $this->render->LogicStore->GetEligiblePlans();
            $this->render->GetRequiredPlan   =              $this->render->LogicStore->GetRequiredPlan( $this->render->GetDevice['data'][0]['DevicePlanRequired'] );
            $this->render->GetAccessories    =              $this->render->LogicStore->GetAccessories( $this->render->GetDevice['data'][0]['DeviceID'] );  


            if ( $this->render->GetDevice['count'] == 0 ) :

                $this->render->page( 'Store/NotFound', $this->render->setParams );

            else:

                $this->render->page( 'Store/Buy', $this->render->setParams );

            endif;

        }

        public function ordercomplete() {

            $this->render->OrderID           =              func_get_arg( 0 );
            $this->render->GetOrder          =              $this->render->LogicStore->GetOrder( $this->render->OrderID );
            $this->render->GetDevice         =              $this->render->LogicStore->GetDeviceByID( $this->render->GetOrder['data'][0]['OrderDevice'] );
            $this->render->GetPlan           =              $this->render->LogicStore->GetOrderPlan( $this->render->GetOrder['data'][0]['OrderPlan'] );

            if ( !empty( $this->render->GetOrder['data'][0]['OrderAccessories'] ) ) :

                $this->render->GetAccessory  =              $this->render->LogicStore->GetAccessory( $this->render->GetOrder['data'][0]['OrderAccessories'] );

            endif;

            $this->render->GetRequiredPlan   =              $this->render->LogicStore->GetRequiredPlan( $this->render->GetDevice['data'][0]['DevicePlanRequired'] );
            $this->render->GetAccessories    =              $this->render->LogicStore->GetAccessories( $this->render->GetDevice['data'][0]['DeviceID'] );  

            if ( $this->render->GetOrder['count'] == 0 ) :

                $this->render->page( 'Store/OrderNotFound', $this->render->setParams );

            else:

                $this->render->page( 'Store/OrderCompleted', $this->render->setParams );

            endif;

        }

        public function track() {

            if ( isset( $_POST['btnTrack'] ) ) :

                $this->process              =               $this->render->LogicStore->FindOrder();

                $this->render->setMessage   =               [ 'warning', 'the last name and/or tracking number is incorrect. please check the tracking details then try again.'];

            endif;

            $this->render->page( 'Store/TrackMyOrder', $this->render->setParams );

        }
        
        public function tracking() {

            $this->render->OrderID           =              func_get_arg( 0 );     
            $this->render->GetOrder          =              $this->render->LogicStore->GetOrder( $this->render->OrderID );
            $this->render->GetDevice         =              $this->render->LogicStore->GetDeviceByID( $this->render->GetOrder['data'][0]['OrderDevice'] );
            $this->render->GetPlan           =              $this->render->LogicStore->GetOrderPlan( $this->render->GetOrder['data'][0]['OrderPlan'] );
            $this->render->GetAccessory      =              $this->render->LogicStore->GetAccessory( $this->render->GetOrder['data'][0]['OrderAccessories'] );

            $this->render->page( 'Store/Tracking', $this->render->setParams );

        }
        
    }