<?php 
    $client_name = "";
    $industry    = "";
    $customer_exp= "";
    $back_office = "";
    $fa          = "";
    $headquarter = "";
    $tier        = "";
    $case_study  = "";
    $visit       = "";
    $target      = "";
    $segment     = "";
    $job_desc    = "";
    $client_id   = "";
    $address     = "";
    $ref_no      = "";
    if(!empty($client_data))
    {
        foreach($client_data as $row)
        {
            $client_id   = $row->team_id;
            $client_name = $row->team_name;
            $industry    = $row->division_id;
            $customer_exp= $row->customer_experience;
            $back_office = $row->back_office;
            $fa          = $row->F_and_a;
            $headquarter = $row->hq;
            $tier        = $row->tier;
            $case_study  = $row->case_study;
            $visit       = $row->visit;
            $target      = $row->target_market;
            $segment     = $row->segment;
            $job_desc    = $row->job_desc;
            $address     = $row->address;
            if($row->ref_no == "")
                $ref_no  = @date('Ymd').$row->team_id;
            else
                $ref_no  = $row->ref_no;
        }
    }
?>
<?php 
    if(!empty($user_modules))
    {
        foreach($user_modules as $row)
        {
            if($row->module_name == 'edit client')
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
            Update Client Info
            <small style="font-size: 12px;">Infinit-o</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary" >
                    <div class="box-header">
                        <h4><?php echo "Client ID: <b>".$client_id."</b>"; ?></h4>
                        <h4><?php echo "Reference #: <b>".$ref_no."</b>"; ?><button class="btn btn-sm btn-warning pull-right" id="view-headcount" data-pk="<?php echo $client_id; ?>" data-name="<?php echo $client_name; ?>"><i class="fa fa-users"></i>&nbsp;&nbsp;View headcount</button></h4>
                        
                    </div><hr>
                    <div class="box-body">
                        <div class='row'>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Client Name:</label>
                                <div class='col-md-6'>
                                    <input type='text' class='form-control' id='client-name' placeholder="Sample client name" value="<?php echo $client_name; ?>" data-id="<?php echo $client_id; ?>" data-ref="<?php echo $ref_no; ?>">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Industry:</label>
                                <div class='col-md-8'>
                                    <select class="form-control select2" id="industry">
                                        <option value="">Select industry..</option>
                                        <?php 
                                            if(!empty($division))
                                            {
                                                foreach($division as $row)
                                                {
                                                    echo"<option value='".$row->div_id."' ".(($industry == $row->div_id) ? " selected " : " ").">".$row->div_name."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Address</label>
                                <div class='col-md-8'>
                                    <input type='text' class='form-control' id='client-address' placeholder="Client Address" value="<?php echo $address; ?>">
                                </div>
                            </div>
                            <!-- <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Customer Experience:</label>
                                <div class='col-md-8'>
                                    <input type='text' class='form-control' id='customer-exp' placeholder="Customer Experience" value="<?php echo $customer_exp; ?>">
                                </div>
                            </div> -->
                            <!-- <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Back Office:</label>
                                <div class='col-md-8'>
                                    <input type='text' class='form-control' id='back-office' placeholder="Back Office" value="<?php echo $back_office; ?>"> 
                                </div>
                            </div> -->
                            <!-- <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>F&A:</label>
                                <div class='col-md-8'>
                                    <input type="text" class="form-control" placeholder ="F&A" id="fa" value="<?php echo $fa; ?>">
                                </div>
                            </div> -->
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Headquarter:</label>
                                <div class='col-md-8'>
                                    <input type="text" class="form-control" name="Headquarter" id="hq" placeholder="Headquarter" value="<?php echo $headquarter; ?>">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Tier:</label>
                                <div class='col-md-8'>
                                    <select class='select2 col-md-12' id="tier" data-live-search='true'>
                                        <option value="">Select Tier..</option>
                                        <option value="G" <?php echo ($tier == 'G')? "selected" : "" ?>>G</option>
                                        <option value="P" <?php echo ($tier == 'P')? "selected" : "" ?>>P</option>
                                        <option value="S" <?php echo ($tier == 'S')? "selected" : "" ?>>S</option>          
                                    </select>
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Case Study:</label>
                                <div class='col-md-8'>
                                    <input type="text" class="form-control" id="case-study" placeholder="Case Study"  value="<?php echo $case_study; ?>">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Auth HC:</label>
                                <div class='col-md-8'>
                                    <input type="text" class="form-control" disabled placeholder="Headcount"  value="<?php echo $headcount[0]->headcount; ?>">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Visit:</label>
                                <div class='col-md-8'>
                                    <input type="text" class="form-control date-picker" id="visit" placeholder="Visit"  value="<?php echo $visit; ?>">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Target Market:</label>
                                <div class='col-md-8'>
                                    <input type="text" class="form-control" id="target-market" placeholder="Target Market"  value="<?php echo $target; ?>">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Segment:</label>
                                <div class='col-md-8'>
                                    <textarea id='segment' class='form-control' rows='5' placeholder="Segment.."><?php echo $segment; ?></textarea>
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>What you do:</label>
                                <div class='col-md-8'>
                                    <textarea id='job-desc' class='form-control' rows='5' placeholder="Describe what you do.."><?php echo $job_desc; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div><hr>
                    <div class="scrollit">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Contract</th>
                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">Expiry Date</th>
                                    <th class="text-center">Remaining Months</th>
                                    <th class="text-center">Remarks</th>
                                    <th class="text-center">Attachment</th>
                                    <th class="text-center"><button data-pk="<?php echo $client_id; ?>"  title="Add master contract" style="cursor: pointer;" id="add-master-contract" class="btn btn-sm btn-success"><span class="fa fa-plus"></span>&nbsp; &nbsp;Add Contract</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if(!empty($client_data))
                                    {
                                        foreach($client_data as $row)
                                        {
                                            $count = 0;
                                            if($row->contract != "")
                                            {
                                                $date1 = @date('m', @strtotime(@date('Y-m-d')));
                                                $date2 = @date('m', @strtotime($row->expiry_date));
                                                $year1 = @date('Y', @strtotime(@date('Y-m-d')));
                                                $year2 = @date('Y', @strtotime($row->expiry_date));
                                                $diff  = (($year2 - $year1) * 12) + ($date2 - $date1);
                                                if($diff <= 0)
                                                    $diff = "<i class='text-danger'>Contract Expired</i>";
                                                echo"<tr class='pointer hover-tbl'>
                                                        <td class='text-center'>".$row->contract."</td>
                                                        <td class='text-center'>".@date_format(@date_create($row->start_date), 'd M, Y')."</td>
                                                        <td class='text-center'>".@date_format(@date_create($row->expiry_date), 'd M, Y')."</td>
                                                        <td class='text-center'>".$diff."</td>
                                                        <td class='text-center'>".$row->remarks."</td>";
                                                    if(!empty($files))
                                                    {
                                                        foreach($files as $row_files)
                                                        {
                                                            if($row->team_line_id == $row_files->contract_no)
                                                                $count++;
                                                        }
                                                        if($count > 0)
                                                        {
                                                            echo "<td class='text-center'><button data-contract='".$row->team_line_id."' data-team='".$client_id."' class='btn btn-sm btn-info attach-file'><i class='fa fa-paperclip'></i>&nbsp; &nbsp;".$count." attached documents</button></td>";
                                                        }
                                                        else
                                                        {
                                                            echo "<td class='text-center'><button  data-contract='".$row->team_line_id."' data-team='".$client_id."' class='btn btn-sm btn-warning attach-file'><i class='fa fa-paperclip'></i>&nbsp; &nbsp;Attachment is not available</button></td>";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo "<td class='text-center'><button  data-contract='".$row->team_line_id."' data-team='".$client_id."' class='btn btn-sm btn-warning attach-file'><i class='fa fa-paperclip'></i>&nbsp; &nbsp;Attachment is not available</button></td>";
                                                    }
                                                    echo"<td class='text-center'><button class='btn btn-sm btn-primary view-contract' data-pk='".$row->team_line_id."' data-contract='".$row->contract."' data-start_date='".@date_format(@date_create($row->start_date), 'Y-m-d')."' data-expiry_date='".@date_format(@date_create($row->expiry_date), 'Y-m-d')."' data-headcount='".$row->headcount."' data-remarks='".$row->remarks."' data-document='".$count."' data-client-id='".$client_id."'><i class='fa fa-eye'></i>&nbsp;&nbsp; View contract</td>";
                                                echo"</tr>";
                                            }
                                        }
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <td colspan="9">
                                    <button class="btn btn-md btn-primary pull-right" id="proceed-update-client"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp; Save Changes</button>
                                </td>
                            </tfoot>
                        </table>
                    <div class="scrollit">
                </div>
            </div>
        </div>
    </section>
</div>

<?php } ?>