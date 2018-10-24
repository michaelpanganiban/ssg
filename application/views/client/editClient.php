<?php 
    $client_name = "";
    $industry    = "";
    $customer_exp= "";
    $back_office = "";
    $fa          = "";
    $headquarter = "";
    $auth_hc     = "";
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
            $auth_hc     = $row->auth_hc;
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
<div class="content-wrapper">
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
                        <h4><?php echo "Reference #: <b>".$ref_no."</b>"; ?></h4>
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
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Customer Experience:</label>
                                <div class='col-md-8'>
                                    <input type='text' class='form-control' id='customer-exp' placeholder="Customer Experience" value="<?php echo $customer_exp; ?>">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Back Office:</label>
                                <div class='col-md-8'>
                                    <input type='text' class='form-control' id='back-office' placeholder="Back Office" value="<?php echo $back_office; ?>"> 
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>F&A:</label>
                                <div class='col-md-8'>
                                    <input type="text" class="form-control" placeholder ="F&A" id="fa" value="<?php echo $fa; ?>">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Headquarter:</label>
                                <div class='col-md-8'>
                                    <input type="text" class="form-control" name="Headquarter" id="hq" placeholder="Headquarter" value="<?php echo $headquarter; ?>">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Auth HC:</label>
                                <div class='col-md-8'>
                                    <input type="number" class="form-control" id="hc" placeholder="Auth Head Count" value="<?php echo $auth_hc; ?>">
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
                                <label class='control-label col-md-4'>Visit:</label>
                                <div class='col-md-8'>
                                    <input type="text" class="form-control" id="visit" placeholder="Visit"  value="<?php echo $visit; ?>">
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
                                <label class='control-label col-md-4'>Job Description:</label>
                                <div class='col-md-8'>
                                    <textarea id='job-desc' class='form-control' rows='5' placeholder="Describe what you do.."><?php echo $job_desc; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div><hr>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">Annex</th>
                                <th class="text-center">Start Date</th>
                                <th class="text-center">Expiry Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Next Step</th>
                                <th class="text-center">Remarks</th>
                                <th><span class="fa fa-2x fa-plus text-primary" style="cursor: pointer;" title="add set" id="table-add-update" data-pk="<?php echo $client_id; ?>"></span></th>
                            </tr>
                        </thead>
                        <tbody id="append-client-line">
                            <?php 
                                if(!empty($client_data))
                                {
                                    foreach($client_data as $row)
                                    {
                                        echo'<tr class="client-line">
                                                <td>
                                                    <input type="text" name="annex[]" class="form-control col-md-4" placeholder="Annex" value="'.$row->annex.'" data-pk="'.$row->team_line_id.'">
                                                </td>
                                                <td>
                                                    <input type="text" name="s_date[]" class="form-control col-md-4 date-picker" placeholder="Start Date" value="'.@date_format(@date_create($row->start_date), 'Y-m-d').'">
                                                </td>
                                                <td>
                                                    <input type="text" name="e_date[]" class="form-control col-md-4 date-picker" placeholder="Expiry Date" value="'.@date_format(@date_create($row->expiry_date), 'Y-m-d').'">
                                                </td>
                                                <td>
                                                    <select class="form-control" name="status[]">
                                                        <option value="">Select Status..</option>
                                                        <option value="Signed" '.(($row->status == "Signed") ? "selected" : "").'>Signed</option>
                                                        <option value="Renewed on time" '.(($row->status == "Renewed on time") ? "selected" : "").'>Renewed on time</option>
                                                        <option value="Contract expired during this month" '.(($row->status == "Contract expired during this month") ? "selected" : "").'>Contract expired during this month</option>
                                                        <option value="Contract expired for more than a month" '.(($row->status == "Contract expired for more than a month") ? "selected" : "").'>Contract expired for more than a month</option>
                                                        <option value="Contract terminated during this month" '.(($row->status == "Contract terminated during this month") ? "selected" : "").'>Contract terminated during this month</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="next-step[]" class="form-control col-md-4" placeholder="Next Step"  value="'.$row->next_step.'">
                                                </td>
                                                <td>
                                                    <input type="text" name="remarks[]" class="form-control col-md-4" placeholder="Remarks"  value="'.$row->remarks.'">
                                                </td>
                                                <td><span class="fa fa-2x fa-close text-danger remove-line-edit remove-line" style="cursor: pointer;" data-pk="'.$row->team_line_id.'"></span></td>
                                            </tr>';
                                    }
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <td colspan="7">
                                <button class="btn btn-md btn-primary pull-right" id="proceed-update-client"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp; Save Changes</button>
                            </td>
                        </tfoot>
                    </table><hr>
                </div>
            </div>
        </div>
    </section>
</div>