<?php
    class Amizade
    {

        public static function EncontrarAmigo($pequisa)
        {     
            $objDb = new db();
            $link = $objDb->mysqlConnect();
            $msg = '';
    
            $nome = mysqli_real_escape_string($link, $pequisa);

            $sql = "select name from usuario where name like '%{$nome}%'";
            $result = mysqli_query($link, $sql);

            if(mysqli_num_rows($result) == 0){
                $msg = 'Nenhuma pessoa encontrada';
            }else{
               while($row = mysqli_fetch_assoc($result)){
                    
                    $msg .="<div class='col-md-3' style='padding: 20px;'>";
                    $msg .="    <img src='img/user.png' class='img-thumbnail' alt=''>";
                    $msg .="    <div class='text-center'>".$row['name']."</div>";
                    $msg .="    <button class='btn btn-success btn-block'>Adicionar Amigo</button>";
                    $msg .="</div>";
                }
                
            }
            echo $msg;
            
        }

    }
?>