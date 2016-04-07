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
											
								<ul class="quote-list">

									<?php
										
																					echo 	'<li>
													<div class="row">
														<div class="8u 12u(mobile)">
														<h2>Sport : '.$Workout['Workout']['sport'].'</h2>
														<div>Date : '.$Workout['Workout']['date'].'</div>
														<div>Description : '.$Workout['Workout']['description'].'</div>
														<div>Lieu : '.$Workout['Workout']['location_name'].'</div>';
														if($Workout['Workout']['contest_id'] != null) {
																echo "<div class=info>MATCH</div>";
															}
														echo '</div>
														</div>
													</li>';
										
									?>

								</ul>
							</section>
							
						</header>
						<ul class="quote-list">
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
										if($Workout['Workout']['contest_id'] != null) {
											echo "<div class=info>C'est un match, vous ne pouvez pas supprimer les logs</div>";
										}
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
							<?php
							if($Workout['Workout']['contest_id'] != null && !$Workout['Workout']['running']) {
								echo "<div class=info>Attendez que le match commence pour pouvoir entrer un Log</div>";
							} else {
								echo $this->Form->create('Log',array('action' => 'addlog/'.$id,'method' => 'post'));
								echo '<input name="data[Log][date]" type="text" placeholder="Date : AAAA-MM-JJ hh:mm:ss">';
								echo '<input name="data[Log][location_latitude]" type="text" placeholder="Latitude">';
								echo '<input name="data[Log][location_logitude]" type="text" placeholder="Longitude">';
								echo '<input name="data[Log][log_type]" type="text" placeholder="Exercice">';
								echo '<input name="data[Log][log_value]" type="text" placeholder="Valeur">';
								echo '<input class="button-medium" type="submit" value="Ajouter">';
							 	echo $this->Form->end(); 
							 } ?>
						</div>
						</section>
				</div>
			</div>
		</div>
	</div>
</div>
