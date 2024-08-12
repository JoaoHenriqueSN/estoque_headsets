<!DOCTYPE html>
<html>

<head>
    <title>Atualizando headset</title>
    <!-- Sweet Alert -->
    <link type="text/css" href="/cpd/assets/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Sweet Alerts 2 -->
    <script src="/cpd/assets/sweetalert2/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    <?php
    // Dados do modal
    $headsetId = $_POST['headsetId2'];
    $associadoA = $_POST['associadoA'];
    $estoque = $_POST['estoque'];

    try {
        // Conexão com o banco de dados
        $pdo = new PDO("sqlsrv:Server=172.10.20.60\SQLEXPRESS2;Database=GerenciadorAcessos", "USR_TOPACESSO", "top332");

        // Define o modo de erro para exceção
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar se o headset já está associado para alguém
        $stmtCheck = $pdo->prepare("SELECT * FROM Headsets WHERE EmPosse = :associadoA");
        $stmtCheck->bindParam(':associadoA', $associadoA);
        $stmtCheck->execute();

        // Se o valor não existir, faça a atualização
        if ($stmtCheck->rowCount() == 0) {
            $stmt1 = $pdo->prepare("UPDATE Headsets SET EmPosse = :associadoA, Estoque = 0, Manutencao = 0, Id_defeito = NULL, Inativo = 0, Treinamento = 0 WHERE Lacre = :headsetId2");

            // Liga os parâmetros
            $stmt1->bindParam(':associadoA', $associadoA);
            $stmt1->bindParam(':headsetId2', $headsetId);

            // Executa a instrução
            $stmt1->execute();

            // Verifica se a atualização foi feita
            if ($stmt1->rowCount() > 0) {
                echo "<script>
                    Swal.fire({
                        title: 'Sucesso!',
                        text: 'Atualização realizada com sucesso!',
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
            }
        } else {
            echo "<script>
                    Swal.fire({
                        title: 'Erro!',
                        text: 'O headset já está associado a outro usuário!',
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
</body>

</html>
