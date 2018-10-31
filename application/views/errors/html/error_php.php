<!DOCTYPE html>
<html class="backend">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Something Went Wrong</title>
        <meta name="author" content="pampersdry.info">
        <meta name="description" content="Adminre is a clean and flat backend and frontend theme build with twitter bootstrap 3.1.1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/adminre/image/touch/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/adminre/image/touch/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/adminre/image/touch/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../assets/adminre/image/touch/apple-touch-icon-57x57-precomposed.png">
        <link rel="shortcut icon" href="../assets/adminre/image/favicon.ico">
        <link rel="stylesheet" href="../assets/adminre/library/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/adminre/stylesheet/layout.min.css">
        <link rel="stylesheet" href="../assets/adminre/stylesheet/uielement.min.css">
        <script src="../assets/adminre/library/modernizr/js/modernizr.min.js"></script>
    </head>
    <body>
        <section id="main" role="main">
            <section class="container animation delay animating fadeInDown">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3">
                        <div class="panel panel-minimal" style="margin-top:10%;">
                            <div class="panel-body text-center">
                                <i class="ico-database3 longshadow fsize112 text-default"></i>
                            </div>
                            <div class="panel-body text-center">
                                <h1 class="semibold longshadow text-center text-default fsize32 mb10 mt0">SOMETHING WHEN WRONG!!</h1>
                                <h4 class="semibold text-danger text-center nm">Unexpected condition was encountered...</h4><br>
                                <p class="semibold text-danger text-center nm">Severity: <?php echo $severity; ?></p>
								<p class="semibold text-danger text-center nm">Message:  <?php echo $message; ?></p>
								<p class="semibold text-danger text-center nm">Filename: <?php echo $filepath; ?></p>
								<p class="semibold text-danger text-center nm">Line Number: <?php echo $line; ?></p><br>
                            </div>
                            <div class="panel-body text-center">
                                <a href="#" id="return" class="btn btn-default mb5">Back To Dashboard</a>
                                <span class="semibold text-default hidden-xs">&nbsp;&nbsp;OR&nbsp;&nbsp;</span>
                                <a href="javascript:void(0);" class="btn btn-success mb5">Report This Problem</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
        <script type="text/javascript" src="../assets/adminre/library/jquery/js/jquery.min.js"></script>
        <script type="text/javascript" src="../assets/adminre/library/jquery/js/jquery-migrate.min.js"></script>
        <script type="text/javascript" src="../assets/adminre/library/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../assets/adminre/library/core/js/core.min.js"></script>
        <script type="text/javascript" src="../assets/adminre/plugins/sparkline/js/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="../assets/adminre/javascript/app.min.js"></script>
        <script type="text/javascript">
            $("#return").click(function(e){
                window.location = "../MainController";
            });
        </script>
    </body>
</html>