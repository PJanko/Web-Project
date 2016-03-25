Member.cp

<div id="content-wrapper">
	<div id="content">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="6u 12u(mobile)">

						<!-- Banner Copy -->
							<h2>Mes Informations</h2>
							
							<div class="6u 12u(mobile)">

							<!-- Image profil -->
								<a href="#" class="bordered-feature-image"><img src="../img/profil.png" alt="" /></a>
							
								<h3> 
								  <?php print_r($userInfo['Member']['email']);?> 
								</h3>
								<?php echo $this->Form->create('Member',array('action' => 'changepassword','method' => 'post'));?>
								<input name="data[Member][old_password]" type="password" placeholder="Ancien Mot de Passe">
								<input name="data[Member][new_password]" type="password" placeholder="Nouveau Mot de Passe">
								<input name="data[Member][confirm_password]" type="password" placeholder="Confirmation">
								<input class="button-big" type="submit" value="Enregister">
								<?php echo $this->Form->end(); ?>
								
								
							</div>
							
							

							<a href="#" class="button-big">Go on, click me!</a>

					</div>
				</div>	
			</div>
		</div>
	</div>
</div>