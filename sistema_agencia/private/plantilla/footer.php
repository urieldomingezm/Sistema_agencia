
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
        <footer class="custom-footer">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12 text-center">
                        <div class="footer-content">
                            <span class="copyright">
                                &copy; <?= date('Y') ?> Agencia Shein. Todos los derechos reservados para Ing. Medina
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <button id="scrollTopBtn" class="scroll-top-btn" onclick="scrollToTop()">
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
