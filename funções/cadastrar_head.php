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
    $novo_lacre = $_POST['novo_lacre'];

if (!is_numeric($novo_lacre)) {
    echo "O valor de novo_lacre não é um número.";
} else {

try {
        // Conexão com o banco de dados
        $pdo = new PDO("sqlsrv:Server=172.10.20.60\SQLEXPRESS2;Database=GerenciadorAcessos", "USR_TOPACESSO", "top332");

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO Headsets (Lacre ,EmPosse, Estoque, Manutencao, Id_defeito, Inativo, Treinamento) VALUES (:novo_lacre ,NULL, 1, 0, 0, 0, 0)");

        $stmt->bindParam(':novo_lacre', $novo_lacre);

        $stmt->execute();

        {
            echo "<script>
            Swal.fire({
                title: 'Sucesso!',
                text: 'Cadastro realizado com sucesso!',
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
    }

    catch (PDOException $e) {
        echo "<script>
        Swal.fire({
            title: 'Erro!',
            text: 'Erro ao Cadastrar headset! " . addslashes($e->getMessage()) . "',
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
}


?>