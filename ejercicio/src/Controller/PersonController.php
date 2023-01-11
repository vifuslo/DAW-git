<?php
namespace Src\Controller;

use Src\TableGateways\PersonGateway;

class PersonController {
    /**
    * @access private
    * @var DatabaseConnector
    */
    private $db;
    /**
    * @access private
    * @var string
    */
    private $requestMethod;
    /**
    * @access private
    * @var int
    */
    private $userId;
    /**
    * @access private
    * @var PersonGateway
    */
    private $personGateway;

    
    /**
    * Constructor de la clase PersonController.php
    * @param $db base de datos donde vamos a conectarnos
    * @param $requestMethod tipo de petición que se va a realizar
    * @param $userId identificador del usuario	
    */
    public function __construct($db, $requestMethod, $userId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;

        $this->personGateway = new PersonGateway($db);
    }
    
    
    
    /**
    * Funcionalidad que se encarga de procesar las peticiones de los usuarios.
    * En función de la petición llama a una función diferente.
    * @example POST llama a createUserFromRequest
    */
    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    $response = $this->getUser($this->userId);
                } else {
                    $response = $this->getAllUsers();
                };
                break;
            case 'POST':
                $response = $this->createUserFromRequest();
                break;
            case 'PUT':
                $response = $this->updateUserFromRequest($this->userId);
                break;
            case 'DELETE':
                $response = $this->deleteUser($this->userId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }
    
    
    /**
    * Funcionalidad que se encarga de obtener todos los usuarios del sistema.
    * Si todo ha ido correcto, inserta el código 200 en la respuesta.
    * Posteriormente transforma estos en json para su devolución.
    * @return Response
    */
    
    private function getAllUsers()
    {
        $result = $this->personGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
    
    /**
    * Funcionalidad que se encarga de obtener un usuario en base a una id proporcionada.
    * Si todo ha ido correcto, inserta el código 200 en la respuesta.
    * Posteriormente transforma estos en json para su devolución.
    * En caso de que no se encuentre el usuario, se lanza una excepción de no encontrado.
    * @param $id int
    * @return Response
    */
    private function getUser($id)
    {
        $result = $this->personGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }


    /**
    * Funcionalidad que se encarga de crear un usuario de una petición http.
    * Previa a la creación, se valida que el usuario es correcto.
    * Si es correcto, se inserta en la base de datos.
    * @param $usuario. No incluido como parámero del método, sino que viene en ei input de la petición.
    * @return Response
    */
    private function createUserFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validatePerson($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->personGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function updateUserFromRequest($id)
    {
        $result = $this->personGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validatePerson($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->personGateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function deleteUser($id)
    {
        $result = $this->personGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->personGateway->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validatePerson($input)
    {
        if (! isset($input['firstname'])) {
            return false;
        }
        if (! isset($input['lastname'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
