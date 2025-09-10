document.addEventListener('DOMContentLoaded', function() {
    
    // === Variables ===
    const burger = document.querySelector('.hm-burger');
    const mainNav = document.querySelector('.hm-header__nav');
    const mobileNavContainer = document.getElementById('hm-mobile-nav');
    
    const searchToggle = document.querySelector('.hm-search__toggle');
    const searchPanel = document.getElementById('hm-search');

    // === Menú Móvil ===
    if (burger && mainNav && mobileNavContainer) {
        
        // Clonar menú principal al contenedor móvil la primera vez
        const mainMenuClone = mainNav.querySelector('.hm-menu').cloneNode(true);
        mobileNavContainer.appendChild(mainMenuClone);

        burger.addEventListener('click', function() {
            const isOpen = burger.classList.toggle('is-open');
            burger.setAttribute('aria-expanded', isOpen);
            
            if (isOpen) {
                mobileNavContainer.removeAttribute('hidden');
            } else {
                mobileNavContainer.setAttribute('hidden', '');
            }
        });
    }

    // === Buscador ===
    if (searchToggle && searchPanel) {
        searchToggle.addEventListener('click', function() {
            const isHidden = searchPanel.hasAttribute('hidden');
            
            if (isHidden) {
                searchPanel.removeAttribute('hidden');
            } else {
                searchPanel.setAttribute('hidden', '');
            }
            searchToggle.setAttribute('aria-expanded', String(isHidden));

            // Poner el foco en el campo de búsqueda cuando se abre
            if (isHidden) {
                const searchInput = searchPanel.querySelector('input[type="search"]');
                if (searchInput) {
                    setTimeout(() => searchInput.focus(), 50);
                }
            }
        });

        // Cerrar buscador con la tecla ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !searchPanel.hasAttribute('hidden')) {
                searchPanel.setAttribute('hidden', '');
                searchToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

});