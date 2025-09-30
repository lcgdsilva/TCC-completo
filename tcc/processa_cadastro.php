<?php
session_start();
include("config.php");
   // pega dados do formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];
    $confirmar = $_POST['confirm-password'];

    // Verificar se as senhas coincidem
    if ($senha !== $confirmar) {
        echo "<script>alert('As senhas não coincidem!'); window.location.href='cadastro.php';</script>";
        exit;
    }

    // Verificar tamanho da senha
    if (strlen($senha) < 6) {
        echo "<script>alert('A senha deve ter pelo menos 6 caracteres!'); window.location.href='cadastro.php';</script>";
        exit;
    }

    // Verificar se o email já existe
    $sql = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        echo "<script>alert('Este email já está cadastrado!'); window.location.href='cadastro.php';</script>";
        exit;
    }

    // Criptografar a senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir no banco
    $sql = "INSERT INTO usuarios (nome, email, telefone, senha) VALUES (?,?,?,?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssss", $nome, $email, $telefone, $senhaHash);
    // inserri no banco de dados
    if ($stmt->execute()) {
        $_SESSION['usuario_id'] = $stmt->insert_id;
        $_SESSION['usuario_nome'] = $nome;
        header("Location: home.php");
        exit;
    } else {
        echo "<script>alert('Erro ao cadastrar: " . $conexao->error . "'); window.location.href='cadastro.php';</script>";
    }
}
?>
