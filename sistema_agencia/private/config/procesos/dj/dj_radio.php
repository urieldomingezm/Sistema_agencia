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
        echo '    <img src="/public/custom/custom_radio/img/dj.jpg" class="radio-cover" alt="Radio Cover">';
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
                var radioCover = document.querySelector(".radio-cover"); // Selecciona la imagen

                var defaultStreamURL = "' . $this->defaultStreamURL . '";
                var streamURL = "' . $this->streamURL . '"; // Solo la URL de la radio principal
                var mountPoint = "' . $this->mountPoint . '"; // Mount point para listen2myradio

                // Función para verificar si la radio en vivo está disponible
                function checkStreamAvailability(streamURL, callback) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("HEAD", streamURL, true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                // Stream está disponible
                                callback(true);
                            } else {
                                // Stream no disponible
                                callback(false);
                            }
                        }
                    };
                    xhr.send();
                }

                // Función para reproducir la radio
                function playRadio() {
                    // Inicia la reproducción de la radio
                    radio.src = streamURL;
                    radio.play();

                    // Activar la animación de giro
                    radioCover.classList.add("playing");

                    // Desactiva el botón de Play y activa el de Pause
                    playButton.disabled = true;
                    pauseButton.disabled = false;
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
                    alert("La radio en vivo no está disponible en este momento.");
                };

                // Verificar la disponibilidad del stream en vivo y cambiar la fuente de la radio
                checkStreamAvailability(defaultStreamURL, function(isLiveAvailable) {
                    if (isLiveAvailable) {
                        streamURL = defaultStreamURL;
                        document.querySelector(".mount-point-status span").textContent = "Conectado a: " + streamURL;
                        playRadio(); // Reproducir la radio una vez determinado el streamURL
                    } else {
                        document.querySelector(".mount-point-status span").textContent = "Radio no disponible";
                    }
                });

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
