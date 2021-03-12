<?php
if (isset($_GET)) {

	$dbconn = mysqli_connect('localhost', 'root', '', 'simexamerica'); //usar constantes de define.php
	if (mysqli_connect_errno()) {
		printf("Falló la conexión: %s\n", $dbconn->connect_error);
		exit();
	}

	$userOnline = (int)$_GET['user'];
	$groupOnline = (int)$_GET['grupo'];
	$timestamp = ($_GET['timestamp'] == 0) ? time() : strip_tags(trim($_GET['timestamp']));
	$lastid = (isset($_GET['lastid']) && !empty($_GET['lastid'])) ? $_GET['lastid'] : 0;

	/*	
	$userOnline = 6;
	$groupOnline = 1;
*/
	$usersOn = array();
	$agora = date('Y-m-d H:i:s');
	$expira = date('Y-m-d H:i:s', strtotime('+1 min'));
	//echo "UPDATE `users` SET `limite` = '$expira' WHERE `id_user` = '$userOnline'";
	$sql = "UPDATE `users` SET `limite` = '$expira' WHERE `id_users` = '$userOnline'";
	$upOnline = mysqli_query($dbconn, $sql);

	if ($groupOnline == 0) {
		$sql = "SELECT * FROM `users` WHERE `id_users` != '$userOnline' AND `grupo` not in ('$groupOnline') ORDER BY `id_users` ASC";
		$pegaOnline = mysqli_query($dbconn, $sql);
	} else {
		$sql = "SELECT * FROM `users` WHERE `id_users` != '$userOnline' AND `grupo` in ('$groupOnline','0') ORDER BY `id_users` ASC";
		$pegaOnline = mysqli_query($dbconn, $sql);
	}
	while ($onlines = $pegaOnline->fetch_assoc()) {
		//foreach ($pegaOnline as $onlines) {
		$foto = ($onlines['img_user'] == '') ? 'default.jpg' : $onlines['img_user'];
		$blocks = explode(',', $onlines['blocks']);
		if (!in_array($userOnline, $blocks)) {
			if ($agora >= $onlines['limite']) {
				$usersOn[] = array('id' => $onlines['id_users'], 'nome' => utf8_encode($onlines['nombres']), 'foto' => $foto, 'status' => 'off');
			} else {
				$usersOn[] = array('id' => $onlines['id_users'], 'nome' => utf8_encode($onlines['nombres']), 'foto' => $foto, 'status' => 'on');
			}
		}
	}

	if (empty($timestamp)) {
		die(json_encode(array('status' => 'erro')));
	}

	$tempoGasto = 0;
	$lastidQuery = '';

	if (!empty($lastid)) {
		$lastidQuery = ' AND `id` > ' . $lastid;
	}

	if ($_GET['timestamp'] == 0) {
		$sql = "SELECT * FROM `mensagens` WHERE `lido` = 0 ORDER BY `id` DESC";
		$verifica = mysqli_query($dbconn, $sql);
	} else {
		$sql = "SELECT * FROM `mensagens` WHERE `time` >= $timestamp" . $lastidQuery . " AND `lido` = 0 ORDER BY `id`DESC";
		$verifica = mysqli_query($dbconn, $sql);
	}

	$resultados = mysqli_num_rows($verifica);

	if ($resultados <= 0) {
		while ($resultados <= 0) {
			if ($resultados <= 0) {
				//durar 30 segundos verificando
				if ($tempoGasto >= 20) {
					die(json_encode(array('status' => 'vazio', 'lastid' => 0, 'timestamp' => time(), 'users' => $usersOn)));
					exit;
				}

				//descansar o script por um segundo
				sleep(1);

				$sql = "SELECT * FROM `mensagens` WHERE `time` >= $timestamp" . $lastidQuery . " AND `lido` = 0 ORDER BY `id`DESC";
				$verifica = mysqli_query($dbconn, $sql);
				$resultados = mysqli_num_rows($verifica);
				$tempoGasto += 1;
			}
		}
	}

	$novasMensagens = array();
	if ($resultados >= 1) {
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

		while ($row = $verifica->fetch_assoc()) {
			//foreach ($verifica as $row) {
			$fotoUser = '';
			$janela_de = 0;

			if ($userOnline == $row['id_de']) {
				$janela_de = $row['id_para'];
			} elseif ($userOnline == $row['id_para']) {
				$janela_de = $row['id_de'];
				$sql = "SELECT `img_user` FROM `users` WHERE `id_users` = '$row[id_de]'";
				$pegaUsr = mysqli_query($dbconn, $sql);
				while ($usr = $pegaUsr->fetch_assoc()) {
					//foreach ($pegaUsr as $usr) {
					$fotoUser = ($usr['img_user'] == '') ? 'default.jpg' : $usr['img_user'];
				}
			}
			$msg = str_replace($emotions, $imgs, $row['mensagem']);
			$novasMensagens[] = array(
				'id' => $row['id'],
				'mensagem' => utf8_encode($msg),
				'fotoUser' => $fotoUser,
				'id_de' => $row['id_de'],
				'id_para' => $row['id_para'],
				'janela_de' => $janela_de
			);
		}
	}

	$ultimaMsg = end($novasMensagens);
	$ultimoId = $ultimaMsg['id'];
	die(json_encode(array('status' => 'resultados', 'timestamp' => time(), 'lastid' => $ultimoId, 'dados' => $novasMensagens, 'users' => $usersOn)));
}
?>
