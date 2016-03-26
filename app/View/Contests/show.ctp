
	<div id="content-wrapper">
		<div id="content">
			<div class="container">
				<div class="row">
					<div class="4u 12u(mobile)">

						<!-- Feature #1 -->
							<section>
								<?php 
								echo "<h2>".$contest['name']."</h2>";
								?>
								<ul class="link-list last-child">
								<?php
									echo "<li><h3>".$contest['type']."</h3>";
									echo "<li><span>".$contest['description']."</span></li>";
									echo "<li><span>".$contest['Workout']['date']."</span></li>";
									echo "<li><span>".$contest['Workout']['description']."</span></li>";
									echo "<li><span>".$contest['Workout']['sport']."</span></li>";
								?>
								</ul>
								<?php echo $this->Html->link('Fin du match !', 
										array('controller' => 'workouts', 'action' => 'end'),
										array('class' => 'button-medium'));
								?>
							</section>

					</div>
					<div class="4u 12u(mobile)">

						<!-- Feature #1 -->
							<section>
								
								<h2>Joueur 1 :</h2>
								<?php echo "<h3>".$contest['Member1']['email']."</h3>"; ?> 
								<div class="bordered-feature-image">
								<?php echo $this->Html->image( $contest['Member1']['image'], array('alt' => 'Photo de profil')); ?>
								</div>

							</section>

					</div>
					<?php if(isset($contest['Member2'])) { ?>

					<div class="4u 12u(mobile)">

						<!-- Feature #1 -->
							
							<section>

								<h2>Joueur 1 :</h2>
								<?php echo "<h3>".$contest['Member2']['email']."</h3>"; ?> 
								<div class="bordered-feature-image">
								<?php echo $this->Html->image($contest['Member2']['image'], array('alt' => 'Photo de profil')); ?>
								</div>

							</section>

					</div>

					<?php } ?>
					
				</div>
			</div>
		</div>
	</div>