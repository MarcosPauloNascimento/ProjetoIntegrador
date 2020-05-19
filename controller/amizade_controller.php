<?php

require('../utils/db.php');
require('../model/amizade_model.php');


if (isset($_GET['method'])) {
  $controller = 'amizade_controller';
  $method = $_GET['method'];
} 
 
call_user_func(["{$controller}", $method]);

class amizade_controller {
    
    public static function EncontrarAmigo() {
        $pequisa = $_POST['palavra'];
        Amizade::EncontrarAmigo($pequisa);
    }

    public function SolicitarAmizade() {
        $amigoId = $_POST['palavra'];
        Amizade::SolicitarAmizade($amigoId);
    }

}

?>