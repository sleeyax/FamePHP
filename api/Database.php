<?php
namespace Famephp\api;
/**
 * Database connection class
 */

class Database {

    private $connection;
    private $stmt;

    public function __construct($host, $dbname, $username, $password) 
    {
        try {
            $this->connection = new \PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        }catch (\PDOException $e) {
            exit("Error!: " . $e->getMessage());
        }
    }

    /**
     * Executes a query
     *
     * @param string $query
     * @param array $placeholders associative array
     * -> array(':param' => $param)
     * @return void
     */
    private function ExecuteQuery($query, $placeholders = null) 
    {
        $this->stmt = $this->connection->prepare($query);
        if ($placeholders != null) {
            foreach ($placeholders as $key => $value) {
                $this->stmt->bindValue($key, $value, $this->GetPdoDataType($value));
            }
        }

        return $this->stmt->execute();
    }

    /**
     * Fetches the first row after execution of (SELECT) query
     *
     * @return array associative array 
     */
    public function FetchRow() 
    {
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Return the PDO datatype of a given variable
     *
     * @param var $variable
     * @return constant $datatype
     */
    private function GetPdoDataType($variable) 
    {
        $datatype = \PDO::PARAM_STR;
        switch($variable) {
            case is_numeric($variable):
                $datatype = \PDO::PARAM_INT;
                break;
            case is_string($variable):
                $datatype = \PDO::PARAM_STR;
                break;
            case is_bool($variable):
                $datatype = \PDO::PARAM_BOOL;
                break;
            case is_null($variable):
                $datatype = \PDO::PARAM_NULL;
                break;
        }
        return $datatype;
    }

    /**
     * Insert data into a table
     *
     * @param string $table
     * @param array $fields
     * @param array $values
     * -> array(':param' => $param) with '$param' the value & ':param' the placeholder
     * @return boolean true on success, false on failure
     */
    public function Insert($table, $fields, $values) {
        $query = "INSERT INTO $table (" . implode(', ', $fields) . ") VALUES (" . implode(', ', array_keys($values)) . ")";
        return $this->ExecuteQuery($query, $values);
    }

    /**
     * Select data from table
     *
     * @param string $items
     * -> '*', 'Username, Password'
     * @param string $table
     * @param string $conditions
     * -> 'Username=:username, Password=:password'
     * @param array $placeholders
     * -> array(':username' => 'holly', ':password' => 'nitro007')
     * @return boolean
     */
    public function Select($items, $table, $conditions = null, $placeholders = null) 
    {
        $query = "SELECT $items FROM $table";
        if ($conditions != null) {
            $query .= " WHERE $conditions";
        }
        return $this->ExecuteQuery($query, $placeholders);
    }

    /**
     * Update table from db
     *
     * @param string $table
     * @param string $newValues
     * -> Username=:username
     * @param string $conditions
     * -> Id=:id
     * @param array $placeholders
     * -> array(':username' => $user, ':id' => '12')
     * @return boolean
     */
    public function Update($table, $newValues, $conditions = null, $placeholders = null)
    {
        $query = "UPDATE $table SET $newValues";
        if ($conditions != null) {
            $query .= " WHERE $conditions";
        }
        return $this->ExecuteQuery($query, $placeholders);
    }

    public function AffectedRows() {
        return $this->stmt->rowCount();
    }

}
?>