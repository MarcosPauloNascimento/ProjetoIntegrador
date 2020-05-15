<?php
    require('../utils/db.php');
    require('../model/usuario_model.php');
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    $saltInt = rand(1, 10000);
    $saltStr = (string)$saltInt;
    $saltHash = md5($saltStr);
    $passwordHash = md5($password . $saltHash);

    $resposta = Usuario::CadastrarUsuario($username, $name, $passwordHash, $saltHash, $phone, $email, $address);
    header("Location: ../usuario_cadastro_resposta.html?resposta=".$resposta);
?>