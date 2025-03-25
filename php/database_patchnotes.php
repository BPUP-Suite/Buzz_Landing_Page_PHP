<?php
include_once "components/config.php";

// Funzione per ottenere i patchnotes
function getPatchnotes() {
    global $conn;
    
    try {
        // Usa la connessione PDO esistente
        $stmt = $conn->prepare("SELECT * FROM patchnotes ORDER BY data_inizio DESC");
        $stmt->execute();
        $patchnotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $patchnotes;
    } catch (PDOException $e) {
        // Gestione dell'errore
        error_log("Errore nel recupero dei patchnotes: " . $e->getMessage());
        return [];
    }
}

// Funzione per formattare le date
function formatDate($date) {
    $timestamp = strtotime($date);
    return date('d/m/Y', $timestamp);
}

// Funzione per analizzare i tag
function parseTags($tagsString) {
    if (empty($tagsString)) return [];
    return explode(',', $tagsString);
}

// Funzione per dividere testo con punto e virgola in array
function splitTextByDelimiter($text) {
    if (empty($text)) return [];
    $items = explode(';', $text);
    return array_map('trim', $items);
}

// Ottieni i dati
$patchnotesItems = getPatchnotes();
?>