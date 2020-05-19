<?php
session_start();
    class Login
    {

        public static function EfetuarLogin($usuario, $senha)
        {     
            if(empty($usuario) || empty($senha)){
                header('Location: ../index.html');
                exit();
            }

            $objDb = new db();
            $link = $objDb->mysqlConnect();

            $userName = mysqli_real_escape_string($link, $usuario);
            $password = mysqli_real_escape_string($link, $senha);

            $sql = "select id, username, passwordhash, salthash from usuario where username = '{$userName}'";
            $result = mysqli_query($link, $sql);

            
            if(mysqli_num_rows($result) == 0){
                return "Usuário Inválido!";
                exit();
            }

            $row = mysqli_fetch_assoc($result);

            if($row['passwordhash'] == md5($senha . $row['salthash'])){

                $_SESSION['usuarioId'] = $row['id'];
                $_SESSION['usuario'] = $row['username'];
                return "Sucesso";
                exit();

            }else{

                return "Senha Inválida";
                exit();
            }
        }

    }
?>