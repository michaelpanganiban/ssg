<div class="content-wrapper">
    <section class="content-header" style="background-color: white; min-height: 55px;">
        <h1 style="font-family: Century Gothic; font-size:20px; color: #272727; font-weight: lighter;">
            User Assigned Modules
            <small style="font-size: 12px;">User restriction and access</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success" >
                    <div class="box-header">
                        <!-- <button class="btn btn-sm btn-success pull-right" id="add-user"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add user</button> -->
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#user-modules" data-toggle="tab">User Modules</a></li>
                                    <li><a href="#user-access" data-toggle="tab">User Access</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="active tab-pane" id="user-modules">
                                        <div class="row">
                                            <div class="form-group  col-sm-3 col-sm-offset-4" style="text-align: center;">
                                                <select class="form-control select2" id="user-list"  >
                                                    <option value="">Select user..</option>
                                                    <?php 
                                                        foreach($users as $row)
                                                        {
                                                            echo"<option value='".$row->emp_id."'>".$row->last_name.", ".$row->first_name."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-8 col-sm-offset-2">
                                                <table id="example1" class="table table-bordered table-striped"> 
                                                    <thead>
                                                        <tr style="background-color: #d7d7d8;">
                                                            <th class="text-center" width="40%;">Parent Module</th>
                                                            <th class="text-center">Module</th>
                                                            <th class="text-center"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="append-modules"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="tab-pane" id="user-access">
                                        <table class="table table-bordered table-striped data-table">
                                            <thead>
                                                <tr style="background-color: #d7d7d8;">
                                                    <th class="text-center">Fullname</th>
                                                    <th class="text-center">Position</th>
                                                    <th class="text-center">Module</th>
                                                    <th class="text-center">View</th>
                                                    <th class="text-center">Update</th>
                                                    <th class="text-center">Add</th>
                                                    <th class="text-center">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    if(!empty($user_modules))
                                                    {
                                                        foreach($user_modules as $row)
                                                        {
                                                            echo"<tr>
                                                                    <td>".$row->last_name.", ".$row->first_name."</td>
                                                                    <td>".$row->position."</td>
                                                                    <td>".ucfirst($row->module_name)."</td>";
                                                                    if($row->view == 1)
                                                                        echo"<td class='text-center'><input  type='checkbox' class='minimal update-access' data-value='view' checked data-pk='".$row->id."' data-module='".$row->module_name."'  data-emp='".$row->last_name.", ".$row->first_name."'></td>";
                                                                    else
                                                                        echo"<td class='text-center'><input  type='checkbox' class='minimal update-access' data-value='view' data-pk='".$row->id."' data-module='".$row->module_name."'  data-emp='".$row->last_name.", ".$row->first_name."'></td>";
                                                                    if($row->edit == 1)
                                                                        echo"<td class='text-center'><input  type='checkbox' class='minimal update-access' data-value='edit' checked data-pk='".$row->id."' data-module='".$row->module_name."'  data-emp='".$row->last_name.", ".$row->first_name."'></td>";
                                                                    else
                                                                        echo"<td class='text-center'><input  type='checkbox' class='minimal update-access' data-value='edit' data-pk='".$row->id."' data-module='".$row->module_name."'  data-emp='".$row->last_name.", ".$row->first_name."'></td>";
                                                                    if($row->add == 1)
                                                                        echo"<td class='text-center'><input  type='checkbox' class='minimal update-access' data-value='add' checked data-pk='".$row->id."' data-module='".$row->module_name."'  data-emp='".$row->last_name.", ".$row->first_name."'></td>";
                                                                    else
                                                                        echo"<td class='text-center'><input  type='checkbox' class='minimal update-access' data-value='add' data-pk='".$row->id."' data-module='".$row->module_name."'  data-emp='".$row->last_name.", ".$row->first_name."'></td>";
                                                                    if($row->delete == 1)
                                                                        echo"<td class='text-center'><input  type='checkbox' class='minimal update-access' data-value='delete' checked data-pk='".$row->id."' data-module='".$row->module_name."'  data-emp='".$row->last_name.", ".$row->first_name."'></td>";
                                                                    else
                                                                        echo"<td class='text-center'><input  type='checkbox' class='minimal update-access' data-value='delete' data-pk='".$row->id."' data-module='".$row->module_name."'  data-emp='".$row->last_name.", ".$row->first_name."'></td>";
                                                            echo"</tr>";
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
                </div>
            </div>
        </div>
    </section>
</div>