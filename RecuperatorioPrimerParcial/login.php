<?php
require_once '../RecuperatorioPrimerParcial/datos.php';

class Login{
    public static function validarUsuario($_correo,$_clave){
        $leer=Datos::LeerJSON_Serializado("Archivos/Usuarios.json");
        $mensaje = "Error, Usuario no encontrado";

        foreach($leer as $value){
            if($value->email==$_correo && $value->clave==$_clave){
                $payload=array("email"=>$value->email,"tipo"=>$value->tipo);
                $mensaje=Token::CrearToken($payload);
            break;
            }
        }
        return $mensaje; 
    } 
    public static function devolverUsuario($email){
        $leer=Datos::LeerJSON_Serializado("Archivos/Usuarios.json");
        $mensaje = "Error, Usuario no encontrado";

        if($leer != false){
            foreach($leer as $value){
                if($value->email==$email){
                    return $value;
                break;
                }
            }
        }
        return $mensaje;
    }
    public static function validarTipoUsuario($tipo){
        $leer=Datos::LeerJSON_Serializado("Archivos/Usuarios.json");
        $mensaje = false;

        if($leer != false){
            foreach($leer as $value){
                if($value->tipo==$tipo){
                    return true;
                break;
                }
            }
        }
        return $mensaje;
    }
}