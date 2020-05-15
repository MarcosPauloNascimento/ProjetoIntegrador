
idUsuario INT NOT NULL,
    idAmigo INT NOT NULL,
    dataSolicitacao DATE NOT NULL,
    dataConfirmacao DATE,
    situacao CHAR(2) NOT NULL, -- (P - Pendente, A - Aprovado, R - Rejeitado)
    PRIMARY KEY (idUsuario, idAmigo),
    FOREIGN KEY (idUsuario) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (idAmigo) REFERENCES usuario(id) ON DELETE CASCADE

<?php
    class Amizade
    {

        public static function 

        public static function SolicitarAmizade($username, $name, $passwordHash, $saltHash, $phone, $email, $address)
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