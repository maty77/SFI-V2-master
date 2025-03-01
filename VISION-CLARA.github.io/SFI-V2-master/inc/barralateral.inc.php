<?php 
require_once 'funciones/conexion.php';
$MiConexion=ConexionBD();
require_once 'funciones/login.php';

	 ?>

	<section class="full-width navLateral">
		<div class="full-width navLateral-bg btn-menu"></div>
		
			<figure class="full-width navLateral-body-tittle-menu">
				<div>
					<img src="assets/img/ov.png" class="img-responsive mCS_img_loaded">
				</div>
				<figcaption>
					<span>
						<strong><?php echo $_SESSION['Usuario_Nombre'].' '. $_SESSION['Usuario_Apellido']?><br>
						<small><?php echo $_SESSION['Usuario_Jerarquia']?></small></strong>
					</span>
				</figcaption>
			</figure>
			<nav class="full-width">
				<ul class="full-width list-unstyle menu-principal">
					

					<li class="full-width">
						<a href="home.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-view-dashboard"></i>
							</div>
							<div class="navLateral-body-cr">
								INICIO
							</div>
						</a>
					</li>
					

					<li class="full-width divider-menu-h"></li>
					

				 <?php if ($_SESSION['Usuario_id_jer'] != 2 ) { ?>
					<li class="full-width">
						<a href="#!" class="full-width btn-subMenu">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-case"></i>
							</div>
							<div class="navLateral-body-cr">
								ADMINISTRACION
							</div>
							<span class="zmdi zmdi-chevron-left"></span>
						</a>
						<ul class="full-width menu-principal sub-menu-options">	
						
<?php if ($_SESSION['Usuario_id_jer'] != 6 && $_SESSION['Usuario_id_jer'] != 5) { ?>
							<li class="full-width">
								<a href="proveedores.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-truck"></i>
									</div>
									<div class="navLateral-body-cr">
										PROVEEDORES
									</div>
								</a>
							</li>
							<?php } ?>

<?php if ($_SESSION['Usuario_id_jer'] != 3 && $_SESSION['Usuario_id_jer'] != 5 && $_SESSION['Usuario_id_jer'] != 7) { ?>
							<li class="full-width">
								<a href="promo.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-favorite"></i>
									</div>
									<div class="navLateral-body-cr">
										PROMOCIONES
									</div>
								</a>
							</li><?php } ?>

							<li class="full-width">
								<a href="pagos.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-card"></i>
									</div>
									<div class="navLateral-body-cr">
										F.PAGOS
									</div>
								</a>
							</li>
							
						</ul>
					</li>
					<?php } ?>

<?php if (!in_array($_SESSION['Usuario_id_jer'], array(3,5,7 ))) { ?>
					<li class="full-width divider-menu-h"></li>
					
					
					<li class="full-width">
						<a href="#!" class="full-width btn-subMenu">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-face"></i>
							</div>
							<div class="navLateral-body-cr">
								USUARIOS
							</div>
							<span class="zmdi zmdi-chevron-left"></span>
						</a>
						<ul class="full-width menu-principal sub-menu-options">

							<?php if (!in_array($_SESSION['Usuario_id_jer'], array(2,4, 6))) { ?>
							<li class="full-width">
								
								<a href="admin.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-account"></i>
									</div>
									<div class="navLateral-body-cr">
										ADMINISTRATORES
									</div>
								</a>
							</li><?php } ?>
							
							<?php if ($_SESSION['Usuario_id_jer'] != 2 ) { ?>
							<li class="full-width">
								<a href="users.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-accounts"></i>
									</div>
									<div class="navLateral-body-cr">
										USUARIOS
									</div>
								</a>
							</li><?php } ?>

							<?php if ($_SESSION['Usuario_id_jer'] != 4 ) { ?>
							<li class="full-width">
								<a href="clientes.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-accounts-list"></i>
									</div>
									<div class="navLateral-body-cr">
										CLIENTES
									</div>
								</a>
							</li><?php } ?>
						</ul>
					</li>
					<?php } ?>

					<li class="full-width divider-menu-h"></li>
					

					
					<li class="full-width">
						<a href="productos.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-shopping-cart-plus"></i>
							</div>
							<div class="navLateral-body-cr">
								PRODUCTOS
							</div>
						</a>
					</li>

					<li class="full-width divider-menu-h"></li>

					<?php if ($_SESSION['Usuario_id_jer'] != 2 && $_SESSION['Usuario_id_jer'] != 6 ) { ?>
					<li class="full-width">
						<a href="compra.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-local-mall"></i>
							</div>
							<div class="navLateral-body-cr">
								R. COMPRAS
							</div>
						</a>
					</li>
					<?php } ?>

					<li class="full-width divider-menu-h"></li>
					<?php if ($_SESSION['Usuario_id_jer'] != 3 && $_SESSION['Usuario_id_jer'] != 7) { ?>
					<li class="full-width">
						<a href="Venta.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-local-mall"></i>
							</div>
							<div class="navLateral-body-cr">
								R. VENTAS
							</div>
						</a>
					</li><?php } ?>

					<li class="full-width divider-menu-h"></li>
					<?php if (!in_array($_SESSION['Usuario_id_jer'], array(3, 4, 5, 7))) { ?>
					<li class="full-width">
						<a href="recetas.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-attachment-alt"></i>
							</div>
							<div class="navLateral-body-cr">
								RECETARIO
							</div>
						</a>
					</li><?php } ?>


					<li class="full-width divider-menu-h"></li>
					<?php if (!in_array($_SESSION['Usuario_id_jer'], array(2,4, 6))) { ?>
					<li class="full-width">
						<a href="inventory.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-store"></i>
							</div>
							<div class="navLateral-body-cr">
								INVENTARIO
							</div>
						</a>
					</li>
<?php } ?>
					<li class="full-width divider-menu-h"></li>
					<?php if (!in_array($_SESSION['Usuario_id_jer'], array(3, 4, 5, 6, 7))) { ?>
					<li class="full-width">
						<a href="sistemaventas.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-shopping-cart"></i>
							</div>
							<div class="navLateral-body-cr">
								SISTEMA DE VENTAS
							</div>
						</a>
					</li>
					<?php } ?>


				</ul>
			</nav>
		</div>
	</section>