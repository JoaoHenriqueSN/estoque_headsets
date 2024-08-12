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
$num_lacre = intval($_POST['num_lacre']);

try {
    // Conexão com o banco de dados
    $pdo = new PDO("sqlsrv:Server=172.10.20.60\SQLEXPRESS2;Database=GerenciadorAcessos", "USR_TOPACESSO", "top332");

    // Define o modo de erro para exceção
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Iniciar transação
    $pdo->beginTransaction();

    // Obter o valor atual de EmPosse
    $stmt = $pdo->prepare("SELECT EmPosse FROM Headsets WHERE Lacre = :num_lacre");
    $stmt->bindParam(':num_lacre', $num_lacre);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $emPosseAtual = $row['EmPosse'];

    // Atualizar UltPosse e definir EmPosse como NULL
    $stmt = $pdo->prepare("UPDATE Headsets SET UltPosse = :emPosseAtual, EmPosse = NULL, Estoque = 1, Manutencao = 0, Id_defeito = NULL, Inativo = 0, Treinamento = 0 WHERE Lacre = :num_lacre");
    $stmt->execute(['emPosseAtual' => $emPosseAtual, 'num_lacre' => $num_lacre]);

    // Confirmar transação
    $pdo->commit();


    echo "<script>
    Swal.fire({
        title: 'Sucesso!',
        text: 'Headset em estoque!',
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
        text: 'Erro ao colocar em estoque! " . addslashes($e->getMessage()) . "',
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