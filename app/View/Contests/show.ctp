	</div>
	<div id="content-wrapper">
		<div id="content">
			<div class="container">
				<div class="row">
					<div class="4u 12u(mobile)">

						<!-- Feature #1 -->
							<section>
								<?php 
								echo "<h2>".$contest['Contest']['name']."</h2>";
								echo "<h3>".$contest['Contest']['type']."</h3>";
								echo "<span>".$workouts[0]['Workout']['date']."</span>";
								echo "<p>".$contest['Contest']['description']."</p>";
								echo $this->Html->link('Fin du match !', 
										array('controller' => 'workouts', 'action' => 'end'),
										array('class' => 'button-medium'));
								?>
							</section>

					</div>
					<div class="4u 12u(mobile)">

						<!-- Feature #1 -->
							<section>
								<?php 
								echo "<h2>Joueur 1 : ".$member1['Member']['email']."</h2>";
								echo "<h3>".$contest['Contest']['type']."</h3>";
								echo "<p>".$contest['Contest']['description']."</p>";
								?>
							</section>

					</div>
					<?php if(isset($member2)) { ?>

					<div class="4u 12u(mobile)">

						<!-- Feature #1 -->
							
							<section>
								<?php 
								echo "<h2>Joueur 2 : ".$member2['Member']['email']."</h2>";
								echo "<h3>".$contest['Contest']['type']."</h3>";
								echo "<p>".$contest['Contest']['description']."</p>";
								?>
							</section>

					</div>

					<?php } ?>
					
				</div>
			</div>
		</div>
	</div>