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
                        <button class="btn btn-sm btn-success pull-right" id="add-client" data-pk="add-new"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add Client</button>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped" >
                            <thead>
                                <tr style="background-color: #d7d7d8;">
                                    <th class="text-center">CLient</th>
                                    <th class="text-center">Reference</th>
                                    <th class="text-center">Industry</th>
                                    <th class="text-center">Back Office</th>
                                    <th class="text-center">Auth HC</th>
                                    <th class="text-center">F&A</th>
                                    <th class="text-center">HQ</th>
                                    <!-- <th class="text-center"></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if(!empty($clients))
                                    {
                                        foreach($clients as $row)
                                        {
                                            echo"<tr class='hover-tbl' title='Click to update this client'>
                                                    <td class='client-each' data-pk='".$row->team_id."'>".$row->team_name."</td>
                                                    <td class='client-each' data-pk='".$row->team_id."'>".$row->ref_no."</td>
                                                    <td class='client-each' data-pk='".$row->team_id."'>".$row->div_name."</td>
                                                    <td class='client-each' data-pk='".$row->team_id."'>".$row->back_office."</td>
                                                    <td class='client-each' data-pk='".$row->team_id."'>".$row->auth_hc."</td>
                                                    <td class='client-each' data-pk='".$row->team_id."'>".$row->F_and_a."</td>
                                                    <td class='client-each' data-pk='".$row->team_id."'>".$row->hq."</td>";
                                            echo"</tr>";
                                        }
                                    }
                                    // <td class='text-center'><button  data-pk='".$row->team_id."' class='add-target btn btn-sm btn-primary'><i class='fa fa-plus'></i>&nbsp; &nbsp; Add Target</button></td>
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>