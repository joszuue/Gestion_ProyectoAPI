<?php
    session_start();
    header("Content-Type: application/json");
    class EquipoController extends Controller{
        function __construct(){
        }
 
        function equipos(){
            parent::__construct();            
            if(empty($_SESSION['id'])){
                http_response_code(401); //Unauthorized
                echo json_encode([
                    'success' => false,
                    'message' => 'No tiene acceso.'
                ]);
                return;
            }else{
                $metodo = $_SERVER['REQUEST_METHOD'];
            
                $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'); // Elimina "/" al inicio y al final
                $buscarId = explode('/', $path);
                
                // Si el último valor es un número, lo consideramos como ID
                $id = (!empty($buscarId) && is_numeric(end($buscarId))) ? end($buscarId) : null;
    
                static $executed = false;

                switch($metodo){
                    case 'GET':
                        $this->get($id);
                        break;
                    case 'POST': 
                        $this->insert();
                        break; 
                    case 'PUT':
                        $this->update($id);
                        break;
                    case 'DELETE': 
                        $this->delete($id);
                        break;    
                    default:
                    echo " Metodo no permitido";        
                }
            }
        }

        function get($id){
            global $executed;
            if ($executed) return; // Evita ejecución duplicada.
            $executed = true;
            
            if($id == null){
                $equipos = $this->model->listaEquipos();
            }else{
                $equipos = $this->model->selectEquipo($id);
            }

            
            echo json_encode($equipos);
        }

        function insert() {
            try {
                $data = json_decode(file_get_contents('php://input'), true);
        
                if (empty($data['id_responsable']) || empty($data['nombre'])) {
                    http_response_code(400); // Bad Request
                    echo json_encode([
                        'success' => false,
                        'message' => 'Faltan datos requeridos o están vacíos'
                    ]);
                    return;
                }
        
                $idResponsable = $data['id_responsable'];
                $nombre = $data['nombre'];
                $estado = "Activo";
        
                $insertedId = $this->model->agregarEquipo($idResponsable, $nombre, $estado);
        
                if ($insertedId) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Equipo insertado con éxito',
                        'inserted_id' => $insertedId
                    ]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error al insertar equipo'
                    ]);
                }
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error interno del servidor',
                    'error' => $e->getMessage()
                ]);
            }
        }

        function update($id) {
            global $executed;
            if ($executed) return; // Evita ejecución duplicada.
            $executed = true;

            try {
                $data = json_decode(file_get_contents('php://input'), true);
        
                // Verificar que todos los datos requeridos están presentes y no están vacíos
                if (empty($id) || empty($data['id_responsable']) || empty($data['nombre'])) {
                    http_response_code(400); // Bad Request
                    echo json_encode([
                        'success' => false,
                        'message' => 'Faltan datos requeridos o están vacíos'
                    ]);
                    return;
                }
        
                $idResponsable = $data['id_responsable'];
                $nombre = $data['nombre'];
        
                $updated = $this->model->actualizarEquipo($id, $idResponsable, $nombre);
        
                if ($updated) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Equipo actualizado con exito'
                    ]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error al actualizar equipo'
                    ]);
                }
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error interno del servidor',
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        function delete($id) { 
            global $executed;
            if ($executed) return; // Evita ejecución duplicada.
            $executed = true;
        
            $deleted = $this->model->eliminarEquipo($id, "Eliminado");
        
            if ($deleted) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Equipo eliminado con éxito'
                ]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al eliminar equipo'
                ]);
            }
        }   
    }
?>