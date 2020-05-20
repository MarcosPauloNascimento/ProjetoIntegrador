<?php

session_start();

class Amizade {

    public static function EncontrarAmigo($pequisa) {
        $objDb = new db();
        $link = $objDb->mysqlConnect();
        $msg = '';
        $usuarioId = $_SESSION['usuarioId'];

        $nome = mysqli_real_escape_string($link, $pequisa);
        
        $sql = "SELECT id, name FROM usuario "
                . "WHERE name LIKE '%{$nome}%' "
                . "AND id <> {$usuarioId} "
                . "AND id NOT IN "
                        . "(SELECT idUsuario FROM `amizade` "
                        . "WHERE (idUsuario = {$usuarioId} or idAmigo = {$usuarioId})"
                        . "AND situacao <> 'R') "
                . "AND id NOT IN "
                        . "(SELECT idAmigo FROM `amizade` "
                        . "WHERE (idUsuario = {$usuarioId} or idAmigo = {$usuarioId})"
                        . "AND situacao <> 'R')";
                        
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
    
    public static function PendeteParaAprovacao(){
        $msg = '';
        $usuarioId = $_SESSION['usuarioId'];

        $objDb = new db();
        $link = $objDb->mysqlConnect();

        $sql = "SELECT u.id, u.name FROM amizade a "
                . "INNER JOIN usuario u on u.id = a.idUsuario "
                . "WHERE a.idAmigo = {$usuarioId}"
                . " AND a.situacao = 'P'";
                        
        $result = mysqli_query($link, $sql);
        
        if (mysqli_num_rows($result) == 0) {
            $msg = 'Nenhuma solicitação de amizade pendente!';
        } else {
            while ($row = mysqli_fetch_assoc($result)) {

                $msg .= "<div class='row friends-body'>";
                $msg .= "   <div class='col-md-4 text-center'>";
                $msg .= "       <img src='img/user.png' class='img-circle' alt=''>";
                $msg .= "   </div>";
                $msg .= "   <div class='col-md-8'>";
                $msg .= "       <label>" . $row['name'] . "</label>";
                $msg .= "       <div class='row'>";
                $msg .= "           <div class='col-md-6'>";
                $msg .= "               <button class='btn btn-primary btn-block' onclick='aceitarAmizade(" . $row['id'] . ")'>Confirmar</button>";
                $msg .= "           </div>";
                $msg .= "           <div class='col-md-6'>";
                $msg .= "               <button class='btn btn-warning btn-block' onclick='rejeitarAmizade(" . $row['id'] . ")'>Remover</button>";
                $msg .= "           </div>";
                $msg .= "       </div>";
                $msg .= "   </div>";
                $msg .= "</div>";
                
            }
        }
        echo $msg;
    }
    
    public static function AceitarAmizade($amigoId){
        $msg = '';
        $usuarioId = $_SESSION['usuarioId'];

        $objDb = new db();
        $link = $objDb->mysqlConnect();
        
        $sql = "UPDATE amizade SET dataConfirmacao = NOW(),"
                . "situacao = 'A'"
                . " WHERE idAmigo = {$usuarioId}"
                . " AND idUsuario = {$amigoId}";
                        
        if (mysqli_query($link, $sql)) {
            $msg .= 'sucesso!';
        } else {
            $msg .= 'falha!';
        }
        echo $msg;
    }
    
    public static function RejeitarAmizade($amigoId){
        $msg = '';
        $usuarioId = $_SESSION['usuarioId'];

        $objDb = new db();
        $link = $objDb->mysqlConnect();
        
        $sql = "DELETE FROM amizade WHERE idAmigo = {$usuarioId}"
                . " AND idUsuario = {$amigoId}";
        
        if (mysqli_query($link, $sql)) {
            $msg .= 'sucesso!';
        } else {
            $msg .= 'falha!';
        }
        echo $msg;
    }

}
