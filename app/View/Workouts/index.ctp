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
											<?php
												/*foreach( $workouts as $workout) {
													echo 	'<li>
															<div class="row">
																<div class="8u 12u(mobile)">
																<p>'.$workout['Workout']['description'].'</p>
																<span>Numéro de Série : '.$workout['Workout']['serial'].'</span></div>
																<div class="4u 12u(mobile)">';
													echo $this->Html->link('Supprimer',
															array('controller' => 'devices', 'action' => 'delete', $workout['Device']['id']),
															array('class' => 'button-medium'));
														echo $this->Html->link('Bloquer',
												array('controller' => 'devices', 'action' => 'deny', $workout['Workout']['id']),
												array('class' => array('button-medium', 'orange')));
										echo			'</div>
													</div>
												</li>';
									}*/
								?>
											<ul class="check-list">
												<li>Sed mattis quis rutrum accum</li>
												<li>Eu varius nibh suspendisse lorem</li>
												<li>Magna eget odio amet mollis justo</li>
												<li>Facilisis quis sagittis mauris</li>
												<li>Amet tellus gravida lorem ipsum</li>
											</ul>
										</section>

				</div>
				<div class="6u 12u(mobile)">

					<!-- Box #3 -->

						<h2>Ajout relevé</h2>

						<div>
							<?php echo $this->Form->create('Workout',array('action' => 'index','method' => 'post'));?>
								<input name="data[Workout][date]" type="text" placeholder="Date de début">
								<input name="data[Workout][end_date]" type="text" placeholder="Date de fin">
								<input name="data[Workout][location_name]" type="text" placeholder="Lieux">
								<input name="data[Workout][description]" type="text" placeholder="Description">
								<input name="data[Workout][sport]" type="text" placeholder="Sport">
								<input name="data[Workout][contest_id]" type="text" placeholder="Identifiant compétition">
								<input class="button-big" type="submit" value="Enregister">
							<?php echo $this->Form->end(); ?>
						</div>

				</div>
			</div>
		</div>
	</div>
</div>
