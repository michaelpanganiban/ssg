<div class="content-wrapper">
    <section class="content-header" style="background-color: white; min-height: 55px;">
        <h1 style="font-family: Century Gothic; font-size:20px; color: #272727; font-weight: lighter;">
            User Activity Logs
            <small style="font-size: 12px;">Infinit-o</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                       <!--  <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('assets/dist/img/carl.jpg');?>" alt="User profile picture"> -->
                        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('assets/dist/img/user3-128x128.jpg');?>" alt="User profile picture">
                        <h3 class="profile-username text-center"><?php echo $session[md5('fullname')]; ?></h3>
                        <p class="text-muted text-center"><?php echo $session[md5('position')]; ?></p>
                        <p class="text-muted text-center"><?php echo "Member since ".@date_format(@date_create($session[md5('hired_date')]), 'M d, Y'); ?></p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item" style="font-size: 20px;" >
                              <small>User logs</small><a class="pull-right" title="View all logs" href="#" ><?php $count = 36452; echo (($count > 1000) ? number_format(($count/1000),1)." k" : $count); ?></a>
                            </li>
                            <?php if($session[md5('is_admin')] == 1) { ?>
                                <li class="list-group-item" style="font-size: 20px;" >
                                  <small>User level</small><a class="pull-right">Admin</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php 
                    if($session[md5('is_admin')] == 1)
                    {
                        echo'<div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">System users</h3><a href="'.site_url("AdminController/userList").'" target="_blank" class="pull-right">View all ('; $count = sizeof($users); echo (($count > 1000) ? number_format(($count/1000),1)." k" : $count); echo')</a> 
                                </div>
                                <div class="box-body" style="cursor: pointer;">';
                                        if(!empty($users))
                                        {
                                            for($i = 0; $i < 6; $i++)
                                            {
                                                echo'<div data-pk="'.$users[$i]->emp_id.'"><strong><i class="fa fa-user"> '.ucfirst(strtolower($users[$i]->last_name)).", ".ucfirst(strtolower($users[$i]->first_name)).'</i></strong>
                                                    <p class="text-muted">'.ucfirst(strtolower($users[$i]->position)).'</p>
                                                    <hr></div>';
                                            }
                                        }
                            echo'</div>
                            </div>';
                    }
                ?>
                <center></center>
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <div class="tab-content">
                        <ul class="timeline timeline-inverse" id="append-logs">
                            <?php 
                                if(!empty($logs))
                                {
                                    foreach($logs['query1'] as $dates)
                                    {
                                        echo'<li class="time-label appendme">
                                                <span class="bg-green">'.@date_format(@date_create($dates->created), 'd M. Y').'</span>
                                            </li>';
                                        foreach($logs['query2'] as $row)
                                        {
                                            if($row->created == $dates->created)
                                            {
                                                echo'<li class="appendme">';
                                                    if(strtolower($row->action) == 'add')
                                                        echo'<i class="fa fa-plus bg-aqua"></i>';
                                                    else if(strtolower($row->action) == 'delete')
                                                        echo'<i class="fa fa-trash bg-red"></i>';
                                                    else if(strtolower($row->action) == 'edit')
                                                        echo'<i class="fa fa-edit bg-yellow"></i>';
                                                    else
                                                        echo'<i class="fa fa-o bg-blue"></i>';
                                                    echo'<div class="timeline-item">
                                                            <span class="time"><i class="fa fa-clock-o"></i> '.$row->time_log.'</span>
                                                            <h3 class="timeline-header no-border"><small style="font-family: Century Gothic; font-size:17px; color: #272727; font-weight: normal;">'.$row->log_details.'</small></h3>
                                                            <div class="timeline-body">
                                                                <h5><i class="fa  fa-thumb-tack"></i>  <b>Module: </b>'.$row->module.'</h5>
                                                                <h5><i class="fa  fa-home"></i>  <b>IP Address: </b>'.$row->ip_address.'</h5>
                                                            </div>
                                                        </div>
                                                    </li>';
                                            }
                                        }
                                    }
                                }
                            ?>
                            <li id="time">
                                <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                        </ul>
                        <br><hr>
                        <div id="footer-logs"></div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>