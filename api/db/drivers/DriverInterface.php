<?php
/**
 * FamePHP
 *
 * Facebook Messenger bot framework
 *
 * @copyright Copyright (c) 2018 - 2018
 * @author Sleeyax (https://github.com/sleeyax)
 * @link https://github.com/sleeyax/FamePHP
 * @license https://github.com/sleeyax/FamePHP/blob/master/LICENSE
 */

namespace Famephp\api\db;

interface DriverInterface
{
    /**
     * Execute SQL query
     *
     * @param string $query
     * @param array  $placeholders
     * @return mixed
     */
    public function executeQuery(string $query, array $placeholders = null);

    /**
     * Fetch the first row of a query result
     * @return mixed
     */
    public function fetchRow();

    /**
     * Insert data into specified table
     *
     * @param string $table
     * @param array  $fields
     * @param array  $values
     * @return mixed
     */
    public function insert(string $table, array $fields, array $values);

    /**
     * Update table data
     * @param string $table
     * @param array  $values
     * @param string $whereClause
     * @param        $placeholders
     * @return mixed
     */
    public function update(string $table, array $values, string $whereClause, $placeholders);

    /** Return the number of affected rows after query execution
     * @return int
     */
    public function countAffectedRows();

    /**
     * Select data from specified table
     *
     * @param string      $table
     * @param array       $columns
     * @param string|null $whereClause
     * @param array|null  $placeholders
     * @return mixed
     */
    public function select(string $table, array $columns, string $whereClause = null, array $placeholders = null);

    /**
     * Delete row from table
     * @param string $table
     * @param string $whereClause
     * @return mixed
     */
    public function delete(string $table, string $whereClause);
}
