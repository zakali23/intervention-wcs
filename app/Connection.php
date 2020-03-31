<?php

/**
 * Database connection
 *
 */

namespace App;

use \PDO;


/**
 *class PDO connection
 */
class Connection
{
    /**
     * @var PDO
     *
     * @access private
     */
    private $pdoConnection;

    /**
     * Initialize connection
     *
     * @access public
     */
    public function __construct()
    {

        try {
            $this->pdoConnection = new PDO(
                'mysql:host=' . getenv('APP_DB_HOST') . '; dbname=' . getenv('APP_DB_NAME') . '; charset=utf8',
                getenv('APP_DB_USER'),
                getenv('APP_DB_PWD')
            );

            $this->pdoConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_CLASS);

            // show errors in DEV environment
            if (getenv('APP_DEV')) {
                $this->pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (\PDOException $e) {
            die('<div class="error">Error !: ' . $e->getMessage() . '</div>');
        }
    }


    /**
     * @return $pdo
     */
    public function getPdoConnection(): PDO
    {
        return $this->pdoConnection;
    }
}
