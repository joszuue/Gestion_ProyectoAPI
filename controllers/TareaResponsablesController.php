<?php
session_start();
header("Content-Type: application/json");

class TareaResponsablesController extends Controller {
    public function __construct(){
        // Carga el modelo TareaResponsablesModel.php
        $this->loadModel("TareaResponsables");
    }

    // Endpoint para asignar un responsable a una tarea
    public function asignarResponsable(){
        parent::__construct();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = json_decode(file_get_contents("php://input"), true);
            
            if(!isset($data['id_tarea']) || !isset($data['id_responsable'])){
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "message" => "Faltan datos (id_tarea, id_responsable)"
                ]);
                return;
            }
            
            $resultado = $this->model->asignarResponsable($data['id_tarea'], $data['id_responsable']);
            
            if ($resultado) {
                echo json_encode([
                    "success" => true,
                    "message" => "Responsable asignado correctamente"
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    "success" => false,
                    "message" => "Error al asignar responsable"
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
