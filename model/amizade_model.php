<?php

session_start();
const MAX = 5;

class Amizade {

    public static function SugestaoAmizade() {
        $objDb = new db();
        $link = $objDb->mysqlConnect();
        $msg = '';
        $usuarioId = $_SESSION['usuarioId'];

        
        $sql = Amizade::QueryString($usuarioId);

        $result = mysqli_query($link, $sql);
        
        if (mysqli_num_rows($result) == 0) {
            $msg .= "<div class='col-md-12' style='padding: 20px;'>";
            $msg .= "    <h4>Não consegui encontrar nenhuma sugestão de amizade pra você!</h4>";
            $msg .= "</div>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {

                $msg .= "<div class='col-md-3 text-center' style='padding: 10px;'>";
                $msg .= "    <img src='img/user.png' class='img-circle' alt=''>";
                $msg .= "    <div style='padding: 5px;' class='text-center'>" . $row['name'] . "</div>";
                $msg .= "    <label class='hidden'>" . $row['id'] . "</label>";
                $msg .= "    <button class='btn btn-success btn-block' onclick='SolicitarAmizade(" . $row['id'] . ")'>Adicionar Amigo</button>";
                $msg .= "</div>";
            }
        }
        echo $msg;
    }

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
                . "AND situacao IS NOT NULL) "
                . "AND id NOT IN "
                . "(SELECT idAmigo FROM `amizade` "
                . "WHERE (idUsuario = {$usuarioId} or idAmigo = {$usuarioId})"
                . "AND situacao IS NOT NULL)";

        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) == 0) {
            $msg .= "<div class='col-md-12' style='padding: 20px;'>";
            $msg .= "    <h4>Nenhuma pessoa encontrada!</h4>";
            $msg .= "</div>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {

                $msg .= "<div class='col-md-3 text-center' style='padding: 10px;'>";
                $msg .= "    <img src='img/user.png' class='img-circle' alt=''>";
                $msg .= "    <div style='padding: 5px;' class='text-center'>" . $row['name'] . "</div>";
                $msg .= "    <label class='hidden'>" . $row['id'] . "</label>";
                $msg .= "    <button class='btn btn-success btn-block' onclick='SolicitarAmizade(" . $row['id'] . ")'>Adicionar Amigo</button>";
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
            $msg .= "    <h4>Legal... Agora é só aguardar seu novo amigo aceitar sua solicitação!</h4>";
            $msg .= "</div>";
        } else {

            $msg .= "<div class='col-md-12' style='padding: 20px;'>";
            $msg .= "    <h4>Ocorreu algum erro durante o processo. Verifique sua conexão!</h4>";
            $msg .= "</div>";
        }

        echo $msg;
    }

    public static function MeusAmigos() {
        $msg = '';
        $usuarioId = $_SESSION['usuarioId'];

        $objDb = new db();
        $link = $objDb->mysqlConnect();

        $sql = "SELECT id, name FROM usuario WHERE ID IN"
                ." (SELECT idAmigo FROM `amizade`"
                ." WHERE situacao = 'A' AND idUsuario = {$usuarioId}"
                ." UNION"
                ." SELECT idUsuario FROM `amizade`"
                ." WHERE situacao = 'A' AND idAmigo = {$usuarioId})"
                ." LIMIT " . MAX;
                
        /*$sql = "SELECT DISTINCT u.id, u.name FROM amizade a "
                . "INNER JOIN usuario u on u.id = a.idUsuario or u.id = a.idAmigo"
                . " WHERE (a.idAmigo != {$usuarioId} or a.idUsuario != {$usuarioId})"
                . " AND a.situacao = 'A'"
                . " AND u.id != {$usuarioId}"
                . " LIMIT " . MAX;*/

        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) == 0) {

            $msg .= "<div class='friends-body'>";
            $msg .= "   <h4>Você ainda não tem nenhum amigo!</h4>";
            $msg .= "</div>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {

                $msg .= "<div class='row friends-body'>";
                $msg .= "   <div class='col-md-4 text-center'>";
                $msg .= "       <img src='img/user.png' class='img-circle' alt=''>";
                $msg .= "   </div>";
                $msg .= "   <div class='col-md-8'>";
                $msg .= "       <label>" . $row['name'] . "</label>";
                $msg .= "       <div class='row'>";
                $msg .= "           <div class='col-md-12'>";
                $msg .= "               <button class='btn btn-warning btn-block' onclick='ExcluirAmizade(" . $row['id'] . ")'>Excluir Amigo</button>";
                $msg .= "           </div>";
                $msg .= "       </div>";
                $msg .= "   </div>";
                $msg .= "</div>";
            }
        }
        echo $msg;
    }

    public static function PendeteParaAprovacao() {
        $msg = '';
        $usuarioId = $_SESSION['usuarioId'];

        $objDb = new db();
        $link = $objDb->mysqlConnect();

        $sql = "SELECT u.id, u.name FROM amizade a "
                . "INNER JOIN usuario u on u.id = a.idUsuario "
                . "WHERE a.idAmigo = {$usuarioId}"
                . " AND a.situacao = 'P'"
                . " LIMIT " . MAX;

        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) == 0) {

            $msg .= "<div class='friends-body'>";
            $msg .= "   <h4>Nenhuma solicitação de amizade pendente!</h4>";
            $msg .= "</div>";
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
                $msg .= "               <button class='btn btn-primary btn-block' onclick='AceitarAmizade(" . $row['id'] . ")'>Confirmar</button>";
                $msg .= "           </div>";
                $msg .= "           <div class='col-md-6'>";
                $msg .= "               <button class='btn btn-warning btn-block' onclick='ExcluirAmizade(" . $row['id'] . ")'>Excluir</button>";
                $msg .= "           </div>";
                $msg .= "       </div>";
                $msg .= "   </div>";
                $msg .= "</div>";
            }
        }
        echo $msg;
    }

    public static function AceitarAmizade($amigoId) {
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

    public static function ExcluirAmizade($amigoId) {
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
    
    private static function QueryString($usuarioId){
        return "SELECT DISTINCT u.id, u.name FROM usuario u"
                ." INNER JOIN amizade a on a.idUsuario = u.id or a.idAmigo = u.id"
                ." WHERE (a.idUsuario NOT IN"
                    ." (SELECT idAmigo FROM `amizade`"
                    ." WHERE situacao = 'A'"
                    ." AND idUsuario = {$usuarioId}"
                    ." UNION"
                    ." SELECT idUsuario FROM `amizade`"
                    ." WHERE situacao = 'A' AND idAmigo = {$usuarioId})"
                ." OR"
                ." a.idAmigo NOT IN"
                    ." (SELECT idAmigo FROM `amizade`"
                    ." WHERE situacao = 'A' AND idUsuario = {$usuarioId}"
                    ." UNION"
                    ." SELECT idUsuario FROM `amizade`"
                    ." WHERE situacao = 'A' AND idAmigo = {$usuarioId}))"
                ." AND a.idUsuario <> {$usuarioId}"
                ." AND a.idAmigo <> {$usuarioId}"
                ." AND u.id NOT IN"
                    ." (SELECT idAmigo FROM `amizade`"
                    ." WHERE situacao = 'A' AND idUsuario = {$usuarioId}"
                    ." UNION"
                    ." SELECT idUsuario FROM `amizade`"
                    ." WHERE situacao = 'A' AND idAmigo = {$usuarioId})";
    }

}
