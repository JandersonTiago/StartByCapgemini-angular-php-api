<?php
// Inclui o arquivo de conexão
include("conexao.php");

// Obtém os dados da requisição POST em formato JSON
$dados_recebidos = file_get_contents("php://input");

// Decodifica os dados JSON em um array associativo
$dados = json_decode($dados_recebidos, true);

// Verifica se os dados foram decodificados com sucesso
if ($dados === null) {
    // Se houver um erro na decodificação JSON, retorna uma mensagem de erro
    echo json_encode(array('error' => 'Erro ao decodificar os dados JSON.'));
} else {
    // Extrai os dados do array associativo
    $idCurso = $dados['cursos']['idCurso'];
    $nomeCurso = $dados['cursos']['nomeCurso'];
    $valorCurso = $dados['cursos']['valorCurso'];

    // Prepara e executa a consulta SQL para atualizar o registro na tabela 'cursos'
    $sql = "UPDATE cursos SET nomeCurso=?, valorCurso=? WHERE idCurso=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssi", $nomeCurso, $valorCurso, $idCurso);
    $resultado = $stmt->execute();

    // Verifica se a consulta foi executada com sucesso
    if ($resultado) {
        // Se a atualização foi bem-sucedida, retorna os dados atualizados em formato JSON
        echo json_encode(array('success' => true, 'message' => 'Curso atualizado com sucesso.'));
    } else {
        // Se ocorreu algum erro na atualização, retorna uma mensagem de erro
        echo json_encode(array('error' => 'Erro ao atualizar o curso.'));
    }

    // Fecha a declaração e a conexão com o banco de dados
    $stmt->close();
    $conexao->close();
}
?>
