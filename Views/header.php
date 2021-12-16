<?php
 require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";

DB::conexion("proyecto");

    Sesion::iniciar();
    if (!isset($_SESSION["login"])) {
        header("location:..");
    }
	if (DB::miraRol($_SESSION["login"]) == 2) {
echo "<header class=\"menu\">
<nav class=\"nav\">
	<ul class=\"ul\">
		<li class=\"li\">
			<a href=\"?p=Listados/lista&t=persona\" class=\"links\">
				<span class=\"span first\">
					<i class=\"icon fa fa-users\" ariaa-hidden=\"true\"></i>
				</span>Usuarios
			</a>

			<ul class=\"ul\">
				<li class=\"li\">
					<a href=\"?p=formulario/form&e=anadir&t=persona\" class=\"links\">
						Nuevo usuario
					</a>
				</li>
				<li class=\"li\">
					<a href=\"?p=formulario/formMasivo&t=persona\" class=\"links\">
						Alta masiva de usuarios
					</a>
				</li>
			</ul>
		</li>

		<li class=\"li\">
		<a href=\"?p=Listados/lista&t=tematica\" class=\"links\">
				<span class=\"span second\">
					<i class=\"icon fa fa-archive\" aria-hidden=\"true\"></i>
				</span>Tematicas
			</a>
			<ul class=\"ul\">
				<li class=\"li\">
					<a href=\"?p=formulario/form&e=anadir&t=tematica\" class=\"links\">
						Nueva temática
					</a>
				</li>
			</ul>
		</li>

		<li class=\"li\">
			<a href=\"?p=Listados/lista&t=preguntas\"  class=\"links\">
				<span class=\"span third\">
					<i class=\"icon fa fa-question\" aria-hidden=\"true\"></i>
				</span>Preguntas
			</a>

			<ul class=\"ul\">
				<li class=\"li\">
					<a href=\"?p=formulario/form&e=anadir&t=preguntas\" class=\"links\">
						Nueva pregunta
					</a>
				</li>
			</ul>
		</li>

		<li class=\"li\">
		<a href=\"?p=Listados/lista&t=examen\" class=\"links\">
				<span class=\"span fourth\">
				<i class=\"icon fa fa-file\" aria-hidden=\"true\"></i>
				</span>Examenes
		</a>

			<ul class=\"ul\">
				<li class=\"li\">
					<a href=\"?p=Admin/Examen/nuevoExamen\" class=\"links\">
						Nuevo examen
					</a>
				</li>
				<li class=\"li\">
					<a href=\"?p=Admin/Examen/nuevoExamenMasiva	\" class=\"links\">
						Alta masiva de examenes
					</a>
				</li>
			</ul>
		</li>
	</ul>
</nav>
</header>";
	}else{
		echo "
<header class=\"menu\">
	<nav class=\"nav\">
		<ul class=\"ul\">
			<li class=\"li\">
				<a href=\"?p=Listados/lista&t=examenHecho\" class=\"links\">
						<span class=\"span fourth\">
						<i class=\"icon fa fa-file\" aria-hidden=\"true\"></i>
						</span>Historico exámenes
				</a>
			</li>
			<li class=\"li\">
				<a href=\"?p=Listados/lista&t=examen\" class=\"links\">
						<span class=\"span second\">
						<i class=\"icon fa fa-file\" aria-hidden=\"true\"></i>
						</span>Examen predefinido
				</a>
			</li>
			<li class=\"li\">
				<a href=\"?p=Listados/lista&t=examen\" class=\"links\">
						<span class=\"span third\">
						<i class=\"icon fa fa-file\" aria-hidden=\"true\"></i>
						</span>Examenes
				</a>
			</li>
		</ul>
	</nav>
</header>";
	}
?>
