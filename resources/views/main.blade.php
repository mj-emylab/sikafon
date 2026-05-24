
<!DOCTYPE html>
<html html lang="en">
	
	<head>
		@include('partials._header')
    </head>

	<body class="hold-transition skin-blue sidebar-mini" style="background:url('assets/img/findme-background.png');font-family: 'Montserrat', sans-serif;">
		

		<div id="app">
			
			<router-view />

		</div>

		@include('partials._scripts')

		
	</body>

</html>