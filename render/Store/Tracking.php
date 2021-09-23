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

                            <h1>tracking <strong>order # <?php echo $this->GetOrder['data'][0]['OrderID']; ?></strong></h1>
                            <div class="alert alert-success border-success">
                                your order has been completed and will be processed.  you will receive alerts by email and text messages as the order staus processes.  additionally, you may track your order below using the tracking information specified below.
                            </div>

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
                                            <div class="planCostValue text-left"><?php echo $this->GetPlan['data'][0]['PlanCost']; ?></div>
                                        </div>

                                        <?php if ( !empty( $this->GetOrder['data'][0]['OrderAccessories'] ) ) : ?>

                                            <?php if ( $this->GetAccessory['count'] > 0 ) : ?>

                                                <div class="accessoryCost row pricing">
                                                    <div class="accessoryCostLabel text-right col-6 font-weight-bold">** Accessory</div>
                                                    <div class="accessoryCostValue text-left"><?php echo $this->GetAccessory['data'][0]['AccessoryCost']; ?></div>
                                                </div>

                                            <?php endif; ?>
                                            
                                        <?php endif; ?>

                                        <div class="vatCost row pricing">
                                            <div class="costLabel text-right col-6 font-weight-bold">VAT</div>
                                            <div class="totalVATValue text-left"><?php echo number_format( $this->GetOrder['data'][0]['OrderVAT'], 2 ); ?></div>
                                        </div>

                                        <div class="totalCost row pricing">
                                            <div class="costLabel text-right col-6 font-weight-bold">Total</div>
                                            <div class="totalCostValue text-left"><?php echo number_format( $this->GetOrder['data'][0]['OrderTotal'], 2 ); ?></div>
                                        </div>
                                  
                                    </div>

                                  
                                   
                                </div>

                                <div class="col-md-7">
                                    
                                    <div class="col-md-11">
                                        
                                        <div class="showprocessing"> 

                                            <div class="text-left mt-5 mb-5">
                                                <strong>we are processing your order</strong>
                                            </div>
                                      
                                            <div class="row">                                        
                                            
                                                <div class="progress-track w-100 font-xl">
                                                    <ul id="progressbar">
                                                        <li class="step0 text-left" id="step1">Ordered</li>
                                                        <li class="step0 text-center" id="step2">Processing</li>
                                                        <li class="step0 text-right" id="step3">On the way</li>
                                                        <li class="step0 text-right" id="step4">Delivered</li>
                                                        <li class="step0 text-right" id="step5">Delivered</li>
                                                    </ul>
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

</div>       