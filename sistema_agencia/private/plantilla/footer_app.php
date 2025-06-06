</ion-app>
    
    <script>
        console.log('Aplicación cargada');
        
        // Configuración inicial de Ionic
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelector('ion-tabs');
            
            // Ejemplo de interacción con los tabs
            tabs.addEventListener('ionTabsWillChange', (ev) => {
                console.log('Cambiando a tab:', ev.detail.tab);
            });
        });
    </script>
</body>
</html>