/**
 * translator.js
 * Se encarga de cargar las traducciones buscando en la carpeta GlobalAssets (../GlobalAssets)
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Detectar el idioma (URL o LocalStorage)
    const currentLang = getLanguage();

    // 2. Si el idioma es distinto de español, ejecutamos la traducción
    if (currentLang && currentLang !== 'es') {
        // IMPORTANTE: '../GlobalAssets' sube un nivel para salir de la carpeta de Login
        loadLanguage(currentLang, '../GlobalAssets');
    }
});


async function loadLanguage(lang, path) {
    try {
        // Construimos la ruta al JSON: ../GlobalAssets/lang/en.json
        const response = await fetch(`${path}/lang/${lang}.json`);

        if (!response.ok) {
            throw new Error(`No se pudo cargar el archivo de idioma: ${path}/lang/${lang}.json`);
        }

        const translations = await response.json();

        // Aplicamos las traducciones a los elementos con data-i18n
        document.querySelectorAll('[data-i18n]').forEach(element => {
            const key = element.getAttribute('data-i18n');
            if (translations[key]) {
                // Si es un input o textarea, cambiamos el placeholder
                if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                    element.placeholder = translations[key];
                } 
                // Si es texto normal
                else {
                    element.innerHTML = translations[key];
                }
            }
        });

        // Aseguramos que la preferencia se mantenga guardada
        localStorage.setItem('e3i_lang', lang);

    } catch (error) {
        console.error('Error cargando traducciones:', error);
    }
}

function getLanguage() {
    // Prioridad 1: Si viene en la URL (?lang=en)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('lang')) return urlParams.get('lang');

    // Prioridad 2: Si ya estaba guardado en el navegador
    if (localStorage.getItem('e3i_lang')) return localStorage.getItem('e3i_lang');

    // Por defecto: Español
    return 'es'; 
}