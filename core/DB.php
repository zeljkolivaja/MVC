<?php

class DB
{
    private static $_instance = null;

    private $_pdo, $_query, $_error = false, $_result, $_count = 0, $_lastInsertId = null;

    private function __construct()
    {
        try {
            $this->_pdo = new PDO('mysql:host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function query($sql, $params = [])
    {
        $this->_error = false;
        if ($this->_query =  $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if ($this->_query->execute()) {
                $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
                $this->_lastInsertId = $this->_pdo->lastInsertId();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }


    public function insert($table, $fields = [])
    {
        $fieldString = '';
        $valueString = '';
        $values = [];

        foreach ($fields as $field => $value) {
            $fieldString .= '`' . $field . '`,';
            $valueString .= '?,';
            $values[] = $value;
        }

        $fieldString = rtrim($fieldString, ",");
        $valueString = rtrim($valueString, ",");


        $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";


        if (!$this->query($sql, $values)->error()) {
            return true;
        } else {
            return false;
        }
    }

    public function update($table, $id, $fields = [])
    {
        $fieldString = '';
        $values = [];

        foreach ($fields as $field => $value) {
            $fieldString .= ' ' . $field . ' =?,';
            $values[] = $value;
        }

        $fieldString = trim($fieldString);
        $fieldString = rtrim($fieldString, ",");
        $sql = "UPDATE {$table} SET {$fieldString} WHERE id= {$id}";


        if (!$this->query($sql, $values)->error()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($table, $id)
    {
        $sql = "DELETE from {$table} WHERE id={$id}";


        if (!$this->query($sql)->error()) {
            return true;
        } else {
            return false;
        }
    }

    public function result()
    {
        return $this->_result;
    }

    public function first()
    {
        // ako _result nije prazan vrati nam prvi rezultat querya , ako je prazan vrati prazan array
        return (!empty($this->_result)) ?  $this->_result[0] : [];
    }


    public function count()
    {
        return $this->_count;
    }


    public function lastID()
    {
        return $this->_lastInsertId;
    }

    public function get_columns($table)
    {
        return $this->query("SHOW COLUMNS FROM {$table}")->result();
    }

    public function error()
    {
        return $this->_error;
    }
}
