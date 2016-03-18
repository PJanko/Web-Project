<?php $this->assign('title', 'Index');?>

<html>
	<body>
		<header>
			<h1>
				Bienvenu <?php echo $myname;?>
			</h1>

			<p>
				Inscription prochainement disponible, restez connecté.
			</p>
				
			<h2>Navigation</h2>
			<?php echo $this->Html->link('Liste', array('controller' => 'Accounts', 'action' => 'halloffame')); ?>
			
			<?php echo $this->Html->link('Accueil', '/'); ?>
			
			<?php echo $this->Html->link('Ajouter résultat', array('controller' => 'Accounts', 'action' => 'addresults')); ?>
			
			<?php echo $this->Html->link('Mon Profil', array('controller' => 'Accounts', 'action' => 'myprofile')); ?>
			
			<?php echo $this->Html->link('Mes résultats', array('controller' => 'Accounts', 'action' => 'myresults')); ?>
			
			<?php echo $this->Html->link('Séances', array('controller' => 'Accounts', 'action' => 'sceances')); ?>
		</header>
	</body>
</html>