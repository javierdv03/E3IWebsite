async function loadLanguage(lang, path = "GlobalAssets") {
    try {

        const response = await fetch(`${path}/lang/${lang}.json`);
        if (!response.ok) throw new Error(`No se pudo cargar el idioma: ${lang}`);
        
        const translations = await response.json();

        document.querySelectorAll('[data-i18n]').forEach(element => {
            const key = element.getAttribute('data-i18n');
            if (translations[key]) {
                if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                    element.placeholder = translations[key];
                } else {
                    element.innerHTML = translations[key];
                }
            }
        });


        localStorage.setItem('e3i_lang', lang);
        
        updateLangButtons(lang);

    } catch (error) {
        console.error('Error traduciendo:', error);
    }
}


function getLanguage() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('lang')) return urlParams.get('lang');
    if (localStorage.getItem('e3i_lang')) return localStorage.getItem('e3i_lang');
    return 'es'; 
}


function updateLangButtons(lang) {
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.style.fontWeight = (btn.dataset.lang === lang) ? '700' : '400';
        btn.style.color = (btn.dataset.lang === lang) ? '#00A651' : '#333';
    });
}

window.changeLanguage = (lang) => {
    const url = new URL(window.location);
    url.searchParams.set('lang', lang);
    window.location.href = url.toString();
};