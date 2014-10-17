<?php include dirname(__FILE__) . '/../_partials/header.php'; ?>

	<h3>User management</h3>

	<h4>Available users</h4>
	<?php foreach ($users as $user): ?>
		<form class="user-edit-form" action="" method="post">
			<input name="id" type="hidden" value="<?= $user['id']; ?>">
			<input name="login" type="text" value="<?= $user['login']; ?>">
			<input name="password" type="password" placeholder="Change password">
			<input type="checkbox" name="is_admin" <?php if ($user['is_admin']) echo 'checked="checked"'; ?>>
			<input type="submit" value="Edit user">
			<input type="submit" name='delete' value='Delete'>
		</form>
	<?php endforeach; ?>
	<hr>
	<h4>Create new user</h4>
	<form class="user-add-form" action="" method="post">
		<input name="login" type="text" placeholder="Login">
		<input name="password" type="password" placeholder="Password">
		<input type="checkbox" name="is_admin">
		<input type="submit" value="Add user">
	</form>
	<h3 class="error"><?= $error; ?></h3>

<?php include dirname(__FILE__) . '/../_partials/footer.php'; ?>