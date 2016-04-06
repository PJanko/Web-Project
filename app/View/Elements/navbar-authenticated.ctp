	<header id="header" class="container">
		<div class="row">
			<div class="12u">

				<!-- Logo -->
					<h1>
						<?php
							echo $this->Html->link('Sport Manager', array('controller' => 'pages', 'action' => 'accueil'));
						?>
					</h1>

				<!-- Nav -->
					<nav id="nav">
						<?php
							echo $this->Html->link('Classements', array('controller' => 'classements', 'action' => 'index'));
							echo $this->Html->link('Séances', array('controller' => 'workouts', 'action' => 'index'));
							echo $this->Html->link('Compétitions', array('controller' => 'contests', 'action' => 'index'));
							echo $this->Html->link('Objets Co', array('controller' => 'devices', 'action' => 'index'));
							echo $this->Html->link('Mon Compte', array('controller' => 'members', 'action' => 'account'));
			                echo $this->Html->link('Se Déconnecter', array('controller' => 'members', 'action' => 'logout'));
			            ?>
					</nav>

			</div>
		</div>
	</header>
</div>
