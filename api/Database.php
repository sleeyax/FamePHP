<?php
/**
 * FamePHP
 *
 * Facebook Messenger bot
 *
 * @copyright Copyright (c) 2018 - 2018
 * @author Sleeyax (https://github.com/sleeyax)
 * @link https://github.com/sleeyax/FamePHP
 * @license https://github.com/sleeyax/FamePHP/blob/master/LICENSE
 */

namespace Famephp\api;
/**
 * Database connection
 * @package API
 */
class Database {

    /**
     * Database connection
     * @var \PDO $connection
     */
    private $connection;

    /**
     * SQL query prepared statement handle
     * @var PDOStatement $stmt
     */
    private $stmt;

    /**
     * Database constructor.
     * @param $host
     * @param $dbname
     * @param $username
     * @param $password
     */
    public function __construct($host, $dbname, $username, $password) 
    {
        try {
            $this->connection = new \PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        }catch (\PDOException $e) {
            exit("Error!: " . $e->getMessage());
        }
    }

    /**
     * Execute a SQL query
     *
     * @param string $query SQL query
     * @param array $placeholders associative array
     * @return bool true | false on success or failure
     */
    private function ExecuteQuery($query, $placeholders = null)
    {
        $this->stmt = $this->connection->prepare($query);
        if ($placeholders != null) {
            foreach ($placeholders as $key => $value) {
                if (is_array($value)) {
                    $this->stmt->bindValue($key, $value[0], $value[1]);
                }else{
                    $this->stmt->bindValue($key, $value, $this->GetPdoDataType($value));
                }
            }
        }

        return $this->stmt->execute();
    }

    /**
     * Fetches the first row after execution of a query
     *
     * @return array resultset as associative array
     */
    public function FetchRow() 
    {
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Returns the PDO datatype of a given variable
     *
     * @param mixed $variable (default = \PDO::PARAM_STR)
     * @return mixed $datatype
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
     * @return bool true | false on success or failure
     */
    public function Insert($table, $fields, $values) {
        $query = "INSERT INTO $table (" . implode(', ', $fields) . ") VALUES (" . implode(', ', array_keys($values)) . ")";
        return $this->ExecuteQuery($query, $values);
    }

    /**
     * Select data from table
     *
     * @param string $items items to select from table
     * @param string $table table name
     * @param string $conditions SQL 'WHERE' conditions (optional)
     * @param array $placeholders associative array of elements that match $conditions (optional)
     * @return bool true | false on success or failure
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
     * Update table
     *
     * @param string $table table name
     * @param string $newValues set of values to be updated
     * @param string $conditions SQL 'WHERE' conditions (optional)
     * @param array $placeholders associative array of elements that match $conditions (optional)
     * @return bool true | false on success or failure
     */
    public function Update($table, $newValues, $conditions = null, $placeholders = null)
    {
        $query = "UPDATE $table SET $newValues";
        if ($conditions != null) {
            $query .= " WHERE $conditions";
        }
        return $this->ExecuteQuery($query, $placeholders);
    }

    /**
     * Returns the affected rows (callable after query execution)
     * @return mixed $rowCount
     */
    public function AffectedRows() {
        return $this->stmt->rowCount();
    }
}
?>