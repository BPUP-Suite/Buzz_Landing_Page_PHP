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

    -- Creazione della tabella roadmap per PostgreSQL
CREATE TABLE IF NOT EXISTS patchnotes (
    id SERIAL PRIMARY KEY,
    titolo VARCHAR(255) NOT NULL,
    tags VARCHAR(255),
    data_inizio DATE NOT NULL,
    data_fine DATE NOT NULL,
    descrizione TEXT,
    stato VARCHAR(20) DEFAULT 'pianificato' CHECK (stato IN ('pianificato', 'in-corso', 'completato'))
);