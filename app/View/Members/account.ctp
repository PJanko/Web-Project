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
								<?php print_r($userInfo['Member']['username']);?>
								</h3>
				
								<input name="data[Member][nom]" type="text" placeholder="Nom" value="<?php print_r($userInfo['Member']['nom']); ?>">
								<input name="data[Member][prenom]" type="text" placeholder="Prénom" value="<?php print_r($userInfo['Member']['prenom']); ?>">
								<input name="data[Member][naissance]" type="date"  value="<?php print_r($userInfo['Member']['naissance']); ?>">									
								<input name="data[Member][confirm]" type="password" placeholder="Confirmation">
								<input class="button-big" type="submit" value="Enregister">
								<?php echo $this->Form->end(); ?>
							</div>
							
							

							<a href="#" class="button-big">Go on, click me!</a>

					</div>
									</div>
							
							
				<div class="4u 12u(mobile)">
					<section>
						<header>
							<h2>Pas encore membre ?</h2>
							<h3>Inscris-toi via notre formulaire</h3>
						</header>
						<?php echo $this->Form->create('Member',array('action' => 'register','method' => 'post'));?>
							<input name="data[Member][nom]" type="text" placeholder="Nom d'utilisateur">
							<input name="data[Member][email]" type="text" placeholder="E-Mail">
							<input name="data[Member][password]" type="password" placeholder="Mot de Passe">
							<input name="data[Member][confirm]" type="password" placeholder="Confirmation">
							<input class="button-big" type="submit" value="Enregister">
						<?php echo $this->Form->end(); ?>
					</section>			
				</div>
				
			</div>
		</div>
	</div>
</div>