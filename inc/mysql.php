<?php

    class mysql {

        static $instance;
        protected $connectionInfo = array(
            'user' => 'pomonamo',
            'password' => "Fool3ry#7833",
            'host' => "localhost"
            );
        protected $connection;

        // it's a singleton class!
        static function instance() {
            if(is_object(self::$instance)){
                return self::$instance;
            } else {
                self::$instance = new mysql();

                return self::$instance;
            }
        }

        // establish connection to the database
        protected function __construct() {
            if($this->connection = mysqli_connect($this->connectionInfo['host'], $this->connectionInfo['user'], $this->connectionInfo['password'])) {

            }
            else
                print mysqli_connect_error();
        }

        // escape a string for querying the DB
        static function escStr($str) {
            $conn = self::link();

            return mysqli_escape_string($conn, $str);
        }

        // provide easy access to DB connection
        static protected function link() {
            return self::instance()->connection;
        }

        // take a generic mysql query and execute it
        static public function query($q) {
            $conn = self::link();

            if ($result = mysqli_query($conn, $q))
                {
                    return $result;
                }
                else
                { // handle the error (send error info to a file)
                    self::handle_error($q, $conn);

                    return false;
                }
        }

        // given a mysql result, get the number of rows
        static public function num_rows($resource) {
            return mysqli_num_rows($resource);
        }

        // give a mysql result, fetch a row
        static public function fetch($resource, $type = 'assoc') {
            switch ($type)
                {
                    case "assoc":
                        return mysqli_fetch_assoc($resource);
                        break;
                    case "row":
                        return mysqli_fetch_row($resource);
                        break;
                    case "array":
                        return mysqli_fetch_array($resource);
                        break;
                    default:
                        return false;
                }
        }

        // send error information to a file based on date and time
        public function handle_error($query, $resource) {
            $resp = date('y-m-d g:i:sa', time()) . '<br/>';

            if ($resource) { // if a query error can be found
                $error = mysqli_error($resource);

                $resp .= "<p><strong>Message</strong>: " . htmlspecialchars($error, ENT_QUOTES) . "</p>\r\n";
            }

            // build error
            $resp .= "<p><strong>Error</strong>: " . htmlspecialchars($message, ENT_QUOTES) . "</p>\r\n";

            $currentTime = microtime();

            if (isset($_SESSION) === false) {
                $_SESSION = array();
            }

            if (isset($_REQUEST) === false) {
                $_REQUEST = array();
            }

            $resp .= '<br/><button type="button" onClick="document.getElementById(\'debug_' . $currentTime . '\').style.display = \'block\'; return false;">Show Debug</button><button type="button" onClick="document.getElementById(\'debug_' . $currentTime . '\').style.display = \'none\'; return false;">Hide Debug</button><div id="debug_' . $currentTime . '" style="display: none;">' . "\r\n" . '<p>Debug: </p><pre>' . htmlspecialchars(print_r(debug_backtrace(), true), ENT_QUOTES) . "\n\nRequest:\n" . htmlspecialchars(print_r($_REQUEST, true), ENT_QUOTES) . "\n\nSession:\n" . htmlspecialchars(print_r($_SESSION, true), ENT_QUOTES) . "\n\nServer:\n" . htmlspecialchars(print_r($_SERVER, true), ENT_QUOTES) . '</pre></div>';
            $resp .= "<hr/><br/>\r\n";

            $file = './mysql_log/mysql_' . date('y-m-d_H') . ".html";
            $fp = @fopen($file, 'a');
            if ($fp !== false) {
                fwrite($fp, $resp);
                fclose($fp);
            }
        }
    }
?>