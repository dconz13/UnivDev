<!-- File: /app/View/Posts/index.ctp -->

<h1>Blog Posts</h1>

<?php echo $this->Html->link('Login',array('controller'=>'users','action'=>'login'));?><br>
<?php echo $this->Html->link('Logout',array('controller'=>'users','action'=>'logout'));?><br>
<?php echo 'New user? ',$this->Html->link('Sign up',array('controller'=>'users','action'=>'register'));?><br><br>
	<?php echo $this->Html->link(
	'Add Post',
	array('controller' => 'posts', 'action' => 'add')
	); ?><br>
<table>
	<tr>
		<th>Id</th>
		<th>Title</th>
		<th>Created</th>
	</tr>
	
	<!-- Here is where we loop through our $posts array, printing out post info -->
	
	<?php foreach ($posts as $post): ?> <!-- foreach only usable on arrays -->
	<tr>
		<td><?php echo $post['Post']['id']; ?></td>
		<td><?php echo $this->Html->link($post['Post']['title'],array('controller' => 'posts',
			'action' => 'view', $post['Post']['id'])); ?>
		</td>
		<td><?php echo $this->Html->link('Edit', array('action' => 'edit', $post['Post']['id']));
		    ?></td>
		<td><?php echo $this->Form->postLink('Delete', array('action' => 'delete',
			$post['Post']['id']), array('confirm' => 'Are you sure?'));
			?>
		</td>
		<td><?php echo $post['Post']['created']; ?></td>
	</tr>
	<?php endforeach; ?>
	<?php unset($post); ?>
</table>