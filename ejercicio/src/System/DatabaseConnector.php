<?php
namespace Src\System;

class DatabaseConnector {

    /**
     * @access private
     * @var DataBaseConnection
     */
    private $dbConnection = null;

    /**
     * Constructor de la clase DatabaseConnector.php
     */
    public function __construct()
    {
        /**
         * @param $host para indicar la direccion del servidor a la que se conecta.
         */
        $host = getenv('DB_HOST');

        /**
         * @param $port para indicar el puerto a traves del cual se coencta.
         */
        $port = getenv('DB_PORT');

        /**
         * @param $db para indicar el nombre de la base de datos a la que se conecta.
         */
        $db = getenv('DB_DATABASE');

        /**
         * @param $user para indicar el nombre del usuario que se conecta.
         */
        $user = getenv('DB_USERNAME');

        /**
         * @param $pass para indicar la contraseña de dicho usuario.
         */
        $pass = getenv('DB_PASSWORD');

        try {
            $this->dbConnection = new \PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $user,
                $pass
            );
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Funcionalidad que se encarga de realizar la conexión del usuario.
     * @return dbConnection
     */
    public function getConnection()
    {
        return $this->dbConnection;
    }
}