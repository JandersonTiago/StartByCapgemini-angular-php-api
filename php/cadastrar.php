<?php
// Incluir a conexão
include("conexao.php");

// Obter dados
$obterDados = file_get_contents("php://input");

// Extrair os dados do JSON
$extrair = json_decode($obterDados);

// Verificar se a propriedade "cursos" está presente e não é nula
if (isset($extrair->cursos) && !empty($extrair->cursos)) {
    // Separar os dados do JSON
    $nomeCurso = mysqli_real_escape_string($conexao, $extrair->cursos->nomeCurso);
    $valorCurso = mysqli_real_escape_string($conexao, $extrair->cursos->valorCurso);

    // SQL com prepared statement
    $sql = "INSERT INTO cursos (nomeCurso, valorCurso) VALUES (?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "si", $nomeCurso, $valorCurso);
    $resultado = mysqli_stmt_execute($stmt);

    // Preparar a resposta JSON
    $resposta = [];

    if ($resultado) {
        // Dados cadastrados com sucesso
        $curso = [
            'nomeCurso' => $nomeCurso,
            'valorCurso' => $valorCurso
        ];
        $resposta['curso'] = $curso;
    } else {
        // Erro ao cadastrar
        $resposta['erro'] = 'Erro ao cadastrar curso: ' . mysqli_error($conexao);
    }

    // Retornar a resposta como JSON
    echo json_encode($resposta);
} else {
    // Resposta inválida
    echo json_encode(['erro' => 'Resposta inválida: propriedade "cursos" não definida']);
}
?>
