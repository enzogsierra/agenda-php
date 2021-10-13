<?php
namespace Model;

class Contacto extends ActiveRecord
{
    public $id;
    public $nombre;
    public $compania;
    public $telefono;
    protected static $table = "contactos";
    protected static $columns = ["id", "nombre", "compania", "telefono"];

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? '';
        $this->nombre = $args["nombre"] ?? '';
        $this->compania = $args["compania"] ?? '';
        $this->telefono = $args["telefono"] ?? '';
    }

    public function verify()
    {
        $errors = [];
        if(!filter_var($this->nombre, FILTER_SANITIZE_STRING)) $errors[] = "Debes insertar un nombre válido";
        if(!filter_var($this->compania, FILTER_SANITIZE_STRING)) $errors[] = "Debes insertar una companía con un nombre válido";
        if(!filter_var($this->telefono, FILTER_VALIDATE_INT)) $errors[] = "El número de teléfono solo debe contener números";
        return $errors;
    }
}