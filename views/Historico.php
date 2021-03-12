<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Historico = &$Page;
?>
<?php
if (isset($_POST['conversacom'])) {

	$dbconn = mysqli_connect('localhost', 'root', '', 'simexamerica'); //usar constantes de define.php
	if (mysqli_connect_errno()) {
		printf("Falló la conexión: %s\n", $dbconn->connect_error);
		exit();
	}
	$mensagens = array();
	$id_conversa = (int)$_POST['conversacom'];
	$online = (int)$_POST['online'];


	//$pegaConversas = BD::conn()->prepare("SELECT * FROM `mensagens` WHERE (`id_de` = ? AND `id_para` = ?) OR (`id_de` = ? AND `id_para` = ?) ORDER BY `id` DESC LIMIT 10");
	//$pegaConversas->execute(array($online, $id_conversa, $id_conversa, $online));
	$sql = "SELECT * FROM `mensagens` WHERE (`id_de` = $online AND `id_para` = $id_conversa) OR (`id_de` = $online AND `id_para` = $id_conversa) ORDER BY `id` DESC LIMIT 10";
	$pegaConversas = mysqli_query($dbconn, $sql);

	//$pegaConversas = ExecuteRows("SELECT * FROM `mensagens` WHERE (`id_de` = $online AND `id_para` = $id_conversa) OR (`id_de` = $online AND `id_para` = $id_conversa) ORDER BY `id` DESC LIMIT 10");

	//while ($row = $pegaConversas->fetch()) {
	$row = array();
	while ($row = $pegaConversas->fetch_assoc()) {
		//	foreach ($pegaConversas as $row) {
		$fotouser = '';
		if ($online == $row['id_de']) {
			$janela_de = $row['id_para'];
		} elseif ($online == $row['id_para']) {
			$janela_de = $row['id_de'];


			$pegaFoto = BD::conn()->prepare("SELECT `foto` FROM `usuarios` WHERE `id` = '$row[id_de]'");
			$pegaFoto->execute();

			$pegaFoto = ExecuteRow("SELECT `img_user` FROM `usuarios` WHERE `id_users` = '$row[id_de]'");
			//while ($usr = $pegaFoto->fetch()) {
			foreach ($pegaFoto as $usr) {
				$fotouser = ($usr['img_user'] == '') ? 'default.jpg' : $usr['img_user'];
			}
		}

		$emotions = array(':)', ':@', '8)', ':D', ':3', ':(', ';)');
		$imgs = array(
			'<img src="emotions/nice.png" width="14"/>',
			'<img src="emotions/angry.png" width="14"/>',
			'<img src="emotions/cool.png" width="14"/>',
			'<img src="emotions/happy.png" width="14"/>',
			'<img src="emotions/ooh.png" width="14"/>',
			'<img src="emotions/sad.png" width="14"/>',
			'<img src="emotions/right.png" width="14"/>'
		);
		$msg = str_replace($emotions, $imgs, $row['mensagem']);
		$mensagens[] = array(
			'id' => $row['id'],
			'mensagem' => utf8_encode($msg),
			'fotoUser' => $fotouser,
			'id_de' => $row['id_de'],
			'id_para' => $row['id_para'],
			'janela_de' => $janela_de
		);
	}
	die(json_encode($mensagens));
}
?>



<?= GetDebugMessage() ?>
