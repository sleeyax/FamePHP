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

namespace Famephp\api\db\drivers;
use Famephp\api\ConfigReader;

class MysqlPdoDriver implements DriverInterface
{

    /**
     * Database connection
     * @var \PDO $connection
     */
    private $connection;

    /**
     * SQL query prepared statement handle
     * @var \PDOStatement $stmt
     */
    private $stmt;

    public function __construct(array $settings = null)
    {
        if ($settings == null) {
            $config = ConfigReader::getInstance();
            $settings = $config->getDatabaseSettings()['drivers']['mysql_pdo'];
        }

        try {
            $this->connection = new \PDO(sprintf("mysql:host=%s;dbname=%s", $settings['host'], $settings['dbname']), $settings['username'], $settings['password']);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch (\PDOException $e) {
            exit("Error!: " . $e->getMessage());
        }
    }

    /**
     * Execute SQL query
     *
     * @param string $query
     * @param array  $placeholders
     * @return bool
     */
    public function executeQuery(string $query, array $placeholders = null)
    {
        $this->stmt = $this->connection->prepare($query);
        if ($placeholders != null) {
            foreach ($placeholders as $key => $value) {
                if (is_array($value)) {
                    $this->stmt->bindValue($key, $value[0], $value[1]);
                }else{
                    $this->stmt->bindValue($key, $value);
                }
            }
        }

        return $this->stmt->execute();
    }

    /**
     * Fetch the first row of a query result
     *
     * @return mixed
     */
    public function fetchRow()
    {
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Insert data into specified table
     *
     * @param string $table
     * @param array  $fields
     * @param array  $values
     * @return mixed
     */
    public function insert(string $table, array $fields, array $values)
    {
        $query = "INSERT INTO $table (" . implode(', ', $fields) . ") VALUES (" . implode(', ', array_keys($values)) . ")";
        return $this->executeQuery($query, $values);
    }

    /**
     * Update table data
     *
     * @param string $table
     * @param string $values
     * @param string $whereClause
     * @param        $placeholders
     * @return mixed
     */
    public function update(string $table, string $values, string $whereClause, $placeholders)
    {
        $query = "UPDATE $table SET $values";
        if ($whereClause != null) {
            $query .= " WHERE $whereClause";
        }
        return $this->executeQuery($query, $placeholders);
    }

    /** Return the number of affected rows after query execution
     *
     * @return int
     */
    public function countAffectedRows()
    {
        return $this->stmt->rowCount();
    }

    /**
     * Select data from specified table
     *
     * @param string      $table
     * @param array       $columns
     * @param string|null $whereClause
     * @param array|null  $placeholders
     * @return mixed
     */
    public function select(string $table, array $columns, string $whereClause = null, array $placeholders = null)
    {
        $query = "SELECT " . implode(',', $columns) . " FROM $table";
        if ($whereClause != null) {
            $query .= " WHERE $whereClause";
        }
        return $this->executeQuery($query, $placeholders);
    }

    /**
     * Select all from specified table
     * @param string $table
     * @return mixed
     */
    public function selectAll(string $table)
    {
        $this->executeQuery("SELECT * FROM $table");
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Delete row from table
     *
     * @param string $table
     * @param string $whereClause
     * @return mixed
     */
    public function delete(string $table, string $whereClause)
    {
        $query = "DELETE FROM $table WHERE $whereClause";
        return $this->executeQuery($query);
}}
