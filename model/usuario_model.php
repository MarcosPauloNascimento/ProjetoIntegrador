<?php
    class Usuario
    {
        public static function CadastrarUsuario($username, $name, $passwordHash, $saltHash, $phone, $email, $address)
        {     
            $objDb = new db();
            $link = $objDb->mysqlConnect();
    
            $stmt = $link->prepare("INSERT INTO usuario(username, name, passwordhash, salthash) VALUES (?, ?, ?, ?);");
            $stmt->bind_param("ssss", $username, $name, $passwordHash, $saltHash);
            $runquery = $stmt->execute();
    
            if($runquery)
            {
                $id = $link->insert_id;
                $stmt2 = $link->prepare("INSERT INTO contato(telefone, email, endereco, userid) VALUES (?, ?, ?, ?);");
                $stmt2->bind_param("ssss", $phone, $email, $address, $id);
                $runquery2 = $stmt2->execute();
                if($runquery2)
                    return "Sucesso ao cadastrar usuário!";
                else
                    return "Falha ao cadastrar usuário: ".mysqli_error($link);
            }
            else
                return "Falha ao cadastrar usuário: ".mysqli_error($link);
        }

    }
?>