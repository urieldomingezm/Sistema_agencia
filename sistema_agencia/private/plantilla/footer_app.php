<!-- Ionicons -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<!-- Estilos globales para la app -->
<style>
    :root {
        --ion-color-primary: #3880ff;
        --ion-color-primary-rgb: 56, 128, 255;
        --ion-color-primary-contrast: #ffffff;
        --ion-color-primary-contrast-rgb: 255, 255, 255;
        --ion-color-primary-shade: #3171e0;
        --ion-color-primary-tint: #4c8dff;
        
        --ion-color-secondary: #3dc2ff;
        --ion-color-secondary-rgb: 61, 194, 255;
        --ion-color-secondary-contrast: #ffffff;
        --ion-color-secondary-contrast-rgb: 255, 255, 255;
        --ion-color-secondary-shade: #36abe0;
        --ion-color-secondary-tint: #50c8ff;
        
        --ion-background-color: #f8f9fa;
        --ion-toolbar-background: var(--ion-color-primary);
        --ion-toolbar-color: var(--ion-color-primary-contrast);
    }
    
    .inner-scroll {
        padding-bottom: 60px; /* Espacio para los tabs */
    }
    
    /* Transiciones suaves entre páginas */
    .page-transition {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
// Manejar la carga de páginas con AJAX para una experiencia más fluida
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('ion-tab-button');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');
            
            // Mostrar loader
            const loader = document.createElement('div');
            loader.className = 'page-loader';
            loader.innerHTML = `
                <div class="loader-content">
                    <ion-spinner name="crescent"></ion-spinner>
                    <p>Cargando...</p>
                </div>
            `;
            document.querySelector('.inner-scroll').appendChild(loader);
            
            // Cargar contenido
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    // Extraer solo el contenido de la página
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('.inner-scroll').innerHTML;
                    
                    // Reemplazar contenido con animación
                    const contentContainer = document.querySelector('.inner-scroll');
                    contentContainer.innerHTML = newContent;
                    contentContainer.classList.add('page-transition');
                    
                    // Eliminar loader
                    loader.remove();
                    
                    // Actualizar URL sin recargar
                    window.history.pushState({}, '', url);
                    
                    // Eliminar clase de transición después de la animación
                    setTimeout(() => {
                        contentContainer.classList.remove('page-transition');
                    }, 300);
                })
                .catch(error => {
                    console.error('Error:', error);
                    loader.remove();
                    window.location.href = url; // Fallback a recarga normal
                });
        });
    });
    
    // Manejar el botón de retroceso del navegador
    window.addEventListener('popstate', function() {
        window.location.reload();
    });
});

// Estilos para el loader
const style = document.createElement('style');
style.textContent = `
    .page-loader {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    
    .loader-content {
        text-align: center;
    }
    
    .loader-content ion-spinner {
        width: 48px;
        height: 48px;
        --color: var(--ion-color-primary);
    }
    
    .loader-content p {
        margin-top: 16px;
        color: var(--ion-color-primary);
        font-weight: bold;
    }
`;
document.head.appendChild(style);
</script>