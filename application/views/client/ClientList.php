<?php 
    if(!empty($user_modules))
    {
        foreach($user_modules as $row)
        {
            if($row->module_name == 'client list')
            {
                $view   = $row->view;
                $add    = $row->add;
                $edit   = $row->edit;
                $delete = $row->delete;
            }
            else if($row->module_name == 'add client')
            {
                $view2   = $row->view;
                $add2    = $row->add;
                $edit2   = $row->edit;
                $delete2 = $row->delete;
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
            List of Clients
            <small style="font-size: 12px;">Infinit-o</small>
        </h1>
    </section>
    <section class="content">
        <div class="row"   >
            <div class="col-xs-12" >
                <div class="box box-primary" style='overflow: auto;'>
                    <div class="box-header">
                    <?php 
                        if($add2 == 1)
                            echo'<button class="btn btn-sm btn-success pull-right" id="add-client" data-pk="add-new"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add Client</button>';
                    ?>
                    </div>
                    <div style='width:99%;'>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr style="background-color: #d7d7d8;">
                                        <th class="text-center">CLient</th>
                                        <th class="text-center">Reference</th>
                                        <th class="text-center">Industry</th>
                                        <!-- <th class="text-center">Back Office</th> -->
                                        <th class="text-center">Auth HC</th>
                                        <!-- <th class="text-center">F&A</th> -->
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
                                                $hc = 0;
                                                foreach($headcount as $hc_row)
                                                {
                                                    if($hc_row->client_id == $row->client_id)
                                                        $hc = $hc_row->headcount;
                                                }
                                                $class = "";
                                                if($edit == 1)
                                                    $class= "class='client-each'";
                                                echo"<tr class='hover-tbl' title='Click to update this client'>
                                                        <td ".$class." data-pk='".$row->client_id."'>".$row->client_name."</td>
                                                        <td ".$class." data-pk='".$row->client_id."'>".$row->ref_no."</td>
                                                        <td ".$class." data-pk='".$row->client_id."'>".$row->div_name."</td>";
                                                    if($hc <= 0)
                                                        echo"<td></td>";
                                                    else
                                                        echo"<td align='right' ".$class." data-pk='".$row->client_id."'>".number_format($hc)."</td>";
                                                    echo"<td ".$class." data-pk='".$row->client_id."'>".$row->hq."</td>";
                                                echo"</tr>";
                                            }
                                        }
                                        // <td ".$class." data-pk='".$row->team_id."'>".$row->back_office."</td>
                                        // <td ".$class." data-pk='".$row->team_id."'>".$row->F_and_a."</td>
                                        // <td class='text-center'><button  data-pk='".$row->team_id."' class='add-target btn btn-sm btn-primary'><i class='fa fa-plus'></i>&nbsp; &nbsp; Add Target</button></td>
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