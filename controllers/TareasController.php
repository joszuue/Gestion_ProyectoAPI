<?php
session_start();
header("Content-Type: application/json");

class TareasController extends Controller {
    public function __construct() {
        parent::__construct();
        // Carga TareasModel (archivo TareasModel.php)
        $this->loadModel("Tareas");
    }

    // Endpoint para crear una nueva tarea
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = json_decode(file_get_contents('php://input'), true);

            // Verifica que vengan los datos mínimos
            if(!isset($data['id_proyecto']) || !isset($data['tarea'])){
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "message" => "Faltan datos (id_proyecto, tarea)"
                ]);
                return;
            }

            // Si no envían 'estado', lo ponemos en 'Pendiente'
            $estado = isset($data['estado']) ? $data['estado'] : 'Pendiente';

            // Llama al modelo
            $idInsertado = $this->model->crearTarea($data['id_proyecto'], $data['tarea'], $estado);

            if($idInsertado) {
                echo json_encode([
                    "success" => true,
                    "message" => "Tarea creada correctamente",
                    "id_tarea" => $idInsertado
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    "success" => false,
                    "message" => "Error al crear tarea"
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
}
?>
