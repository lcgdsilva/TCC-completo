<?php
session_start();
include("config.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "Reserva inválida.";
    exit;
}

$reserva_id = intval($_GET['id']);
$usuario_id = $_SESSION['usuario_id'];

// Buscar dados da reserva
$sql = "SELECT * FROM reservas WHERE id = ? AND usuario_id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $reserva_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Reserva não encontrada.";
    exit;
}

$reserva = $result->fetch_assoc();

// Atualizar reserva
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $pessoas = intval($_POST['pessoas']);

    $sql_update = "UPDATE reservas SET checkin = ?, checkout = ?, pessoas = ? WHERE id = ? AND usuario_id = ?";
    $stmt = $conexao->prepare($sql_update);
    $stmt->bind_param("ssiii", $checkin, $checkout, $pessoas, $reserva_id, $usuario_id);

    if ($stmt->execute()) {
        header("Location: reservas.php");
        exit;
    } else {
        echo "Erro ao atualizar: " . $conexao->error;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0; padding: 0;
            background-color: #f8f9fa;
        }
        header {
            background-color: #2d6a4f;
            color: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            margin: 0;
            font-size: 22px;
        }
        header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-left: 15px;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2d6a4f;
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
        .btn {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #2d6a4f;
            color: white;
        }
        .btn-primary:hover {
            background-color: #1b4332;
        }
        .btn-secondary {
            background-color: #363535ff;
            color: white;
            margin-top: 10px;
        }
        .btn-secondary:hover {
            background-color: #999;
        }
    </style>
</head>
<body>
    <header>
        <h1>Recanto Olivo</h1>
        <nav>
            <a href="home.php">Início</a>
            <a href="chales.php">Chalés</a>
            <a href="quiosques.php">Quiosques</a>
            <a href="reservas.php">Minhas Reservas</a>
        </nav>
    </header>

    <div class="container">
        <h2>Editar Reserva</h2>
        <form method="POST">
            <label for="checkin">Data de Check-in:</label>
            <input type="date" name="checkin" value="<?= $reserva['checkin'] ?>" required>

            <label for="checkout">Data de Check-out:</label>
            <input type="date" name="checkout" value="<?= $reserva['checkout'] ?>" required>

            <label for="pessoas">Número de Pessoas:</label>
            <input type="number" name="pessoas" value="<?= $reserva['pessoas'] ?>" min="1" required>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="reservas.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
        </form>
    </div>
</body>
</html>
