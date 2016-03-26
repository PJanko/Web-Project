<div id="content-wrapper">
	<div id="content">
		<div class="container">
			<div class="row">
				<div class="6u 12u(mobile)">
					<a href="#" class="bordered-feature-image"><?php echo $this->Html->image($userInfo['image'], array('alt' => 'Photo de profil'));?></a>
				</div>
				<div class="6u 12u(mobile)">
					<ul class="quote-list">
						<li>
							<h2><?php print_r($userInfo['email']); ?></h2>
						</li>
						<li>
							<h3>Changer mon mot de passe</h3>
							<?php echo $this->Form->create('Member',array('action' => 'changepassword','method' => 'post'));?>
								<input name="data[Member][old_password]" type="password" placeholder="Ancien Mot de Passe">
								<input name="data[Member][new_password]" type="password" placeholder="Nouveau Mot de Passe">
								<input name="data[Member][confirm_password]" type="password" placeholder="Confirmation">
								<input class="button-big" type="submit" value="Enregister">
							<?php echo $this->Form->end(); ?>
						</li>
						<li>
							<h3>Changer ma photo de profil</h3>
							<?php echo $this->Form->create('Member',array('type' => 'file', 'action' => 'changeprofil'));?>
								<input name="data[Member][image]" type="file" accept="image/jpeg" placeholder="Confirmation">
								<input class="button-big" type="submit" value="Envoyer">
							<?php echo $this->Form->end(); ?>
						</li>
					</ul>		
				</div>	
			</div>
		</div>
	</div>
</div>