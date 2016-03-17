<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css('ie9');
		echo $this->Html->css('main');
		echo $this->Html->css('custom.css');
	?>
</head>
<body>

	<?php echo $this->Flash->render(); ?>

	<?php
		echo $this->element('header');
		echo $this->element('navbar-anonym');
		echo $this->fetch('content');
		echo $this->element('footer');
	?>
		
	<?php 
		echo $this->element('sql_dump'); 
		echo $this->Html->script('jquery.min');
		echo $this->Html->script('skel.min');
		echo $this->Html->script('main');
	?>
</body>
</html>
