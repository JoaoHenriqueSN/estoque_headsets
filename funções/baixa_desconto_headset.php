<!DOCTYPE html>
<html>

<head>
    <title>baixa headset</title>
    <!-- Sweet Alert -->
    <link type="text/css" href="/cpd/assets/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Sweet Alerts 2 -->
    <script src="/cpd/assets/sweetalert2/dist/sweetalert2.all.min.js"></script>
</head>
<body>
<?php

// Dados do modal
$func_desl = $_POST['func_desl'];

try {
    // Conexão com o banco de dados
    $pdo = new PDO("sqlsrv:Server=172.10.20.60\SQLEXPRESS2;Database=GerenciadorAcessos", "USR_TOPACESSO", "top332");

    // Define o modo de erro para exceção
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Colocar head em estoque 
    $stmt = $pdo->prepare("UPDATE Funcionarios SET HeadDevolvido = 0, BaixaDesconto = 1, DataBaixa = CAST(GETDATE() AS DATE) WHERE Matricula = :func_desl");

    // Liga os parâmetros
    $stmt->bindParam(':func_desl', $func_desl);

    // Executa a instrução
    $stmt->execute();

    //Update para colocar a matricula na coluna UltPosse
    $stmt1 = $pdo->prepare("UPDATE Headsets SET UltPosse = EmPosse WHERE EmPosse = :func_desl");

    $stmt1->bindParam(':func_desl', $func_desl);

    $stmt1->execute();

    //Update para deixar o headset em estoque 
    $stmt2 = $pdo->prepare("UPDATE Headsets SET EmPosse = NULL, Estoque = 0, Manutencao = 0, Id_defeito = NULL, Inativo = 1, Treinamento = 0 WHERE EmPosse = :func_desl");

    $stmt2->bindParam(':func_desl', $func_desl);

    $stmt2->execute();
    echo "<script>
    Swal.fire({
        title: 'Sucesso!',
        text: 'Baixa com desconto realizada com sucesso!',
        icon: 'success',
        timer: 2000,
        showConfirmButton: false
    }).then((result) => {
        // Redirecionar para outra página após o tempo definido
        if (window.location.href !== '/cpd/paginacao/headset.php') {
            window.location.href = '/cpd/paginacao/headset.php';
        }
    });
    </script>";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    echo "<script>
    Swal.fire({
        title: 'Erro!',
        text: 'Erro ao atualizar o banco de dados: " . addslashes($e->getMessage()) . "',
        icon: 'error',
        timer: 2000,
        showConfirmButton: false
    }).then((result) => {
        // Redirecionar para outra página após o tempo definido
        if (window.location.href !== '/cpd/paginacao/headset.php') {
            window.location.href = '/cpd/paginacao/headset.php';
        }
    });
    </script>";
}

?>
</body>
</html>
