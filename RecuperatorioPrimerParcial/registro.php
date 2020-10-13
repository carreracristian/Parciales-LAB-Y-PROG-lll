<?php
require_once '../RecuperatorioPrimerParcial/datos.php';
require_once '../RecuperatorioPrimerParcial/Token.php';
class Usuario{

    public $email;
    public $clave;
    public $foto;
    public $tipo;

    public function __construct($email,$clave,$foto,$tipo){
        $this->email=$email;
        $this->clave=$clave;
        $this->foto=$foto;
        $this->tipo=$tipo;
    }

    //Metodo magicos
    public function __get($var)
    {
        return $this->$var;
    }
    public function __set($var, $value)
    {
        $this->$var=$value;
    }
    public function guardar(){
        $save=Datos::GuardarJSON_Serializado("Archivos/Usuarios.json",$this);

        var_dump($save);
        return $save;
    }
    
    public static function validarUsuarioRepetido($usuario){

        $leer=Datos::LeerJSON_Serializado("Archivos/Usuarios.json");
        $mensaje = false;

        if($leer!=false){
            foreach($leer as $value){
                if($value->email==$usuario->email){
                    $mensaje=true;
                break;
                }
            }
        }
        echo $mensaje;
        return $mensaje;
    }
}



?>