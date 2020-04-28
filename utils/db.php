<?php
    class db
    {
        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $database = 'unasp_pids_projeto_2';

        public function mysqlConnect()
        {
            $con = mysqli_connect($this->host, $this->username, $this->password, $this->database);
            mysqli_set_charset($con, 'utf8');

            if(mysqli_connect_errno())
            {
                echo 'Erro ao tentar se conectar com o DB MySQL: '.mysqli_connect_error();
            }

            return $con;
        }
    }
?>