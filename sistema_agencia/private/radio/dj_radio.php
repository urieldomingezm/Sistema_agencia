<?php
class RadioPlayer
{
    private $defaultStreamURL;
    private $streamURL;
    private $djName;
    private $mountPoint;

    public function __construct($defaultStreamURL, $djName = "DJ Desconocido", $mountPoint = "")
    {
        $this->defaultStreamURL = $defaultStreamURL;  // La URL de la radio en vivo (por defecto)
        $this->streamURL = $defaultStreamURL;  // Por defecto se usa la radio en vivo
        $this->djName = $djName;
        $this->mountPoint = $mountPoint;
    }

    public function render()
    {
        echo '<div class="radio-container text-center">';
        echo '    <img src="/public/assets/custom_general/custom_radio/img/dj.ico" class="radio-cover" alt="Radio Cover">';
        echo '    <div class="radio-info">';
        echo '        <p class="dj-label">DJ: <span>' . htmlspecialchars($this->djName) . '</span></p>';
        if ($this->mountPoint) {
            echo '        <p class="mount-point-status">Conectado a: <span>' . htmlspecialchars($this->mountPoint) . '</span></p>';
        } else {
            echo '        <p class="mount-point-status">Radio en vivo...</p>';
        }
        echo '    </div>';
        echo '    <audio id="radio" src="' . htmlspecialchars($this->streamURL) . '" preload="none"></audio>';
        echo '    <div class="radio-controls">';
        echo '        <button id="playButton" class="btn btn-danger" onclick="playRadio()"><i class="bi bi-play-fill"></i></button>';
        echo '        <button id="pauseButton" class="btn btn-danger" onclick="pauseRadio()" disabled><i class="bi bi-pause-fill"></i></button>';
        echo '        <button id="muteButton" class="btn btn-danger" onclick="toggleMute()"><i class="bi bi-volume-up-fill"></i></button>';
        echo '        <button id="volumeDownButton" class="btn btn-danger" onclick="volumeDown()"><i class="bi bi-volume-down-fill"></i></button>';
        echo '        <button id="volumeUpButton" class="btn btn-danger" onclick="volumeUp()"><i class="bi bi-volume-up-fill"></i></button>';
        echo '    </div>';
        echo '</div>';

        $this->renderStyles();
        $this->renderScripts();
    }

    private function renderStyles()
    {
        // Cargar el archivo CSS desde una ubicación externa
        $cssPath = CUSTOM_RADIO_CSS_PATH . 'style.css';
        if (file_exists($cssPath)) {
            echo '<style>' . file_get_contents($cssPath) . '</style>';
        }
    }

    private function renderScripts()
    {
        echo '<script>
                var radio = document.getElementById("radio");
                var playButton = document.getElementById("playButton");
                var pauseButton = document.getElementById("pauseButton");
                var muteButton = document.getElementById("muteButton");
                var radioCover = document.querySelector(".radio-cover");
                var mountPointStatus = document.querySelector(".mount-point-status span");

                var defaultStreamURL = "' . $this->defaultStreamURL . '";
                var streamURL = "' . $this->streamURL . '";
                var mountPoint = "' . $this->mountPoint . '";
                
                // Detectar cuando se abre el menú
                document.addEventListener("DOMContentLoaded", function() {
                    // Buscar el botón del menú (ajusta el selector según tu HTML)
                    var menuButton = document.querySelector(".navbar-toggler, .menu-toggle, #menu-button");
                    
                    if (menuButton) {
                        menuButton.addEventListener("click", function() {
                            document.body.classList.toggle("menu-open");
                        });
                    }
                    
                    // También detectar clics fuera para cerrar el menú
                    document.addEventListener("click", function(e) {
                        var menu = document.querySelector(".navbar-collapse.show, .menu.open");
                        var menuButton = document.querySelector(".navbar-toggler, .menu-toggle, #menu-button");
                        
                        if (menu && menuButton && !menu.contains(e.target) && !menuButton.contains(e.target)) {
                            document.body.classList.remove("menu-open");
                        }
                    });
                });

                // Función modificada para verificar disponibilidad del stream
                function checkStreamAvailability(streamURL, callback) {
                    // Usar una técnica alternativa para verificar disponibilidad
                    var audioTest = new Audio();
                    audioTest.src = streamURL;
                    audioTest.preload = "auto";
                    
                    audioTest.addEventListener("canplaythrough", function() {
                        callback(true);
                    });
                    
                    audioTest.addEventListener("error", function() {
                        callback(false);
                    });
                    
                    setTimeout(function() {
                        callback(false);
                    }, 5000);
                }

                // Verificar disponibilidad solo cuando el usuario interactúe
                playButton.addEventListener("click", function() {
                    checkStreamAvailability(defaultStreamURL, function(isLiveAvailable) {
                        if (isLiveAvailable) {
                            streamURL = defaultStreamURL;
                            if (mountPointStatus) {
                                mountPointStatus.textContent = "Conectado a: " + streamURL;
                            }
                            playRadio();
                        } else {
                            if (mountPointStatus) {
                                mountPointStatus.textContent = "Radio no disponible";
                            }
                            // Se eliminó el alert() que estaba aquí
                        }
                    });
                });

                // Función para reproducir la radio (solo después de interacción)
                function playRadio() {
                    try {
                        radio.src = streamURL;
                        var playPromise = radio.play();
                        
                        if (playPromise !== undefined) {
                            playPromise.catch(error => {
                                console.log("Autoplay prevented:", error);
                                playButton.disabled = false;
                                pauseButton.disabled = true;
                            });
                        }
                        
                        radioCover.classList.add("playing");
                        playButton.disabled = true;
                        pauseButton.disabled = false;
                    } catch (error) {
                        console.error("Error al reproducir:", error);
                    }
                }

                // Función para pausar la radio
                function pauseRadio() {
                    radio.pause();

                    // Desactivar la animación de giro
                    radioCover.classList.remove("playing");

                    playButton.disabled = false;
                    pauseButton.disabled = true;
                }

                // Función para silenciar o activar el sonido
                function toggleMute() {
                    radio.muted = !radio.muted;
                    var volumeIcon = muteButton.querySelector("i");
                    if (radio.muted) {
                        volumeIcon.classList.replace("bi-volume-up-fill", "bi-volume-mute-fill");
                    } else {
                        volumeIcon.classList.replace("bi-volume-mute-fill", "bi-volume-up-fill");
                    }
                }

                // Función para bajar el volumen
                function volumeDown() {
                    if (radio.volume > 0) {
                        radio.volume -= 0.1;
                    }
                    updateVolumeIcon();
                }

                // Función para subir el volumen
                function volumeUp() {
                    if (radio.volume < 1) {
                        radio.volume += 0.1;
                    }
                    updateVolumeIcon();
                }

                // Función para actualizar el ícono del volumen
                function updateVolumeIcon() {
                    var volumeIcon = muteButton.querySelector("i");
                    if (radio.muted || radio.volume === 0) {
                        volumeIcon.classList.replace("bi-volume-up-fill", "bi-volume-mute-fill");
                    } else if (radio.volume < 0.5) {
                        volumeIcon.classList.replace("bi-volume-up-fill", "bi-volume-down-fill");
                    } else {
                        volumeIcon.classList.replace("bi-volume-down-fill", "bi-volume-up-fill");
                    }
                }

                // Detectar error de la radio (si no está disponible)
                radio.onerror = function() {
                    console.log("Radio no disponible");
                    // Se eliminó el alert() que estaba aquí
                };

                // Actualizar el estado de los botones cuando la radio se reproduce o se pausa automáticamente
                radio.addEventListener("play", function() {
                    playButton.disabled = true;
                    pauseButton.disabled = false;
                });

                radio.addEventListener("pause", function() {
                    playButton.disabled = false;
                    pauseButton.disabled = true;
                });

                // Actualizar el ícono del volumen cuando cambia el volumen
                radio.addEventListener("volumechange", function() {
                    updateVolumeIcon();
                });
            </script>';
    }

    public function switchToStream($newStreamURL, $mountPoint)
    {
        $this->streamURL = $newStreamURL;
        $this->mountPoint = $mountPoint;
    }
}

// URL de la radio principal
$defaultStreamURL = "https://radionoyabrsk.ru:8443";  // Radio en vivo (por defecto)

// Crear la instancia del radio
$radio = new RadioPlayer($defaultStreamURL, "DJ Nocturno");
$radio->render();

if (isset($_POST['changeStream'])) {
    $radio->switchToStream("http://37.157.242.101:36414/stream", "/stream");  // Cambiar la URL a listen2myradio
    $radio->render();
}
