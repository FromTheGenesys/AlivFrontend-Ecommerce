<div class="container-fluid mt-5  ">

    <div class="animated fadeIn">

        <div class="row text-center">

            <div class="row justify-content-center w-100">

                <div class="col-10">

                    <div class="card">

                        <div class="card-body">

                            <h4>ALIV <strong>DEMO STORE</strong></h4>

                        </div>

                    </div>

                </div>

            </div>

            <div class="row justify-content-center w-100">

                <div class="col-10">

                    <div class="row">

                        <div class="col-md-3">
                        
                            <div class="card">

                                <div class="card-body">

                                    Hello

                                </div>

                            </div>

                        </div>

                        <div class="col-md">

                            <div class="row">

                                <?php if ( $this->GetDevices['count'] == 0 ): ?>

                                    <div class="card">

                                        <div class="card-body">

                                            <div class="alert alert-warning border-warning">
                                                No devices available
                                            </div>

                                        </div>

                                    </div>

                                <?php else: 

                                      $index    =   0;
                                      foreach( $this->GetDevices['data'] as $DeviceSet ) : ?>

                                            <div class="col-md-4">

                                                <div class="card">

                                                    <div class="card-body">

                                                        <div class="text-center mt-5">
                                                            <img class="img-fluid w-75 border-dark" src="<?php echo gpConfig['BURLPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS']; ?>Devices/<?php echo $DeviceSet['DeviceID']; ?>/<?php echo $DeviceSet['DeviceCoverName']; ?>" />
                                                        </div>
                                                        <h5 class="mt-4"><?php echo $DeviceSet['MakeName']; ?> <strong><?php echo $DeviceSet['DeviceName']; ?></strong></h5>
                                                        <div class="mt-5 font-sm">
                                                            From <span class="font-lg"><strong><?php echo number_format( $DeviceSet['DeviceCost'], 2 ); ?></strong></span> VAT not included
                                                        </div>
                                                        <div class="mt-4 row">

                                                            <!--
                                                            <div class="col-md-6 text-left">                                                                
                                                                <button class="btn-lg btn-info font-sm p3 text-white"><i class="fa fa-info-circle text-white"></i> Learn More</button>  
                                                            </div>
                                                            -->
                                                            
                                                            <div class="col-md text-center">
                                                                <input type="hidden" value="<?php echo $index; ?>" name="deviceIndex" class="deviceIndexCnt" />
                                                                <button class="btn-lg btn-success font-sm p3 buynow" onclick="location.href='<?php echo gpConfig['URLPATH']; ?>store/buy/<?php echo $DeviceSet['DeviceSKU']; ?>'" ><i class="fa fa-shopping-cart text-white"></i> Buy Now</button>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                <?php ++$index; endforeach; endif; ?>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
           
        </div>

    </div>

</div>       