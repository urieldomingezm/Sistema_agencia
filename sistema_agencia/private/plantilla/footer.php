
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
        <style>
            .scroll-top-btn {
                position: fixed;
                bottom: 20px;
                right: 20px;
                display: none;
                z-index: 1031;
            }
        </style>
        <footer class="custom-footer py-2 py-md-3 bg-light text-center">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12">
                        <div class="footer-content">
                            <span class="copyright small">
                                &copy; <?= date('Y') ?> Agencia Shein. Todos los derechos reservados para Ing. Medina
                            </span>
                        </div>
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
