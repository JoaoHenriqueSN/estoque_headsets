<!DOCTYPE html>
<html>

<head>
    <title>atualizando headset</title>
    <!-- Sweet Alert -->
    <link type="text/css" href="/cpd/assets/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Sweet Alerts 2 -->
    <script src="/cpd/assets/sweetalert2/dist/sweetalert2.all.min.js"></script>
</head>
<body>
<?php
    // Dados do modal
    // Dados do modal
    $num_lacre = intval($_POST['num_lacre']);

try {
    // Conexão com o banco de dados
    $pdo = new PDO("sqlsrv:Server=172.10.20.60\SQLEXPRESS2;Database=GerenciadorAcessos", "USR_TOPACESSO", "top332");

    // Define o modo de erro para exceção
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    // colocar head em estoque 
    $stmt = $pdo->prepare("UPDATE Headsets SET EmPosse = NULL, Estoque = 0, Manutencao = 0, Id_defeito = NULL, Inativo = 0, Treinamento = 1 WHERE Lacre = :num_lacre");

    // Liga os parâmetros
    $stmt->bindParam(':num_lacre', $num_lacre);


    // Executa a instrução
    $stmt->execute();
    echo "<script>
    Swal.fire({
        title: 'Sucesso!',
        text: 'Headset para treinamento!',
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