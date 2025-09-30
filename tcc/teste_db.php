<?php
require_once "config.php";

echo "<h1>Teste de Conexão - Recanto Olivo</h1>";

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "<p style='color: green;'>✅ Conexão com o banco estabelecida com sucesso!</p>";
    
    // Testar consulta
    $query = "SELECT COUNT(*) as total FROM usuarios";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<p>Total de usuários no banco: <strong>" . $result['total'] . "</strong></p>";
    
    // Listar tabelas
    $query = "SHOW TABLES";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<h3>Tabelas criadas:</h3>";
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li>" . $table . "</li>";
    }
    echo "</ul>";
    
    // Testar consulta de acomodações
    $query = "SELECT a.nome, a.preco_diaria, t.nome as tipo 
              FROM acomodacoes a 
              JOIN tipos_acomodacao t ON a.tipo_id = t.id 
              LIMIT 3";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $acomodacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Acomodações cadastradas:</h3>";
    foreach ($acomodacoes as $acomodacao) {
        echo "<p><strong>" . $acomodacao['nome'] . "</strong> (" . $acomodacao['tipo'] . ") - R$ " . $acomodacao['preco_diaria'] . "</p>";
    }
    
} catch(PDOException $exception) {
    echo "<p style='color: red;'>❌ Erro: " . $exception->getMessage() . "</p>";
    echo "<p>Verifique se:</p>";
    echo "<ul>";
    echo "<li>XAMPP está rodando</li>";
    echo "<li>MySQL está iniciado</li>";
    echo "<li>O banco 'recanto_olivo' existe</li>";
    echo "<li>Usuário: root, Senha: (vazia)</li>";
    echo "</ul>";
}
?>

<a href="http://localhost/phpmyadmin" target="_blank">Abrir phpMyAdmin</a>