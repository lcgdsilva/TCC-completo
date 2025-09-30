<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Recanto Olivo</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9;
        }

        header {
            background: #2c5530;
            padding: 15px 0;
            color: white;
        }
        header .container {
            width: 90%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header .logo h1 {
            margin: 0;
        }
        header .logo p {
            margin: 0;
            font-size: 14px;
        }
        header nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        header nav ul li {
            margin-left: 20px;
        }
        header nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        header nav ul li a:hover {
            text-decoration: underline;
        }

        .auth-section {
            padding: 40px 0;
        }
        .auth-container {
            width: 90%;
            max-width: 900px;
            margin: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: center;
        }
        .auth-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .auth-form h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #2c5530;
        }
        .auth-form p {
            text-align: center;
            margin-bottom: 20px;
            color: #555;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }
        .form-group input:invalid {
            border-color: red;
        }
        .btn-primary {
            background: #ffd93d;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-primary:hover {
            background: #ffca2c;
        }
        .auth-links {
            margin-top: 15px;
            text-align: center;
        }
        .auth-links a {
            color: #2c5530;
            font-weight: bold;
            text-decoration: none;
        }
        footer {
            background: #1e3a22;
            color: white;
            padding: 20px 0;
            margin-top: 40px;
        }
        footer .container {
            width: 90%;
            margin: auto;
            text-align: center;
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <h1>Recanto Olivo</h1>
            <p>Medianeira - PR</p>
        </div>
        <nav>
            <ul>
                <li><a href="#" onclick="alertNaoLogado()">Início</a></li>
                <li><a href="#" onclick="alertNaoLogado()">Chalés</a></li>
                <li><a href="#" onclick="alertNaoLogado()">Quiosques</a></li>
                <li><a href="#" onclick="alertNaoLogado()">Minhas Reservas</a></li>
            </ul>
        </nav>
    </div>
</header>

<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <div class="auth-form">
                <h2>Criar Conta</h2>
                <p>Cadastre-se para fazer reservas online</p>
                <form id="register-form" method="post" action="processa_cadastro.php" onsubmit="return validarCadastro()">
                    <div class="form-group">
                        <label for="name">Nome Completo</label>
                        <input type="text" id="name" name="nome" required placeholder="Seu nome completo">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required placeholder="seu@email.com">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefone</label>
                        <input type="tel" id="phone" name="telefone" required placeholder="(45) 99999-9999">
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" id="password" name="senha" required placeholder="Mínimo 6 caracteres">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirmar Senha</label>
                        <input type="password" id="confirm-password" name="confirm-password" required placeholder="Digite a senha novamente">
                    </div>
                    <button type="submit" class="btn-primary">Cadastrar</button>
                </form>
                <div class="auth-links">
                    <p>Já tem uma conta? <a href="login.php">Faça login aqui</a></p>
                </div>
            </div>
            <div class="auth-illustration">
                <div style="background:#2c5530; color:white; padding:50px; border-radius:10px; text-align:center;">
                    <span style="font-size:50px;">👥</span>
                    <p>Cadastro de Usuário</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <p>&copy; 2023 Recanto Olivo de Medianeira. Todos os direitos reservados.</p>
    </div>
</footer>

<script>
    function alertNaoLogado() {
        alert("Você precisa estar logado para acessar esta página!");
    }

    function validarCadastro() {
        let senha = document.getElementById("password").value;
        let confirmar = document.getElementById("confirm-password").value;
        let telefone = document.getElementById("phone").value;
        let email = document.getElementById("email").value;

        // senha com pelo menos 6 caracteres
        if (senha.length < 6) {
            alert("A senha deve ter no mínimo 6 caracteres!");
            return false;
        }

        // confirmar senha
        if (senha !== confirmar) {
            alert("As senhas não coincidem!");
            return false;
        }

        // validar email simples (tem @ e .)
        let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regexEmail.test(email)) {
            alert("Por favor, insira um email válido (ex: nome@dominio.com).");
            return false;
        }

        // telefone máscara simples
        let regexTelefone = /^\(\d{2}\)\s\d{5}-\d{4}$/;
        if (!regexTelefone.test(telefone)) {
            alert("O telefone deve estar no formato (99) 99999-9999");
            return false;
        }

        return true;
    }

    // máscara automática no telefone
    document.getElementById("phone").addEventListener("input", function(e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
    });
</script>
</body>
</html>
