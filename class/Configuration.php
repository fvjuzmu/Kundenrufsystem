<?php
namespace FVJUZ\Kundenrufsystem;

/**
 * Class Configuration
 *
 * Holds all information and configurations needed during runtime to operate correctly
 *
 * @package FVJUZ\Kundenrufsystem
 */
class Configuration
{
    private static $instance = null;

    private $database;
    private $base;
    private $databaseAssist;

    /**
     * Confgiuration constructor.
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function __construct()
    {
        require __ROOT__ . "config/base.conf.php";
        require __ROOT__ . "config/db.conf.php";

        if( !empty($configBase) )
        {
            $this->base = $configBase;
        }

        if( !empty($configDB) )
        {
            $this->database = $configDB[ 'servers' ][ $this->getDBConfigName() ];
            $this->databaseAssist = $configDB[ 'assist' ];
        }
    }

    /**
     * Returns a static object of the class FVJUZ\Kundenrufsystem\Configuration
     *
     * @return null|Configuration
     */
    public static function getInstance()
    {
        //TODO get rid of static instance
        if( null === self::$instance )
        {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Returns database username
     *
     * @return string
     */
    public function getDBUser()
    {
        return $this->database[ 'user' ];
    }

    /**
     * Returns database password
     *
     * @return string
     */
    public function getDBPw()
    {
        return $this->database[ 'password' ];
    }

    /**
     * Returns databse host
     *
     * @return string
     */
    public function getDBHost()
    {
        return $this->database[ 'host' ];
    }

    /**
     * Returns database Name
     *
     * @return string
     */
    public function getDBName()
    {
        return $this->database[ 'name' ];
    }

    /**
     * Returns database config name (for debug use only)
     *
     * Due to the fact that the config/db.conf.php file can hold more then one database configuration,
     * we return the name of the used configuration
     *
     * @return string
     */
    public function getDBConfigName()
    {
        return $this->base[ 'dbConfig' ];
    }

    /**
     * Returns the table prefix for database tables
     *
     * @return string
     */
    public function getDBTablePrefix()
    {
        return $this->databaseAssist[ 'tablePrefix' ];
    }

    /**
     * Returns the complete database configurations from the config files
     *
     * @return array
     */
    public function getDatabaseConfig()
    {
        return array_merge($this->database, $this->databaseAssist);
    }
}
