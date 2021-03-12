<?php
$dbconn = mysqli_connect('localhost', 'root', '', 'simexamerica'); //usar constantes de define.php
if (mysqli_connect_errno()) {
	//printf("Falló la conexión: %s\n", $dbconn->connect_error);
	exit();
}
if (isset($_POST['mensagem'])) {
	$mensagem = utf8_decode(strip_tags(trim(filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING))));
	$de = (int)$_POST['de'];
	$para = (int)$_POST['para'];
	if ($mensagem != '') {
		$sql = "INSERT INTO `mensagens` (id_de, id_para, mensagem, time, lido) VALUES ('$de','$para','$mensagem','" . time() . "', '0')";
		if (mysqli_query($dbconn, $sql)) {
			echo 'ok';
		} else {
			echo 'no';
		}
	}
}
?>
