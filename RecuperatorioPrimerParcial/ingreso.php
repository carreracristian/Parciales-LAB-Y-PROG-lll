<?php
class Auto{
    public $patente;
    public $marca;
    public $modelo;
    public $precio;


    public function __construct($marca, $patente, $modelo, $precio){
        $this->marca=$marca;
        $this->patente=$patente;
        $this->modelo=$modelo;
        $this->precio=$precio;
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

     public function guardar($patente){
        $auto=Auto::patenteRepetida($patente);
        if($auto==false){
            $save=Datos::GuardarJSON_Serializado("Archivos/autos.json",$this);
        }
        else{
            $mensaje='Patente repetida';
        }
        

        var_dump($save);
        return $save;
    }
    public function guardarSalida(){
        $save=Datos::GuardarJSON_Serializado("Archivos/autosSalida.json",$this);

        var_dump($save);
        return $save;
    }
    public static function patenteRepetida($patente){
        $leer=Datos::LeerJSON_Serializado("Archivos/autos.json");
        $mensaje = false;

        if($leer!=false){
            foreach($leer as $value){
                if($value->patente==$patente){
                    $mensaje=true;
                break;
                }
            }
        }
        return $mensaje;
    }
    public static function devolverAutos(){

        $leer=Datos::LeerJSON_Serializado("Archivos/autos.json");
        $mensaje = 'No hay autos';

        if($leer!=false){
            $mensaje=$leer;
        }
        return $mensaje;
    }
    public static function devolverAutosSalida(){

        $leer=Datos::LeerJSON_Serializado("Archivos/autosSalida.json");
        $mensaje = 'No hay autos';

        if($leer!=false){
            $mensaje=$leer;
        }
        return $mensaje;
    }
    
    /*public static function ordenarAutos(){
        $leer=Datos::LeerJSON_Serializado("Archivos/autos.json");
        if($leer!=false){
            foreach($leer as $value){
                if($value->fechaIngreso>)
                break;
                }
            }
        }
    }*/
    public static function calcularTarifa($egreso,$patente){
        $leer=Datos::LeerJSON_Serializado("Archivos/autos.json");
        if($leer!=false){
            foreach($leer as $value){
                if($value->patente==$patente){
                    $minutos = (strtotime($value->fechaIngreso)-strtotime($egreso))/60;
                    $minutos = abs($minutos); 
                    $minutos = floor($minutos);
                    $horas=$minutos/60;

                    if($horas <= 4){
                        $importe = $horas * 100;
                        $autoSalida=new Auto($value->patente,$value->mail,$value->fechaIngreso,$egreso,$importe);
                        $autoSalida->guardarSalida();
                    }
                    else if($horas > 4 && $horas <= 12){
                        $importe=$horas * 60;
                        $autoSalida=new Auto($value->patente,$value->mail,$value->fechaIngreso,$egreso,$importe);
                        $autoSalida->guardarSalida();
                    }
                    else{
                        $importe=$horas * 30;
                        $autoSalida=new Auto($value->patente,$value->mail,$value->fechaIngreso,$egreso,$importe);
                        $autoSalida->guardarSalida();
                    }
                }
                
            break;
            }
        }
        return $autoSalida;
    }
    public static function datosDeAuto($patente){
        $leer=Datos::LeerJSON_Serializado("Archivos/autosSalida.json");
        foreach($leer as $value){
            if($value->patente==$patente){
                $mensaje->data=$value;
            }
        }
        return $mensaje;
    }
    public static function ConvertirMinuscula($auto)
    {
        $palabra=strtolower($auto);
        return $palabra;
    }
    public static function autoEncontrado($auto){
        $leer=Datos::LeerJSON_Serializado("Archivos/autos.json");

        if($leer!=false){
            foreach($leer as $value){
                if($value==$auto){
                    return $value;
                }
                break;
                
            }
        }
        return $value;
    }

}