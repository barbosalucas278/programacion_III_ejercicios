<?php

define("RUTA", "./registros.csv");
define("CANTIDAD_ATRIBUTOS", 3);
class Usuario
{
    private $_Nombre;
    private $_Clave;
    private $_Mail;
    public function __construct($nombre, $clave, $mail)
    {
        $this->_Nombre = $nombre;
        $this->_Clave = $clave;
        $this->_Mail = $mail;
    }

    private function ToCvs()
    {
        $datos = "$this->_Nombre,$this->_Clave,$this->_Mail\n";
        return $datos;
    }

    public function GuardarUsuario()
    {
        $ret = false;
        $archivo = fopen(RUTA, "a");
        if ($archivo != null) {
            $datos = $this->ToCvs();
            if (fwrite($archivo, $datos,)) {
                if (fclose($archivo)) {
                    return $ret = true;
                }
            }
            return $ret;
        }
        return $ret;
    }

    public static function LeerUsuarios($ruta = RUTA)
    {
        $archivo = fopen($ruta, "r");
        if ($archivo != null) {
            $datos = array();
            while (!feof($archivo)) {
                $aux = fgets($archivo);
                $lectura = explode(",", $aux);
                if (count($lectura) == CANTIDAD_ATRIBUTOS) {
                    $usuario = array("nombre" => $lectura[0], "clave" => $lectura[1], "mail" => $lectura[2]);
                    array_push($datos, $usuario);
                }
            }
            fclose($archivo);
            return $datos;
        }
        return false;
    }

    public static function ListarUsuarios($listado)
    {
        $salida = "";
        foreach ($listado as $usuario) {
            foreach ($usuario as $key => $value) {
                $salida .= $key . " " . $value . "</br>";
            }
            $salida .= "</br>";
        }
        return $salida;
    }

    public static function Login($datos)
    {
        $respuesta = 0;
        $usuarios = Usuario::LeerUsuarios();
        if (!is_null($usuarios)) {
            foreach ($usuarios as $usuario) {
                if ($usuario["mail"] == $datos["mail"]) {
                    if ($usuario["clave"] == $datos["clave"]) {
                        $respuesta = 1;
                        return $respuesta;
                    } else {
                        $respuesta = -1;
                        break;
                    }
                }
            }
        }
        return $respuesta;
    }
}
