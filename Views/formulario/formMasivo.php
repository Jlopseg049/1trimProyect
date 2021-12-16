<?php
    Sesion::iniciar();
    if (!isset($_SESSION["login"])) {
        header("location:../..");
    }
?>
<script src="../js/subidaMasiva.js"></script>
