<div class="inner-scroll">
            <!-- Aquí va el contenido dinámico de cada página -->
        </div>
    </div> <!-- .page -->

    <!-- Framework7 JS -->
    <script src="https://unpkg.com/framework7@6.3.14/framework7-bundle.min.js"></script>

    <script>
        var app = new Framework7({
            theme: 'md',
            routes: [
                // Tus rutas personalizadas aquí
            ]
        });

        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('ion-tab-button');

            tabButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');

                    const loader = document.createElement('div');
                    loader.className = 'page-loader';
                    loader.innerHTML = `
                        <div class="loader-content">
                            <ion-spinner name="crescent"></ion-spinner>
                            <p>Cargando...</p>
                        </div>`;
                    document.querySelector('.inner-scroll').appendChild(loader);

                    fetch(url)
                        .then(res => res.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newContent = doc.querySelector('.inner-scroll').innerHTML;

                            const content = document.querySelector('.inner-scroll');
                            content.innerHTML = newContent;
                            content.classList.add('page-transition');

                            loader.remove();
                            window.history.pushState({}, '', url);

                            setTimeout(() => {
                                content.classList.remove('page-transition');
                            }, 300);
                        })
                        .catch(err => {
                            console.error('Error cargando:', err);
                            loader.remove();
                            window.location.href = url;
                        });
                });
            });

            window.addEventListener('popstate', () => {
                window.location.reload();
            });
        });
    </script>
</body>
</html>
