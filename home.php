
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>My Pet's Space</title>

        <script src="js/jquery-3.4.1.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/tooltip.min.js"></script>
        <script src="js/bootstrap.js"></script>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet">

        <?php
        session_start();
        $usuario = '';
        $usuarioId = '';

        $usuario = $_SESSION['usuario'];
        $usuarioId = $_SESSION['usuarioId'];
        ?>
    </head>

    <body>



        <nav class="navbar navbar-light bg-primary">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <img class="logo" src="img/logo.png" alt="">
                    
                        <ul class="nav nav-pills pull-right">
                            <li>
                                <a class="nav-item" href="#" onclick="loadLinhadoTempo()">Inicio</a></li>
                            <li>
                                <a class="nav-item" href="#" onclick="loadPaginaAmizade()">Amigos</a></li>
                            <li>
                                <a class="nav-item" href="index.html" onclick="sair()" >Sair</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </nav>




        <section>
            <div class="container">
                <label><?php echo 'Bem Vindo, ' . $usuario. ' - '.$usuarioId; ?></label>
                <h4 class="hidden usuarioId"><?php echo $usuarioId; ?></h4>
                <div class="row" id="conteudo">

                </div>
            </div>

        </section>


        <footer>
            <div class="container">
                <p>My Pet's Space</p>
            </div>
        </footer>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.js"></script>

        <script>
                                    function MeusAmigos() {
                                        $.get('controller/amizade_controller.php?method=MeusAmigos', function (result) {
                                            $(".meusAmigos").html(result);
                                        });
                                    }
                                    ;

                                    function PendeteParaAprovacao() {
                                        $.get('controller/amizade_controller.php?method=PendeteParaAprovacao', function (result) {
                                            $(".pendentes").html(result);
                                        });
                                    }
                                    ;

                                    function AceitarAmizade(id) {
                                        let dados = {
                                            idAmigo: id
                                        };
                                        $.post('controller/amizade_controller.php?method=AceitarAmizade', dados, function () {
                                            PendeteParaAprovacao();
                                            MeusAmigos();
                                        });
                                    }

                                    function ExcluirAmizade(id) {
                                        let dados = {
                                            idAmigo: id
                                        };
                                        $.post('controller/amizade_controller.php?method=ExcluirAmizade', dados, function (result) {
                                            PendeteParaAprovacao();
                                            MeusAmigos();
                                            console.log(result);
                                        });
                                    }

                                    function loadLinhadoTempo() {
                                        $('#conteudo').load("linhaDoTempo.html");
                                    }
                                    ;

                                    function loadPaginaAmizade() {
                                        $('#conteudo').load("paginaAmizade.html");
                                        SugestaoAmizade();
                                    }
                                    ;

                                    function SugestaoAmizade() {
                                        $.get('controller/amizade_controller.php?method=SugestaoAmizade', function (result) {
                                            $(".resultado").html(result);
                                        });
                                    }
                                    ;

                                    function SolicitarAmizade(id) {
                                        let dados = {
                                            idAmigo: id
                                        };
                                        $.post('controller/amizade_controller.php?method=SolicitarAmizade', dados, function (result) {
                                            $(".resultado").html(result);
                                            $("#pesquisar").val("");
                                            document.getElementById("pesquisar").focus();

                                        });
                                    }
                                    ;

                                    $(document).ready(function () {

                                        $('#conteudo').load("linhaDoTempo.html");

                                    });

                                    function sair() {
                                        session_destroy();
                                        unset($_SESSION['usuario']);
                                        $_SESSION['usuario'] = null;
                                        header('location: .');
                                        session_commit();
                                    }


        </script>

    </body>
</html>
