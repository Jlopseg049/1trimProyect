<?php
 require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";

DB::conexion("proyecto");
//$rol = DB::miraDB($_SESSION);
?>
<header class="menu">
	<nav class="nav">
		<ul class="ul">
			<li class="li">
				<a href="?p=Listados/lista&t=persona" class="links">
					<span class="span first">
						<i class="icon fa fa-users" ariaa-hidden="true"></i>
					</span>Usuarios
				</a>

				<ul class="ul">
					<li class="li">
						<a href="?p=Admin/Usuarios/nuevoUsuario" class="links">
							Nuevo usuario
						</a>
					</li>
                    <li class="li">
						<a href="?p=Admin/Usuarios/nuevoUsuarioMasiva" class="links">
							Alta masiva de usuarios
						</a>
					</li>
				</ul>
			</li>

			<li class="li">
			<a href="?p=Listados/lista&t=tematica" class="links">
					<span class="span second">
						<i class="icon fa fa-archive" aria-hidden="true"></i>
					</span>Tematicas
				</a>

				<ul class="ul">
					<li class="li">
						<a href="?p=Admin/Tematicas/NuevaTematica" class="links">
							Nueva temática
						</a>
					</li>
                </ul>
			</li>

			<li class="li">
				<a href="?p=Listados/lista&t=preguntas"  class="links">
					<span class="span third">
						<i class="icon fa fa-question" aria-hidden="true"></i>
					</span>Preguntas
				</a>

                <ul class="ul">
					<li class="li">
						<a href="?p=Admin/Preguntas/nuevaPregunta" class="links">
							Nueva pregunta
						</a>
					</li>
                </ul>
			</li>

			<li class="li">
			<a href="?p=Listados/lista&t=examen" class="links">
					<span class="span fourth">
					<i class="icon fa fa-file" aria-hidden="true"></i>
					</span>Examenes
			</a>

                <ul class="ul">
					<li class="li">
						<a href="?p=Admin/Examen/nuevoExamen" class="links">
							Nuevo examen
						</a>
					</li>
                    <li class="li">
						<a href="?p=Admin/Examen/nuevoExamenMasiva	" class="links">
							Alta masiva de examenes
						</a>
					</li>
                </ul>
			</li>
		</ul>
	</nav>
</header>