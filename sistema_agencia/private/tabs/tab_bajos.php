<ion-tabs>
    <!-- Tab de Inicio -->
    <ion-tab tab="inicio">
        <ion-content>
            <ion-card class="custom-card">
                <ion-card-header>
                    <ion-card-title>Bienvenido</ion-card-title>
                    <ion-card-subtitle>Última actualización: <?php echo date('d/m/Y'); ?></ion-card-subtitle>
                </ion-card-header>
                <ion-card-content>
                    <p>Esta es tu aplicación personalizada. Explora las diferentes secciones usando el menú inferior.</p>
                </ion-card-content>
            </ion-card>

            <ion-list>
                <ion-list-header>
                    <ion-label>Acciones rápidas</ion-label>
                </ion-list-header>

                <ion-item button>
                    <ion-icon slot="start" name="add-circle"></ion-icon>
                    <ion-label>Nuevo elemento</ion-label>
                </ion-item>

                <ion-item button>
                    <ion-icon slot="start" name="search"></ion-icon>
                    <ion-label>Buscar</ion-label>
                </ion-item>

                <ion-item button>
                    <ion-icon slot="start" name="share-social"></ion-icon>
                    <ion-label>Compartir</ion-label>
                </ion-item>
            </ion-list>

            <div class="section-title">Noticias recientes</div>

            <ion-slides pager="true" options="{slidesPerView: 1.2, spaceBetween: 10, centeredSlides: true}">
                <ion-slide>
                    <ion-card>
                        <img src="https://via.placeholder.com/300x150?text=Noticia+1" />
                        <ion-card-header>
                            <ion-card-subtitle>Novedad</ion-card-subtitle>
                            <ion-card-title>Lanzamiento nueva función</ion-card-title>
                        </ion-card-header>
                        <ion-card-content>
                            Descubre las últimas actualizaciones de nuestra aplicación.
                        </ion-card-content>
                    </ion-card>
                </ion-slide>
                <ion-slide>
                    <ion-card>
                        <img src="https://via.placeholder.com/300x150?text=Noticia+2" />
                        <ion-card-header>
                            <ion-card-subtitle>Evento</ion-card-subtitle>
                            <ion-card-title>Webinar gratuito</ion-card-title>
                        </ion-card-header>
                        <ion-card-content>
                            Únete a nuestro próximo evento en línea.
                        </ion-card-content>
                    </ion-card>
                </ion-slide>
            </ion-slides>
        </ion-content>
    </ion-tab>

    <!-- Tab de Perfil -->
    <ion-tab tab="perfil">
        <ion-content>
            <ion-card class="custom-card">
                <ion-card-header>
                    <ion-avatar class="avatar-large" slot="start">
                        <img src="https://via.placeholder.com/150?text=Usuario" />
                    </ion-avatar>
                    <ion-card-title>Usuario Ejemplo</ion-card-title>
                    <ion-card-subtitle>Miembro desde 2023</ion-card-subtitle>
                </ion-card-header>

                <ion-card-content>
                    <ion-item lines="none">
                        <ion-icon slot="start" name="mail"></ion-icon>
                        <ion-label>usuario@ejemplo.com</ion-label>
                    </ion-item>

                    <ion-item lines="none">
                        <ion-icon slot="start" name="call"></ion-icon>
                        <ion-label>+1 234 567 890</ion-label>
                    </ion-item>
                </ion-card-content>
            </ion-card>

            <ion-list>
                <ion-list-header>
                    <ion-label>Configuración de cuenta</ion-label>
                </ion-list-header>

                <ion-item button>
                    <ion-icon slot="start" name="lock-closed"></ion-icon>
                    <ion-label>Seguridad</ion-label>
                    <ion-badge color="warning" slot="end">2</ion-badge>
                </ion-item>

                <ion-item button>
                    <ion-icon slot="start" name="notifications"></ion-icon>
                    <ion-label>Notificaciones</ion-label>
                    <ion-toggle slot="end" checked></ion-toggle>
                </ion-item>

                <ion-item button>
                    <ion-icon slot="start" name="moon"></ion-icon>
                    <ion-label>Modo oscuro</ion-label>
                    <ion-toggle slot="end"></ion-toggle>
                </ion-item>
            </ion-list>

            <ion-list>
                <ion-list-header>
                    <ion-label>Ayuda</ion-label>
                </ion-list-header>

                <ion-item button>
                    <ion-icon slot="start" name="help-circle"></ion-icon>
                    <ion-label>Centro de ayuda</ion-label>
                </ion-item>

                <ion-item button>
                    <ion-icon slot="start" name="chatbubbles"></ion-icon>
                    <ion-label>Soporte</ion-label>
                </ion-item>
            </ion-list>
        </ion-content>
    </ion-tab>

    <!-- Tab de Configuración -->
    <ion-tab tab="config">
        <ion-content>
            <ion-list>
                <ion-list-header>
                    <ion-label>Preferencias</ion-label>
                </ion-list-header>

                <ion-item>
                    <ion-label>Idioma</ion-label>
                    <ion-select value="es" interface="action-sheet">
                        <ion-select-option value="es">Español</ion-select-option>
                        <ion-select-option value="en">Inglés</ion-select-option>
                        <ion-select-option value="fr">Francés</ion-select-option>
                    </ion-select>
                </ion-item>

                <ion-item>
                    <ion-label>Tamaño de texto</ion-label>
                    <ion-range min="12" max="24" step="2" value="16" pin="true">
                        <ion-icon slot="start" name="text"></ion-icon>
                        <ion-icon slot="end" name="text"></ion-icon>
                    </ion-range>
                </ion-item>

                <ion-item>
                    <ion-label>Almacenamiento usado</ion-label>
                    <ion-progress-bar value="0.65" color="primary"></ion-progress-bar>
                    <ion-note slot="end">65%</ion-note>
                </ion-item>
            </ion-list>

            <ion-list>
                <ion-list