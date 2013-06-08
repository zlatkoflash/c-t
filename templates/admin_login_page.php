<?php if(!isset($_SESSION))session_start();?>

<?php
/*
  Template Name: Admin Login Page

 */
?>

<?php get_header(); ?>

<div id="adminSimpleUpdateForm" class="margin__0___AUTO width500PX borderGrayDotted colorBGWhite padding30px">
    <form action="<?php print SETTINGS::URL_TO_ADMIN_PAGE; ?>" id="form_submit_login" method="post" enctype="multipart/form-data">
        <input type="hidden" name="fst_try_to_login" value="yes" />
        <div class="marginBottom10px">
            User Name:<br />
            <input type="text" name="fsl_username" id="fsl_username" class=""  />
        </div>
        <div class="marginBottom10px">
            Password:<br />
            <input type="password" name="fsl_password" id="fsl_password" class="" />
        </div>
        <div>
            <input type="button" id="button_login" value="Login" />
        </div>
    </form>
</div>
<script>
    function LoginForm()
    {
        this.login = function()
        {
            $.post(settings.URL_TO_PHP_TOOLS,
                    {
                        TRY_TO_LOGIN: "TRY_TO_LOGIN",
                        user_login: $("#fsl_username").val(),
                        user_pass: $("#fsl_password").val()
                    }, function(data)
            {
                //alert(data);
                if (String(data + "").indexOf("login_all_right") != -1)
                {
                    //MenuAdmin.MA.submit_menu("<?php print PagesModerator::PAGE_ADMIN_DIRECTIONS; ?>");
                    window.location.href = "../admin-orders-navigator/";
                }
                else
                {
                    alert("Login incorect!");
                }
            });
        }
    }
    LoginForm.LF = new LoginForm();
    $("#button_login").click(function(e)
    {
        LoginForm.LF.login();
    });
</script>


<?php get_footer(); ?>