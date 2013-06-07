<?php
User::INIT();
if (!User::$LOGGED_USER->isloged) {
    ?>
    <script>
        window.location.href = "./admin-login/";
    </script>
    <?php
}
?>