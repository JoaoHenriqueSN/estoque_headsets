<?php
        session_start();
        if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['senha']) == true)) {
            unset($_SESSION['login']);
            unset($_SESSION['senha']);
            header('location: login.html');
        }

        $logado = $_SESSION['login'];
        // chekaro tipo do usuário
        if ($_SESSION['tipo'] != 'admin' && $_SESSION['tipo'] != 'suporte' && $_SESSION['tipo'] != 'gerencia') {
            echo "<script>
    Swal.fire({
        title: 'Acesso Negado!',
        text: 'Você não tem acesso a esse menu.',
        icon: 'error'
    }).then((result) => {
        window.location.href = '/caminho/da/home.php';
    });
    </script>";
        }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Controle de Headsets Plansul</title>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="author" content="CodedThemes" />

        <!-- Favicon icon -->
        <link rel="icon" href="/caminho/assets/images/favicon.ico" type="image/x-icon">
        <!-- fontawesome icon -->
        <link rel="stylesheet" href="/caminho/assets/fonts/fontawesome/css/fontawesome-all.min.css">
        <!-- animation css -->
        <link rel="stylesheet" href="/caminho/assets/plugins/animation/css/animate.min.css">
        <!-- vendor css -->
        <link rel="stylesheet" href="/caminho/assets/css/style.css">

        <link rel="stylesheet" href="/caminho/assets/DataTables-1.13.6/media/css/jquery.dataTables.css">

        <!-- Sweet Alert -->
        <link type="text/css" href="/caminho/assets/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
        <!-- Sweet Alerts 2 -->
        <script src="/caminho/assets/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <!-- Favicon icon -->
        <link rel="icon" href="/caminho/assets/images/favicon.png" type="image/x-icon">
        <!-- jQuery library via CDN -->
        <script src="/caminho/js/jquery-3.6.0.min.js"></script>

        <style>


            /* Estilos para o botão */
            div.dt-buttons .btn-export-csv {
                background-color: #141f2e;
                width: 150px;
                height: 28px;
                margin-left: 20px;
                line-height: 14px;
                cursor: pointer;
                color: white;
                margin-top: 10px;
            }

            div.dt-buttons :hover.btn-export-csv {
                background-color: #243854;
            }

            div.dataTables_wrapper div.dataTables_filter input {
                line-height: 20px;
                height: 28px;
            }

            /* Estilos para remover a borda do botão de fechar */
            .btn-close-transparent {
                background-color: transparent;
                border: none;
                box-shadow: none;
            }

            /* Estilos para remover a borda do botão de fechar */
            .btn-close-transparent {
                background-color: transparent;
                border: none;
                box-shadow: none;
            }
        </style>
    </head>

    <body>
        <!-- [ Pre-loader ] start -->
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>
        <!-- [ Pre-loader ] End -->

        <?php include '../funcoes/nav2.php'; ?>


        <!-- [ Header ] start -->
        <header class="navbar pcoded-header navbar-expand-lg navbar-light">
            <div class="m-header">
                <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
                <a href="#" class="b-brand">
                    <div class="b-bg">
                        <i class="feather icon-slack"></i>
                    </div>
                    <span class="b-title">Sistema C.P.D</span>
                </a>
            </div>
            <a class="mobile-menu" id="mobile-header" href="javascript:">
                <i class="feather icon-more-horizontal"></i>
            </a>
            <div class="collapse navbar-collapse">
                <li><a href="javascript:" class="full-screen" onclick="javascript:toggleFullScreen()"><i class="feather icon-maximize"></i></a></li>
                <h2>Controle de Headsets Plansul </h2>
                <ul class="navbar-nav ml-auto">
                    <li>
                        <div class="dropdown drp-user">
                            <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon feather icon-settings"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-notification">
                                <div class="pro-head">
                                    <img src="../assets/images/user/avatar-2.jpg" class="img-radius" alt="User-Profile-Image">
                                    <span>
                                        <?php
                                        echo $_SESSION['nome'];
                                        ?>
                                    </span>
                                    <a href="logoff.php" class="dud-logout" title="Logout">
                                        <i class="feather icon-log-out"></i>
                                    </a>
                                </div>
                                <ul class="pro-body">
                                    <li><a href="/caminho/paginacao/agenda.php" class="dropdown-item"><i class="feather icon-user"></i> Agenda</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
        <!-- [ Header ] end -->

        <!-- [ Main Content ] start -->
        <section class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <div class="pcoded-content">
                    <div class="pcoded-inner-content">
                        <!-- [ breadcrumb ] end -->
                        <div class="main-body">
                            <div class="page-wrapper">
                                <!-- [ Main Content ] start -->
                                <div class="row">
                                    <!-- [ stiped-table ] start -->
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-block table-border-style">
                                                <div class="table-responsive">
                                                <button type="button" class="btn btn-secondary" id="modalpesquisar" data-bs-dismiss="modal1">Pesquisar Funcionário</button>
                                               <button type="button" class="btn btn-secondary" id="cadashead" data-bs-dismiss="modal1">Cadastrar headset</button>
                                                <button type="button" class="btn btn-secondary" id="baixa" data-bs-dismiss="modal1">Baixa no headset</button>
                                                    <br>
                                                    <br>
                                                    <table id="tabela-headsets" class="display">
                                                        <thead>
                                                            <tr>
                                                                <th style='display:none;'>Id</th>
                                                                <th>Lacre</th>
                                                                <th>Matricula</th>
                                                                <th>Ult. Posse</th>
                                                                <th>Estoque</th>
                                                                <th>Manutenção</th>
                                                                <th>Defeito</th>
                                                                <th>Ativo/Inativo</th>
                                                                <th>Treinamento</th>
                                                                <th>Ação</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            // Conexão com o banco de dados
                                                            $server = 'server';
                                                            $database = 'bancoDEdados';
                                                            $username = 'usuario';
                                                            $password = 'senha_do_user';

                                                            try {
                                                                $conn = new PDO("sqlsrv:Server=$server;Database=$database", $username, $password);
                                                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                            
                                                                // Consulta SQL com filtro
                                                                $filtro = $_GET['filtro'];
                                                                $sql = "SELECT Id, Lacre, EmPosse, Motivo, Chamado, UltPosse, Estoque, Manutencao, Id_defeito, Garantia, Id_vendedor, Inativo, Id_marca, Emprestado, Treinamento, Sem_conserto, Nao_encontrado 
                                                                FROM Banco";
                                                                if ($filtro) {
                                                                    $sql .= " WHERE (Estoque = 1) OR (Inativo = 1) OR (Manutencao = 1)";
                                                                } else {
                                                                    $sql .= " WHERE EmPosse IS NOT NULL OR Estoque = 1 OR Inativo = 0 OR Manutencao = 0";
                                                                }
                                                            
                                                            $stmt = $conn->query($sql);
                                                                // Gera as linhas da tabela
                                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                    echo "<tr>";
                                                                    echo "<td style='display:none;'>" . $row['Id'] . "</td>";
                                                                    echo "<td>" . $row['Lacre'] . "</td>";
                                                                    echo "<td>" . $row['EmPosse'] . "</td>";
                                                                    echo "<td>" . $row['UltPosse'] . "</td>";
                                                                    if ($row['Estoque'] == 1) {
                                                                        echo "<td>Em estoque</td>";
                                                                    } else {
                                                                        echo "<td>N/A</td>";
                                                                    }
                                                                    if ($row['Manutencao'] == 1) {
                                                                        echo "<td>Em Manutenção</td>";
                                                                    } else {
                                                                        echo "<td>N/A</td>";
                                                                    }
                                                                    switch ($row['Id_defeito']) {
                                                                        case 1:
                                                                            echo "<td>Quebrado</td>";
                                                                            break;
                                                                        case 2:
                                                                            echo "<td>Microfone</td>";
                                                                            break;
                                                                        case 3:
                                                                            echo "<td>Alto Falante</td>";
                                                                            break;
                                                                        case 4:
                                                                            echo "<td>Conector</td>";
                                                                            break;
                                                                        case 5:
                                                                            echo "<td>Cabo</td>";
                                                                            break;
                                                                        default:
                                                                            echo "<td>Sem defeito</td>";
                                                                    }
                                                                    if ($row['Inativo'] == 1) {
                                                                        echo "<td>Inativo</td>";
                                                                    } else {
                                                                        echo "<td>Ativo</td>";
                                                                    }
                                                                    if ($row['Treinamento'] == 1){
                                                                        echo "<td>Em treinamento</td>";
                                                                    }else{
                                                                        echo "<td>Operação</td>";
                                                                    }
                                                                    echo "<td><button type='button' class='botaoacao'><i class='bi bi-three-dots-vertical'></i> Ação</button></td>";
                                                                    echo "</tr>";
                                                                    
                                                                }
                                                              

                                                                $conn = null;
                                                            } catch (PDOException $e) {
                                                                echo "<tr><td>Erro ao carregar dados: " . $e->getMessage() . "</td></tr>";
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- [ Main Content ] end -->

 <!-- Modal Para realizar baixa no headset -->
<div class="modal fade" id="baixahead" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Realizar baixa no headset</h5>
                    <button type="button" class="btn-close btn-close-transparent" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="func_desl">Qual funcionário você vai desligar?</label>
                        <input type="text" class="form-control" id="func_desl" name="func_desl" placeholder="Digite a matrícula do funcionário">
                        <button type="button" class="btn btn-primary"id="botao_func_desl" name="botao_func_desl">Pesquisar</button>
                        <div id="resultados"></div> 
                        <form action="/caminho/das/funcoes/baixa_headset.php" method="post">
                            <input type="hidden" id="func_desl_hidden" name="func_desl">
                            <input type="hidden" id="lacre_hidden" name="lacre">
                            <button type="submit" class="btn btn-secondary"id="baixa" name="baixa">Baixa sem Desconto</button>
                        </form>
                        <form action="/caminho/das/funcoes/baixa_desconto_headset.php" method="post">
                            <input type="hidden" id="func_desl_hidden2" name="func_desl">
                            <input type="hidden" id="lacre_hidden2" name="lacre">
                            <button type="submit" class="btn btn-secondary"id="baixa_desconto" name="baixa_desconto">Baixa com Desconto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal Principal - Funcionário -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Detalhes do Headset</h5>
                <button type="button" class="btn-close btn-close-transparent" data-bs-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST" action="/caminho/das/funcoes/atualizar_headset.php">
                <div class="modal-body">
                    <div id="modalContent">
                        <p><strong>Headset:</strong> <span id="column2Data"></span></p>
                        <p><strong>Associado a:</strong> <span id="column3Data"></span></p>
                    </div>
                    <div class="form-group">
                         <label for="associadoA">Vincular matrícula:</label>
                         <input type="text" class="form-control" id="associadoA" name="associadoA">
                    </div>
                        <input type="hidden" id="idToUpdate" name="headsetId">
                        <input type="hidden" id="idToUpdate2" name="headsetId2">
                    <div id="result"></div>
                        <button id="gerarInfoBtn" class="btn btn-primary" style="display: none;">Gerar</button>
                     </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                         <button type="submit" class="btn btn-primary" name="atualizarMatriculaBtn">Vincular Matricula</button> 
                        <input type="hidden" id="actionType" name="actionType" value="">
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Botão Ação -->
<div class="modal fade" id="modalacao" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Detalhes do Headset</h5>
                <button type="button" class="btn-close btn-close-transparent" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/caminho/das/funcoes/manutencao_head.php" method="POST">
                <div class="modal-body">
                    <div id="modalContent">
                    <p><strong>Headset que será alterado:</strong></p> 
                    <p id="textoModal"></p>
                    </div>
                    <hr>
                    <div>
                        <button type="submit" class="btn btn-secondary" id="treinamento" name="treinamento">Treinamento</button>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="num_lacre" name="num_lacre">
                    </div>
                    <button type="submit" class="btn btn-secondary" id="inativar" name="inativar">Inativar</button>
                    <button type="submit" class="btn btn-secondary" id="estoque" name="estoque">Estoque</button>
                </div>
                <hr>
                <div class="modal-footer">
                    <select id="manutencao" name="manutencao" class="custom-select">
                        <option selected disabled>Selecionar Defeito</option>
                        <option value="1">Quebrado</option>
                        <option value="2">Microfone</option>
                        <option value="3">Alto Falante</option>
                        <option value="4">Conector</option>
                        <option value="5">Cabo</option>
                    </select>
                    <button type="submit" name="registrar_defeito" class="btn btn-secondary">Registrar defeito</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal - Pesquisar Funcionário -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pesquisar Funcionário por Matrícula</h5>
        <button type="button" class="btn-close btn-close-transparent" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="searchForm">
          <div class="mb-3">
            <label for="matriculaInput" class="form-label">Matrícula:</label>
            <input type="text" class="form-control" id="matriculaInput" placeholder="Digite a matrícula">
          </div>
          <div id="resultado"></div>
          <button type="submit" class="btn btn-primary">Pesquisar</button>
        </form>
        <div id="result"></div>
      </div>
    </div>
  </div>
</div>

<!-- Modal - Cadastrar Head -->
<div class="modal fade" id="casdastrohead" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastrar novos headset</h5>
        <button type="button" class="btn-close btn-close-transparent" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
       </div>
      <form action="/caminho/das/funcoes/cadastrar_head.php" method="post">
      <div class="modal-body">
        <div class="form-group">
             <label for="novo_lacre">Gostaria de cadastrar um novo headset?</label>
             <input type="text" class="form-control" id="novo_lacre" name="novo_lacre" placeholder="Digite o novo lacre">
           </div>
           <div id="resultado"></div>
           <button type="submit" class="btn btn-primary"id="botao_novo_lacre" name="botao_novo_lacre">Cadastrar</button>
             </form>
             <div id="result"></div>
             </div>
            </div>
    </div>
</div>

<!-- script para realizar baixa no headset -->
<script>
        $(document).ready(function(){
            $("#botao_func_desl").click(function(){     
                var matricula = $("#func_desl").val();
                $("#func_desl_hidden").val(matricula);
                $("#func_desl_hidden2").val(matricula);
                $.ajax({
                    url: '/caminho/das/funcoes/pesq_baixa_headset.php',
                    type: 'post',
                    data: {func_desl: matricula},
                    success: function(response){
                        $("#resultados").html(response);
                    }
                });
            });
        });
    </script>

<script>
    $(document).ready(function(){
  $("#baixa").click(function(){
    $("#baixahead").modal('show');
  });
});
</script>


<!-- script para realizar abrir o modal de cadastro dos headsets -->
<script>
    $(document).ready(function(){
  $("#cadashead").click(function(){
    $("#casdastrohead").modal('show');
  });
});
</script>

<!-- scripts para o botão de ação nos headsets -->
<script>
document.querySelectorAll('.botaoacao').forEach(function(botao) {
  botao.addEventListener('click', function(event) {
    var celula = event.target.parentElement.parentElement.children[1];
    document.getElementById('textoModal').textContent = celula.textContent;
    document.getElementById('num_lacre').setAttribute('value', celula.textContent);
    document.getElementById('modalacao').style.display = 'block';
  });
});
</script>

<script>
$(document).ready(function(){
  $(".botaoacao").click(function(){
    $("#modalacao").modal('show');
  });
});
</script>


<!-- script feito para direcionar os botões para as funções corretas, utilizando o form dos modais -->
<script>
$(document).ready(function(){
    $("#inativar").click(function(){
        $("form").attr("action", "/caminho/das/funcoes/inativar_head.php");
    });
    $("#manutencao").click(function(){
        $("form").attr("action", "/caminho/das/funcoes/manutencao_head.php");
    });
    $("#treinamento").click(function(){
        $("form").attr("action", "/caminho/das/funcoes/treinamento_head.php");
    });
    $("#botao_novo_lacre").click(function(){
        $("form").attr("action", "/caminho/das/funcoes/cadastrar_head.php");
    });
    $("#estoque").click(function(){
        $("form").attr("action", "/caminho/das/funcoes/colocar_head_estoque.php");
    });
});
</script>

<!-- InicializA o DataTables com as opções desejadas -->
    <script>
        $(document).ready(function() {
            // Inicialize a tabela como DataTable
            var table = $('table.display').DataTable({
                "select": true,
                // Desative a ordenação inicial da tabela
                "order": [],
                //página aberta incial
                "pageLength": 30,
                // Opções de exibição de registros por página
                "lengthMenu": [30, 50, 70, 100, 200, 500],
                // Opção de paginação
                "paging": true,
                // Habilita a responsividade da tabela
                "responsive": true,
                // Adicione a opção de idioma
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                },
                dom: 'lfrtBp',
                buttons: [{
                    extend: 'csv',
                    text: 'Exportar CSV',
                    className: 'btn-export-csv',
                    customize: function(csv) {
                        // Formata o CSV em UTF-8
                        csv = "\uFEFF" + csv;
                        // Altera o separador para ";"
                        csv = csv.replace(/,/g, ";");
                        // Remove as aspas das strings
                        csv = csv.replace(/"/g, "");
                        return csv;
                    }
                }],
            });

            //ao clicar ele pega as informações da coluna e associa a variaveis e joga no modal
            // Manipulador de eventos de clique na tabela
            $('table.display tbody').on('click', 'td', function() {
             var cellIndex = $(this).index(); // Obtém o índice da célula clicada
             if(cellIndex === 1 || cellIndex === 2) { // Verifica se a célula clicada é a segunda ou terceira coluna
             var rowData = table.row(this).data(); // Obtém os dados da linha clicada
             var column2Data = rowData[1]; // Dados da segunda coluna
            var column3Data = rowData[2]; // Dados da terceira coluna (EmPosse)

        // Monta o conteúdo do modal
        var modalContent = '<p>Headset: ' + column2Data + '</p>';
        modalContent += '<p>Matricula: ' + column3Data + '</p>';

        // Insere o conteúdo no modal
        $('#modalContent').html(modalContent);

        // Define o valor do input oculto com a matrícula do funcionário
        $('#idToUpdate').val(column3Data);

        // Define o valor do input oculto com o numero do headset
        $('#idToUpdate2').val(column2Data);

        // Exibe o modal
        $('#myModal').modal('show');
         }
     });
 });
        
</script>
<script>
        //pegar a informação da 3 coluna armazenada na variavel matricula e jogar pro php
        // Manipulador de eventos de clique no botão "Gerar"
        $('#gerarInfoBtn').click(function(event) {
            event.preventDefault(); // previne o comportamento padrão do formulário de recarregar a página
            var matricula = $('#idToUpdate').val(); // Obtém o valor do input oculto

            // Envie a matrícula para o script PHP via AJAX
            $.ajax({
                url: '/caminho/das/funcoes/funcoes/detalhes_funcionario.php',
                type: 'POST',
                data: { matricula: matricula },
                success: function(data) {
                    // Exibe os dados na página modal
                    $('#result').html(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        
        //esconde o botao gerar e clica automatico
        $(document).ready(function() {
            $('#myModal').on('shown.bs.modal', function () {
                // Simula o clique no botão "Gerar"
                $('#gerarInfoBtn').click();
                
                // Esconde o botão "Gerar"
                $('#gerarInfoBtn').hide();
            });
        });
</script>

<script>
  $(document).ready(function() {
    // Manipulador de eventos de envio do formulário
    $('#searchForm').submit(function(event) {
      event.preventDefault(); // previne o comportamento padrão de envio do formulário

      var matricula = $('#matriculaInput').val(); // Obtém o valor do input de matrícula

      // Envie a matrícula para o script PHP via AJAX
      $.ajax({
        url: '/caminho/das/funcoes/detalhes_funcionario2.php',
        type: 'POST',
        data: { matricula: matricula },
        success: function(data) {
          // Exibe os dados na página modal
          $('#resultado').html(data);
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });
  });

  $(document).ready(function() {
    $('#modalpesquisar').click(function() {
      $('#exampleModal').modal('show');
    });
  });

  $(document).ready(function() {
    // Evento acionado quando o modal é fechado
    $('#exampleModal').on('hidden.bs.modal', function() {
      // Limpa o conteúdo dos campos dentro do modal
      $('#matriculaInput').val('');
      $('#resultado').empty(); // Limpa o conteúdo da div de resultados
    });
  });
</script>

    <script src="/caminho/assets/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Required Js -->
    <script src="/caminhopd/assets/js/vendor-all.min.js"></script>
    <script src="/caminho/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/caminho/assets/js/pcoded.min.js"></script>

    <!-- Biblioteca DataTables -->
    <script type="text/javascript" src="../assets/dataTables/datatables.min.js"></script>
    <script src="../assets/dataTables/Buttons-2.3.6/js/dataTables.buttons.min.js"></script>

    <!-- CSS Datatables -->
    <link rel="stylesheet" href="/caminho/assets/dataTables/Buttons-2.3.6/css/buttons.dataTables.min.css">

    <!-- Biblioteca DataTables -->
    <script type="text/javascript" src="../assets/dataTables/datatables.min.js"></script>
    <script src="../assets/dataTables/Buttons-2.3.6/js/dataTables.buttons.min.js"></script>

</body>
</html>