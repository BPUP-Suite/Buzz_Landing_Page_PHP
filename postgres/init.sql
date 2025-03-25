-- Create the roadmap table
CREATE TABLE IF NOT EXISTS roadmap (
    id SERIAL PRIMARY KEY,
    versione VARCHAR(50) NOT NULL,
    titolo VARCHAR(255) NOT NULL,
    descrizione TEXT,
    tags TEXT,
    tipo VARCHAR(50) CHECK (tipo IN ('server', 'client', 'both')),
    data_inizio DATE NOT NULL,
    data_fine DATE NOT NULL,
    stato VARCHAR(50) CHECK (stato IN ('completato', 'in-corso', 'pianificato', '')),
    categoria VARCHAR(100)
);

-- Create the patchnotes table
CREATE TABLE IF NOT EXISTS patchnotes (
    id SERIAL PRIMARY KEY,
    titolo VARCHAR(255) NOT NULL,
    tags VARCHAR(255),
    data_inizio DATE NOT NULL,
    data_fine DATE NOT NULL,
    bug_fixes TEXT,
    features TEXT,
    improvements TEXT,
    known_issues TEXT
);

-- Patch 1: Versione più recente
INSERT INTO patchnotes (titolo, tags, data_inizio, data_fine, bug_fixes, features, improvements, known_issues)
VALUES (
    'Versione 1.2.0 - Nuove Funzionalità',
    'interfaccia,performance,sicurezza',
    '2025-03-01',
    '2025-03-20',
    'Risolto crash durante il caricamento dei file di grandi dimensioni; Corretto errore di visualizzazione nella dashboard; Fixato problema di sincronizzazione con dispositivi mobili',
    'Nuova interfaccia utente completamente ridisegnata; Sistema di notifiche in tempo reale; Modalità dark/light automatica; Supporto per dispositivi touch',
    'Migliorata la velocità di caricamento del 30%; Ridotto consumo di memoria; Ottimizzato il codice per migliori prestazioni; Migliorata compatibilità con browser meno recenti',
    'Menu a tendina a volte non risponde al primo click; Possibili rallentamenti con connessioni lente'
);

-- Patch 2: Versione intermedia
INSERT INTO patchnotes (titolo, tags, data_inizio, data_fine, bug_fixes, features, improvements, known_issues)
VALUES (
    'Versione 1.1.5 - Patch di Sicurezza',
    'sicurezza,bug-fix,database',
    '2025-02-01',
    '2025-02-15',
    'Risolte vulnerabilità XSS in form di contatto; Corretti errori SQL injection; Risolto problema di timeout nelle sessioni utente',
    'Implementazione sistema di autenticazione a due fattori; Dashboard di sicurezza per amministratori; Log avanzato delle attività sospette',
    'Migliorato sistema di cifratura dati; Ottimizzate query database per ridurre tempi di risposta; Aggiunto supporto per password più complesse',
    'La dashboard di sicurezza potrebbe non mostrare eventi più vecchi di 30 giorni; L''attivazione 2FA richiede riavvio dell''applicazione'
);

-- Patch 3: Versione base
INSERT INTO patchnotes (titolo, tags, data_inizio, data_fine, bug_fixes, features, improvements, known_issues)
VALUES (
    'Versione 1.1.0 - Aggiornamento Funzionalità',
    'feature,database,UI',
    '2025-01-10',
    '2025-01-25',
    'Risolto bug #324 nel modulo utenti; Corretti problemi di visualizzazione su Safari; Risolto crash durante l''esportazione di report',
    'Nuova funzionalità di esportazione dati in Excel; Grafici interattivi per statistiche; Barra di ricerca avanzata; Sistema di tag per documenti',
    'Accelerato caricamento pagina principale; Migliorata interfaccia su dispositivi mobili; Ridotto utilizzo CPU durante operazioni intensive',
    'L''esportazione di dataset molto grandi può causare rallentamenti; Alcuni grafici non si visualizzano correttamente in modalità stampa'
);

-- Patch 4: Versione iniziale
INSERT INTO patchnotes (titolo, tags, data_inizio, data_fine, bug_fixes, features, improvements, known_issues)
VALUES (
    'Versione 1.0.0 - Rilascio Iniziale',
    'release,core',
    '2024-12-01',
    '2024-12-15',
    'Stabilizzato sistema di login; Risolti problemi con database',
    'Sistema di gestione documentale; Dashboard personalizzabile; Login utenti; Sistema di autorizzazioni; API RESTful',
    'Ottimizzazione generale dopo i test beta; Migliorata compatibilità cross-browser',
    'Import di file molto grandi può causare timeout; Alcuni elementi UI potrebbero non essere ottimizzati per schermi molto piccoli'
);