document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburgerBtn');
    const mainNav = document.getElementById('mainNav');
    const body = document.body;

    // Función para mostrar / ocultar el widget de accesibilidad
    function setAccessibilityVisible(visible) {
        const widget = document.querySelector('.accessibility-widget');
        if (!widget) return;

        if (visible) {
            widget.style.display = '';
        } else {
            // Ocultamos el widget y aseguramos que el panel quede cerrado
            widget.style.display = 'none';
            widget.classList.remove('panel-open');

            const panel = widget.querySelector('.accessibility-panel');
            const overlay = widget.querySelector('.accessibility-overlay');
            if (panel) panel.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
        }
    }

    if (hamburger && mainNav) {
        
        hamburger.addEventListener('click', function(e) {
            e.stopPropagation(); 
            
            hamburger.classList.toggle('active');
            mainNav.classList.toggle('active');
            
            const menuOpen = mainNav.classList.contains('active');

            // Prevenir scroll del body cuando el menú está abierto
            body.style.overflow = menuOpen ? 'hidden' : '';

            // Ocultar accesibilidad cuando el menú está abierto
            setAccessibilityVisible(!menuOpen);
        });
        
        const navLinks = mainNav.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                hamburger.classList.remove('active');
                mainNav.classList.remove('active');
                body.style.overflow = '';
                setAccessibilityVisible(true);   // volver a mostrar accesibilidad
            });
        });
        
        document.addEventListener('click', function(event) {
            const isClickInsideNav = mainNav.contains(event.target);
            const isClickOnHamburger = hamburger.contains(event.target);
            
            if (!isClickInsideNav && !isClickOnHamburger && mainNav.classList.contains('active')) {
                hamburger.classList.remove('active');
                mainNav.classList.remove('active');
                body.style.overflow = '';
                setAccessibilityVisible(true);
            }
        });
        
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && mainNav.classList.contains('active')) {
                hamburger.classList.remove('active');
                mainNav.classList.remove('active');
                body.style.overflow = '';
                setAccessibilityVisible(true);
            }
        });
    }
});
