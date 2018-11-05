<div class="content-wrapper">
    <section class="content-header" style="background-color: white; min-height: 55px;">
        <h1 style="font-family: Century Gothic; font-size:20px; color: #272727; font-weight: lighter;">
            List of Users
            <small style="font-size: 12px;">SSG granted access</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary" >
                    <div class="box-header">
                        <button class="btn btn-sm btn-success pull-right" id="add-user"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add user</button>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped" >
                            <thead>
                                <tr style="background-color: #d7d7d8;">
                                    <th class="text-center">Employee ID</th>
                                    <th class="text-center">Employee Name</th>
                                    <th class="text-center">Position</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Location</th>
                                    <th class="text-center">Status</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if(!empty($users))
                                    {
                                        foreach($users as $row)
                                        {
                                            echo"<tr class='hover-tbl'>
                                                    <td class='text-center'>".$row->emp_id."</td>
                                                    <td class='text-center'>".$row->first_name." ".$row->last_name."</td>
                                                    <td class='text-center'>".$row->position."</td>
                                                    <td class='text-center'>".$row->infinit_email."</td>
                                                    <td class='text-center'>".$row->work_location."</td>
                                                    <td class='text-center'>".(($row->status == 1)? "<span class='badge bg-green'>Active</span>" : "<span class='badge bg-red'>Inactive</span>")."</td>";
                                                    if($row->emp_id == $session['emp_id'])
                                                        echo"<td class='text-center'></td>";
                                                    else if($row->status == 0)
                                                        echo"<td class='text-center'><button data-pk='".$row->auth_id."' title='Grant access' class='btn btn-sm btn-primary grant-access'><i class='fa fa-check'></i></button></td>";
                                                    else 
                                                        echo"<td class='text-center'><button data-pk='".$row->auth_id."' title='Remove access' class='remove-grant btn btn-sm btn-danger'><i class='fa fa-close' ></i></button></td>";
                                                    if($row->emp_id == $session['emp_id'])
                                                        echo"<td class='text-center'></td>";
                                                    else
                                                        echo"<td class='text-center'><i class='fa fa-trash text-danger delete-user' data-pk='".$row->auth_id."'></i></td>";
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
    </section>
</div>