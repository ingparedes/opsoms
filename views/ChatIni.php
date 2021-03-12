<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ChatIni = &$Page;
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/responsive.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery_play.js"></script>
<script type="text/javascript">
	$.noConflict();
</script>
<?php
error_reporting(E_ALL);
$email = $_SESSION[SESSION_USER_NAME];
$dadosUser = ExecuteRow("SELECT * FROM `users` WHERE `email` = '" . $email . "' LIMIT 1;");
$_SESSION["id_user"] = $dadosUser['id_users'];
?>
<span class="user_online" id="<?php echo $dadosUser['id_users']; ?>"><?php echo "usuario:" . $dadosUser['nombres']; ?></span>
<aside id="users_online">
	<ul>
		<?php
		if ($dadosUser['grupo'] <> '0') {
			$pegaUsuarios = ExecuteRows("SELECT * FROM users WHERE email != '" . $email . "' AND grupo IN ('0', '" . $dadosUser['grupo'] . "') ;");
			//var_dump($pegaUsuarios);
		} else {
			$pegaUsuarios = ExecuteRows("SELECT * FROM users WHERE id_users != " . $_SESSION['id_user'] . ";");
			//var_dump($pegaUsuarios);
		}

		foreach ($pegaUsuarios as $row) {

			$img_user = ($row['img_user'] == '') ? 'default.jpg' : $row['img_user'];
			$blocks = explode(',', $row['blocks']);
			$agora = date('Y-m-d H:i:s');
			if (!in_array($_SESSION['id_user'], $blocks)) {
				$status = 'on';
				if ($agora >= $row['limite']) {
					$status = 'off';
				}
		?>
				<!-- ventanas de chat -->
				<li id="<?php echo $row['id_users']; ?>">
					<div class="imgSmall"><img src="fotos/<?php echo $img_user; ?>" border="0" /></div>
					<a href="#" id="<?php echo $_SESSION['id_user'] . ':' . $row['id_users']; ?>" class="comecar"><?php echo utf8_encode($row['nombres']); ?></a>
					<span id="<?php echo $row['id_users']; ?>" class="status <?php echo $status; ?>"></span>
				</li>
		<?php } // if (!in array)
		}
		?>
	</ul>
</aside>
<aside id="chats">
</aside>
<script type="text/javascript" src="js/functions.js"></script>

<?= GetDebugMessage() ?>
