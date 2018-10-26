<?php 
    $data = array();
    foreach($clients as $row)
    {
        $true = 0; $jan = 0; $feb = 0; $mar = 0; $apr = 0; $may = 0; $jun = 0; $jul = 0; $aug = 0; $sep = 0; $oct = 0; $nov = 0; $dec = 0; $total = 0; $prev_total = 0;
        foreach($current as $row_prev)
        {
            if($row->team_id == $row_prev->team_id)
            {
                $true = 1;
                $prev_total = $row_prev->January + $row_prev->February + $row_prev->March + $row_prev->April + $row_prev->May + $row_prev->June + $row_prev->July + $row_prev->August + $row_prev->September + $row_prev->October + $row_prev->November + $row_prev->December;
                foreach($targets as $row_list)
                {
                    if($row->team_id == $row_list->team_id)
                    {
                        $jan += $row_list->January;
                        $feb += $row_list->February;
                        $mar += $row_list->March;
                        $apr += $row_list->April;
                        $may += $row_list->May;
                        $jun += $row_list->June;
                        $jul += $row_list->July;
                        $aug += $row_list->August;
                        $sep += $row_list->September;
                        $oct += $row_list->October;
                        $nov += $row_list->November;
                        $dec += $row_list->December;
                    }
                }
            }
        }
        if($true == 1)
        {
            $total += $jan + $feb + $mar + $apr + $may + $jun + $jul + $aug + $sep + $oct + $nov + $dec + $prev_total;
            $temp = array(
                            'client'     => $row->team_name,
                            'January'    => $jan,
                            'February'   => $feb,
                            'March'      => $mar,
                            'April'      => $apr,
                            'May'        => $may,
                            'June'       => $jun,
                            'July'       => $jul,
                            'August'     => $aug,
                            'September'  => $sep,
                            'October'    => $oct,
                            'November'   => $nov,
                            'December'   => $dec, 
                            'total'      => $total,
                            'prev_total' => $prev_total,
                            'team_id'    => $row->team_id
                        );
            array_push($data, $temp);
        }
    }
?>

<div class="content-wrapper">
    <section class="content-header" style="background-color: white; min-height: 55px;">
        <h1 style="font-family: Century Gothic; font-size:20px; color: #272727; font-weight: lighter;">
            Targets and Actuals
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
                                    <th class="text-center"><?php echo @date('Y'). " Actual"; ?></th>
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
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $total_current = 0; $t_jan = 0; $t_feb = 0; $t_mar = 0; $t_apr = 0; $t_may = 0; $t_jun = 0; $t_jul = 0; $t_aug = 0; $t_sep = 0; $t_oct = 0; $t_nov = 0; $t_dec = 0; $overall_total = 0;
                                    if(!empty($data))
                                    {
                                        for($i = 0; $i < sizeof($data); $i++)
                                        {
                                            $total_current += $data[$i]['prev_total'];
                                            $t_jan         += $data[$i]['January'];
                                            $t_feb         += $data[$i]['February'];
                                            $t_mar         += $data[$i]['March'];
                                            $t_apr         += $data[$i]['April'];
                                            $t_may         += $data[$i]['May'];
                                            $t_jun         += $data[$i]['June'];
                                            $t_jul         += $data[$i]['July'];
                                            $t_aug         += $data[$i]['August'];
                                            $t_sep         += $data[$i]['September'];
                                            $t_oct         += $data[$i]['October'];
                                            $t_nov         += $data[$i]['November'];
                                            $t_dec         += $data[$i]['December'];
                                            $overall_total += $data[$i]['total'];
                                            echo"<tr class='hover-tbl target-each' data-name='".$data[$i]['client']."' data-pk='".$data[$i]['team_id']."' title='Click to view details'>";
                                                    echo"<td>".$data[$i]['client']."</td>";
                                                    echo"<td class='text-center'>".$data[$i]['prev_total']."</td>";
                                                    echo"<td class='text-center' ".(($data[$i]['January'] < 0) ? "style='color:red;'" : "").">".(($data[$i]['January'] == 0)? "" : $data[$i]['January'])."</td>";
                                                    echo"<td class='text-center' ".(($data[$i]['February'] < 0) ? "style='color:red;'" : "").">".(($data[$i]['February'] == 0)? "" : $data[$i]['February'])."</td>";
                                                    echo"<td class='text-center' ".(($data[$i]['March'] < 0) ? "style='color:red;'" : "").">".(($data[$i]['March'] == 0)? "" : $data[$i]['March'])."</td>";
                                                    echo"<td class='text-center' ".(($data[$i]['April'] < 0) ? "style='color:red;'" : "").">".(($data[$i]['April'] == 0)? "" : $data[$i]['April'])."</td>";
                                                    echo"<td class='text-center' ".(($data[$i]['May'] < 0) ? "style='color:red;'" : "").">".(($data[$i]['May'] == 0)? "" : $data[$i]['May'])."</td>";
                                                    echo"<td class='text-center' ".(($data[$i]['June'] < 0) ? "style='color:red;'" : "").">".(($data[$i]['June'] == 0)? "" : $data[$i]['June'])."</td>";
                                                    echo"<td class='text-center' ".(($data[$i]['July'] < 0) ? "style='color:red;'" : "").">".(($data[$i]['July'] == 0)? "" : $data[$i]['July'])."</td>";
                                                    echo"<td class='text-center' ".(($data[$i]['August'] < 0) ? "style='color:red;'" : "").">".(($data[$i]['August'] == 0)? "" : $data[$i]['August'])."</td>";
                                                    echo"<td class='text-center' ".(($data[$i]['September'] < 0) ? "style='color:red;'" : "").">".(($data[$i]['September'] == 0)? "" : $data[$i]['September'])."</td>";
                                                    echo"<td class='text-center' ".(($data[$i]['October'] < 0) ? "style='color:red;'" : "").">".(($data[$i]['October'] == 0)? "" : $data[$i]['October'])."</td>";
                                                    echo"<td class='text-center' ".(($data[$i]['November'] < 0) ? "style='color:red;'" : "").">".(($data[$i]['November'] == 0)? "" : $data[$i]['November'])."</td>";
                                                    echo"<td class='text-center' ".(($data[$i]['December'] < 0) ? "style='color:red;'" : "").">".(($data[$i]['December'] == 0)? "" : $data[$i]['December'])."</td>";
                                                    echo"<td class='text-center' ".(($data[$i]['total'] < 0) ? "style='color:red;'" : "").">". $data[$i]['total']."</td>";
                                            echo"</tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr style="background-color: #d7d7d8;">
                                    <th class="text-center">Total</th>
                                    <th class="text-center"><?php echo $total_current; ?></th>
                                    <th class="text-center"><?php echo $t_jan; ?></th>
                                    <th class="text-center"><?php echo $t_feb; ?></th>
                                    <th class="text-center"><?php echo $t_mar; ?></th>
                                    <th class="text-center"><?php echo $t_apr; ?></th>
                                    <th class="text-center"><?php echo $t_may; ?></th>
                                    <th class="text-center"><?php echo $t_jun; ?></th>
                                    <th class="text-center"><?php echo $t_jul; ?></th>
                                    <th class="text-center"><?php echo $t_aug; ?></th>
                                    <th class="text-center"><?php echo $t_sep; ?></th>
                                    <th class="text-center"><?php echo $t_oct; ?></th>
                                    <th class="text-center"><?php echo $t_nov; ?></th>
                                    <th class="text-center"><?php echo $t_dec; ?></th>
                                    <th class="text-center"><?php echo $overall_total; ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>