<?php
session_start();
header("Content-Type: application/json");

class TareasProgresoController extends Controller {
    public function __construct(){
        $this->loadModel("TareasProgreso");
    }
    
    // Endpoint para registrar el progreso de una tarea
    public function registrar(){
        parent::__construct();
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['id_tarea']) || !isset($data['comentario']) ||
                !isset($data['last_estado']) || !isset($data['new_estado'])) {
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "message" => "Faltan datos (id_tarea, comentario, last_estado, new_estado)"
                ]);
                return;
            }
            $resultado = $this->model->registrarProgreso(
                $data['id_tarea'],
                $data['comentario'],
                $data['last_estado'],
                $data['new_estado']
            );
            if ($resultado){
                echo json_encode([
                    "success" => true,
                    "message" => "Progreso registrado correctamente"
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    "success" => false,
                    "message" => "Error al registrar progreso"
                ]);
            }
        } else {
            http_response_code(405);
            echo json_encode([
                "success" => false,
                "message" => "Método no permitido"
            ]);
        }
    }
    
    // Endpoint para actualizar el progreso de una tarea
    public function actualizar(){
        parent::__construct();
        if ($_SERVER['REQUEST_METHOD'] === 'PUT'){
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['id']) || !isset($data['comentario']) ||
                !isset($data['last_estado']) || !isset($data['new_estado'])) {
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "message" => "Faltan datos (id, comentario, last_estado, new_estado)"
                ]);
                return;
            }
            $resultado = $this->model->actualizarProgreso(
                $data['id'],
                $data['comentario'],
                $data['last_estado'],
                $data['new_estado']
            );
            if($resultado){
                echo json_encode([
                    "success" => true,
                    "message" => "Progreso actualizado correctamente"
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    "success" => false,
                    "message" => "Error al actualizar el progreso"
                ]);
            }
        } else {
            http_response_code(405);
            echo json_encode([
                "success" => false,
                "message" => "Método no permitido"
            ]);
        }
    }
    
    // Endpoint para obtener el progreso de una tarea
    public function obtener() {
        parent::__construct();
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            if(!isset($_GET['id_tarea'])){
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "message" => "Falta el parámetro id_tarea"
                ]);
                return;
            }
            $id_tarea = $_GET['id_tarea'];
            $progreso = $this->model->obtenerProgreso($id_tarea);
            echo json_encode([
                "success" => true,
                "progreso" => $progreso
            ]);
        } else {
            http_response_code(405);
            echo json_encode([
                "success" => false,
                "message" => "Método no permitido"
            ]);
        }
    }
}
?>
