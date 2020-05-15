<?php
    require('../utils/db.php');
    require('../model/login_model.php');

    $usuario = $_POST['username'];
    $senha = $_POST['password'];

    $resposta = Login::EfetuarLogin($usuario, $senha);

    if($resposta != "Sucesso"){
        header("Location: ../usuario_cadastro_resposta.html?resposta=".$resposta);
    }else{
        header("Location: ../feed_principal.html");
    }


?>