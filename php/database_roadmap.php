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

// Query to get all versions
$stmt = $conn->prepare("
    SELECT versione 
    FROM roadmap 
    GROUP BY versione
    ORDER BY 
        CASE 
            WHEN versione LIKE '%-pre-alpha%' THEN 1
            WHEN versione LIKE '%-alpha%' THEN 2
            WHEN versione LIKE '%-beta%' THEN 3
            ELSE 4
        END,
        versione ASC;
");
$stmt->execute();
$versions = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Fetch features for all versions
$stmtFeatures = $conn->prepare("
    SELECT 
        r.id, 
        r.versione, 
        r.titolo, 
        r.descrizione, 
        r.tags, 
        r.tipo, 
        r.data_inizio, 
        r.data_fine, 
        r.stato,
        r.categoria
    FROM 
        roadmap r
    ORDER BY 
        r.data_inizio ASC
");
$stmtFeatures->execute();
$allFeatures = $stmtFeatures->fetchAll(PDO::FETCH_ASSOC);

// Group features by version and category
$featuresGrouped = [];
foreach ($allFeatures as $feature) {
    $version = $feature['versione'];
    $category = empty($feature['categoria']) ? 'General' : $feature['categoria'];
    
    if (!isset($featuresGrouped[$version])) {
        $featuresGrouped[$version] = [];
    }
    
    if (!isset($featuresGrouped[$version][$category])) {
        $featuresGrouped[$version][$category] = [];
    }
    
    $featuresGrouped[$version][$category][] = $feature;
}

// Count features by status for progress bars
$versionStats = [];
foreach ($versions as $version) {
    if (isset($featuresGrouped[$version])) {
        $completed = 0;
        $inProgress = 0;
        $planned = 0;
        $total = 0;
        
        foreach ($featuresGrouped[$version] as $category => $features) {
            foreach ($features as $feature) {
                $status = getItemStatus($feature);
                $total++;
                
                if ($status === 'completato') {
                    $completed++;
                } elseif ($status === 'in-corso') {
                    $inProgress++;
                } else {
                    $planned++;
                }
            }
        }
        
        $versionStats[$version] = [
            'completed' => $completed,
            'inProgress' => $inProgress,
            'planned' => $planned,
            'total' => $total,
            'completedPercentage' => $total > 0 ? round(($completed / $total) * 100) : 0,
            'inProgressPercentage' => $total > 0 ? round(($inProgress / $total) * 100) : 0,
            'plannedPercentage' => $total > 0 ? round(($planned / $total) * 100) : 0
        ];
    }
}

function sortVersionsByLatestFeature($versions, $featuresGrouped) {
    $versionDates = [];

    foreach ($versions as $version) {
        if (isset($featuresGrouped[$version])) {
            // Find the latest feature date for each version
            $latestDate = '0000-00-00';
            foreach ($featuresGrouped[$version] as $category) {
                foreach ($category as $feature) {
                    if (strtotime($feature['data_fine']) > strtotime($latestDate)) {
                        $latestDate = $feature['data_fine'];
                    }
                }
            }
            $versionDates[$version] = $latestDate;
        }
    }

    // Sort versions based on the latest feature date
    usort($versions, function($a, $b) use ($versionDates) {
        $dateA = $versionDates[$a] ?? '0000-00-00';
        $dateB = $versionDates[$b] ?? '0000-00-00';
        return strtotime($dateB) - strtotime($dateA);
    });

    return $versions;
}
?>