
<?php
class Footer
{
    private $jsFiles = [];

    public function addJsFile($filePath)
    {
        $this->jsFiles[] = $filePath;
    }

    public function render()
    {
        ?>
        <footer class="custom-footer py-2 py-md-3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-8 col-md-6 text-center text-md-start">
                        <div class="footer-content">
                            <span class="copyright small">
                                &copy; <?= date('Y') ?> Agencia Shein. Todos los derechos reservados para Ing. Medina
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 col-md-6 text-center text-md-end mt-2 mt-sm-0">
                        <a href="#" class="text-decoration-none small me-3">Política de Privacidad</a>
                        <a href="#" class="text-decoration-none small">Términos de Servicio</a>
                    </div>
                </div>
            </div>
        </footer>

        <button id="scrollTopBtn" class="scroll-top-btn btn btn-primary btn-sm" onclick="scrollToTop()">
            <i class="bi bi-arrow-up"></i>
        </button>

        <script>
        window.onscroll = function() {
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                document.getElementById("scrollTopBtn").style.display = "block";
            } else {
                document.getElementById("scrollTopBtn").style.display = "none";
            }
        };

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
        </script>
        <?php
    }
}

$footer = new Footer();
$footer->render();
?>
