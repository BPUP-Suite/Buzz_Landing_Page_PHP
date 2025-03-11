<?php
include 'components/config.php';

// Funzione per formattare le date
function formatDate($date)
{
    return date("d/m/Y", strtotime($date));
}

// Funzione per determinare lo stato di un elemento
function getItemStatus($item)
{
    $today = date('Y-m-d');

    if (isset($item['stato']) && !empty($item['stato'])) {
        return $item['stato'];
    } else if ($today > $item['data_fine']) {
        return 'completato';
    } else if ($today >= $item['data_inizio'] && $today <= $item['data_fine']) {
        return 'in-corso';
    } else {
        return 'pianificato';
    }
}

// Funzione per ottenere la classe CSS in base allo stato
function getStatusClass($status)
{
    switch ($status) {
        case 'completato':
            return 'completed';
        case 'in-corso':
            return 'in-progress';
        case 'pianificato':
            return 'planned';
        default:
            return '';
    }
}

// Funzione per ottenere l'icona in base allo stato
function getStatusIcon($status)
{
    switch ($status) {
        case 'completato':
            return '<i class="fas fa-check-circle"></i>';
        case 'in-corso':
            return '<i class="fas fa-spinner fa-spin"></i>';
        case 'pianificato':
            return '<i class="fas fa-calendar-alt"></i>';
        default:
            return '';
    }
}

// Funzione per convertire i tag da stringa a array
function parseTags($tagsString)
{
    if (empty($tagsString))
        return [];
    return explode(',', $tagsString);
}

?>