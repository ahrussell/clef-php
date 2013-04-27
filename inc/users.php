<?php
    require_once("mysql.php");
    require_once("constants.php");

    // looks up a user in the database given some parameters
    function find_user($clef_id=NULL, $id=NULL, $name=NULL, $phone=NULL, $email=NULL) {

        $where = "";

        // build where statement
        if($clef_id) {
            $where .= "clef_id=".mysql::escStr($clef_id);
        }

        if($id) {
            if(strlen($where) !== 0)
                $where .= " AND ";

            $where .= " id=".mysql::escStr($id);
        }

        if($name) {
            if(strlen($where) !== 0)
                $where .= " AND ";

            $where .= " name='".mysql::escStr($name)."'";
        }

        if($phone) {
            if(strlen($where) !== 0)
                $where .= " AND ";

            $where .= "phone='".mysql::escStr($clef_id)."'";
        }

        if($email) {
            if(strlen($where) !== 0)
                $where .= " AND ";

            $where .= "email='".mysql::escStr($email)."'";
        }

        // select user

        $query = "SELECT * FROM " . DB_NAME . ".users WHERE ".$where;

        if($result = mysql::query($query)) {
            if(mysql::num_rows($result) == 0)
                return false;
            else
                return mysql::fetch($result);
        }
    }

    function register_user($user_info) {

        $name = mysql::escStr($user_info["first_name"] . " " . $user_info["last_name"]);
        $phone = mysql::escStr($user_info["phone_number"]);
        $clef_id = mysql::escStr($user_info["id"]);
        $email = mysql::escStr($user_info["email"]);

        $query = "INSERT INTO " . DB_NAME . ".users (name, phone, clef_id, email) VALUES ('{$name}','{$phone}','{$clef_id}','{$email}')";

        if($result = mysql::query($query))
            return true;
        else
            return false;
    }
?>