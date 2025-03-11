// Tema light/dark toggle

// Funzione per applicare il tema corrente
function applyTheme() {
    try {
        // Controlla se esiste una preferenza salvata
        const lightModeStatus = localStorage.getItem('lightMode');
        
        // Se non esiste una preferenza, lascia dark mode come default
        if (lightModeStatus === null) {
            localStorage.setItem('lightMode', 'disabled');
            console.log('Tema scuro impostato come predefinito');
            return;
        }
        
        // Altrimenti usa la preferenza salvata
        const lightMode = lightModeStatus === 'enabled';
        
        if (lightMode) {
            document.body.classList.add('light-mode');
        } else {
            document.body.classList.remove('light-mode');
        }
        
        console.log('Tema applicato:', lightMode ? 'chiaro' : 'scuro');
    } catch (error) {
        console.error('Errore nell\'applicazione del tema:', error);
    }
}

// Quando la pagina viene caricata, applica il tema
document.addEventListener('DOMContentLoaded', function() {
    applyTheme();
    
    // Gestione del pulsante per cambiare tema
    const themeToggle = document.getElementById('theme-toggle');
    
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            // Toggle della classe light-mode
            document.body.classList.toggle('light-mode');
            
            // Salva la preferenza in localStorage
            try {
                if (document.body.classList.contains('light-mode')) {
                    localStorage.setItem('lightMode', 'enabled');
                    console.log('Tema chiaro attivato e salvato');
                } else {
                    localStorage.setItem('lightMode', 'disabled');
                    console.log('Tema scuro attivato e salvato');
                }
            } catch (error) {
                console.error('Errore nel salvataggio del tema:', error);
            }
        });
    } else {
        console.warn('Elemento theme-toggle non trovato nella pagina');
    }
});