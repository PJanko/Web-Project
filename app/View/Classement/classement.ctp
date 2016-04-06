<div id="content-wrapper">
	<div id="content">
		<div class="container">
			<div class="row">
				<div class="6u 12u(mobile)">

					<!-- Box #2 -->
										<section>
											<header>
												<h2>Activités</h2>
												<h3>Dernières séances</h3>
											</header>
											<ul class="check-list">

													<?php
														foreach( $workouts as $workout) {
															echo 	'<li>
																	<div class="row">
																		<div class="8u 12u(mobile)">
																		<h2>Sport : '.$workout['Workout']['sport'].'</h2>
																		<div>Date : '.$workout['Workout']['date'].'</div>
																		<div>Description : '.$workout['Workout']['description'].'</div>
																		<div>Lieux : '.$workout['Workout']['location_name'].'</div></div>
																		<div class="4u 12u(mobile)">';
															echo $this->Html->link('Supprimer',
																	array('controller' => 'workouts', 'action' => 'delete', $workout['Workout']['id']),
																	array('class' => 'button-medium'));
												echo			'</div>
															</div>
														</li>';
											}
										?>

											</ul>
										</section>

				</div>
				<div class="6u 12u(mobile)">

					<!-- Box #3 -->
						<section>
						<h2>Ajout séance</h2>

						<div>
							<?php echo $this->Form->create('Workout',array('action' => 'index','method' => 'post'));?>
								<input name="data[Workout][date]" type="text" placeholder="Date de début AAAA-MM-JJ hh:mm:ss">
								<input name="data[Workout][end_date]" type="text" placeholder="Date de fin AAAA-MM-JJ hh:mm:ss">
								<input name="data[Workout][location_name]" type="text" placeholder="Lieux">
								<input name="data[Workout][sport]" type="text" placeholder="Sport">
								<input name="data[Workout][description]" type="text" placeholder="Description">
								<input name="data[Workout][contest_id]" type="text" placeholder="Identifiant compétition">
								<input class="button-medium" type="submit" value="Enregister">
							<?php echo $this->Form->end(); ?>
						</div>
						</section>
				</div>
			</div>
		</div>
	</div>
</div>
