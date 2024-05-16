<?php
// Incluir a conexão
include("conexao.php");

// Verificar se a requisição é do tipo DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Extrair o ID do curso da URL
    $idCurso = $_GET['idCurso'] ?? null;

    // Verificar se o ID do curso foi fornecido
    if ($idCurso !== null) {
        // Sanitizar o ID do curso para evitar injeção de SQL
        $idCurso = mysqli_real_escape_string($conexao, $idCurso);

        // SQL para excluir o curso
        $sql = "DELETE FROM `cursos` WHERE `idCurso` = $idCurso";

        // Executar a consulta SQL
        if (mysqli_query($conexao, $sql)) {
            // Exclusão bem-sucedida
            echo json_encode(["message" => "Curso excluído com sucesso"]);
        } else {
            // Erro na exclusão
            echo json_encode(["error" => "Erro ao excluir o curso: " . mysqli_error($conexao)]);
        }
    } else {
        // Caso o ID do curso não tenha sido fornecido na requisição
        echo json_encode(["error" => "Dados incompletos: 'idCurso' não foi fornecido"]);
    }
} else {
    // Caso a requisição não seja do tipo DELETE
    echo json_encode(["error" => "Método não permitido. Esta API suporta apenas requisições DELETE"]);
}
?>
