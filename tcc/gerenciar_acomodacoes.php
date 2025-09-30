<?php
session_start();
include("config.php");

// 🔹 Busca todas as acomodações
$sql = "SELECT * FROM acomodacoes ORDER BY tipo_id, nome";
$result = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Gerenciar Acomodações - Recanto Olivo</title>
  <style>
    body { font-family: Arial, sans-serif; margin:0; padding:0; background:#f8f9fa; }
    header { background:#2d6a4f; color:#fff; padding:15px 0; }
    header .container { width:90%; margin:auto; display:flex; justify-content:space-between; align-items:center; }
    nav ul { list-style:none; display:flex; gap:20px; }
    nav a { color:#fff; text-decoration:none; font-weight:bold; }
    nav a.active, nav a:hover { text-decoration:underline; }
    .btn-logout { background:#e63946; color:#fff; padding:8px 15px; border-radius:5px; text-decoration:none; font-weight:bold; margin-left:20px; }
    .btn-logout:hover { background:#c1121f; }
    .page-header { text-align:center; padding:40px; background:#d8f3dc; }
    .container { width:90%; margin:20px auto; }

    table { width:100%; border-collapse:collapse; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
    th, td { padding:12px; border-bottom:1px solid #ddd; text-align:left; }
    th { background:#2d6a4f; color:#fff; }
    tr:hover { background:#f1f1f1; }
    a.btn { padding:6px 12px; border-radius:5px; text-decoration:none; font-weight:bold; font-size:14px; }
    .btn-edit { background:#52b788; color:#fff; }
    .btn-delete { background:#e63946; color:#fff; }
    .btn-add { background:#ffd93d; color:#2d6a4f; display:inline-block; margin-bottom:15px; }

    footer { background:#2d6a4f; color:#fff; padding:40px 20px 20px; margin-top:40px; text-align:center; }
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
  <h1>Gerenciar Acomodações</h1>
  <p>Adicione, edite ou exclua chalés e quiosques</p>
</section>

<div class="container">
  <a href="nova_acomodacao.php" class="btn btn-add">➕ Nova Acomodação</a>
  <table>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>Descrição</th>
      <th>Preço</th>
      <th>Tipo</th>
      <th>Ações</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['nome'] ?></td>
        <td><?= $row['descricao'] ?></td>
        <td>R$ <?= number_format($row['preco_diaria'],2,",",".") ?></td>
        <td><?= $row['tipo_id'] == 1 ? 'Chalé' : 'Quiosque' ?></td>
        <td>
          <a href="editar_acomodacao.php?id=<?= $row['id'] ?>" class="btn btn-edit">Editar</a>
          <a href="excluir_acomodacao.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Deseja excluir esta acomodação?')">Excluir</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>

<footer>
  <p>&copy; <?= date('Y') ?> Recanto Olivo - Todos os direitos reservados</p>
</footer>
</body>
</html>
