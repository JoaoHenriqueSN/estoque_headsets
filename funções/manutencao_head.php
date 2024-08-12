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
    $manutencao = intval($_POST['manutencao']);

    try {
        // Conexão com o banco de dados
        $pdo = new PDO("sqlsrv:Server=172.10.20.60\SQLEXPRESS2;Database=GerenciadorAcessos", "USR_TOPACESSO", "top332");
    
        switch ($manutencao) {
          case 1:
              // Deixa o headset sem nenhum funcionário vinculado e com defeito quebrado
              $stmt = $pdo->prepare("UPDATE Headsets SET UltPosse = EmPosse, EmPosse = NULL, Estoque = 0, Manutencao = 1, Treinamento = 0, Id_defeito = 1 WHERE Lacre = :num_lacre;");
              $stmt->bindParam(':num_lacre', $num_lacre);
              $stmt->execute();
              break;
          case 2:
              // Deixa o headset sem nenhum funcionário vinculado e com defeito no microfone
              $stmt = $pdo->prepare("UPDATE Headsets SET UltPosse = EmPosse, EmPosse = NULL, Estoque = 0, Manutencao = 1, Treinamento = 0, Id_defeito = 2 WHERE Lacre = :num_lacre;");
              $stmt->bindParam(':num_lacre', $num_lacre);
              $stmt->execute();
              break;
          case 3:
              // Deixa o headset sem nenhum funcionário vinculado e com defeito no alto falante
              $stmt = $pdo->prepare("UPDATE Headsets SET UltPosse = EmPosse, EmPosse = NULL, Estoque = 0, Manutencao = 1, Treinamento = 0, Id_defeito = 3 WHERE Lacre = :num_lacre;");
              $stmt->bindParam(':num_lacre', $num_lacre);
              $stmt->execute();
              break;
          case 4:
              // Deixa o headset sem nenhum funcionário vinculado e com defeito no conector
              $stmt = $pdo->prepare("UPDATE Headsets SET UltPosse = EmPosse, EmPosse = NULL, Estoque = 0, Manutencao = 1, Treinamento = 0, Id_defeito = 4 WHERE Lacre = :num_lacre;");
              $stmt->bindParam(':num_lacre', $num_lacre);
              $stmt->execute();
              break;
          case 5:
              // Deixa o headset sem nenhum funcionário vinculado e com defeito no cabo
              $stmt = $pdo->prepare("UPDATE Headsets SET UltPosse = EmPosse, EmPosse = NULL, Estoque = 0, Manutencao = 1, Treinamento = 0, Id_defeito = 5 WHERE Lacre = :num_lacre;");
              $stmt->bindParam(':num_lacre', $num_lacre);
              $stmt->execute();
              break;
      }
      echo "<script>
      Swal.fire({
          title: 'Sucesso!',
          text: 'Defeito informado com sucesso!',
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

