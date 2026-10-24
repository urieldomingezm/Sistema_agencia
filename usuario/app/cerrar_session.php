<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
echo '<script>
Swal.fire({
    title: "Sesión cerrada",
    text: "Has cerrado sesión correctamente",
    icon: "success"
}).then(() => {
    window.location.href = "/login.php";
});
</script>';
?>