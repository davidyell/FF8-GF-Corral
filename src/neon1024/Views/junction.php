<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Final Fantasy VIII - Guardian Force Corral</title>
		
		<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="/assets/css/style.css">
		
    </head>
    <body>
		<div class="container">
			<header class="row">
				<h1>Final Fantasy VIII - Guardian Force Corral</h1>
				<nav>
					<a href="/" class="btn btn-primary">Home</a>
				</nav>
			</header>
			
			<div class="row body">
				
				<table summary="Character junctions" class='table table-bordered'>
					<thead>
						<tr>
							<th><?php echo $firstCharacter->getName();?></th>
							<th><?php echo $secondCharacter->getName();?></th>
							<th><?php echo $thirdCharacter->getName();?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				
			</div>
			
			<footer class="row">
				<p>Created by <a href='http://jedistirfry.co.uk/'>David Yell</a> <?php date('Y');?> | <a href='http://github.com/davidyell/ff8-gf-corral'>Fork it!</a></p>
			</footer>
		</div>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="/bootstrap/js/bootstrap.min.js"></script>
		<script src="/assets/js/common.js"></script>
    </body>
</html>
