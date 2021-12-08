<?php
    Sesion::iniciar();
    if (!isset($_SESSION["login"])) {
        header("location:../..");
    }
?>
<script src="../js/form.js"></script>
<form action="mehtods/sentencia" method="post">
    
</form>