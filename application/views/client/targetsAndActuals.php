<div class="content-wrapper">
    <section class="content-header" style="background-color: white; min-height: 55px;">
        <h1 style="font-family: Century Gothic; font-size:20px; color: #272727; font-weight: lighter;">
            List of Clients
            <small style="font-size: 12px;">Infinit-o</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary" >
                    <div class="box-header">
                        <button class="btn btn-sm btn-success pull-right" id="add-target"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Manage Target</button>
                    </div><hr>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped" >
                            <thead>
                                <tr style="background-color: #d7d7d8;">
                                    <th class="text-center">
                                        <select class="form-control select2">
                                        <?php 
                                            $current_year = @date('Y') - 1;
                                            for($i = 5; $i > 0; $i--)
                                            {
                                                echo"<option value='$current_year'>".$current_year." Actual</option>";
                                                $current_year--;
                                            }
                                        ?>
                                        </select>
                                    </th>
                                    <th class="text-center">Dec</th>
                                    <th class="text-center">Jan</th>
                                    <th class="text-center">Feb</th>
                                    <th class="text-center">Mar</th>
                                    <th class="text-center">Apr</th>
                                    <th class="text-center">May</th>
                                    <th class="text-center">Jun</th>
                                    <th class="text-center">Jul</th>
                                    <th class="text-center">Aug</th>
                                    <th class="text-center">Sep</th>
                                    <th class="text-center">Oct</th>
                                    <th class="text-center">Nov</th>
                                    <th class="text-center">Dec</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    // if(!empty($clients))
                                    // {
                                    //     foreach($clients as $row)
                                    //     {
                                    //         echo"<tr class='hover-tbl client-each' data-pk='".$row->team_id."' title='Click to update this client'>
                                    //                 <td>".$row->team_id." - ".$row->team_name."</td>
                                    //                 <td>".$row->ref_no."</td>
                                    //                 <td>".$row->div_name."</td>
                                    //                 <td>".$row->back_office."</td>
                                    //                 <td>".$row->auth_hc."</td>
                                    //                 <td>".$row->F_and_a."</td>
                                    //                 <td>".$row->hq."</td>";
                                    //         echo"</tr>";
                                    //     }
                                    // }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>