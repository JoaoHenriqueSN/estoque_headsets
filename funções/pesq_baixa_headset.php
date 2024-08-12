<?php
if(isset($_POST['func_desl'])){
    $matricula = $_POST['func_desl'];
    // Conecte-se ao banco de dados e realize a consulta
    $pdo = new PDO("sqlsrv:Server=172.10.20.60\SQLEXPRESS2;Database=GerenciadorAcessos", "USR_TOPACESSO", "top332");
    $stmt = $pdo->prepare("SELECT Matricula, Nome, HeadDevolvido, BaixaDesconto, DataBaixa, Lacre_devolvido from Funcionarios WHERE Matricula=:func_desl");
    $stmt->bindParam(':func_desl', $matricula);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // Exiba os resultados
    echo "Matricula: " . $result['Matricula'] . "<br>";
    echo "Nome: " . $result['Nome'] . "<br>";
    echo "Baixa sem desconto: " . ($result['HeadDevolvido'] == 1 ? 'Sim' : 'Não') . "<br>";
    echo "Baixa com desconto: " . ($result['BaixaDesconto'] == 1 ? 'Sim' : 'Não') . "<br>";
    echo "Data da baixa: " . $result['DataBaixa'] . "<br>";
    
    // Nova consulta para a tabela Headsets
    $stmt2 = $pdo->prepare("SELECT Lacre from Headsets WHERE EmPosse=:func_desl");
    $stmt2->bindParam(':func_desl', $matricula);
    $stmt2->execute();
    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    // Exiba o resultado
    echo "Lacre atual: " . $result2['Lacre'] . "<br>";
    echo "Lacre devolvido: " . $result['Lacre_devolvido'] . "<br>";

    // Armazene o valor do lacre no campo oculto
    echo "<script>document.getElementById('lacre_hidden').value = '" . $result2['Lacre'] . "';</script>";
    echo "<script>document.getElementById('lacre_hidden2').value = '" . $result2['Lacre'] . "';</script>";
}
?>
