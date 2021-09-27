<section class="full-width pageContent">
		<!-- navBar -->
		<div class="full-width navBar">
			<div class="full-width navBar-options">
				<i class="zmdi zmdi-swap btn-menu" id="btn-menu"></i>	
				<div class="mdl-tooltip" for="btn-menu">Ocultar Menu</div>
				<nav class="navBar-options-list">
					<ul class="list-unstyle">
					
						<li class="btn-exit" id="btn-exit">
							<i class="zmdi zmdi-power"></i>
							<div class="mdl-tooltip" for="btn-exit">Cerrar Sesion</div>
						</li>
						<li class="text-condensedLight noLink" ><small>{{Auth::user()->nombreuser}}</small></li>
						<li class="noLink">
							<figure>
								<img src="assets/img/avatar-male.jpg" alt="Avatar" class="img-responsive">
							</figure>
						</li>
					</ul>
				</nav>
			</div>
		</div>
		<div >
		@yield('contenido')
		</div>
</section>
<section class="full-width navLateral">
<div class="full-width navLateral-bg btn-menu"></div>
		<div class="full-width navLateral-body">
			<div class="full-width navLateral-body-logo text-center tittles">
				<i class="zmdi zmdi-close btn-menu"></i> <a style="font-family: 'Ruda', sans-serif; color: #f2f2f2; float: revert; text-transform: uppercase;" class="logo"><b>MEDI<span>SIS</span></b></a>
			</div>
			<figure class="full-width navLateral-body-tittle-menu">
				<div>
					<img src="assets/img/avatar-male.jpg" alt="Avatar" class="img-responsive">
				</div>
				<figcaption>
					<span>
					{{Auth::user()->rolnombre}}<br>
						<small>{{Auth::user()->nombreuser}}</small>
					</span>
				</figcaption>
			</figure>
			<nav class="full-width">
				<ul class="full-width list-unstyle menu-principal">
				<li class="full-width divider-menu-h"></li>
					<li class="full-width">
						<a href="#" class="full-width btn-subMenu">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-store"></i>
							</div>
							<div class="navLateral-body-cr">
								PRINCIPAL
							</div>
							<span class="zmdi zmdi-chevron-left"></span>
						</a>
						<ul class="full-width menu-principal sub-menu-options">
						
							<li @click="menu=0" class="full-width">
								<a href="#" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-view-dashboard"></i>
									</div>
									<div class="navLateral-body-cr">
                                    PRINCIPAL
									</div>
								</a>
							</li>
							<li @click="menu=13" class="full-width">
								<a href="#" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-view-dashboard"></i>
									</div>
									<div class="navLateral-body-cr">
                                    DASHBOARD
									</div>
								</a>
							</li>
						</ul>
					</li>
				
					
					<li class="full-width divider-menu-h"></li>
					<li @click="menu=1" class="full-width">
								<a href="#" class="full-width">
									<div class="navLateral-body-cl">
									<i class="zmdi zmdi-label"></i>										
									</div>
									<div class="navLateral-body-cr">
										CATEGORIAS
									</div>
								</a>
							</li>
					<li class="full-width divider-menu-h"></li>
					<li class="full-width">
						<a href="#" class="full-width btn-subMenu">
							<div class="navLateral-body-cl">
							<i class="zmdi zmdi-store"></i>
							</div>
							<div class="navLateral-body-cr">
								ALMACEN
							</div>
							<span class="zmdi zmdi-chevron-left"></span>
						</a>
						<ul class="full-width menu-principal sub-menu-options">	
						<li @click="menu=2" class="full-width">
								<a href="#" class="full-width">
							<div class="navLateral-body-cl">
							<i class="zmdi zmdi-washing-machine"></i>
							</div>
							<div class="navLateral-body-cr">
								ARTICULOS
							</div>
						</a>
							</li>					
						</ul>
					</li>
					
					<li class="full-width divider-menu-h"></li>
					<li class="full-width">
						<a href="#" class="full-width btn-subMenu">
							<div class="navLateral-body-cl">
							<i class="zmdi zmdi-widgets"></i>
							</div>
							<div class="navLateral-body-cr">
								ACCIONES
							</div>
							<span class="zmdi zmdi-chevron-left"></span>
						</a>
						<ul class="full-width menu-principal sub-menu-options">					
							<li @click="menu=5" class="full-width">
								<a href="#" class="full-width">
									<div class="navLateral-body-cl">										
									<i class="zmdi zmdi-shopping-cart"></i>
									</div>
									<div class="navLateral-body-cr">
									REGISTRAR VENTA
									</div>
								</a>
							</li>
							<li @click="menu=11" class="full-width">
								<a href="#" class="full-width">
									<div class="navLateral-body-cl">										
									<i class="zmdi zmdi-shopping-cart"></i>
									</div>
									<div class="navLateral-body-cr">
									ENVIAR RECETARIO
									</div>
								</a>
							</li>
						</ul>
					</li>
					
				
				</ul>
			</nav>
		
	</section>