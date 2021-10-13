<?php
namespace Model;

class ActiveRecord
{
    protected static $db;
    protected static $table = "";
    protected static $columns = [];

    //
    public static function setDB($database)
    {
        self::$db = $database;
    }
    public function insert_id() 
    { 
        return self::$db->insert_id; 
    }
    

    //
    public function save()
    {
        $input = [];
        foreach(static::$columns as $column)
        {
            if($column === "id") continue;
            $input[$column] = self::$db->escape_string($this->$column);
        }
        
        return self::$db->query("INSERT INTO " . static::$table . " (" . join(", ", array_keys($input)) . ") VALUES ('" . join("', '", array_values($input)) . "')");
    }

    public function update()
    {
        $input = [];
        $str = [];
        foreach(static::$columns as $column) 
        {
            if($column === "id") continue;
            $input[$column] = self::$db->escape_string($this->$column);
        }
        foreach($input as $key => $value)
        {
            $str[] = "{$key} = '{$value}'";
        }

        return self::$db->query("UPDATE " . (static::$table) . " SET " . (join(", ", $str)) . " WHERE id = " . ($this->id) . " LIMIT 1");
    }

    public function delete()
    {
        return self::$db->query("DELETE FROM " . (static::$table) . " WHERE id = " . $this->id . " LIMIT 1");
    }


    //
    public static function query($query) // Extrar datos iterando
    {
        $array = [];
        $result = self::$db->query($query); // Consultar a la db
        while($row = $result->fetch_assoc()) 
        {
            $array[$row["id"]] = $row; // Asociar el id al array
        }

        $result->free(); // Liberar memoria
        return $array; // Retornar resultados
    }

    public static function all() // Consultar todos los datos
    {
        return self::query("SELECT * FROM " . static::$table);
    }

    public static function findById($id) // Consultar un dato por su id
    {
        return self::query("SELECT * FROM " . (static::$table) . " WHERE id = ${id}");
    }

    public static function limit($limit) // Consultar un número limitado de datos
    {
        return self::query("SELECT * FROM " . (static::$table) . " LIMIT ${limit}");
    }
}