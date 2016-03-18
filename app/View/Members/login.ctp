	
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
								<input class="button-big" type="submit" value="Enregister">
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
								<input class="button-big" type="submit" value="Connecter">
							<?php echo $this->Form->end(); ?>
						</section>

				</div>
				<div class="4u 12u(mobile)">

					<!-- Box #3 -->
						<section>
							<header>
								<h2>Présent sur les réseaux sociaux ?</h2>
								<h3>Connecte toi rapidement avec Google et Facebook</h3>
							</header>
							
						</section>

				</div>
			</div>
		</div>
	</div>
</div>
