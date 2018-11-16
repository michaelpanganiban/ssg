<div class="content-wrapper">
    <section class="content-header" style="background-color: white; min-height: 55px;">
        <h1 style="font-family: Century Gothic; font-size:20px; color: #272727; font-weight: lighter;">
            Add New Client
            <small style="font-size: 12px;">Infinit-o</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary" >
                    <div class="box-header">
                        <small style="font-family: Century Gothic; font-size:20px; color: #272727; font-weight: lighter;">Basic Information</small><hr>
                    </div>
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
                                <div class='col-md-8 '>
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
                                <label class='control-label col-md-4'>What you do? :</label>
                                <div class='col-md-8'>
                                    <textarea id='job-desc' class='form-control' rows='5' placeholder="Describe what you do.."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-header">
                        <small style="font-family: Century Gothic; font-size:20px; color: #272727; font-weight: lighter;">Contract Information</small><hr>
                    </div>
                    <div class="scrollit">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Contract</th>
                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">Expiry Date</th>
                                    <th class="text-center">Headcount</th>
                                    <th class="text-center">Remarks</th>
                                    <th class="text-center">Attachment</th>
                                </tr>
                            </thead>
                            <tbody id="append-client-line">
                                <tr class="client-line">
                                    <td  class="text-center">
                                        <input type="text" id="contract" class="form-control col-md-4" placeholder="Contract" data-pk="0">
                                    </td>
                                    <td  class="text-center">
                                        <input type="text" id="s_date" class="form-control col-md-4 date-picker" placeholder="Start Date">
                                    </td>
                                    <td  class="text-center">
                                        <input type="text" id="e_date" class="form-control col-md-4 date-picker" placeholder="Expiry Date">
                                    </td>
                                    <td  class="text-center">
                                        <input type="number" id="headcount" placeholder="Headcount" readonly="true" class="form-control">
                                    </td>
                                    <td  class="text-center">
                                        <textarea class="form-control" id="remarks" rows="1" placeholder="Say something about this.."></textarea>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn btn-default btn-file">
                                            <i class="fa fa-paperclip"></i> <medium id="file-name">Supporting Document</medium>
                                            <input type="file" name="sup_doc" id="attachment">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-header">
                        <small style="font-family: Century Gothic; font-size:20px; color: #272727; font-weight: lighter;">Functions Information</small><hr>
                    </div>
                    <div class="scrollit">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Current Function</th>
                                    <th class="text-center">Billed HC</th>
                                    <th class="text-center">Cost Per Title</th>
                                    <th class="text-center">Total Cost</th>
                                    <th class="text-center">Hours of Work</th>
                                    <th class="text-center">Timezone</th>
                                    <th class="text-center">Shift</th>
                                    <th class="text-center">Location</th>
                                    <th class="text-center"><i class="fa fa-plus-circle fa-2x text-success" style="cursor: pointer;" id="add-column-target"></i></th>
                                </tr>
                            </thead>
                            <tbody id="target-data">
                                <tr class="target-clone">
                                    <td>
                                        <select class="form-control functions" id="func-1" data-pk="1" name="functions[]">
                                            <option value="">Select Current Function..</option>
                                            <option value="add">Add new function</option>
                                            <?php 
                                                if(!empty($function))
                                                {
                                                    foreach($function as $row)
                                                    {
                                                        echo"<option value='".$row->joborder_id."'>".$row->title."</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="billed[]" class="form-control billed">
                                    </td>
                                    <td class="cost-td">
                                        <input type="number" class="form-control cost" name="cost[]">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control ttl-cost" readOnly name="ttl-cost[]">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control " name="hours[]">
                                    </td>
                                    <td>
                                        <select class="form-control" name="timezone[]">
                                            <option value="">Select timezone..</option>
                                            <option value="US">US</option>
                                            <option value="Manila">Manila</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control " name="shift[]">
                                            <option value="">Select shift..</option>
                                            <option value="Night">Night</option>
                                            <option value="Day">Day</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="location[]">
                                            <option value="">Select Location..</option>
                                            <option value="Makati">Makati</option>
                                            <option value="Legazpi">Legazpi</option>
                                        </select>
                                    </td>
                                    <td>
                                        <i class="fa fa-close fa-2x remove-target text-danger" style="cursor:pointer;"></i>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <td colspan="9">
                                    <br>
                                    <button class="btn btn-md btn-primary col-md-offset-11" id="proceed-add-client"><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;&nbsp; Proceed</button>
                                </td>
                            </tfoot>
                        </table>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </section>
</div>