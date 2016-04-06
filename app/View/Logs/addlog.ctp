<div id="content-wrapper">
	<div id="content">
		<div class="container">
			<div class="row">
				<div class="6u 12u(mobile)">

					<!-- Box #2 -->
					<section>
						<header>
							<h2>Séance sélectionnée</h2>
							<section>
											
								<ul class="check-list">

									<?php
										
																					echo 	'<li>
													<div class="row">
														<div class="8u 12u(mobile)">
														<h2>Sport : '.$Workout['Workout']['sport'].'</h2>
														<div>Date : '.$Workout['Workout']['date'].'</div>
														<div>Description : '.$Workout['Workout']['description'].'</div>
														<div>Lieu : '.$Workout['Workout']['location_name'].'</div></div>
														<div class="4u 12u(mobile)">';
											echo $this->Html->link('Supprimer',
													array('controller' => 'workouts', 'action' => 'delete', $Workout['Workout']['id']),
													array('class' => 'button-medium'));
											echo $this->Html->link('Ajouter log', 
													array('controller' => 'logs', 'action' => 'addlog', $Workout['Workout']['id']),
													array('class' => 'button-medium'));
											echo			'</div>
														</div>
													</li>';
										
									?>

								</ul>
							</section>
							
						</header>
						<ul class="check-list">
								<h2>Logs associés</h2>
								<?php
									foreach( $Logs as $log) {
										echo 	'<li>
												<div class="row">
													<div class="8u 12u(mobile)">
													<h2>Exercice : '.$log['Log']['log_type'].'</h2>
													<div><h3>Valeur type : '.$log['Log']['log_value'].'</h3></div>
													<div>Date : '.$log['Log']['date'].'</div>
													<div>Latitude : '.$log['Log']['location_latitude'].'</div>
													<div>Longitude : '.$log['Log']['location_logitude'].'</div></div>
													<div class="4u 12u(mobile)">';
										echo $this->Html->link('Supprimer',
												array('controller' => 'logs', 'action' => 'delete', $log['Log']['id']),
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
						<h2>Ajouter log</h2>

						<div>
							<?php echo $this->Form->create('Log',array('action' => 'addlog','method' => 'post'));?>
								<input name="data[Log][date]" type="text" placeholder="Date de début AAAA-MM-JJ hh:mm:ss">
								<input name="data[Log][location_latitude]" type="text" placeholder="Latitude">
								<input name="data[Log][location_logitude]" type="text" placeholder="Longitude">
								<input name="data[Log][log_type]" type="text" placeholder="Exercice">
								<input name="data[Log][log_value]" type="text" placeholder="Valeur type">
								<input class="button-medium" type="submit" value="Ajouter">
							<?php echo $this->Form->end(); ?>
						</div>
						</section>
				</div>
			</div>
		</div>
	</div>
</div>
