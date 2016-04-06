<div id="content-wrapper">
	<div id="content">
		<div class="container">
			<div class="row">
				

				<div class="12u 12u(mobile)">

					<!-- Box #2 -->
					<section>
						<header>
							<h2>Classements par Sport</h2>
							<h3>Choisi le sport avoir un classement plus précis</h3>
						</header>
						<div>
						<?php 
							foreach($sports as $s) {
								echo $this->Html->link($s['Workout']['sport'], 
												array('controller' => 'classements', 'action' => 'index', $s['Workout']['sport']),
												array('class' => 'button-medium'));
							}
						?>
						</div>
					</section>

				</div>
				<div class="12u 12u(mobile)">
					<!-- Box #2 -->
					<section>
						<header>
							<h2>Classements <?php if(!isset($sport)) echo('Général'); else echo('par Sport : '.$sport);?></h2>
							<h3>Cliquez sur les <strong>titres</strong> pour changer l'ordre</h3>
						</header>
						<table class="sortable">
							<?php
							echo('<tr>');
							echo('<th>Membres</th>');
							foreach ($types as $type) {
								echo('<th>'.$type['Log']['log_type'].'</th>');
							}
							echo('</tr>');
							foreach ($members as $member) {
								echo('<tr>');
								echo('<td>'.$member['Member']['email'].'</td>');
								foreach ($types as $type) {
									echo('<td>'.$member['Log'][$type['Log']['log_type']].'</td>');
								}
								echo('</tr>');
							}
							?>
						</table>
					</section>

				</div>
				
			</div>
		</div>
	</div>
</div>
