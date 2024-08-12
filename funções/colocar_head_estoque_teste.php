<?php
// Dados do modal
$headsetId = $_POST['botao_estoque'];

try {
    // Conexão com o banco de dados
    $pdo = new PDO("sqlsrv:Server=172.10.20.60\SQLEXPRESS2;Database=GerenciadorAcessos", "USR_TOPACESSO", "top332");

    // Define o modo de erro para exceção
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Iniciar transação
    $pdo->beginTransaction();

    // Obter o valor atual de EmPosse
    $stmt = $pdo->prepare("SELECT EmPosse FROM Temp_head_backup WHERE Lacre = :estoque");
    $stmt->bindParam(':estoque', $headsetId);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $emPosseAtual = $row['EmPosse'];

    // Atualizar UltPosse e definir EmPosse como NULL
    $stmt = $pdo->prepare("UPDATE Temp_head_backup SET UltPosse = :emPosseAtual, EmPosse = NULL, Estoque = 1, Manutencao = 0, Id_defeito = NULL, Inativo = 0, Treinamento = 0 WHERE Lacre = :headsetId2");
    $stmt->execute(['emPosseAtual' => $emPosseAtual, 'headsetId2' => $headsetId]);

    // Confirmar transação
    $pdo->commit();

    // Verificar se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Exibir os dados recebidos via POST
    echo "Dados recebidos via POST:\n";
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";

    // Criar uma string com os dados recebidos
    $postData = print_r($_POST, true);

    // Definir o caminho do arquivo de texto
    $filePath = '/srv/www/htdocs/cpd/paginacao/dados_post.txt';

    // Salvar os dados em um arquivo de texto
    if (file_put_contents($filePath, $postData, FILE_APPEND | LOCK_EX) !== false) {
        echo "Os dados foram salvos em $filePath.";
    } else {
        echo "Ocorreu um erro ao salvar os dados.";
    }
}
}

?>
