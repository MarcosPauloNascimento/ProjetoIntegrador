
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Unasp Face Pet</title>

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

        <header>
            <div class="container">
                <img src="img/logo.png" class="logo" alt="">
            </div>
        </header>

        <nav class="navbar navbar-btn">
            <div class="container">
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav nav-tabs nav-fill">
                        <li id="inicio"><a href="#" onclick="loadLinhadoTempo()">Inicio</a></li>
                        <li><a href="#" onclick="loadPaginaAmizade()">Amigos</a></li>
                        <li class="dropdown pull-right">
                            <a class="dropdown-item" href="index.html">Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <section>
            <div class="container">
                <h4><?php echo 'Bem Vindo, ' . $usuario; ?></h4>
                <div class="row" id="conteudo">

                </div>
            </div>

        </section>


        <footer>
            <div class="container">
                <p>Unasp Face</p>
            </div>
        </footer>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.js"></script>

        <script>
                            $(document).ready(function () {

                                $('#conteudo').load("linhaDoTempo.html");

                            });

                            function loadLinhadoTempo() {
                                $('#conteudo').load("linhaDoTempo.html");
                            }
                            ;

                            function loadPaginaAmizade() {
                                $('#conteudo').load("paginaAmizade.html");
                            }
                            ;

                            function solicitarAmizade(linha) {
                                let dados = {
                                    palavra: linha
                                };
                                $.post('controller/amizade_controller.php?method=SolicitarAmizade', dados, function (result) {
                                    $(".resultado").html(result);

                                });
                            }
                            ;


        </script>

    </body>
</html>
