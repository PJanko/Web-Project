<!-- Content -->
<div id="content-wrapper">
	<div id="content">
		<div class="container">
			<div class="row">
				<div class="12u 12u(mobile)">

					<!-- Box #2 -->
						<section>
							<header>
								<h2>Vos objets</h2>
								<h3>Liste de tous les objets qui ont accès à votre compte</h3>
							</header>
							<ul class="quote-list">
								<?php 
									foreach( $trusted as $device) {
										echo 	'<li>
													<div class="row">
														<div class="8u 12u(mobile)"><p>'.$device['Device']['description'].'</p>
														<span>Numéro de Série : '.$device['Device']['serial'].'</span></div>
														<div class="4u 12u(mobile)">';
										echo $this->Html->link('Supprimer', 
												array('controller' => 'devices', 'action' => 'delete', $device['Device']['id']),
												array('class' => 'button-medium'));
										echo $this->Html->link('Bloquer', 
												array('controller' => 'devices', 'action' => 'deny', $device['Device']['id']),
												array('class' => array('button-medium', 'orange')));
										echo			'</div>
													</div>
												</li>';
									}
								?>
							</ul>
						</section>

				</div>
			</div>
			<div class="row">
				<div class="12u 12u(mobile)">

					<!-- Box #2 -->
						<section>
							<header>
								<h2>Objets non validés</h2>
								<h3>Liste de objets qui demandent accès à votre compte </h3>
							</header>
							<ul class="quote-list">
								<?php 
									foreach( $untrusted as $device) {
										echo 	'<li>
													<div class="row">
														<div class="8u 12u(mobile)"><p>'.$device['Device']['description'].'</p>
														<span>Numéro de Série : '.$device['Device']['serial'].'</span></div>
														<div class="4u 12u(mobile)">';
										echo $this->Html->link('Supprimer', 
												array('controller' => 'devices', 'action' => 'delete', $device['Device']['id']),
												array('class' => 'button-medium'));
										echo $this->Html->link('Accepter', 
												array('controller' => 'devices', 'action' => 'allow', $device['Device']['id']),
												array('class' => array('button-medium', 'green')));
										echo			'</div>
													</div>
												</li>';
									}
								?>
							</ul>
						</section>
				</div>
			</div>
		</div>
	</div>
</div>