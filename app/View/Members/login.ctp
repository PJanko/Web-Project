	
<!-- Content -->
<div id="content-wrapper">
	<div id="content">
		<div class="container">
			<div class="row">
				<div class="4u 12u(mobile)">

					<!-- Box #1 -->
						<section>
							<header>
								<h2>Pas encore membre ?</h2>
								<h3>Inscris-toi via notre formulaire</h3>
							</header>
							<?php echo $this->Form->create('Member',array('action' => 'register','method' => 'post'));?>
								<input name="data[Member][email]" type="text" placeholder="E-Mail">
								<input name="data[Member][password]" type="password" placeholder="Mot de Passe">
								<input name="data[Member][confirm]" type="password" placeholder="Confirmation">
								<input class="button-medium" type="submit" value="Enregistrer">
							<?php echo $this->Form->end(); ?>
						</section>

				</div>
				<div class="4u 12u(mobile)">

					<!-- Box #2 -->
						<section>
							<header>
								<h2>Déjà inscris ?</h2>
								<h3>Connectes toi pour profiter de nos services</h3>
							</header>
							<?php echo $this->Form->create('Member',array('action' => 'login','method' => 'post'));?>
								<input name="data[Member][email]" type="text" placeholder="E-Mail">
								<input name="data[Member][password]" type="password" placeholder="Mot de Passe">
								<input class="button-medium" type="submit" value="Connecter">
							<?php echo $this->Form->end(); ?>
						</section>

				</div>
				<div class="4u 12u(mobile)">

					<!-- Box #3 -->
						<section>
							<header>
								<h2>Présent sur les réseaux sociaux ?</h2>
							</header>
							<div class="social-login">
								<?php echo $this->Html->link(
									    '<i class="fa fa-facebook-official"></i><span>Connecte-toi avec Facebook</span>',
									    array('action'=>'social_login', 'Facebook'),
									    array('escape' => false)
									);
								?>
							</div>
							<div class="social-login">
								<?php echo $this->Html->link(
									    '<i class="fa fa-google-plus-square"></i><span>Connecte-toi  avec  Google  </span>',
									    array('action'=>'social_login', 'Google'),
									    array('escape' => false)
									);
								?>
							</div>							
						</section>

				</div>
			</div>
		</div>
	</div>
</div>
