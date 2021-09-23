


       <div class="modal fade animated" id="CancelOrder" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form method="POST" action="<?php echo gpConfig['URLPATH']; ?>">

                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">CANCEL <strong>ORDER</strong></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">

                        <div class="form-body text-dark"> 
                        
                            <div class="alert alert-danger border-danger">
                                Are you sure you want to discontinue this order process?
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">                                 
                        <input type="hidden" value="<?php echo $PlanSet['PlanID']; ?>" name="PlanID" />                                                                                           
                        <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>                                                  
                        <button class="font-sm btn-lg btn-danger cancelOrder" type="submit" name="btnRemovePlan"><i class="fa fa-thumbs-up"></i> Cancel Order</button>                                                                          
                    </div>

                </form>
                
            </div>

        </div>

    </div>

  </div>
  <footer class="app-footer font-sm" style="border: 1px solid #000;">
    <span>Copyright © <?php echo date('Y'); ?>. <a class="text-primary" href="https://www.bealiv.com/" target="_BLANK">Aliv</a></span>
    <span class="ml-auto font-sm">Developed by <a class="text-primary " href="https://www.genesysnow.com/" target="_BLANK">Genesys Now. A Technology Company</a></span>
  </footer>

  <!-- Bootstrap and necessary plugins -->
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/jquery.min.js"></script>
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>js/inputmask.js"></script>  
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>js/ecommerce-demo.js"></script>  
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/popper.min.js"></script>
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/bootstrap.min.js"></script>
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/pace.min.js"></script>

  <!-- Plugins and scripts required by all views -->

  <!-- CoreUI Pro main scripts -->
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>js/app.js"></script>

  <!-- Plugins and scripts required by this views -->
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/toastr.min.js"></script>
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/gauge.min.js"></script>
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/moment.min.js"></script>
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/daterangepicker.min.js"></script>

  <!-- Custom scripts required by this view -->
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>js/views/main.js"></script>

</body>
</html>