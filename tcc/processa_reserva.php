<?php
session_start();
include("config.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $accommodation_id = $_POST['accommodation-id'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $guests = $_POST['guests'];

    // 🔹 Verifica datas
    if ($checkin < date("Y-m-d")) {
        echo "<script>alert('A data de entrada não pode ser antes de hoje!');history.back();</script>";
        exit;
    }
    if ($checkout <= $checkin) {
        echo "<script>alert('A data de saída deve ser depois da entrada!');history.back();</script>";
        exit;
    }

    // 🔹 Insere a reserva no banco
    $sql = "INSERT INTO reservas (usuario_id, acomodacao_id, checkin, checkout, pessoas, status) 
            VALUES ('$usuario_id', '$accommodation_id', '$checkin', '$checkout', '$guests', 'Confirmada')";

    if ($conexao->query($sql) === TRUE) {
        header("Location: reservas.php");
        exit;
    } else {
        echo "Erro ao processar reserva: " . $conexao->error;
    }
}
?>
