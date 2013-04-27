<?php
    
    require_once("inc/common.php");

    // if the user is not logged in, return them to the homepage
    if (!isset($_SESSION["uid"])) {
        header("Location: http://pomonamocktrial.org/clef/");
    }
        
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Bridges Consulting Group</title>

        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

        <link href="css/styles.css" rel="stylesheet" type="text/css">
        <link href="css/members.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <!--<link rel="stylesheet" type="text/css" href="bootstrap/darkstrap.css">!-->
        
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>

        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

    </head>

    <body>
        <div class="container">
            <div class="row" id="logo">
                <div class="span8">
                    <a href="./"><img src="img/logo.png"></a>
                </div>
                
                <div class="span4">
                    <div class="container-fluid">
                        <div class="row-fluid">
                            <div class="span6" style="align: right;">
                                <ul class="nav nav-pills nav-stacked" style="width: 73%;">

                                    <li class="active">
                                        <a href="./">Home</a>
                                      </li>
                                      <li><a href="partners">Partners</a></li>
                                </ul>
                            </div>

                            <div class="span6" style="align: right;">
                                <ul class="nav nav-pills nav-stacked" style="width: 73%;">

                                    <li>
                                        <a href="clients">Clients</a>
                                      </li>
                                      <li><a href="advisors">Advisors</a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row" id="body">
                <div class="span11">
                        <h1>Member Directory</h1>

                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                        </tr>

                        <?php
                            $users = get_users();
                            $k = 1;

                            // list users - the current user will be listed as "You" rather than "Joe Plumber"
                            foreach($users as $user) { ?>
                                <tr class="<?=$user['id'] == $_SESSION['uid'] ? 'info' : '';?>"> 
                                    <td><?=$k++;?></td>

                                    <?php if($user['id'] == $_SESSION['uid']) { ?>
                                        <td>You</td>
                                    <?php } else { ?>
                                        <td><?=$user["name"];?></td>
                                    <?php } ?>

                                    <td><?=$user["phone"];?></td>

                                    <td><?=$user["email"];?></td>

                                </tr>
                            <?php } ?>
                    </table>
                </div>
            </div>

            <div class="row" id="footer">
                <div class="span12">
                    <p style="vertical-align:middle; margin-right: 10px;">Bridge Consulting &copy; 2013</p>
                </div>
            </div>
        </div>

    </body>
</html>

<?php

    function get_users() {
        require_once("inc/mysql.php");

        $query = "SELECT id, name, phone, email FROM " . DB_NAME . ".users";

        if($result = mysql::query($query)) {

            $users = array();

            while (($user = mysql::fetch($result)) != NULL) {
                array_push($users,$user);
            }

            return $users;
        }
    }
?>