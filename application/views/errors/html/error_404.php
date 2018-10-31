
<!DOCTYPE html>
<html class="backend">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Error 404 - Page Not Found</title>
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
                                <i class="ico-file-remove2 longshadow fsize112 text-default"></i>
                            </div>
                            <div class="panel-body text-center">
                                <h1 class="semibold longshadow text-center text-default fsize32 mb10 mt0">WHOOPS!!</h1>
                                <h4 class="semibold text-primary text-center nm">The page you're looking for does not exits...</h4>
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