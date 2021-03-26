<?php
namespace core;

use \PDO;

abstract class BaseModel
{
    static $table = 'table';
    static $sql_str = '';

    abstract public function rules();

    public function loadPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = $_POST;
            $fields = get_object_vars($this);
            foreach ($fields as $key => $value) {
                if (isset($data[$key])) {
                    $this->{$key} = $data[$key];
                }
            }
            return true;
        }
        return false;
    }

  
    public function validate()
    {
        $error = false;
        $error_message = '';
        foreach ($this->rules() as $key => $fields) {
            switch ($key) {
                case 'required':
                    foreach ($fields as $field) {
                        if ($this->{$field} == '') {
                            $error_message .= $field . ' is required. <br>'; 
                            $error = true;
                        }
                    }
                    break;
                case 'email':
                    if (!filter_var($this->{$fields[0]}, FILTER_VALIDATE_EMAIL)) {
                        $error_message .= $fields[0] . ' is not correct. <br>'; 
                        $error = true;
                    }
                    break;
                case 'string':
                    if (strlen($this->{$fields[0]}) < 2 || strlen($this->{$fields[0]}) > 25) {
                        $error_message .= $fields[0] . ' too short are too long. Please correct!! <br>'; 
                        $error = true;
                    }
                    if (strlen($this->{$fields[1]}) < 5 ) {
                        $error_message .= $fields[1] . ' too short. Please correct!! <br>'; 
                        $error = true;
                    }
                    if (!preg_match("#[0-9]+#", $this->{$fields[1]})) {
                        $error_message .= $fields[1] . ' must include at least one number!! <br>'; 
                        $error = true;
                    }
                    if (!preg_match("#[a-zA-Z]+#", $this->{$fields[1]})) {
                        $error_message .= $fields[1] . ' must include at least one letter!! <br>';
                    }  
                    break;
                default:
                    $error_message .= $key . ' do not find!!';
                    break;
            }
        }
        if(!isset($_SESSION)) session_start();
        if($error) $_SESSION['error'] = $error_message;
        return !$error;
    }

    public function save()
    {
        $fields = get_object_vars($this);
        $keys = [];
        $values = [];

        foreach ($fields as $key => $value) {
            if ($value || is_bool($value)) {
                $keys[] = $key;
                $values[] = ":$key";
            }
        }
        $conn = ConnectDB::connectDB();
        $table = static::$table;
        $sql_keys = implode(', ', $keys);
        $sql_value = implode(', ', $values);

        $stmt = $conn->prepare("INSERT INTO $table ($sql_keys) VALUES ($sql_value)");
        foreach ($fields as $key => $value) {
            if ($value || is_bool($value)) {
                $stmt->bindParam(":$key", $fields[$key]);
            }
        }
        if ($stmt->execute()) {
            $this->id = $conn->lastInsertId();
            return $this;
        }
        return false;
    }




    //1. find SELECT * FROM table
    //2. where - add fields and value
    //3. All - SELECT*  (array(obj))
    //4. One - виконати і повернути обєкт
    // ['field'=>'value']


    static public function find()
    {
        $obj_name = get_called_class(); //отримуємо назву класу
        $obj = new $obj_name;
        $table = static::$table;
        static::$sql_str = "SELECT* FROM `$table`";
        return $obj;
    }
    
    public function where($params = [])
    {
        if ($params) {
            $sql = [];
            foreach ($params as $key => $value) {
                $value = htmlspecialchars($value);
                $sql[] = "`$key` = '$value'";
            }
            static::$sql_str .= " WHERE " . implode(' AND ', $sql);
        }
        return $this;
    }

    public function one()
    {
        $conn = ConnectDB::connectDB();
        $stmt = $conn->prepare(static::$sql_str);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
        // echo static::$sql_str;
        // die();
    }

    public function all()
    {
        $conn = ConnectDB::connectDB();
        $stmt = $conn->prepare(static::$sql_str);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    static function delete($params = [])
    {
        $conn = ConnectDB::connectDB();
        $table = static::$table;
        $sql_where = [];
        foreach ($params as $key => $value) {
            $sql_where[] = "`$key`='$value'";
        }
        $sql_where[] = implode(' AND ', $sql_where);
        $sql = "DELETE FROM $table WHERE $sql_where";
        $stmt = $conn->prepare($sql);
        return $stmt->execute();
    }
    
    public function update($params = [])
    {
        $conn = ConnectDB::connectDB();
        $table = static::$table;
        $data = get_object_vars($this);

        $values = [];
        foreach ($data as $key => $value) {
            $values[] = "`$key` = :$key";
        }

        $sql_where = [];
        foreach ($params as $key => $value) {
            $sql_where[] = "`$key` = '$value'";
        }

        $sql_where = implode(' AND ', $sql_where);
        $sql_set = implode(', ', $values);
        $sql = "UPDATE `$table` SET $sql_set WHERE $sql_where";
        $stmt = $conn->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindParam(":$key", $data[$key]);
        }
        return $stmt->execute();
    }
}