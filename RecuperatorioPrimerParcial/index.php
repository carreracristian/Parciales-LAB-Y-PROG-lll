<?php
//require_once '../PracticaParcial1/Usuario.php';
require_once '../RecuperatorioPrimerParcial/Datos.php';
require_once '../RecuperatorioPrimerParcial/ingreso.php';
require_once '../RecuperatorioPrimerParcial/Respuestas.php';
require_once '../RecuperatorioPrimerParcial/login.php';
require_once '../RecuperatorioPrimerParcial/registro.php';

$method= $_SERVER["REQUEST_METHOD"];
$path=  $_SERVER["PATH_INFO"]??"ruta inexistente";

$mensaje= new Respuestas();

try{
    $auxPad= explode('/',$path)[1];
switch('/'.$auxPad){
    case '/registro':
        switch ($method) {
            case 'POST':
                $email=$_POST['email'] ?? null; 
                $clave =$_POST['password'] ?? null;
                $tipo=$_POST['tipo']??null;
                $name=$_FILES["imagen"]["name"]??null;
                $tmp_name=$_FILES["imagen"]["tmp_name"]??null;

                if (isset($email)&&isset($clave)&&isset($name)&&isset($tipo))
                {

                    $usuario=new Usuario($email,$clave,$name,$tipo);

                    if(Usuario::validarUsuarioRepetido($usuario)){
                        
                        $mensaje->data = "usuario repetido";
                    }else{
                        $usuario->foto=Datos::GuardarFoto($name,$tmp_name);
                        $respuesta=$usuario->guardar();
                        $mensaje->data =  'Se guardo exitosamente';
                    }
                }
                break;
        }
    break;
    case '/login':
        switch ($method) {
            case 'POST':
                echo 'entro al post';
                $email=$_POST['email'] ?? null; 
                $clave =$_POST['password'] ?? null;
                if (isset($email)&&isset($clave))
                {
                    $rta = Login::validarUsuario($email,$clave);
                    $obj = Login::devolverUsuario($email);
                    $mensaje->data="Datos del usuario: $obj->email $obj->tipo Y su Token es: $rta";
                }
            break; 
        }
    break;
    case '/vehiculo':
        switch ($method) {
            case 'POST':
                $headers=getallheaders();
                $patente=$_POST['patente']?? null;
                $marca=$_POST['marca']?? null;
                $modelo=$_POST['modelo']?? null;
                $precio=$_POST['precio']?? null;
                $Token=$headers["token"]??"";
                $payload = Token::ValidarToken($Token);
                if($payload !=null)
                {
                    if(isset($patente)&&strlen($patente)>0 &&strlen($marca)>0&&strlen($modelo)>0&&strlen($precio)>0)
                    {
                    $auto=new Auto($marca, $patente, $modelo, $precio);
                    $rta=$auto->guardar($patente);
                    $mensaje->status= "Se guardo el archivo con exito";
                    $mensaje->data='Alta exitosa';
                    }
                }
            case 'GET':
                $headers=getallheaders();
                $Token = $headers["token"]??"";
                $payload= Token::ValidarToken($Token);
                if($payload!=null){
                    $mensaje->data=Auto::devolverAutosSalida();
                }
                else{
                    $mensaje='Token invalido';
                }
                
            break;
        }
    break;
    case '/patente':
        case 'GET':
            if($patente=explode('/', $path)[2])
                    {
                            $headers=getallheaders();
                            $buscar= $_GET['buscar']??'';
                            $Token=$headers["token"]??"";
                            $payload = Token::ValidarToken($Token);
                            
                                if(Auto::PatenteRepetida($patente))
                                {
                                    $auxBuscar=Auto::ConvertirMinuscula($buscar);
                                    if($vehiculo=Auto::autoEncontrado($auxBuscar))
                                    {
                                        $mensaje = "Marca: $vehiculo->marca Patente: $vehiculo->patente Modelo: $vehiculo->modelo  Precio: $vehiculo->precio";

                                    }else 
                                    {
                                        $mensaje = "ERROR!! No existe $auxBuscar ";
                                    }

                                }else
                                {
                                    $mensaje ="ERROR No existe la patente!!";
                                }
                                
                        
                        
                    }
           
        break;
    break;

    }
}catch(Exception $e){
    
}

echo json_encode($mensaje);
?>