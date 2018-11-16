
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/select2/dist/css/select2.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/font-awesome/css/font-awesome.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/Ionicons/css/ionicons.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/datatables-bs/css/dataTables.bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-dialog/dist/css/bootstrap-dialog.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/alertify.min.css'); ?>"/>
        <link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/themes/default.min.css'); ?>"/>
        <link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/themes/semantic.min.css'); ?>"/>
        <link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/themes/bootstrap.min.css'); ?>"/> 
        <link rel="stylesheet" href="<?php echo base_url('assets/jquery-confirm/dist/jquery-confirm.min.css'); ?>"/> 
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/pace/pace.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/all.css'); ?>">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <style type="text/css">
            .text-center
            {
                text-align: center;
            }
            .pointer {
                cursor: pointer;
            }
            .scrollit 
            {
                width:100%;  
                overflow:auto;
            }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="<?php echo site_url(''); ?>" class="logo">
                    <span class="logo-mini"><b>IO</b>m</span>
                    <span class="logo-lg"><b>Infinit</b>-o</span>
                </a>
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo base_url('assets/dist/img/user2-160x160.jpg'); ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $session[md5('fullname')]; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <img src="<?php echo base_url('assets/dist/img/user2-160x160.jpg'); ?>" class="img-circle" alt="User Image">
                                        <p>
                                            <?php echo $session[md5('fullname')]." - ".$session[md5('position')]."<br>".$session[md5('location')];

                                            ?>
                                            <small><?php echo "Member since ".@date_format(@date_create($session[md5('hired_date')]), 'M d, Y'); ?></small>
                                        </p>
                                    </li>
                                    <!-- <li class="user-body">
                                        <div class="row">
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Followers</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Sales</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Friends</a>
                                            </div>
                                        </div>
                                    </li> -->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                          <a href="#" class="btn btn-default btn-flat" title="Settings"><i class="fa fa-cog"></i></a>
                                        </div>
                                        <div class="pull-right">
                                          <a href="<?php echo site_url('MainController/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                          <img src="<?php echo base_url('assets/dist/img/user2-160x160.jpg'); ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $session[md5('fullname')]; ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header">MAIN NAVIGATION</li>
                            <li <?php echo ($this->uri->segment(2) == "home" || $this->uri->segment(2) == "")? "class='active'" : "" ?>>
                                <a href="<?php echo site_url(); ?>">
                                    <i class="fa fa-th "></i> <span><?php echo ($this->uri->segment(2) == "home" || $this->uri->segment(2) == "")? "<b style='color:#00c0ef;'>Dashboard</b>" : "Dashboard" ?></span>
                                </a>
                            </li>
                            <li <?php echo ($this->uri->segment(2) == "userList" || $this->uri->segment(2) == "userModules")? "class='treeview active'" : "class='treeview'" ?>>
                                <a href="#">
                                    <i class="fa fa-user-secret"></i> <span><?php echo ($this->uri->segment(2) == "userList" || $this->uri->segment(2) == "userModules")? "<b style='color:#00c0ef;'>Admin</b>" : "Admin" ?></span>
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li <?php echo ($this->uri->segment(2) == "userList")? "class='active'" : "" ?>><a href="<?php echo site_url('AdminController/userList'); ?>"><i class="fa fa-circle-o"></i> Users</a></li>
                                    <li <?php echo ($this->uri->segment(2) == "userModules")? "class='active'" : "" ?>><a href="<?php echo site_url('AdminController/userModules'); ?>"><i class="fa fa-circle-o"></i>User Modules</a></li>
                                </ul>
                            </li>
                            <li  <?php echo ($this->uri->segment(2) == "client" || $this->uri->segment(2) == "addClient"  || $this->uri->segment(2) == "editClient" || $this->uri->segment(2) == "targetsAndActuals")? "class='active treeview'" : "class='treeview'" ?>>
                                <a href="#">
                                    <i class="fa fa-users"></i> <span><?php echo ($this->uri->segment(2) == "client"  || $this->uri->segment(2) == "addClient"  || $this->uri->segment(2) == "editClient" || $this->uri->segment(2) == "targetsAndActuals" )? "<b style='color:#00c0ef;'>Client</b>" : "Client" ?></span>
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li <?php echo ($this->uri->segment(2) == "client" || $this->uri->segment(2) == "editClient"  || $this->uri->segment(2) == "addClient")? "class='active'" : "" ?>><a href="<?php echo site_url('ClientController/client'); ?>"><i class="fa fa-circle-o"></i> Client List</a></li>
                                    <li <?php echo ($this->uri->segment(2) == "targetsAndActuals")? "class='active'" : "" ?>><a href="<?php echo site_url('ClientController/targetsAndActuals'); ?>"><i class="fa fa-circle-o"></i>Targets and Actuals</a></li>
                                </ul>
                            </li>
                            <li <?php echo ($this->uri->segment(2) == "userActivityLogs")? "class='active treeview'" : "class='treeview'" ?>>
                                <a href="#">
                                    <i class="fa fa-files-o"></i>
                                    <span><?php echo ($this->uri->segment(2) == "userActivityLogs")? "<b style='color:#00c0ef;'>Reports</b>" : "Reports" ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li <?php echo ($this->uri->segment(2) == "userActivityLogs")? "class='active'" : "" ?>><a href="<?php echo base_url("AdminReportsController/userActivityLogs"); ?>"><i class="fa fa-circle-o"></i>User Activity Logs</a></li>
                                </ul>
                            </li>
                            <!-- <li>
                                <a href="pages/widgets.html">
                                    <i class="fa fa-th"></i> <span>Widgets</span>
                                    <span class="pull-right-container">
                                      <small class="label pull-right bg-green">new</small>
                                    </span>
                                </a>
                            </li> -->
                        </li>
                    </ul>
                </section>
            </aside>
