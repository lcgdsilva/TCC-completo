<?php
session_start();
include("config.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Busca reservas com preço da acomodação
$sql = "SELECT r.id, a.nome AS acomodacao, r.checkin, r.checkout, r.pessoas, r.status, a.preco_diaria 
        FROM reservas r
        JOIN acomodacoes a ON r.acomodacao_id = a.id
        WHERE r.usuario_id = $usuario_id
        ORDER BY r.checkin DESC";
$result = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Minhas Reservas - Recanto Olivo</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin:0; 
            padding:0; 
            background:#f8f9fa; 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column;
        }
        header { background:#2f5233; color:#fff; padding:15px 0; }
        header .container { width:90%; margin:auto; display:flex; justify-content:space-between; align-items:center; }
        header h1 { margin:0; }
        nav ul { list-style:none; display:flex; gap:15px; margin:0; padding:0; }
        nav ul li a { color:#fff; text-decoration:none; font-weight:bold; }
        nav ul li a:hover { text-decoration:underline; }
        .logout-btn { background:#c0392b; padding:6px 12px; border-radius:5px; text-decoration:none; color:white; font-size:14px; }
        .page-header { background:#3e7845; color:#fff; padding:30px 0; text-align:center; }
        .container { width:90%; margin:20px auto; flex: 1; }
        table { width:100%; border-collapse:collapse; margin-top:20px; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding:12px; text-align:left; border-bottom:1px solid #ddd; }
        th { background:#2f5233; color:#fff; }
        tr:hover { background:#f1f1f1; }
        .status-confirmed { color:green; font-weight:bold; }
        .status-pending { color:orange; font-weight:bold; }
        .status-cancelled { color:red; font-weight:bold; }
        .btn { padding:6px 12px; border-radius:5px; text-decoration:none; font-size:14px; font-weight:bold; border:none; cursor:pointer; }
        .btn-danger { background:#e63946; color:#fff; }
        .btn-danger:hover { background:#c1121f; }
        .btn-warning { background:#f4a261; color:#fff; }
        .btn-warning:hover { background:#e76f51; }
        footer { background:#2f5233; color:#fff; text-align:center; padding:15px; }
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
                <li><a href="home.php">Início</a></li>
                <li><a href="chales.php">Chalés</a></li>
                <li><a href="kiosques.php">Quiosques</a></li>
                <li><a href="reservas.php" class="active">Minhas Reservas</a></li>
                <li><a href="logout.php" class="logout-btn">Sair</a></li>
            </ul>
        </nav>
    </div>
</header>

<section class="page-header">
    <h1>Minhas Reservas</h1>
    <p>Acompanhe suas reservas de chalés e quiosques</p>
</section>

<div class="container">
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Acomodação</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Pessoas</th>
                <th>Status</th>
                <th>Valor Total</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()):
                $dias = (strtotime($row['checkout']) - strtotime($row['checkin'])) / (60*60*24);
                if ($dias < 1) $dias = 1; // pelo menos 1 diária
                $valor_total = $dias * $row['preco_diaria'];
            ?>
            <tr>
                <td><?= $row['acomodacao'] ?></td>
                <td><?= date("d/m/Y", strtotime($row['checkin'])) ?></td>
                <td><?= date("d/m/Y", strtotime($row['checkout'])) ?></td>
                <td><?= $row['pessoas'] ?></td>
                <td class="status-<?= strtolower($row['status']) ?>"><?= ucfirst($row['status']) ?></td>
                <td>R$ <?= number_format($valor_total, 2, ',', '.') ?></td>
                <td>
                    <a href="editar_reserva.php?id=<?= $row['id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="excluir_reserva.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta reserva?')">Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Você ainda não possui reservas.</p>
    <?php endif; ?>
</div>

<footer>
    &copy; 2025 Recanto Olivo de Medianeira. Todos os direitos reservados.
</footer>
</body>
</html>
