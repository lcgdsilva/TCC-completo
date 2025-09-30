<?php
session_start();
include("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $tipo = $_POST['tipo'];

    $sql = "INSERT INTO acomodacoes (nome, descricao, preco_diaria, tipo_id) VALUES ('$nome', '$descricao', '$preco', '$tipo')";
    if ($conexao->query($sql)) {
        header("Location: gerenciar_acomodacoes.php");
        exit;
    } else {
        echo "Erro ao salvar: " . $conexao->error;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Nova Acomodação - Recanto Olivo</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f8f9fa; margin:0; padding:0; }
    header { background:#2d6a4f; color:#fff; padding:15px 0; }
    header .container { width:90%; margin:auto; display:flex; justify-content:space-between; align-items:center; }
    nav ul { list-style:none; display:flex; gap:20px; }
    nav a { color:#fff; text-decoration:none; font-weight:bold; }
    nav a.active, nav a:hover { text-decoration:underline; }
    .btn-logout { background:#e63946; color:#fff; padding:8px 15px; border-radius:5px; text-decoration:none; font-weight:bold; margin-left:20px; }
    .btn-logout:hover { background:#c1121f; }
    .page-header { text-align:center; padding:40px; background:#d8f3dc; }
    .container { width:90%; margin:20px auto; background:#fff; padding:20px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }

    label { font-weight:bold; display:block; margin:10px 0 5px; }
    input, textarea, select { width:100%; padding:8px; border:1px solid #ccc; border-radius:5px; }
    button { margin-top:15px; padding:10px 20px; background:#2d6a4f; color:#fff; border:none; border-radius:5px; font-weight:bold; cursor:pointer; }
    button:hover { background:#1b4332; }

    footer { background:#2d6a4f; color:#fff; padding:20px; margin-top:40px; text-align:center; }
  </style>
</head>
<body>
<header>
  <div class="container">
    <div class="logo"><h1>Recanto Olivo</h1></div>
    <nav>
      <ul>
        <li><a href="home.php">Início</a></li>
        <li><a href="chales.php">Chalés</a></li>
        <li><a href="kiosques.php">Quiosques</a></li>
        <li><a href="reservas.php">Minhas Reservas</a></li>
        <li><a href="gerenciar_acomodacoes.php" class="active">Gerenciar</a></li>
      </ul>
    </nav>
    <a href="logout.php" class="btn-logout">Sair</a>
  </div>
</header>

<section class="page-header">
  <h1>Nova Acomodação</h1>
</section>

<div class="container">
  <form method="POST">
    <label>Nome:</label>
    <input type="text" name="nome" required>

    <label>Descrição:</label>
    <textarea name="descricao" rows="4" required></textarea>

    <label>Preço da diária:</label>
    <input type="number" step="0.01" name="preco" required>

    <label>Tipo:</label>
    <select name="tipo" required>
      <option value="1">Chalé</option>
      <option value="2">Quiosque</option>
    </select>

    <button type="submit">Salvar</button>
  </form>
</div>

<footer>
  <p>&copy; <?= date('Y') ?> Recanto Olivo - Todos os direitos reservados</p>
</footer>
</body>
</html>
