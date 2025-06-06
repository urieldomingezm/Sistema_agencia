<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Aplicación Móvil Completa</title>
    
    <!-- Ionic CDN -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ionic/core/css/ionic.bundle.css"/>
    
    <style>
        :root {
            --ion-color-primary: #3880ff;
            --ion-color-primary-rgb: 56,128,255;
            --ion-color-primary-contrast: #ffffff;
            --ion-color-primary-contrast-rgb: 255,255,255;
            --ion-color-primary-shade: #3171e0;
            --ion-color-primary-tint: #4c8dff;
            --ion-safe-area-top: 20px;
            --ion-safe-area-bottom: 20px;
        }
        
        ion-tab-bar {
            --background: var(--ion-color-primary);
            --color-selected: white;
            --color: rgba(255, 255, 255, 0.7);
        }
        
        .custom-card {
            margin: 16px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .avatar-large {
            width: 80px;
            height: 80px;
        }
        
        .section-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 16px 16px 8px;
            color: var(--ion-color-primary);
        }
        
        /* Mejoras para responsividad */
        @media (max-width: 576px) {
            .custom-card {
                margin: 8px;
            }
            
            .avatar-large {
                width: 60px;
                height: 60px;
            }
            
            .section-title {
                font-size: 1rem;
                margin: 12px 12px 6px;
            }
            
            ion-slides {
                --bullet-background: var(--ion-color-primary);
                --bullet-background-active: var(--ion-color-primary-shade);
            }
        }
        
        @media (min-width: 768px) {
            .custom-card {
                max-width: 600px;
                margin-left: auto;
                margin-right: auto;
            }
            
            ion-slides {
                max-width: 80%;
                margin: 0 auto;
            }
        }
        
        /* Ajustes para pantallas muy pequeñas */
        @media (max-width: 360px) {
            ion-tab-button {
                --padding-start: 4px;
                --padding-end: 4px;
                font-size: 0.8rem;
            }
            
            ion-tab-button ion-icon {
                font-size: 1.2rem;
            }
        }
        
        /* Asegurar que el contenido no quede detrás del header o tab bar */
        ion-content {
            --padding-top: 16px;
            --padding-bottom: 80px;
        }
        
        /* Mejoras para las tarjetas de noticias */
        ion-slide ion-card {
            height: 100%;
            margin: 0 8px;
        }
        
        ion-slide img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <ion-app>
        <ion-header>
            <ion-toolbar color="primary">
                <ion-title>Mi Aplicación</ion-title>
                <ion-buttons slot="end">
                    <ion-button>
                        <ion-icon slot="icon-only" name="notifications"></ion-icon>
                    </ion-button>
                </ion-buttons>
            </ion-toolbar>
        </ion-header>
        
        <ion-tabs>
            <!-- Tab de Inicio -->
            <ion-tab tab="inicio">
                <ion-content>
                    <ion-card class="custom-card">
                        <ion-card-header>
                            <ion-card-title>Bienvenido</ion-card-title>
                            <ion-card-subtitle>Última actualización: hoy</ion-card-subtitle>
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
                    
                    <ion-slides pager="true" options="{slidesPerView: 'auto', spaceBetween: 10, centeredSlides: true}">
                        <ion-slide style="width: 85%;">
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
                        <ion-slide style="width: 85%;">
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
                        <ion-slide style="width: 85%;">
                            <ion-card>
                                <img src="https://via.placeholder.com/300x150?text=Noticia+3" />
                                <ion-card-header>
                                    <ion-card-subtitle>Consejo</ion-card-subtitle>
                                    <ion-card-title>Tips para usar la app</ion-card-title>
                                </ion-card-header>
                                <ion-card-content>
                                    Aprende a sacarle el máximo provecho a todas las funciones.
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
                        <ion-list-header>
                            <ion-label>Información</ion-label>
                        </ion-list-header>
                        
                        <ion-item button>
                            <ion-icon slot="start" name="information-circle"></ion-icon>
                            <ion-label>Acerca de</ion-label>
                        </ion-item>
                        
                        <ion-item button>
                            <ion-icon slot="start" name="document-text"></ion-icon>
                            <ion-label>Términos y condiciones</ion-label>
                        </ion-item>
                        
                        <ion-item button>
                            <ion-icon slot="start" name="shield-checkmark"></ion-icon>
                            <ion-label>Política de privacidad</ion-label>
                        </ion-item>
                    </ion-list>
                    
                    <ion-button expand="block" color="danger" fill="outline" style="margin: 20px">
                        <ion-icon slot="start" name="log-out"></ion-icon>
                        Cerrar sesión
                    </ion-button>
                    
                    <ion-item lines="none" style="text-align: center; color: var(--ion-color-medium)">
                        <ion-label>
                            Versión 1.0.0<br>
                            © 2023 Mi Aplicación
                        </ion-label>
                    </ion-item>
                </ion-content>
            </ion-tab>
            
            <ion-tab-bar slot="bottom">
                <ion-tab-button tab="inicio">
                    <ion-icon name="home"></ion-icon>
                    <ion-label>Inicio</ion-label>
                    <ion-badge color="danger">3</ion-badge>
                </ion-tab-button>
                
                <ion-tab-button tab="perfil">
                    <ion-icon name="person"></ion-icon>
                    <ion-label>Perfil</ion-label>
                </ion-tab-button>
                
                <ion-tab-button tab="config">
                    <ion-icon name="settings"></ion-icon>
                    <ion-label>Configuración</ion-label>
                </ion-tab-button>
            </ion-tab-bar>
        </ion-tabs>
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
            
            // Ajustar dinámicamente el tamaño de los slides
            function adjustSlides() {
                const slides = document.querySelector('ion-slides');
                if (slides) {
                    const width = window.innerWidth;
                    const slideWidth = Math.min(width * 0.85, 400); // Máximo 400px
                    document.querySelectorAll('ion-slide').forEach(slide => {
                        slide.style.width = `${slideWidth}px`;
                    });
                    
                    // Actualizar opciones de los slides
                    slides.update();
                }
            }
            
            // Ejecutar al cargar y al cambiar el tamaño de la ventana
            adjustSlides();
            window.addEventListener('resize', adjustSlides);
        });
    </script>
</body>
</html>