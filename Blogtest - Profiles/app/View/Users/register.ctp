<!--File: app\View\Users\signup.ctp -->

<?php
	echo $this->Form->create(array('action' => 'register'));
	echo $this->Form->input('name');
	echo $this->Form->input('username');
	echo $this->Form->input('email');
	echo $this->Form->input('password');
	echo $this->Form->end('Register');
?>