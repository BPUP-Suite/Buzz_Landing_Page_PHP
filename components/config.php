<?php
// Configurazione connessione al database PostgreSQL
$host = 'postgresql'; // Il nome del servizio nel docker-compose
$dbname = 'progetto_db';
$user = 'root';
$pass = 'root';

try {
    // Connessione al database PostgreSQL
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query per recuperare tutti gli elementi della roadmap
    $stmt = $conn->prepare("SELECT * FROM patchnotes ORDER BY data_inizio ASC");
    $stmt->execute();
    $roadmapItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Errore di connessione al database: " . $e->getMessage());
}
?>