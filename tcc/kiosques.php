<?php
session_start();
include("config.php");

// 🔹 Pega quiosques do banco
$sql = "SELECT * FROM acomodacoes WHERE tipo_id = 2";
$result = $conexao->query($sql);

// 🔹 Associa cada quiosque a uma imagem fixa
$imagens = [
    "Quiosque Grande" => "img6.png",
    "Quiosque Médio"  => "img5.png",
    "Quiosque Pequeno"=> "img4.png"
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nossos Quiosques - Recanto Olivo</title>
  <style>
    body{font-family:Arial,sans-serif;background:#f8f9fa;margin:0;padding:0;}
    header{background:#2d6a4f;color:#fff;padding:15px 0;}
    header .container{width:90%;margin:auto;display:flex;justify-content:space-between;align-items:center;}
    nav ul{list-style:none;display:flex;gap:20px;}
    nav a{color:#fff;text-decoration:none;font-weight:bold;}
    nav a.active,nav a:hover{text-decoration:underline;}
    .btn-logout{background:#e63946;color:#fff;padding:8px 15px;border-radius:5px;text-decoration:none;font-weight:bold;margin-left:20px;}
    .btn-logout:hover{background:#c1121f;}
    .page-header{text-align:center;padding:40px;background:#d8f3dc;}
    .page-header h1{margin-bottom:10px;}
    .accommodations{padding:40px;}
    .accommodations-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;}
    .card{background:#fff;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.1);padding:20px;text-align:center;}
    .card img{width:100%;height:180px;object-fit:cover;border-radius:8px;margin-bottom:10px;}
    .card h3{margin-bottom:10px;color:#2d6a4f;}
    .card p{font-size:0.9rem;margin-bottom:10px;}
    .price{font-weight:bold;color:#2d6a4f;margin-bottom:15px;}
    .btn-primary{background:#ffd93d;color:#2d6a4f;padding:8px 15px;border-radius:5px;text-decoration:none;font-weight:bold;cursor:pointer;}
    .btn-primary:hover{background:#ffc107;}
    footer{background:#2d6a4f;color:#fff;padding:40px 20px 20px;margin-top:40px;}
    .footer-content{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:20px;}
    .footer-section h3{color:#ffd93d;margin-bottom:10px;}
    .footer-bottom{text-align:center;font-size:0.9rem;border-top:1px solid rgba(255,255,255,0.2);padding-top:10px;}
    
    /* 🔹 Estilo do Modal */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.6);justify-content:center;align-items:center;}
    .modal-content{background:#fff;padding:20px;border-radius:10px;width:400px;max-width:90%;position:relative;}
    .modal-content h2{margin-bottom:15px;color:#2d6a4f;}
    .form-group{margin-bottom:15px;text-align:left;}
    label{font-weight:bold;display:block;margin-bottom:5px;}
    input{width:100%;padding:8px;border:1px solid #ccc;border-radius:5px;}
    .form-actions{text-align:right;}
    .btn-secondary{background:#ddd;color:#333;padding:8px 15px;border-radius:5px;margin-right:10px;cursor:pointer;}
    .btn-secondary:hover{background:#bbb;}
    .close{position:absolute;top:10px;right:15px;font-size:20px;cursor:pointer;color:#333;}
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
        <li><a href="kiosques.php" class="active">Quiosques</a></li>
        <li><a href="reservas.php">Minhas Reservas</a></li>
      </ul>
    </nav>
    <a href="logout.php" class="btn-logout">Sair</a>
  </div>
</header>

<section class="page-header">
  <h1>Nossos Quiosques</h1>
  <p>Conheça nossos quiosques, ideais para encontros e momentos especiais</p>
</section>

<section class="accommodations">
  <div class="container">
    <div class="accommodations-grid">
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="card">
          <?php if(isset($imagens[$row['nome']])): ?>
            <img src="images/<?= $imagens[$row['nome']] ?>" alt="<?= $row['nome'] ?>">
          <?php endif; ?>
          <h3><?= $row['nome'] ?></h3>
          <p><?= $row['descricao'] ?></p>
          <div class="price">R$ <?= number_format($row['preco_diaria'],2,",",".") ?>/dia</div>
          <button class="btn-primary" onclick="openModal(<?= $row['id'] ?>)">Reservar</button>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- 🔹 Modal de Reserva -->
<div id="reservation-modal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Fazer Reserva</h2>
    <form action="reservas.php" method="POST" onsubmit="return validarDatas()">
      <input type="hidden" id="accommodation-id" name="accommodation-id">
      <div class="form-group">
        <label for="checkin">Data de Entrada</label>
        <input type="date" id="checkin" name="checkin" required>
      </div>
      <div class="form-group">
        <label for="checkout">Data de Saída</label>
        <input type="date" id="checkout" name="checkout" required>
      </div>
      <div class="form-group">
        <label for="guests">Número de Pessoas</label>
        <input type="number" id="guests" name="guests" min="1" max="20" required>
      </div>
      <div class="form-actions">
        <button type="button" class="btn-secondary" onclick="closeModal()">Cancelar</button>
        <button type="submit" class="btn-primary">Confirmar</button>
      </div>
    </form>
  </div>
</div>

<footer>
  <div class="container">
    <div class="footer-content">
      <div class="footer-section">
        <h3>Recanto Olivo</h3>
        <p>Medianeira - Paraná</p>
        <p>📧 contato@recantoolivo.com</p>
        <p>📞 (45) 99999-9999</p>
      </div>
      <div class="footer-section">
        <h3>Links Rápidos</h3>
        <p><a href="home.php">Início</a></p>
        <p><a href="chales.php">Chalés</a></p>
        <p><a href="kiosques.php">Quiosques</a></p>
        <p><a href="reservas.php">Minhas Reservas</a></p>
      </div>
      <div class="footer-section">
        <h3>Horário de Atendimento</h3>
        <p>Segunda a Sexta: 8h às 18h</p>
        <p>Sábado e Domingo: 8h às 17h</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; <?= date('Y') ?> Recanto Olivo</p>
    </div>
  </div>
</footer>

<script>
function openModal(id){
  document.getElementById("reservation-modal").style.display = "flex";
  document.getElementById("accommodation-id").value = id;
}
function closeModal(){
  document.getElementById("reservation-modal").style.display = "none";
}

// 🔹 Validação de datas
function validarDatas(){
  let hoje = new Date().toISOString().split("T")[0];
  let checkin = document.getElementById("checkin").value;
  let checkout = document.getElementById("checkout").value;

  if(checkin < hoje){
    alert("A data de entrada não pode ser antes de hoje!");
    return false;
  }
  if(checkout <= checkin){
    alert("A data de saída deve ser antes da entrada!");
    return false;
  }
  return true;
}
</script>
</body>
</html>
