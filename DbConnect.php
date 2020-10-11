<?php
    include_once "configp.php";

    //$CurrentKeys = new MyKeys();
    
    class DbConnect {
        private $host = 'localhost';
        private $dbName = 'youtube';
        private $user = 'root';
        private $pass;
      
        function get_pass() {
            return $this->pass;
        }

        function set_pass($CurrentKeys) {
            $this->pass = $CurrentKeys;
        }

        // public function test(){           
        //     return $this->thedata->get();
        // }

        public function connect() {
            global $CurrentKeys;
            try {
                $conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbName . '', $this->user, $this->pass->getPass());
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch(PDOException $e){
                echo 'Database Error: ' . $e->getMessage();
            }
        }
    }
?>