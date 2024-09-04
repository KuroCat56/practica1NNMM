<?php
$hosts_aceptados = array('localhost', '127.0.0.1');
$metodo_aceptado = 'POST';
$usuario_correcto = "Admin";
$password_correcto = "Admin";
$txt_usuario = $_POST["txt_usuario"];
$txt_password = $_POST["txt_password"];
$token = "";

if(in_array($_SERVER['HTTP_HOST'], $hosts_aceptados)){
    //Se acepta la ip
    if($_SERVER['REQUEST_METHOD'] == $metodo_aceptado){
    //Se acepta el método
        if (isset($txt_usuario) && !empty($txt_usuario)){
            //El usuario existe
            if (isset($txt_password) && !empty($txt_password)){
            //La contraseña existe
                if($txt_password == $password_correcto){
                    //Contraseña correcta
                    $ruta = "welcome.php";
                    $msg = "El usuario no está permitido";
                    $codigo_estado = 200;
                    $texto_estado = "OK";
                    //Generar codigo basado en la hora
                    list($usec,$sec) = explode(" ",microtime());
                    $token = base64_encode(date("Y-m-d H:i:s",$sec).substr($usec,1));
                } else {
                    $ruta = "";
                    $msg = "La contrasñea es incorrecta";
                    $codigo_estado = 401;
                    $texto_estado = "Unauthorized";
                    $token = "";
                }
                if ($txt_usuario == $usuario_correcto){

                } else{
                    $ruta = "";
                    $msg = "El usuario no está permitido";
                    $codigo_estado = 401;
                    $texto_estado = "Unauthorized";
                    $token = "";
                }


            } else {
                $ruta = "";
                $msg = "Campo contraseña no posee datos";
                $codigo_estado = 412;
                $texto_estado = "Precondition fail";
                $token = "";
            }
        } else{
            $ruta = "";
            $msg = "Campo usuario no posee datos";
            $codigo_estado = 412;
            $texto_estado = "Precondition fail";
            $token = "";
        }
    } else {
        $ruta = "";
        $msg = "El método HTTP no es permitido";
        $codigo_estado = 405;
        $texto_estado = "Method not allowed";
        $token = "";
    }
} else {
    $ruta = "";
    $msg = "La dirección IP no está permitida";
    $codigo_estado = 406;
    $texto_estado = "Not Accepted";
    $token = "";
}

$arreglo_respuesta = array(
    "status"=>((intval($codigo_estado) == 200) ? "success" : "error"),
    "error"=>((intval($codigo_estado) == 200) ? "" : array("code"=>$codigo_estado, "message"=>$msg)),
    "data"=>array(
        "url"=>$ruta,
        "token"=>$token
    ),
    "count"=>1
    );

header("HTTP/1.1".$codigo_estado." ".$texto_estado);
header("Context-Type: application/json");
echo($arreglo_respuesta);
?>