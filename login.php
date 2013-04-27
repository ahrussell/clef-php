<?php


    if (isset($_GET["code"]) && $_GET["code"] != "") {
        require_once("inc/clef.php");
        require_once("inc/common.php");
        require_once("inc/users.php");

        $code = $_GET["code"];

        $user_info = get_user_info($code);

        
        // if we found the user, log them in
        if ($user = find_user($user_info["id"])) {
            $_SESSION["uid"] = $user['id'];

            // send them to the member's area
            header("Location: http://pomonamocktrial.org/clef/members");
        } else {
            // register the user and log them in
            if(register_user($user_info)) {
                if ($user = find_user($user_info["id"])) {
                    $_SESSION["uid"] = $user['id'];

                    // send them to the member's area
                    header("Location: http://pomonamocktrial.org/clef/members");
                }
            } else {
                die("a helpful error message (aka check the mysql error logs)");
            }
        }

        
    }

?>