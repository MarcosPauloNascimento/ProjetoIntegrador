<?php
    require('../utils/db.php');
    require('../model/amizade_model.php');

    $pequisa = $_POST['palavra'];

    Amizade::EncontrarAmigo($pequisa);  

    

?>