<?php

 if(isset($_GET['msg'])){ $msg = $_GET['msg']; }
        ?>

        
<form class="form-signin" role="form" action="<?=_SPPATH;?>login?setlang=en" method="post" id="loginform" name="loginform">
    
<div class="row" style="margin-bottom: 20px;">
    <span class="col-xs-10 col-xs-offset-1 col-md-12 col-md-offset-0">
    <img src="<?=_SPPATH."images/leap_logo.png";?>" alt="LEAP eLearning" class="img-responsive">
    </span>
</div>
<? if(isset($msg)){ ?>
    <div class="row" style="margin-bottom: 20px;">
        <span class="col-md-12" style="text-align: center;">
            <div class="alert alert-danger" role="alert">
            <?=$msg;?>
            </div>
        </span>
    </div>
<? } ?>    
<select name="sekolah" class="form-control">
    <option value="mhssd">Primary School</option>
</select>    
<input id="user_login" type="text" name="admin_username" class="form-control" placeholder="Username" required autofocus>
<input id="user_pass" type="password" name="admin_password" class="form-control" placeholder="Password" required>
<label class="checkbox">
<input type="checkbox" value="1" id="rememberme" name="rememberme">  <?=Lang::t('rememberme');?>
</label>
<button class="btn btn-lg btn-primary btn-block" type="submit"><?=Lang::t("submit");?></button>
</form>
<?
