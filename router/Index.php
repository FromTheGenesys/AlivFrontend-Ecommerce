<?php

    class Index extends gpRouter {
        
        public function __construct() {
            parent::__construct();
            
            $this->render->LogicStore        =   new GPLogicStore();
            $this->render->setParams         =   ['header'  =>  'Store/Header',
                                                  'footer'  =>  'Store/Footer'];
            
        }
        
        public function getindex() {
                 
            $this->render->GetDevices        =                  $this->render->LogicStore->GetDevices();
            $this->render->GetPlans          =                  $this->render->LogicStore->GetEligiblePlans();
            //$this->render->GetRequiredPlan   =                  
            
            $this->render->page( 'Store/Index', $this->render->setParams );
            
        }
        
    }