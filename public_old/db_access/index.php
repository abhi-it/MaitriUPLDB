<?php
function adminer_object() {
    include_once "./plugin.php";
    include_once "./login-otp.php";
    
    $plugins = array(
        new AdminerLoginOtp(base64_decode('upT16VLbFZOMeA==')),
    );
    
    return new AdminerPlugin($plugins);
}

// store original adminer.php somewhere not accessible from web
include "./EwyYi4aRd5K]]4gd.php";