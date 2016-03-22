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
						echo $this->Html->link('Classements', array('controller' => 'members', 'action' => 'login'));
		                echo $this->Html->link('Se Connecter', array('controller' => 'members', 'action' => 'login'));
		            ?>
				</nav>

		</div>
	</div>
</header>