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

class SqliteDriver implements DriverInterface
{

    public function __construct() { }

    /**
     * Execute SQL query
     *
     * @param string $query
     * @param array  $placeholders
     * @return mixed
     */
    public function executeQuery(string $query, array $placeholders = null)
    {
        // TODO: Implement executeQuery() method.
    }

    /**
     * Fetch the first row of a query result
     *
     * @return mixed
     */
    public function fetchRow()
    {
        // TODO: Implement fetchRow() method.
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
        // TODO: Implement insert() method.
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
        // TODO: Implement update() method.
    }

    /** Return the number of affected rows after query execution
     *
     * @return int
     */
    public function countAffectedRows()
    {
        // TODO: Implement countAffectedRows() method.
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
        // TODO: Implement select() method.
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
        // TODO: Implement delete() method.
    }
}
