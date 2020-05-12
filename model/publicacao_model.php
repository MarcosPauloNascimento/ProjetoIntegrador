<?php
    class Publicacao
    {
        static function Cadastro($datapublicacao, $conteudo, $userid)
        {     
            $objDb = new db();
            $link = $objDb->mysqlConnect();
    
            $stmt = $link->prepare("INSERT INTO publicacao(datapublicacao, conteudo, userid) VALUES (?, ?, ?);");
            $stmt->bind_param("sss", $datapublicacao, $conteudo, $userid);
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