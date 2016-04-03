	<div id="features-wrapper">
		<div id="features">
			<div class="container">
				<div class="row">
					<div class="12u 12u(mobile)">

						<!-- Feature #1 -->
							<section>
								<?php echo $this->Html->link('Ajouter une compétition',
										array('controller' => 'workouts', 'action' => 'index' , "?" => array( "contest" => 1)),
										array('class' => 'button-medium'));
								?>
							</section>

					</div>
				</div>
			</div>
		</div>
	</div>

<!-- Content -->
	<div id="content-wrapper">
		<div id="content">
			<div class="container">
				<div class="row">
					<div class="12u 12u(mobile)">

						<!-- Box #1 -->
							<section>
								<header>
									<h2>Compétitions à venir</h2>
								</header>
								<ul class="quote-list">
									<?php
										foreach( $matchs as $match) {
											echo 	'<li>
														<div class="row">
															<div class="8u 12u(mobile)"><p>'.$match['Contest']['name'].'</p>
															<span>Type : '.$match['Contest']['type'].'</span>
															<span>Location : '.$match['Contest']['location'].'</span>
															<span>Date : '.$match['Contest']['date'].'</span></div>
															<div class="4u 12u(mobile)">';
											echo $this->Html->link('Details',
													array('controller' => 'contests', 'action' => 'show', $match['Contest']['id']),
													array('class' => 'button-medium'));
											echo $this->Html->link('Participer',
													array('controller' => 'contests', 'action' => 'register', $match['Contest']['id']),
													array('class' => array('button-medium','green')));
											echo			'</div>
														</div>
													</li>';
										}
									?>
								</ul>
							</section>

					</div>
				</div>

				<div class="row">
					<div class="12u 12u(mobile)">

						<!-- Box #1 -->
							<section>
								<header>
									<h2>Mes Compétitions</h2>
								</header>
								<ul class="quote-list">
									<?php
										foreach( $my as $m) {
											if(isset($m['Contest']['full'])) echo '<li class="full">';
											else echo '<li>';
											echo 		'<div class="row">
															<div class="8u 12u(mobile)"><p>'.$m['Contest']['name'].'</p>
															<span>Type : '.$m['Contest']['type'].'</span>
															<span>Location : '.$m['Contest']['location'].'</span>
															<span>Date : '.$m['Contest']['date'].'</span></div>
															<div class="4u 12u(mobile)">';
											echo $this->Html->link('Details',
													array('controller' => 'contests', 'action' => 'show', $m['Contest']['id']),
													array('class' => 'button-medium'));
											echo			'</div>
														</div>
													</li>';
										}
									?>
								</ul>
							</section>

					</div>
				</div>

			</div>
		</div>
	</div>
