<?php 
    $view = "";
    if(!empty($user_modules))
    {
        foreach($user_modules as $row)
        {
            if($row->module_name == 'authentication logs')
            {
                $view   = $row->view;
                $add    = $row->add;
                $edit   = $row->edit;
                $delete = $row->delete;
            }
        }
    }
?>

<div class="content-wrapper">
    <?php 
        if($view == 0)
        {
            include APPPATH.'/views/notAllowed.php'; 
        }
        else
        {
    ?>
    <section class="content-header" style="background-color: white; min-height: 55px;">
        <h1 style="font-family: Century Gothic; font-size:20px; color: #272727; font-weight: lighter;">
            Authentication Logs
            <small style="font-size: 12px;">Infinit-o</small>
        </h1>
    </section>
    <section class="content">
        <div class="row"   >
            <div class="col-lg-12" >
                <div class="box box-primary" style='overflow: auto;'>
                    <form class="form-horizontal form-bordered" method="GET">
                        <div class="panel-body">
                            <div class="form-group message-container"></div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label">Date</label>
                                <div class="col-sm-2">
                                    <input required type="text" name="from" class="form-control date-picker" id="from" placeholder="From" value="<?php echo $this->input->get('from'); ?>">
                                </div>
                                <div class="col-sm-2">
                                    <input required type="text" name="to"  class="form-control date-picker" id="to" placeholder="To"  value="<?php echo $this->input->get('to'); ?>">
                                </div>
                            <?php if($session[md5('is_admin')] == 1) { ?>
                                <label class="col-sm-1 control-label">User</label>
                                <div class="col-sm-2">
                                    <select class="form-control select2" name="user" id="user">
                                        <option value="">Select user..</option>
                                        <?php 
                                            if(!empty($users))
                                            {
                                                foreach($users as $rows)
                                                {
                                                    if($rows->emp_id == $this->input->get('user'))
                                                        echo"<option selected value='".$rows->emp_id."'>".$rows->last_name.", ".$rows->first_name."</option>";
                                                    else
                                                        echo"<option value='".$rows->emp_id."'>".$rows->last_name.", ".$rows->first_name."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            <?php } ?>
                                <div class="pull-right" style="margin-right: 2%;">
                                    <button class="btn btn-sm btn-primary" id="filter-auth"><i class="fa fa-search"></i>&nbsp; &nbsp;Filter</button>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-print"></i>&nbsp;&nbsp;Print</button>
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-primary" role="menu">
                                            <li class="divider"></li>
                                            <li id="auth-pdf"><a href="#"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;As Pdf</a></li>
                                            <li class="divider"></li>
                                            <li id="auth-excel"><a href="#"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;As Excel</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                
                            </div>
                        </div>
                    </form>
                    <div style='width:99%;'>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr style="background-color: #d7d7d8;">
                                        <th class="text-center">User</th>
                                        <th class="text-center">IP Address</th>
                                        <th class="text-center">Action</th>
                                        <th class="text-center">Result</th>
                                        <th class="text-center">Datetime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(!empty($auth_logs))
                                        {
                                            foreach($auth_logs as $row)
                                            {
                                                echo"<tr>
                                                        <td>".$row->last_name.", ".$row->first_name."</td>
                                                        <td>".$row->ip_address."</td>
                                                        <td>".$row->action."</td>
                                                        <td>".(($row->result == 0)? "Failure login" : "Successful login")."</td>
                                                        <td>".@date_format(@date_create($row->created), 'M d, Y h:s a')."</td>
                                                    </tr>";
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php } ?>