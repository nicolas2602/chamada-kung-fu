<?php
    use Config\Conexao;
    use App\Helpers\CaminhoHelpers;

    require_once("../../../bootstrap.php");
    require_once(CaminhoHelpers::PUBLIC . "/components/mensagem.php");

    $conexao = new Conexao();
    if(!$conexao->testaConexao()) {
        echo "<h1>Erro no banco de dados!</h1>";
        exit;
    }

    require_once("./logica.php");
    require_once("./conteudo.php");
    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= CaminhoHelpers::PUBLIC ?>/assets/style/style.css">
    <title>Login - Chamada Kung-Fu</title>
</head>
<body class="bg-dark">
    <div class="d-flex justify-content-center align-items-center h-100">
        <main class="login-card p-4">
            <?php 
                mensagem($entradaMensagem);
                loginConteudo();
            ?>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</body>
</html>