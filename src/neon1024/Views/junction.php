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
				
				<h2>Suggested junctions</h2>
				<table summary="Character junctions" class='table table-bordered'>
					<thead>
						<tr>
							<?php foreach ($party->getCollection() as $character): ?>
								<th><?php echo $character->getName();?></th>
							<?php endforeach;?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php
							foreach ($party->getCollection() as $character) {
								echo "<td>";
								foreach ($character->getJunctionedGFs() as $gf) {
									echo "<div class='gf'><img src='/assets/images/{$gf->getName()}.png'><br>{$gf->getName()}</div>";
								}
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<?php
							foreach ($party->getCollection() as $character) {
								echo "<td>";
								foreach ($character->getJunctionedStats() as $junction) {
									$class = strtolower(rtrim($junction, '-J'));
									echo "<span class='$class'>" . $junction . "</span><br>";
								}
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<?php
							foreach ($party->getCollection() as $character) {
								echo "<td>";
								foreach ($character->getJunctionedGFs() as $gf) {
									foreach ($gf->getJunctions() as $junction) {
										if (preg_match('/(Elem|ST|Ability)/', $junction)) {
											$extraJunctions[] = $junction;
										}
									}
								}
								foreach (array_unique($extraJunctions) as $junction) {
									echo $junction . "<br>";
								}
								echo "</td>";
							}
							?>
						</tr>
						<tr>
							<?php
							foreach ($party->getCollection() as $character) {
								echo "<td>";
								foreach ($character->getJunctionedGFs() as $gf) {
									foreach ($gf->getAbilities() as $ability) {
										echo $ability . "<br>";
									}
								}
								echo "</td>";
							}
							?>
						</tr>
					</tbody>
				</table>
				
				<h2>Unjunctioned GFs</h2>
				<?php
				foreach ($corral->getCollection() as $gf) {
					if (!$gf->getJunctionedBy()) {
						echo "<div class='gf'><img src='/assets/images/{$gf->getName()}.png'><br>{$gf->getName()}</div>";
					}
				}
				?>
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
