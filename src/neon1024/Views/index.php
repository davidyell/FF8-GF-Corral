<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Final Fantasy VIII - Guardian Force Corral</title>
		
		<link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="/src/neon1024/Assets/css/style.css">
		
    </head>
    <body>
		<div class="container">
			<header class="row">
				<h1>Final Fantasy VIII - Guardian Force Corral</h1>
			</header>
			
			<div class="row body">
				
				<table summary="GF Junction table" class='table table-bordered'>
					<thead>
						<tr>
							<th>GF</th>
							<?php foreach ($this->junctions as $junction) {
								echo "<th>" . $junction . "</th>";
							}?>
							<th>Other junctions</th>
							<th>Abilities</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($this->viewVars['gfs']->getCollection() as $gf): ?>
							<tr>
								<td class='table-label'>
									<img src='/src/neon1024/Assets/images/<?php echo $gf->getName();?>.png'>
									<?php echo $gf->getName(); ?>

									<select name='character' id='<?php echo strtolower($gf->getName());?>' class='select-character'><option>Select character</option>
									<?php	
									foreach ($this->viewVars['chars']->getCollection() as $character) {
										echo "<option value='" . $character->getName() . "'>" . $character->getName() . "</option>";
									}
									?>
									</select>
								</td>
								
								<?php
								foreach ($this->junctions as $junction) {
									echo "<td class='" . strtolower($junction) . "'>";
										if ($gf->hasJunction($junction)) {
											echo "<i class='glyphicon glyphicon-ok'></i>";
										} else {
//											echo "<i class='glyphicon glyphicon-remove'></i>";
										}
									echo "</td>";
								}
								?>
								<td>
									<?php
									foreach ($gf->getJunctions() as $junction) {
										if (preg_match('/(Elem|ST|Ability)/', $junction)) {
											echo $junction . '<br>';
										}
									}
									?>
								</td>
								<td>
									<?php
									foreach ($gf->getAbilities() as $ability) {
										echo $ability . "<br>";
									}
									?>
								</td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				
			</div>
			
			<footer class="row">
				<p>Created by <a href='http://jedistirfry.co.uk/'>David Yell</a> <?php date('Y');?> | <a href='http://github.com/davidyell/ff8-gf-corral'>Fork it!</a></p>
			</footer>
		</div>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="/src/neon1024/Assets/js/common.js"></script>
    </body>
</html>
