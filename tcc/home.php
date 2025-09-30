<?php
session_start();
include("config.php");

// 🔹 Para testes: força usuário logado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['usuario_id'] = 1; 
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recanto Olivo - Página Inicial</title>
  <style>
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:Arial,sans-serif;background:#f8f9fa;color:#333;}
    header{background:#2d6a4f;color:#fff;padding:15px 0;}
    header .container{width:90%;margin:auto;display:flex;justify-content:space-between;align-items:center;}
    nav ul{list-style:none;display:flex;gap:20px;}
    nav a{color:#fff;text-decoration:none;font-weight:bold;}
    nav a.active,nav a:hover{text-decoration:underline;}
    .btn-logout{background:#e63946;color:#fff;padding:8px 15px;border-radius:5px;text-decoration:none;font-weight:bold;margin-left:20px;}
    .btn-logout:hover{background:#c1121f;}

    /* 🔹 Banner com imagem */
    .banner{
      background:url("images/img7.png") no-repeat center center/cover;
      color:#fff;
      text-align:center;
      padding:100px 20px;
      position:relative;
    }
    .banner::after{
      content:"";
      position:absolute;
      top:0;left:0;width:100%;height:100%;
      background:rgba(0,0,0,0.4);
    }
    .banner h2,.banner p,.banner-buttons{position:relative;z-index:2;}
    .banner h2{font-size:2.5rem;margin-bottom:15px;}
    .banner p{font-size:1.2rem;margin-bottom:20px;}
    .banner-buttons a{display:inline-block;margin:10px;padding:10px 20px;border-radius:5px;font-weight:bold;text-decoration:none;}
    .btn-primary{background:#ffd93d;color:#2d6a4f;}
    .btn-primary:hover{background:#ffc107;}
    .btn-secondary{background:#fff;color:#2d6a4f;}
    .btn-secondary:hover{background:#ddd;}

    section{padding:50px 20px;}
    .about-content{display:grid;grid-template-columns:1fr 1fr;gap:30px;align-items:center;}
    .about-text ul{list-style:none;margin-top:15px;}
    .about-text li{margin-bottom:8px;}
    .illustrative-image{background:#1b4332;border-radius:10px;display:flex;align-items:center;justify-content:center;height:250px;color:#fff;}

    .highlights-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-top:30px;}
    .highlight-item{background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.1);text-align:center;}
    .highlight-icon{font-size:2rem;margin-bottom:10px;}

    .featured-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;margin-top:30px;}
    .featured-card{background:#fff;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.1);overflow:hidden;}
    .card-image{height:150px;overflow:hidden;}
    .card-image img{width:100%;height:100%;object-fit:cover;}
    .card-content{padding:15px;}
    .card-price{font-weight:bold;color:#2d6a4f;margin:10px 0;}
    .btn-primary{background:#ffd93d;color:#2d6a4f;padding:6px 12px;border-radius:5px;text-decoration:none;font-weight:bold;}
    .btn-primary:hover{background:#ffc107;}

    footer{background:#2d6a4f;color:#fff;padding:40px 20px 20px;margin-top:40px;}
    .footer-content{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:20px;}
    .footer-section h3{color:#ffd93d;margin-bottom:10px;}
    .footer-bottom{text-align:center;font-size:0.9rem;border-top:1px solid rgba(255,255,255,0.2);padding-top:10px;}
  </style>
</head>
<body>
<header>
  <div class="container">
    <div class="logo"><h1>Recanto Olivo</h1><p>Medianeira - PR</p></div>
    <nav>
      <ul>
        <li><a href="home.php" class="active">Início</a></li>
        <li><a href="chales.php">Chalés</a></li>
        <li><a href="kiosques.php">Quiosques</a></li>
        <li><a href="reservas.php">Minhas Reservas</a></li>
      </ul>
    </nav>
    <a href="logout.php" class="btn-logout">Sair</a>
  </div>
</header>

<section class="banner">
  <h2>Bem-vindo ao Recanto Olivo</h2>
  <p>Um refúgio de paz e tranquilidade em Medianeira</p>
  <div class="banner-buttons">
    <a href="chales.php" class="btn-primary">Conheça nossos Chalés</a>
    <a href="kiosques.php" class="btn-secondary">Veja nossos Quiosques</a>
  </div>
</section>

<section class="about">
  <div class="container">
    <h2>Sobre o Recanto Olivo</h2>
    <div class="about-content">
      <div class="about-text">
        <p>O Recanto Olivo é um espaço acolhedor localizado em Medianeira, projetado para proporcionar momentos de descanso e lazer em meio à natureza.</p>
        <ul>
          <li>📍 Localização privilegiada</li>
          <li>🌳 Contato com a natureza</li>
          <li>🏊 Piscina para adultos e crianças</li>
          <li>🍖 Áreas de churrasco equipadas</li>
          <li>🅿️ Estacionamento amplo</li>
        </ul>
      </div>
      <div class="illustrative-image">
        <img src="images/img2.png" alt="Vista do Recanto" style="width:100%; height:100%; object-fit:cover; border-radius:10px;">
      </div>
    </div>
  </div>
</section>

<section class="highlights">
  <div class="container">
    <h2>Por que Escolher o Recanto Olivo?</h2>
    <div class="highlights-grid">
      <div class="highlight-item"><div class="highlight-icon">🏡</div><h3>Chalés Confortáveis</h3></div>
      <div class="highlight-item"><div class="highlight-icon">🌳</div><h3>Área Verde</h3></div>
      <div class="highlight-item"><div class="highlight-icon">🍖</div><h3>Churrasqueiras</h3></div>
      <div class="highlight-item"><div class="highlight-icon">🏊</div><h3>Piscina</h3></div>
    </div>
  </div>
</section>

<section class="featured">
  <div class="container">
    <h2>Chalés em Destaque</h2>
    <div class="featured-grid">
      <!-- Chalé Família -->
      <div class="featured-card">
        <div class="card-image">
          <img src="images/img4.png" alt="Chalé Família">
        </div>
        <div class="card-content">
          <h3>Chalé Família</h3>
          <p>Ideal para famílias, com 2 quartos, sala ampla e varanda.</p>
          <div class="card-price">R$ 200/noite</div>
          <a href="chales.php" class="btn-primary">Ver Detalhes</a>
        </div>
      </div>

      <!-- Chalé Casal -->
      <div class="featured-card">
        <div class="card-image">
          <img src="images/img6.png" alt="Chalé Casal">
        </div>
        <div class="card-content">
          <h3>Chalé Casal</h3>
          <p>Romântico e aconchegante, perfeito para casais.</p>
          <div class="card-price">R$ 150/noite</div>
          <a href="chales.php" class="btn-primary">Ver Detalhes</a>
        </div>
      </div>

      <!-- Chalé Premium -->
      <div class="featured-card">
        <div class="card-image">
          <img src="images/img5.png" alt="Chalé Premium">
        </div>
        <div class="card-content">
          <h3>Chalé Premium</h3>
          <p>Espaçoso e luxuoso, com área de churrasco privativa.</p>
          <div class="card-price">R$ 300/noite</div>
          <a href="chales.php" class="btn-primary">Ver Detalhes</a>
        </div>
      </div>
    </div>
  </div>
</section>

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
        <p><a href="gerenciar_acomodacoes.php">Gerenciar Acomodações</a></p>
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
</body>
</html>
