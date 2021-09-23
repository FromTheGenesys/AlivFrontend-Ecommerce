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

                            <h1>track <strong>your order.</strong></h1>
                            <div class="alert alert-secondary border-secondary">
                                enter the last name and tracking number in the spaces provided below.
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="row justify-content-center w-100">

                <div class="col-8 text-center">

                    <div class="card">

                        <div class="card-body">

                            <div class="row">

                                <form method="POST" action="">

                                    <div class="col-md-12 text-center">

                                        <?php if ( isset( $_POST['btnTrack'] ) ) : ?>

                                            <div class="alert alert-<?php echo $this->setMessage[0]; ?> border=<?php echo $this->setMessage[0]; ?>">
                                                <?php echo $this->setMessage[1]; ?>
                                            </div>

                                        <?php endif; ?>
                                        
                                        <div class="row text-center">   

                                            <div class="col text-center mt-2">
                                                <input type="text" name="OrderLast" autocomplete="off" required class="form-control w-100 form-control-lg text-center" value="<?php echo $_POST['OrderLast'] ?? NULL ; ?>" placeholder="last name" />
                                            </div>

                                        </div>

                                        <div class="row text-center">   

                                            <div class="col text-center mt-2">
                                                <input type="text" name="OrderTracking" autocomplete="off" required maxlength="8" class="form-control w-100 form-control-lg text-center" value="<?php echo $_POST['OrderTracking'] ?? NULL; ?>"placeholder="tracking number" />
                                            </div>

                                        </div>

                                        <div class="row">                                           
                                            <div class="col text-left mt-2">
                                                <button class="btn-lg btn-warning font-sm" name="btnTrack"><i class="fa fa-search"></i> track my order</button>                                            
                                            </div>
                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>       

</div>       