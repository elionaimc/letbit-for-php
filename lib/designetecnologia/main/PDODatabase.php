<?php
namespace designetecnologia\main;

use PDO;
use designetecnologia\main\exception\NoLoggedException;

/**
 * Describes an PDO handler class for Letbit Framework
 *
 * For PHP versions 5.4+
 *
 * @category   Framework
 * @author     Elionai Moura <eli.embits@gmail.com>
 * @copyright  2015 Design e Tecnologia by Elionai Moura <http://designetecnologia.com.br>
 * @license    The MIT license <https://opensource.org/licenses/MIT>
 * @version    0.1
 * @link       https://github.com/elionaimc/letbit-for-php
 *
 */
class PDODatabase extends \PDO
{
    private $dsn;
    private $user = DBUSER;
    private $password = DBPASS;

    protected $transactionCounter = 0;

    public $handle = null;
    public static $instance;

    /**
     * Public method for instancing a new conexion OR return a existing one
     * @return PDODatabase
     */
    final public static function getInstance(){
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * If connected return a handle for it, otherwise return false
     * @throws LoggedException
     * @return resource PDODatabase
     */
    public function __construct(){
        try {
            if ($this->handle == null) {
                if (DBPREFIX != '') {
                    $this->dsn = DBPREFIX.':host='.HOST;
                    if (PORT) $this->dsn .= ';port:'.PORT; // Sets a specifc port, if defined
                    $this->dsn .= ';dbname='.DBNAME;
                    $pdoh = parent::__construct($this->dsn,$this->user,$this->password);
                    $this->setAttribute(self::ATTR_ERRMODE, self::ERRMODE_EXCEPTION);
                    $this->handle = $pdoh;
                    if (DBPREFIX == "mysql") {
                        // Sets UTF-8 as default encoding
                        (DBUTF8)? $this->setAttribute(
                                self::MYSQL_ATTR_INIT_COMMAND,
                                'SET NAMES utf8'
                        ) : '';
                        // Prevent the syntax database(.)table when using MySQL databases
                        $this->exec("USE ". DBNAME);
                    } elseif (DBPREFIX == "pgsql" && DBUTF8) {
                        $this->exec("SET NAMES 'UTF8'"); // Sets UTF-8 as default encoding
                    }
                    return $this->handle;
                } else { // Sets SQLITE as default database
                    $this->handle = parent::__construct(
                    'sqlite::memory:',
                    null,
                    null,
                    array(self::ATTR_PERSISTENT => true)
                    );
                    return $this->handle;
                }
            }
        }
        catch (\PDOException $e){
            throw new NoLoggedException($e->getMessage());
            return false;
        }
    }

    /**
     * Close the connection with the database resource
     */
    final function __destruct(){
        $this->handle = null;
    }
    /**
     * (non-PHPdoc)
     * @see PDO::beginTransaction()
     */
    function beginTransaction()
    {
        if(!$this->transactionCounter++)
            return parent::beginTransaction();
            return $this->transactionCounter >= 0;
    }

    /**
     * (non-PHPdoc)
     * @see PDO::commit()
     */
    function commit()
    {
        if(!--$this->transactionCounter)
            return parent::commit();
        return $this->transactionCounter >= 0;
    }

    /**
     *
     * @return boolean
     */
    function rollback()
    {
        if($this->transactionCounter >= 0){
            $this->transactionCounter = 0;
            return parent::rollback();
        }
        $this->transactionCounter = 0;
        return false;
    }
}
