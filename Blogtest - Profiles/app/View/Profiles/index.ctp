<!-- File: app\View\Profiles\index.ctp -->

<h1>Profile Tester</h1>
<table border = "0">
	<tr>
	<td> Name </td>
	</tr>
	<tr>
	<td> Major </td>
	</tr>
	<tr>
	<td> Year </td>
	</tr>
</table>
 <?php echo $this->Html->link('Edit', array('controller' => 'profiles',
		'action'=>'editProfileMajor')); ?>