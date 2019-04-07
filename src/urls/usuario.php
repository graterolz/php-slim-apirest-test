<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;
//
// GET, obtener todos los usuarios
$app->get('/api/usuario', function(Request $request, Response $response){
	$sql = "SELECT * FROM usuario";
	//
	try{
		$db = new db();
		$db = $db->conectDB();
		$resultado = $db->query($sql);
		//
		if ($resultado->rowCount() > 0){
			$usuario = $resultado->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($usuario);
		}
		else {
			echo json_encode("No existen usuarios en la BBDD.");
		}
		$resultado = null;
		$db = null;
	}
	catch(PDOException $e){
		echo '{"error" : {"text":'.$e->getMessage().'}';
	}
});
//
// GET, obtener un usuario por ID
$app->get('/api/usuario/{id}', function(Request $request, Response $response){
	$idusu = $request->getAttribute('id');
	$sql = "SELECT * FROM usuario WHERE idusu = $idusu";
	//
	try{
		$db = new db();
		$db = $db->conectDB();
		$resultado = $db->query($sql);
		//
		if ($resultado->rowCount() > 0){
			$usuario = $resultado->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($usuario);
		}
		else {
			echo json_encode("No existe usuario en la BBDD con este ID.");
		}
		$resultado = null;
		$db = null;
	}
	catch(PDOException $e){
		echo '{"error" : {"text":'.$e->getMessage().'}';
	}
});
//
// POST, crear usuario
$app->post('/api/usuario/add', function(Request $request, Response $response){
	$data['idusu'] = NULL;
	$data['idrol'] = $request->getParam('idrol');
	$data['user'] = $request->getParam('user');
	$data['pass'] = $request->getParam('pass');
	$data['fecha_registro'] = 'NOW()';
	$data['fecha_edicion'] = 'NOW()';
	$data['estado_registro'] = 1;
	//
	$sql = "INSERT INTO usuario (idusu, idrol, user, pass, fecha_registro, fecha_edicion, estado_registro) VALUES 
		(:idusu, :idrol, :user, :pass, :fecha_registro, :fecha_edicion, :estado_registro)";
	//
	try{
		$db = new db();
		$db = $db->conectDB();
		$resultado = $db->prepare($sql);
		$resultado->bindParam(':idusu', $data['idusu']);
		$resultado->bindParam(':idrol', $data['idrol']);
		$resultado->bindParam(':user', $data['user']);
		$resultado->bindParam(':pass', $data['pass']);
		$resultado->bindParam(':fecha_registro', $data['fecha_registro']);
		$resultado->bindParam(':fecha_edicion', $data['fecha_edicion']);
		$resultado->bindParam(':estado_registro', $data['estado_registro']);
		$resultado->execute();
		echo json_encode("Nuevo usuario guardado.");
		$resultado = null;
		$db = null;
	}
	catch(PDOException $e){
		echo '{"error" : {"text":'.$e->getMessage().'}';
	}
}); 
//
// PUT, Editar usuario
$app->put('/api/usuario/edit/{id}', function(Request $request, Response $response){
	$data['idusu'] = $request->getAttribute('id');
	$data['idrol'] = $request->getParam('idrol');
	$data['user'] = $request->getParam('user');
	$data['pass'] = $request->getParam('pass');
	$data['fecha_registro'] = 'NOW()';
	$data['fecha_edicion'] = 'NOW()';
	$data['estado_registro'] = 1;
	//
	$sql = "UPDATE usuario SET
				idrol = :idrol,
				user = :user,
				pass = :pass,
				fecha_edicion = :fecha_edicion
			WHERE idusu = :idusu";
	//
	try{
		$db = new db();
		$db = $db->conectDB();
		$resultado = $db->prepare($sql);
		
		$resultado->bindParam(':idusu', $data['idusu']);
		$resultado->bindParam(':idrol', $data['idrol']);
		$resultado->bindParam(':user', $data['user']);
		$resultado->bindParam(':pass', $data['pass']);
		$resultado->bindParam(':fecha_edicion', $data['fecha_edicion']);
		$resultado->execute();
		echo json_encode("Usuario modificado.");
		$resultado = null;
		$db = null;
	}
	catch(PDOException $e){
		echo '{"error" : {"text":'.$e->getMessage().'}';
	}
}); 
//
// DELETE, Eliminar usuario
$app->delete('/api/usuario/del/{id}', function(Request $request, Response $response){
	$idusu = $request->getAttribute('id');
	$sql = "DELETE FROM usuario WHERE idusu = $idusu";
	//
	try{
		$db = new db();
		$db = $db->conectDB();
		$resultado = $db->prepare($sql);
		$resultado->execute();
		//
		if ($resultado->rowCount() > 0) {
			echo json_encode("Usuario eliminado.");  
		}
		else {
			echo json_encode("No existe usuario con este ID.");
		}
		$resultado = null;
		$db = null;
	}
	catch(PDOException $e){
		echo '{"error" : {"text":'.$e->getMessage().'}';
	}
});