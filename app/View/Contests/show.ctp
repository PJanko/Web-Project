	</div>
	<div id="content-wrapper">
		<div id="content">
			<div class="container">
				<div class="row">
					<div class="4u 12u(mobile)">

						<!-- Feature #1 -->
							<section>
								<?php 
								echo "<h2>".$contest['name']."</h2>";
								echo "<h3>".$contest['type']."</h3>";
								echo "<p>".$contest['description']."</p>";
								echo "<span>".$contest['Workout']['date']."</span>";
								echo "<p>".$contest['Workout']['description']."</p>";
								echo "<p>".$contest['Workout']['sport']."</p>";
								echo $this->Html->link('Fin du match !', 
										array('controller' => 'workouts', 'action' => 'end'),
										array('class' => 'button-medium'));
								?>
							</section>

					</div>
					<div class="4u 12u(mobile)">

						<!-- Feature #1 -->
							<section>
								
								<h2>Joueur 1 :</h2>
								<?php 
									echo "<h3>".$contest['Member1']['email']."</h3>";
								?> 
								<div class="bordered-feature-image">
								<?php 
									echo $this->Html->image( /*$contest['Member1']['id']*/"profil".".png", array('alt' => 'User Picture'));
								?>
								</div>

							</section>

					</div>
					<?php if(isset($contest['Member2'])) { ?>

					<div class="4u 12u(mobile)">

						<!-- Feature #1 -->
							
							<section>

								<h2>Joueur 1 :</h2>
								<?php 
									echo "<h3>".$contest['Member2']['email']."</h3>";
								?> 
								<div class="bordered-feature-image">
								<?php 
									echo $this->Html->image( /*$contest['Member2']['id']*/"profil".".png", array('alt' => 'User Picture'));
								?>
								</div>

							</section>

					</div>

					<?php } ?>
					
				</div>
			</div>
		</div>
	</div>