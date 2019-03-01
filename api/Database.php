<?php
/**
 * FamePHP
 *
 * Facebook Messenger bot framework
 *
 * @copyright Copyright (c) 2018 - 2019
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
     * @param $host hostname
     * @param $dbname database name
     * @param $username username
     * @param $password password
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
     * Execute SQL query
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
     * Fetch the first row of a query result
     *
     * @return array resultset as associative array
     */
    public function FetchRow() 
    {
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Returns PDO datatype of a variable
     *
     * @param mixed $variable (default = \PDO::PARAM_STR)
     * @return mixed PDO::<data type>
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
     * Insert data into table
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
     * Return the affected rows after query execution
     * @return mixed row count
     */
    public function AffectedRows() {
        return $this->stmt->rowCount();
    }
}
?>
