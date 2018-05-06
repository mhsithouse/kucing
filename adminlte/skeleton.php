<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?=$title;?></title>
    <?=$metaKey;?>
    <?=$metaDescription;?>
   
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?=_THEMEPATH;?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
   
        <!-- font Awesome -->
        <link href="<?=_THEMEPATH;?>/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?=_THEMEPATH;?>/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?=_THEMEPATH;?>/css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?=_THEMEPATH;?>/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="<?=_THEMEPATH;?>/css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?=_THEMEPATH;?>/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?=_THEMEPATH;?>/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?=_THEMEPATH;?>/css/AdminLTE.css" rel="stylesheet" type="text/css" />
         <!-- jQuery 2.0.2 -->
       <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
          
        <style>
            .skin-blue .navbar {
                background-color: #31a3cc;
                
              }
              .skin-blue .logo{
                  background: #3ebeff url(<?=_SPPATH;?>images/tab_header.jpg) repeat-x bottom left;
                  font-family: verdana;
              }
              .skin-blue .logo:hover{
                  background: #3ebeff url(<?=_SPPATH;?>images/tab_header.jpg) repeat-x bottom left;
              }
         body > .header .logo {
          
            font-family: Verdana;
           
          }
          .content h1{
            margin: 0;
            font-size: 24px;
            padding: 0px;
            padding-bottom: 15px;
            border-bottom: 1px solid #dedede;
            margin-bottom: 20px;
          }
          .dropdown-menu{
              z-index:2000000000;
          }
          .form-group .col-sm-10{ padding-bottom: 10px;}
        </style>
<style>
#facebookG{
width:28px}

.facebook_blockG{
background-color:#FFFFFF;
border:1px solid #FFFFFF;
float:left;
height:20px;
margin-left:1px;
width:5px;
opacity:0.1;
-moz-animation-name:bounceG;
-moz-animation-duration:0.9s;
-moz-animation-iteration-count:infinite;
-moz-animation-direction:linear;
-moz-transform:scale(0.7);
-webkit-animation-name:bounceG;
-webkit-animation-duration:0.9s;
-webkit-animation-iteration-count:infinite;
-webkit-animation-direction:linear;
-webkit-transform:scale(0.7);
-ms-animation-name:bounceG;
-ms-animation-duration:0.9s;
-ms-animation-iteration-count:infinite;
-ms-animation-direction:linear;
-ms-transform:scale(0.7);
-o-animation-name:bounceG;
-o-animation-duration:0.9s;
-o-animation-iteration-count:infinite;
-o-animation-direction:linear;
-o-transform:scale(0.7);
animation-name:bounceG;
animation-duration:0.9s;
animation-iteration-count:infinite;
animation-direction:linear;
transform:scale(0.7);
}

#blockG_1{
-moz-animation-delay:0.27s;
-webkit-animation-delay:0.27s;
-ms-animation-delay:0.27s;
-o-animation-delay:0.27s;
animation-delay:0.27s;
}

#blockG_2{
-moz-animation-delay:0.36s;
-webkit-animation-delay:0.36s;
-ms-animation-delay:0.36s;
-o-animation-delay:0.36s;
animation-delay:0.36s;
}

#blockG_3{
-moz-animation-delay:0.45s;
-webkit-animation-delay:0.45s;
-ms-animation-delay:0.45s;
-o-animation-delay:0.45s;
animation-delay:0.45s;
}

@-moz-keyframes bounceG{
0%{
-moz-transform:scale(1.2);
opacity:1}

100%{
-moz-transform:scale(0.7);
opacity:0.1}

}

@-webkit-keyframes bounceG{
0%{
-webkit-transform:scale(1.2);
opacity:1}

100%{
-webkit-transform:scale(0.7);
opacity:0.1}

}

@-ms-keyframes bounceG{
0%{
-ms-transform:scale(1.2);
opacity:1}

100%{
-ms-transform:scale(0.7);
opacity:0.1}

}

@-o-keyframes bounceG{
0%{
-o-transform:scale(1.2);
opacity:1}

100%{
-o-transform:scale(0.7);
opacity:0.1}

}

@keyframes bounceG{
0%{
transform:scale(1.2);
opacity:1}

100%{
transform:scale(0.7);
opacity:0.1}

}

</style>
<style>
/* Fix menu positions on xs screens to appear correctly and fully */
@media screen and (max-width: 480px) {
  
  .navbar-nav > .messages-menu > .dropdown-menu {
    position: absolute;
    right: -110px;
    left: auto;
  }
}
</style>

         <? $this->getHeadfiles();?>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue" onload="pullContent2();">

        
<div id="loadingtop" style="display:none; opacity: 0.3; position: fixed; width:100%; top:40%;z-index:200000000;">
<div id="loadingtop2" style="text-align:center; padding: 10px; width:100px; border-radius:10px; color: white; background-color: #5c6e7d; font-weight: bold; margin:0 auto;">
<img style="margin-bottom:10px;" src="<?=_SPPATH;?>images/leaploader.gif"/>
<div><?=Lang::t('lang_loading');?></div>
</div>
</div>


<div id="oktop" style="display:none;opacity: 0.3; position: fixed; width:100%; top:40%;z-index:20000000;">
<div id="oktop2" style="text-align:center; padding: 10px; width:100px; border-radius:10px; color: white; background-color: #7db660; font-weight: bold; margin:0 auto;">
<img style="margin-bottom:10px;" src="<?=_SPPATH;?>images/ok.gif"/>
<div style='font-size:48px;'><?=Lang::t('OK');?></div>
</div>
</div>    

        <!-- header logo: style can be found in header.less -->
        <header class="header hidden-print">
            <div class="logo">
                <div style="position: absolute; top:-3px; left: 0; width: 50px; height: 50px; ">
                <img src="<?=_SPPATH;?>images/tab_icon.jpg">
                </div>
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Leap
            </div>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a id="toggleNav" href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span id="envelopebaloon" style="display:none;" class="label label-danger"></span>
                            </a>
                            <ul class="dropdown-menu" id="envelopeul">
                                <? 
                                $inbox = new Inboxweb();
                                $inbox->fillEnvelope();
                                ?>
                            </ul>
                        </li>
                        
                        <!-- Notifications: style can be found in dropdown.less -->
                        <?/*
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                                <span id="cb_baloon" style="display:none;" class="label label-warning"></span>
                            </a>
                            <ul class="dropdown-menu" id="cb_ul">
                                
                            </ul>
                        </li>*/?>
                        <? /*
                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                                <span class="label label-danger">9</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 9 tasks</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Design some buttons
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Create a nice theme
                                                    <small class="pull-right">40%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">40% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Some task I need to do
                                                    <small class="pull-right">60%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">60% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Make beautiful transitions
                                                    <small class="pull-right">80%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">80% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li>*/?>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?=Account::getMyName();?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    
                                    <div style="float:left; padding: 5px;">
                                        <? Account::makeMyFoto();?>
                                    </div>
                                    <div style="float:left; padding: 5px;">
                                        <?=Account::getMyName();?> - <?=Account::getMyRole();?>
                                        <small><?=date('l jS \of F Y h:i:s A',strtotime(Account::getMyLastUpdate()));?></small>
                                    </div>
                                </li>
                                <!-- Menu Body -->
                               <?/* <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li> */?>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" onclick="openProfile('<?=Account::getMyID();?>');" class="btn btn-default btn-flat"><?=Lang::t('Profile');?></a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?=_SPPATH;?>logout" class="btn btn-default btn-flat"><?=Lang::t('Sign Out');?></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li style="padding-top:15px; padding-left:5px;">
                            <div id="facebookG" style="display:none;">
                            <div id="blockG_1" class="facebook_blockG">
                            </div>
                            <div id="blockG_2" class="facebook_blockG">
                            </div>
                            <div id="blockG_3" class="facebook_blockG">
                            </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside id='leftMainmenu' class="left-side sidebar-offcanvas hidden-print">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image" onclick="openProfile('<?=Account::getMyID();?>');">
                            <? Account::makeMyFoto();?>
                        </div>
                        <div class="pull-left info" onclick="openProfile('<?=Account::getMyID();?>');">
                            <p><?=getNamaPendek(Account::getMyName());?></p>

                            
                        </div>
                    </div>
                   <? Mold::both("leftmenu");?>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                
                
                <!-- Main content -->
                <section class="content">
                    <div id="lw_content" class="row"></div>
                    <div id="content_utama">
                    <?=$content;?>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->
        <!-- modal container for preserving modal -->
        <div id="modalcontainer">
            
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body" id="myModalBody">
        
      </div>
      <div class="modal-footer" id="myModalFooter">
 
      </div>
    </div>
  </div>
</div>
            
        </div>

       
        <!-- jQuery UI 1.10.3 -->
        <script src="<?=_THEMEPATH;?>/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?=_THEMEPATH;?>/js/bootstrap.min.js" type="text/javascript"></script>
        
        <!-- Sparkline -->
        <script src="<?=_THEMEPATH;?>/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="<?=_THEMEPATH;?>/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="<?=_THEMEPATH;?>/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- fullCalendar -->
        <script src="<?=_THEMEPATH;?>/js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?=_THEMEPATH;?>/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="<?=_THEMEPATH;?>/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?=_THEMEPATH;?>/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?=_THEMEPATH;?>/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="<?=_THEMEPATH;?>/js/AdminLTE/app.js" type="text/javascript"></script>
        
        <script src="<?=_SPPATH;?>js/viel-windows-jquery.js?t=<?=time();?>"></script>

        <script src="<?=_SPPATH;?>js/holder.js"></script>
         <!-- Chart -->
        <script src="<?=_SPPATH;?>js/chart/Chart.js"></script>
		 <!-- Mansory -->
        <script src="<?=_THEMEPATH;?>/js/masonry.pkgd.min.js"></script>
        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-66177070-1', 'auto');
  ga('send', 'pageview');

</script>
    </body>
</html>