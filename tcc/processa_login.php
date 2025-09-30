<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar usuário
    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verificar senha password verify pega a senha no banco de dados e verifica se a senha digitada esta correta com a salva no banco 
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];

            header("Location: home.php");
            exit;
        } else {
            echo "<script>alert('Usuário ou senha inválidos!'); window.location.href='login.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Usuário ou senha inválidos!'); window.location.href='login.php';</script>";
        exit;
    }
}
?>
