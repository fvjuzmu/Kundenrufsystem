<?php
namespace FVJUZ\Kundenrufsystem;

use Exception;
use FVJUZ\Kundenrufsystem\Exceptions\FVDBConnectionFailed;
use PDO;
use PDOStatement;

/**
 * Class DatabaseHandler
 *
 * Handles all requests to the Database and does some small work like returning IDs
 *
 * @package FVJUZ\Kundenrufsystem
 */
class DatabaseHandler
{
    /** @var PDO $database */
    private $database;
    private $dbConf;
    private $lastQueries = [];

    /**
     * DatabaseHandler constructor.
     *
     * Establishes a database connection for further work
     */
    public function __construct()
    {
        /** @var Configuration $config */
        global $config;
        $this->dbConf = $config->getDatabaseConfig();
        $this->connectToDB();
    }

    /**
     * Returns the last inserted ID from the DB (mysql: LAST_INSERT_ID())
     */
    public function fetchLastInsertedID()
    {
        $sqlSelect = "SELECT LAST_INSERT_ID() AS LAST_ID;";
        $sqlResult = $this->fetchAllAssoc($sqlSelect);
        return $sqlResult[0]["LAST_ID"];
    }

    /**
     * Execute an prepared database statement
     *
     * @param string $statement  SQL statement
     * @param array  $parameters (optional) If $statement is a prepared statement you have to provide the parameters in an array
     *
     * @return PDOStatement  Returns the result as an PDOStatement object
     * @throws Exception
     */
    public function executeStatement($statement, $parameters = [])
    {
        $this->checkDBConnection();
        if( !$this->database->inTransaction() )
        {
            $this->database->beginTransaction();
        }

        //check if all parameters are set

        $preparedStatement = $this->database->prepare($statement);

        $this->lastQueries[] = str_replace(array_keys($parameters), array_values($parameters), $statement);
        $preparedStatement->execute($parameters);

        return $preparedStatement;
    }

    /**
     * Same as executeStatement but it has an multidimensional parameter array.
     * So the executeStatement method gets called for every parameter array in the parameters array
     * parameter-ception
     *
     * @param       $statement
     * @param array $parameters
     */
    public function executeMultiRowStatement($statement, $parameters = [])
    {
        foreach( $parameters as $parameter )
        {
            $this->executeStatement($statement, $parameter);
        }
    }

    /**
     * Check if the database connection is still alive
     *
     * @throws Exception
     */
    private function checkDBConnection()
    {
        if( !isset($this->database) )
        {
            $this->connectToDB();

            if( !isset($this->database) )
            {
                throw new FVDBConnectionFailed;
            }
        }
    }

    /**
     * Returns the result of an select statement as assoc array
     *
     * @param string $sql        SQL select statement
     * @param array  $parameters (optional) values for the use parameters in the statement
     *
     * @return array
     */
    public function fetchAllAssoc($sql, $parameters = [])
    {
        $result = $this->executeStatement($sql, $parameters);
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    /**
     * returns the result of an select statement as object
     *
     * @param string $sql        SQL select statement
     * @param array  $parameters (optional) values for the use parameters in the statement
     *
     * @return array
     */
    public function fetchAllObject($sql, $parameters = [])
    {
        $result = $this->executeStatement($sql, $parameters);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);

        return $rows;
    }


    /**
     * Connect to the database mentioned in the config/base.conf.php file
     */
    private function connectToDB()
    {
        global $config;

        $dbOptions = [ PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                       PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                       PDO::ATTR_EMULATE_PREPARES   => true ];

        $dbHost = "host=" . $config->getDBHost() . ";";
        $dbName = "dbname=" . $this->dbConf[ "name" ];

        $dbConnectionString = "mysql:" . $dbHost . $dbName;

        $this->database = new PDO($dbConnectionString, $config->getDBUser(), $config->getDBPw(), $dbOptions);
    }

    /**
     * Returns one single value from the database
     *
     * Returns the value one column of the first matching row
     *
     * @param string $column     column to look for
     * @param string $table      table in the opal03 database
     * @param array  $conditions array full of conditions
     *
     * @return null|mixed
     */
    public function fetchSingleValue($column, $table, $conditions)
    {
        $conditionsAndParams = $this->prepareWhereConditionAndParameters($conditions);

        $sqlSelect = "SELECT " . $column . " FROM opal03." . $table . $conditionsAndParams[ "sql" ] . " LIMIT 0,1";

        $sqlResult = $this->executeStatement($sqlSelect, $conditionsAndParams[ "parameters" ]);
        $result = $sqlResult->fetch();

        if( count($result) > 0 )
        {
            return $result[ 0 ];
        }

        return null;
    }

    /**
     * Returns a single row from the database
     *
     * @param string $columns    Columns for the select, separated by coma
     * @param string $table      Table name for the select
     * @param array  $conditions Where condition for the select, [ "column" => "id", "value" => 1, "operator" => "=" ];
     *
     * @return array Returns the result or null if no row was found at all
     */
    public function fetchSingleRow($columns, $table, $conditions)
    {
        global $config;

        $conditionsAndParams = $this->prepareWhereConditionAndParameters($conditions);

        $sqlSelect = "SELECT " . $columns . " FROM ".$config->getDBName()."." . $table . $conditionsAndParams[ "sql" ] . " LIMIT 0,1";

        $sqlResult = $this->executeStatement($sqlSelect, $conditionsAndParams[ "parameters" ]);
        $result = $sqlResult->fetch();

        if( count($result) > 0 )
        {
            return $result;
        }

        return null;
    }

    /**
     * Updates a single value in the database
     *
     * conditions input array example:
     * $contidions = [  "column"   => "some_column_name",
     *                  "value"    => 12345,
     *                  "operator" => ">=" ]
     *
     * @param string $column     column name where to write the new value
     * @param mixed  $value      new value
     * @param string $table      table name of a table in the opal03 database
     * @param array  $conditions where condition
     */
    public function updateSingleValue($column, $value, $table, $conditions)
    {
        $conditionsAndParams = $this->prepareWhereConditionAndParameters($conditions);

        $preparedSetStatement = $this->prepareSetStatementPart($column);


        $parameters = array_merge($conditionsAndParams[ "parameters" ],
            [ $preparedSetStatement[ "paramName" ] => $value ]);

        $sqlUpdate = "UPDATE opal03." . $table .
            " SET " . $preparedSetStatement[ "sql" ] .
            " " . $conditionsAndParams[ "sql" ] .
            " LIMIT 0,1";

        $this->executeStatement($sqlUpdate, $parameters);
    }

    /**
     * Prepares the SET statement part of an sql UPDATE
     *
     * @param string $column columname
     *
     * @return string[]
     */
    private function prepareSetStatementPart($column)
    {
        $paramName = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 8);

        $prepValue[ "sql" ] = $column . " = :" . $paramName;
        $prepValue[ "paramName" ] = $paramName;

        return $prepValue;
    }

    /**
     * Prepares a sql where statement part and a parameter list
     *
     * conditions input array example:
     * $contidions = [  "column"  => "some_column_name",
     *                  "value"   => 12345,
     *                  "operator => ">=" ]
     *
     * @param array $conditions array with conditions [[ column, value, operator],...]
     *
     * @return array
     */
    private function prepareWhereConditionAndParameters($conditions)
    {
        if( !array_key_exists(0, $conditions) )
        {
            $conditionsTmp = $conditions;
            $conditions = [];
            $conditions[] = $conditionsTmp;
        }

        $sqlConditionAndParam[ "sql" ] = "";
        $sqlConditionAndParam[ "parameters" ] = [];
        if( count($conditions) <= 0 )
        {
            return $sqlConditionAndParam;
        }

        foreach( $conditions as $condition )
        {
            $sqlConditionAndParam[ "sqlTMP" ][] = " " . $condition[ "column" ] .
                " " . $condition[ "operator" ] .
                " :" . $condition[ "column" ];

            $sqlConditionAndParam[ "parameters" ] = [ ":" . $condition[ "column" ] => $condition[ "value" ] ];
        }

        $sqlConditionAndParam[ "sql" ] = " WHERE";
        $sqlConditionAndParam[ "sql" ] .= implode(" AND", $sqlConditionAndParam[ "sqlTMP" ]);

        unset($sqlConditionAndParam[ "sqlTMP" ]);

        return $sqlConditionAndParam;
    }

    /**
     * Delete a single row from the database
     *
     * @param string     $table  Table name
     * @param string     $column Column name, mostly the key column for where condition
     * @param string|int $rowID  Value in the column field for where condition
     *
     * @return int  Number of effected rows
     */
    public function deleteSingleRow($table, $column, $rowID)
    {
        $sqlStatement = "DELETE FROM " . $this->dbConf[ 'name' ] . "." . $table . " WHERE " . $column . " = " . $rowID . " LIMIT 1";
        $sqlResult = $this->executeStatement($sqlStatement);
        $this->commitDB();
        return $sqlResult->rowCount();
    }

    /**
     * Commit Suici... uhm.. Database
     */
    public function commitDB()
    {
        $this->database->commit();
    }
}
