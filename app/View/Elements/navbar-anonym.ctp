<header id="header" class="container">
	<div class="row">
		<div class="12u">

			<!-- Logo -->
				<h1><a href="#" id="logo">Sport Manager</a></h1>

			<!-- Nav -->
				<nav id="nav">
					<?php
						echo $this->Html->link('Accueil', array('controller' => 'pages', 'action' => 'accueil'));
						echo $this->Html->link('Classements', array('controller' => 'members', 'action' => 'login'));
		                echo $this->Html->link('Se Connecter', array('controller' => 'members', 'action' => 'login'));
		            ?>
				</nav>

		</div>
	</div>
</header>