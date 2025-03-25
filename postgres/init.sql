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