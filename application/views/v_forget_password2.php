<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <script src="<?php echo base_url(); ?>http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/bootstraplogin.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/gubja.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/yaozl.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/style.css">
</head>
<body>

<div class="container">
    <div id="login" class="signin-card">
        <div class="logo-image">
            <img src="<?php echo base_url(); ?>asset/image/logosigma.png" style="height:60px;width:200px;">
        </div>
        <?php

        echo validation_errors();
        echo form_open('login/doforget');
        ?>

        <!--<h1 class="display1">Title</h1>
        <p class="subhead">Description</p>-->

        <h3>
            <p>
                Please input your new password.
            </p>
        </h3>
        <div id="form-login-username" class="form-group">
            <input type="hidden" name='EMAIL' id="EMAIL" value="<?php echo $email; ?>"/>
            <input id="NPASS" class="form-control" name="NPASS" type="password" size="18" alt="login" required />
            <span class="form-highlight"></span>
            <span class="form-bar"></span>
            <label for="username" class="float-label">Input your New Password.</label>
            <?php //echo $this->input->post('USER_NAME') ?>
        </div>
        <div id="form-login-username" class="form-group">
            <input id="CPASS" class="form-control" name="CPASS" type="password" size="18" alt="login" required />
            <span class="form-highlight"></span>
            <span class="form-bar"></span>
            <label for="username" class="float-label">Confirm New Password</label>
        </div>
        <button class="btn btn-block btn-info ripple-effect" style="background-color:#e74c3c;"type="submit" name="Submit">SUBMIT</button>



    </div>

</div>
</form>
</div>
</div>

<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/gubja.js"></script>
<script src="js/yaozl.js"></script>
<script src="js/index.js"></script>
</body>
</html>
