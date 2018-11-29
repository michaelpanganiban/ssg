            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.4.0
                </div>
                <strong>Copyright &copy; 2018 <a href="https://infinit-o.com">Infinit-o</a>.</strong> All rights
                reserved.
            </footer>
            <aside class="control-sidebar control-sidebar-dark">
                <div class="tab-content">
                    <div class="tab-pane" id="control-sidebar-home-tab"></div>
                        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                            <div class="tab-pane" id="control-sidebar-settings-tab">
                                <form method="post">
                                    <h3 class="control-sidebar-heading">General Settings</h3>
                                    <div class="form-group">
                                        <label class="control-sidebar-subheading">
                                          Report panel usage
                                          <input type="checkbox" class="pull-right" checked>
                                        </label>
                                        <p>
                                          Some information about this general settings option
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-sidebar-subheading">
                                          Allow mail redirect
                                          <input type="checkbox" class="pull-right" checked>
                                        </label>
                                        <p>
                                          Other sets of options are available
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-sidebar-subheading">
                                          Expose author name in posts
                                          <input type="checkbox" class="pull-right" checked>
                                        </label>
                                        <p>
                                          Allow the user to show his name in blog posts
                                        </p>
                                    </div>
                                    <h3 class="control-sidebar-heading">Chat Settings</h3>
                                    <div class="form-group">
                                        <label class="control-sidebar-subheading">
                                          Show me as online
                                          <input type="checkbox" class="pull-right" checked>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-sidebar-subheading">
                                          Turn off notifications
                                          <input type="checkbox" class="pull-right">
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-sidebar-subheading">
                                          Delete chat history
                                          <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> 
                </div>
            </aside>
        </div>
        <script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bower_components/jquery-ui/jquery-ui.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bower_components/PACE/pace.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bower_components/jquery-knob/dist/jquery.knob.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bower_components/moment/min/moment.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/dist/js/demo.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bower_components/datatables-bs/js/dataTables.bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/select2/dist/js/select2.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bootstrap-dialog/dist/js/bootstrap-dialog.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/alertifyjs/alertify.js'); ?>"></script> 
        <script src="<?php echo base_url('assets/alertifyjs/alertify.js'); ?>"></script> 
        <script src="<?php echo base_url('assets/jquery-confirm/dist/jquery-confirm.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js'); ?>"></script>
        <!-- react -->
        <!-- <script src="http://localhost:3000/static/js/bundle.js"></script>
        <script src="http://localhost:3000/static/js/main.chunk.js"></script>
        <script src="http://localhost:3000/static/js/0.chunk.js"></script> -->
        <!-- react -->
        <script src="<?php echo base_url('assets/custom/admin.js'); ?>"></script>
        <script src="<?php echo base_url('assets/custom/client.js'); ?>"></script>
        <script src="<?php echo base_url('assets/loading.js'); ?>"></script>
        
        <script>
            $.widget.bridge('uibutton', $.ui.button);
            $(function () {
                $('#example1').DataTable({'ordering'    : false})
                $('#example2').DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false
                });
            });
            $(".select2").select2();

            $(".hover-tbl").hover(function(e){
                $(this).css('cursor','pointer');
                $(this).css("background-color","#666");
                $(this).css("color","white");
            });
            $(".hover-tbl").mouseout(function(event){
                $(this).css("background-color","white");
                $(this).css("color","black");
            });

            // $("").datePicker();
            $('.date-picker').datepicker({
                autoclose: true,
                format: 'yyyy-m-d'
            });

             //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
              checkboxClass: 'icheckbox_minimal-blue',
              radioClass   : 'iradio_minimal-blue'
            });

            $(".data-table").DataTable({'ordering'    : false});
        </script>
    </body>
</html>