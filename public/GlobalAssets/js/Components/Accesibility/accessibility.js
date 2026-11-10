class AccessibilityWidget {

    // 1. Eliminamos la propiedad estática fija.
    // Ahora la ruta se gestiona en la instancia.

    constructor(customPath) {
        // 2. Si pasas una ruta personalizada al hacer 'new', la usa.
        // Si no, usa la ruta por defecto "./GlobalAssets..."
        this.localPath = customPath || "./GlobalAssets/img/accessibility/";

        this.settings = this.loadSettings();
        this.textLevel = this.settings.textLevel || 0;
        this.init();
    }

    init() {
        this.createWidget();
        this.applySettings();
        this.attachEvents();
    }

    createWidget() {
        const widget = document.createElement('div');
        widget.className = 'accessibility-widget';
        
        // 3. CAMBIO CLAVE: Usamos ${this.localPath} en todas las imágenes
        widget.innerHTML = `
            <button class="accessibility-toggle" aria-label="Abrir opciones de accesibilidad">
                <img src="${this.localPath}accesibilidad.png" alt="Accesibilidad">
            </button>

            <div class="accessibility-overlay"></div>

            <div class="accessibility-panel">
                <div class="accessibility-header">
                    <h3 data-i18n="accessibility_title">Accesibilidad</h3>
                </div>

                <div class="accessibility-options">
                    <div class="accessibility-option" data-action="increase-text">
                        <img src="${this.localPath}aumentar.png" alt="">
                        <span data-i18n="accessibility_increase_text">Aumentar texto</span>
                        <span class="text-level-indicator"></span>
                    </div>

                    <div class="accessibility-option" data-action="decrease-text">
                        <img src="${this.localPath}disminuir.png" alt="">
                        <span data-i18n="accessibility_decrease_text">Disminuir texto</span>
                        <span class="text-level-indicator"></span>
                    </div>

                    <div class="accessibility-option" data-action="grayscale">
                        <img src="${this.localPath}escala-grises.png" alt="">
                        <span data-i18n="accessibility_grayscale">Escala de grises</span>
                    </div>

                    <div class="accessibility-option" data-action="high-contrast">
                        <img src="${this.localPath}contraste.png" alt="">
                        <span data-i18n="accessibility_high_contrast">Alto contraste</span>
                    </div>

                    <div class="accessibility-option" data-action="negative-contrast">
                        <img src="${this.localPath}negativo.png" alt="">
                        <span data-i18n="accessibility_negative_contrast">Contraste negativo</span>
                    </div>

                    <div class="accessibility-option" data-action="underline-links">
                        <img src="${this.localPath}enlaces.png" alt="">
                        <span data-i18n="accessibility_underline_links">Subrayar enlaces</span>
                    </div>

                    <div class="accessibility-option" data-action="readable-font">
                        <img src="${this.localPath}fuente-legible.png" alt="">
                        <span data-i18n="accessibility_readable_font">Fuente legible</span>
                    </div>

                    <div class="accessibility-option" data-action="reset">
                        <img src="${this.localPath}restablecer.png" alt="">
                        <span data-i18n="accessibility_reset">Restablecer</span>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(widget);
    }

    attachEvents() {
        const widget = document.querySelector('.accessibility-widget');
        const toggle = document.querySelector('.accessibility-toggle');
        const panel = document.querySelector('.accessibility-panel');
        const overlay = document.querySelector('.accessibility-overlay');
        const options = document.querySelectorAll('.accessibility-option');

        // Pequeña validación por seguridad
        if (toggle) {
            toggle.addEventListener('click', () => {
                panel.classList.toggle('active');
                overlay.classList.toggle('active');
                widget.classList.toggle('panel-open');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                panel.classList.remove('active');
                overlay.classList.remove('active');
                widget.classList.remove('panel-open');
            });
        }

        options.forEach(option => {
            option.addEventListener('click', () => {
                const action = option.dataset.action;
                this.handleAction(action, option);
            });
        });
    }

    handleAction(action, element) {
        if (action === 'reset') {
            this.resetAll();
            return;
        }

        if (action === 'increase-text') {
            if (this.textLevel < 3) {
                this.textLevel++;
                this.applyTextSize();
                this.updateTextIndicators();
            }
        } else if (action === 'decrease-text') {
            if (this.textLevel > -3) {
                this.textLevel--;
                this.applyTextSize();
                this.updateTextIndicators();
            }
        } else {
            const isActive = document.body.classList.toggle(action);
            this.settings[action] = isActive;
            element.classList.toggle('active', isActive);
        }

        this.saveSettings();
    }

    applyTextSize() {
        document.body.classList.remove(
            'text-size-minus-3',
            'text-size-minus-2',
            'text-size-minus-1',
            'text-size-plus-1',
            'text-size-plus-2',
            'text-size-plus-3'
        );

        if (this.textLevel !== 0) {
            const levelClass = this.textLevel > 0 
                ? `text-size-plus-${this.textLevel}` 
                : `text-size-minus-${Math.abs(this.textLevel)}`;
            document.body.classList.add(levelClass);
        }

        this.settings.textLevel = this.textLevel;
    }

    updateTextIndicators() {
        const increaseOption = document.querySelector('[data-action="increase-text"]');
        const decreaseOption = document.querySelector('[data-action="decrease-text"]');
        
        if (!increaseOption || !decreaseOption) return;

        const increaseIndicator = increaseOption.querySelector('.text-level-indicator');
        const decreaseIndicator = decreaseOption.querySelector('.text-level-indicator');

        if (this.textLevel > 0) {
            increaseIndicator.textContent = `+${this.textLevel}`;
            increaseOption.classList.add('active');
        } else {
            increaseIndicator.textContent = '';
            increaseOption.classList.remove('active');
        }

        if (this.textLevel < 0) {
            decreaseIndicator.textContent = `${this.textLevel}`;
            decreaseOption.classList.add('active');
        } else {
            decreaseIndicator.textContent = '';
            decreaseOption.classList.remove('active');
        }

        if (this.textLevel >= 3) {
            increaseOption.style.opacity = '0.5';
            increaseOption.style.cursor = 'not-allowed';
        } else {
            increaseOption.style.opacity = '1';
            increaseOption.style.cursor = 'pointer';
        }

        if (this.textLevel <= -3) {
            decreaseOption.style.opacity = '0.5';
            decreaseOption.style.cursor = 'not-allowed';
        } else {
            decreaseOption.style.opacity = '1';
            decreaseOption.style.cursor = 'pointer';
        }
    }

    resetAll() {
        document.body.className = '';
        document.querySelectorAll('.accessibility-option').forEach(opt => {
            opt.classList.remove('active');
            opt.style.opacity = '1';
            opt.style.cursor = 'pointer';
            const indicator = opt.querySelector('.text-level-indicator');
            if (indicator) indicator.textContent = '';
        });
        this.textLevel = 0;
        this.settings = {};
        this.saveSettings();
    }

    applySettings() {
        if (this.settings.textLevel) {
            this.textLevel = this.settings.textLevel;
            this.applyTextSize();
            this.updateTextIndicators();
        }

        Object.keys(this.settings).forEach(key => {
            if (key !== 'textLevel' && this.settings[key]) {
                document.body.classList.add(key);
                const option = document.querySelector(`[data-action="${key}"]`);
                if (option) option.classList.add('active');
            }
        });
    }

    saveSettings() {
        localStorage.setItem('e3i-accessibility', JSON.stringify(this.settings));
    }

    loadSettings() {
        const saved = localStorage.getItem('e3i-accessibility');
        return saved ? JSON.parse(saved) : {};
    }
}