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
            Client List Report
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
                                <div class="col-sm-1">
                                    <input required type="text" name="from" class="form-control date-picker" id="from" placeholder="From" value="<?php echo $this->input->get('from'); ?>">
                                </div>
                                <div class="col-sm-1">
                                    <input required type="text" name="to"  class="form-control date-picker" id="to" placeholder="To"  value="<?php echo $this->input->get('to'); ?>">
                                </div>
                            <?php if($session[md5('is_admin')] == 1) { ?>
                                <label class="col-sm-1 control-label">Client</label>
                                <div class="col-sm-2">
                                    <select class="form-control select2" name="client" id="client">
                                        <option value="">Select client..</option>
                                        <?php 
                                            if(!empty($clients))
                                            {
                                                foreach($clients as $rows)
                                                {
                                                    if($rows->client_id == $this->input->get('client'))
                                                        echo"<option selected value='".$rows->client_id."'>".$rows->client_name."</option>";
                                                    else
                                                        echo"<option value='".$rows->client_id."'>".$rows->client_name."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            <?php } ?>
                                <label class="col-sm-1 control-label">Industry</label>
                                <div class="col-sm-2">
                                    <select class="form-control select2" name="div_id" id="div_id">
                                        <option value="">Select industry..</option>
                                        <?php 
                                            if(!empty($division))
                                            {
                                                foreach($division as $rows)
                                                {
                                                    if($rows->div_id == $this->input->get('div_id'))
                                                        echo"<option selected value='".$rows->div_id."'>".$rows->div_name."</option>";
                                                    else
                                                        echo"<option value='".$rows->div_id."'>".$rows->div_name."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="pull-right" style="margin-right: 2%;">
                                    <button class="btn btn-sm btn-primary" id="filter-hc"><i class="fa fa-search"></i>&nbsp; &nbsp;Filter</button>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-print"></i>&nbsp;&nbsp;Print</button>
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-primary" role="menu">
                                            <li class="divider"></li>
                                            <li id="hc-pdf"><a href="#"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;As Pdf</a></li>
                                            <li class="divider"></li>
                                            <li id="hc-excel"><a href="#"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;As Excel</a></li>
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
                            <table class="data-table table table-bordered table-striped">
                                <thead>
                                    <tr style="background-color: #d7d7d8;">
                                        <th class="text-center">Client Name</th>
                                        <th class="text-center">Jobs</th>
                                        <th class="text-center">Headcount</th>
                                        <th class="text-center">Cost Per Title</th>
                                        <th class="text-center">Total Cost</th>
                                        <th class="text-center">Working Hours</th>
                                        <th class="text-center">Timezone</th>
                                        <th class="text-center">Shift</th>
                                        <th class="text-center">Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(!empty($headcount))
                                        {
                                            error_reporting(0);
                                            $count  = -1;
                                            $count2 = 1;
                                            $temp   = 0;
                                            $hc_ttl = 0;
                                            $ct_ttl = 0;
                                            $ttl_c  = 0;
                                            foreach($headcount as $row)
                                            {
                                                echo"<tr>";
                                                if($headcount[$temp]->client_name == $headcount[$count]->client_name)
                                                {
                                                    echo"<td></td>";
                                                    $hc_ttl += $headcount[$count]->hc;
                                                    $ct_ttl += $headcount[$count]->cost_per_title;
                                                    $ttl_c  += $headcount[$count]->ttl_cost;
                                                }
                                                else
                                                {
                                                    echo"<td><b>".$row->client_name."</b></td>";
                                                }
                                                echo"<td>".$row->jobtitle."</td>
                                                        <td style='text-align:right'>".$row->hc."</td>
                                                        <td style='text-align:right'>".number_format($row->cost_per_title,2)."</td>
                                                        <td style='text-align:right'>".number_format($row->ttl_cost,2)."</td>
                                                        <td>".$row->hours_work."</td>
                                                        <td>".$row->timezone."</td>
                                                        <td>".$row->shift."</td>
                                                        <td>".$row->location."</td>
                                                    </tr>";
                                                if($headcount[$temp]->client_name != $headcount[$count2]->client_name)
                                                {
                                                    $hc_ttl += $headcount[$temp]->hc;
                                                    $ct_ttl += $headcount[$temp]->cost_per_title;
                                                    $ttl_c  += $headcount[$temp]->ttl_cost;
                                                    echo"<tr style='background-color:#d2c8c8;'>
                                                            <td><b>Total</b></td>
                                                            <td></td>
                                                            <td style='text-align:right'><b>".$hc_ttl."</b></td>
                                                            <td style='text-align:right'><b>".number_format($ct_ttl,2)."</b></td>
                                                            <td style='text-align:right'><b>".number_format($ttl_c,2)."</b></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>";
                                                    $all_hc += $hc_ttl;
                                                    $all_ct += $ct_ttl;
                                                    $all_tc += $ttl_c;
                                                    $hc_ttl = 0;
                                                    $ct_ttl = 0;
                                                    $ttl_c  = 0;
                                                }
                                                $count2++;
                                                $count++;
                                                $temp++;
                                            }

                                            echo"<tr style='background-color:#d2c8c8;'>
                                                    <td><b>Over All Total</b></td>
                                                    <td></td>
                                                    <td style='text-align:right'><b>".$all_hc."</b></td>
                                                    <td style='text-align:right'><b>".number_format($all_ct,2)."</b></td>
                                                    <td style='text-align:right'><b>".number_format($all_tc,2)."</b></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>";
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