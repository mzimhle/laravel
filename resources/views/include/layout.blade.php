<!DOCTYPE html>
<html>
<head>
    <title>CRUD Member Page</title>
	@include('include.css')
</head>
<body>
	<div class="row">
		<div class="col-lg-12 margin-tb">
			<nav class="navbar navbar-expand-sm navbar-light bg-light">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
					<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
						@guest
						<li class="nav-item">
							<a class="nav-link" href="/">Login</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/register">Register</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/forgot">Forgot password</a>
						</li>
						@endguest
						@auth
						<li class="nav-item">
							<a class="nav-link" href="/">Dashboard</a>
						</li>	
						<li class="nav-item">
							<a class="nav-link" href="/member">Members</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/logout">Logout</a>
						</li>			
						@endauth
						<!--
						<li class="nav-item dropdown dmenu">
						<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
						Our Service
						</a>
						<div class="dropdown-menu sm-menu">
						<a class="dropdown-item" href="#">service2</a>
						<a class="dropdown-item" href="#">service 2</a>
						<a class="dropdown-item" href="#">service 3</a>
						</div>
						</li> -->
					</ul>
				</div>
			</nav>
		</div>
	</div>
	<div class="container pd-t-50">
		<div class="row">
			<div class="col">	
				@yield('content')
			</div>
		</div>
	</div>	
	@include('include.javascript')
</body>
</html>