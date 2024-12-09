<?php
session_start();
session_unset();

echo '<script>
window.location.replace("http://localhost/Biblothéque/index.php");
</script>';
?>