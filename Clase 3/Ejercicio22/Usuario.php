<?php

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
        $archivo = fopen("./registros.csv", "a");
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

    public static function LeerUsuarios($ruta)
    {
        $archivo = fopen($ruta, "r");
        if ($archivo != null) {
            $datos = array();
            while (!feof($archivo)) {
                $aux = fgets($archivo);
                $lectura = explode(",", $aux);
                $usuario = array("nombre" => $lectura[0], "clave" => $lectura[1], "mail" => $lectura[2]);
                array_push($datos, $usuario);
            }
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
}
