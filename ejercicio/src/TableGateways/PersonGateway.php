<?php
namespace Src\TableGateways;

class PersonGateway {

    /**
     * @access private
     * @var DataBaseConnector
     */
    private $db = null;

    /**
     * Constructor de la clase PersonGateway.php
     * @param $db base de datos donde vamos a conectarnos
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Funcionalidad que se encarga de encontrar todos los usuarios de la base de datos.
     * @param $satement utilizada para hacer la peticion a la base de datos de los datos de un usuario.
     * @return Result
     */
    public function findAll()
    {
        $statement = "
            SELECT
                id, firstname, lastname, firstparent_id, secondparent_id
            FROM
                person;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Funcionalidad que se encarga de encontrar un usuario de la base de datos a partir de una ID proporcionada.
     * @param $satement utilizada para hacer la peticion a la base de datos de los datos de un usuario.
     * @param $id int
     * @return Result
     */
    public function find($id)
    {
        $statement = "
            SELECT
                id, firstname, lastname, firstparent_id, secondparent_id
            FROM
                person
            WHERE id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Funcionalidad para insertar nuevos usuarios (filas) en la base de datos.
     * @param $satement utilizada para hacer la peticion a la base de datos.
     * @param $input array  utilizada para asignar los valores a cada atributo.
     * @return número filas añadidas 
     */
    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO person
                (firstname, lastname, firstparent_id, secondparent_id)
            VALUES
                (:firstname, :lastname, :firstparent_id, :secondparent_id);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'firstname' => $input['firstname'],
                'lastname'  => $input['lastname'],
                'firstparent_id' => $input['firstparent_id'] ?? null,
                'secondparent_id' => $input['secondparent_id'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Funcionalidad para actualizar informacion de un usuario (fila) en la base de datos a partir de una ID proporcionada.
     * @param $satement utilizada para hacer la peticion a la base de datos.
     * @param $input array  utilizada para asignar los valores a cada atributo.
     * @param $id int
     * @return número filas actualizadas
     */
    public function update($id, Array $input)
    {
        $statement = "
            UPDATE person
            SET
                firstname = :firstname,
                lastname  = :lastname,
                firstparent_id = :firstparent_id,
                secondparent_id = :secondparent_id
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'firstname' => $input['firstname'],
                'lastname'  => $input['lastname'],
                'firstparent_id' => $input['firstparent_id'] ?? null,
                'secondparent_id' => $input['secondparent_id'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Funcionalidad que se encarga de eliminar un usuario de la base de datos a partir de una ID proporcionada.
     * @param $satement utilizada para hacer la peticion a la base de datos de los datos de un usuario.
     * @param $id int
     * @return número filas eliminadas
     */
    public function delete($id)
    {
        $statement = "
            DELETE FROM person
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}