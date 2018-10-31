<div class="content-wrapper">
    <section class="content-header" style="background-color: white; min-height: 55px;">
        <h1 style="font-family: Century Gothic; font-size:20px; color: #272727; font-weight: lighter;">
            Add New Client
            <small style="font-size: 12px;">Infinit-o</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary" >
                    <div class="box-header">
                        <!-- <button class="btn btn-sm btn-success pull-right" id="add-client"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Button</button> -->
                    </div><hr>
                    <div class="box-body">
                        <div class='row'>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Client Name:</label>
                                <div class='col-md-6'>
                                    <input type='text' class='form-control' id='client-name' placeholder="Sample client name">
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
                                                    echo"<option value='".$row->div_id."'>".$row->div_name."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Address</label>
                                <div class='col-md-8'>
                                    <input type='text' class='form-control' id='client-address' placeholder="Client Address" >
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Customer Experience:</label>
                                <div class='col-md-8'>
                                    <input type='text' class='form-control' id='customer-exp' placeholder="Customer Experience">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Back Office:</label>
                                <div class='col-md-8'>
                                    <input type='text' class='form-control' id='back-office' placeholder="Back Office">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>F&A:</label>
                                <div class='col-md-8'>
                                    <input type="text" class="form-control" placeholder ="F&A" id="fa">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Headquarter:</label>
                                <div class='col-md-8'>
                                    <input type="text" class="form-control" name="Headquarter" id="hq" placeholder="Headquarter">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Auth HC:</label>
                                <div class='col-md-8'>
                                    <input type="number" class="form-control" id="hc" placeholder="Auth Head Count">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Tier:</label>
                                <div class='col-md-8'>
                                    <select class='select2 col-md-12' id="tier" data-live-search='true'>
                                        <option value="">Select Tier..</option>
                                        <option value="G">G</option>
                                        <option value="P">P</option>
                                        <option value="S">S</option>          
                                    </select>
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Case Study:</label>
                                <div class='col-md-8'>
                                    <input type="text" class="form-control" id="case-study" placeholder="Case Study">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Visit:</label>
                                <div class='col-md-8'>
                                    <input type="text" class="form-control" id="visit" placeholder="Visit">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Target Market:</label>
                                <div class='col-md-8'>
                                    <input type="text" class="form-control" id="target-market" placeholder="Target Market">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Segment:</label>
                                <div class='col-md-8'>
                                    <textarea id='segment' class='form-control' rows='5' placeholder="Segment.."></textarea>
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label class='control-label col-md-4'>Job Description:</label>
                                <div class='col-md-8'>
                                    <textarea id='job-desc' class='form-control' rows='5' placeholder="Describe what you do.."></textarea>
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
                                <th><span class="fa fa-2x fa-plus text-primary" style="cursor: pointer;" title="add set" id="table-add"></span></th>
                            </tr>
                        </thead>
                        <tbody id="append-client-line">
                            <tr class="client-line">
                                <td>
                                    <input type="text" name="annex[]" class="form-control col-md-4" placeholder="Annex" data-pk="0">
                                </td>
                                <td>
                                    <input type="text" name="s_date[]" class="form-control col-md-4 date-picker" placeholder="Start Date">
                                </td>
                                <td>
                                    <input type="text" name="e_date[]" class="form-control col-md-4 date-picker" placeholder="Expiry Date">
                                </td>
                                <td>
                                    <select class="form-control" name="status[]">
                                        <option value="Signed">Signed</option>
                                        <option value="Renewed on time">Renewed on time</option>
                                        <option value="Contract expired during this month">Contract expired during this month</option>
                                        <option value="Contract expired for more than a month">Contract expired for more than a month</option>
                                        <option value="Contract terminated during this month">Contract terminated during this month</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="next-step[]" class="form-control col-md-4" placeholder="Next Step">
                                </td>
                                <td>
                                    <input type="text" name="remarks[]" class="form-control col-md-4" placeholder="Remarks">
                                </td>
                                <td><span class="fa fa-2x fa-close text-danger remove-line" style="cursor: pointer;"></span></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <td colspan="7">
                                <button class="btn btn-md btn-primary pull-right" id="proceed-add-client"><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;&nbsp; Proceed</button>
                            </td>
                        </tfoot>
                    </table><hr>
                </div>
            </div>
        </div>
    </section>
</div>