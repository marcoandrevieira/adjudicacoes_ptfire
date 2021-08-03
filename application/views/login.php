<!DOCTYPE html>
<html lang="pt-pt">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>PTFIRE | Adjudicações</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #1 for " name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo plugins_url(); ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo plugins_url(); ?>simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo plugins_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo plugins_url(); ?>bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo plugins_url(); ?>select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo plugins_url(); ?>select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo css_url(); ?>components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo css_url(); ?>plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo css_url(); ?>login-3.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="#" /> 
	</head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <img src="./recourses/images/logo/logo.png">
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" method="post" action="#">
                <h3 class="form-title">Login</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Insira um utilizador e uma password. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="email" /> </div>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
                </div>
                <div class="form-actions">
                   
                    <button type="submit" class="btn green pull-right"> Entrar </button>
                </div>
                
                <div class="forget-password">
                    <h4>Esquceu a sua password</h4>
                    <p> sem problema, clique
                        <a href="javascript:;" id="forget-password"> aqui </a> para criar uma nova password. </p>
                </div>
               
            </form>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form class="forget-form" action="#" method="post">
                <h3>Esqueceu a Password ?</h3>
                <p> Insiria o seu e-mail abaixo criar uma nova password. </p>
                <div class="form-group">
                    <div class="input-icon">
                        <i class="fa fa-envelope"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="recuperar_conta" /> </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn grey-salsa btn-outline"> Voltar </button>
                    <button type="submit" class="btn green pull-right"> Recuperar </button>
                </div>
            </form>
            <!-- END FORGOT PASSWORD FORM -->
          
        </div>
        <!-- END LOGIN -->
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script>let baseurl="<?php echo base_url(); ?>"</script>
        <script src="<?php echo plugins_url(); ?>jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo plugins_url(); ?>jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>select2/js/select2.full.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo scripts_url(); ?>app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        
        <script src="<?php echo scripts_url(); ?>login.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>
    </body>

</html>