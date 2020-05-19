<?php

session_start();

class Amizade {

    public static function EncontrarAmigo($pequisa) {
        $objDb = new db();
        $link = $objDb->mysqlConnect();
        $msg = '';

        $nome = mysqli_real_escape_string($link, $pequisa);

        $sql = "select id, name from usuario where name like '%{$nome}%'";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) == 0) {
            $msg = 'Nenhuma pessoa encontrada';
        } else {
            while ($row = mysqli_fetch_assoc($result)) {

                $msg .= "<div class='col-md-3' style='padding: 20px;'>";
                $msg .= "    <img src='img/user.png' class='img-thumbnail' alt=''>";
                $msg .= "    <div style='padding: 5px;' class='text-center'>" . $row['name'] . "</div>";
                $msg .= "    <label class='hidden'>" . $row['id'] . "</label>";
                $msg .= "    <button class='btn btn-success btn-block' onclick='solicitarAmizade(" . $row['id'] . ")'>Adicionar Amigo</button>";
                $msg .= "</div>";
            }
        }
        echo $msg;
    }

    public static function SolicitarAmizade($amigoId) {
        $msg = '';
        $usuarioId = $_SESSION['usuarioId'];

        $objDb = new db();
        $link = $objDb->mysqlConnect();

        $sqlInsert = "INSERT INTO amizade(idUsuario, idAmigo, dataSolicitacao, dataConfirmacao, situacao) "
                . "VALUES ({$usuarioId}, {$amigoId}, NOW(), null, 'P')";
        $result = mysqli_query($link, $sqlInsert);

        if ($result) {

            $msg .= "<div class='col-md-12' style='padding: 20px;'>";
            $msg .= "    <label class='label-lg'>Legal... Agora é só aguardar seu novo amigo aceitar sua solicitação!</label>";
            $msg .= "</div>";
            
        } else {
            
            $msg .= "<div class='col-md-12' style='padding: 20px;'>";
            $msg .= "    <label class='label-lg'>Ocorreu algum erro durante o processo. Verifique sua conexão!</label>";
            $msg .= "</div>";
        }
        
        echo $msg;
    }

}

?>