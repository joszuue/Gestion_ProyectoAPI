<?php
session_start();
header("Content-Type: application/json");

class TareasAsignadasController extends Controller {
    public function __construct(){
        $this->loadModel("TareasAsignadas");
    }
    
    // Endpoint para obtener las tareas asignadas al usuario logueado
    public function obtener(){
        parent::__construct();
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            // Verifica que la sesión esté activa
            if (empty($_SESSION['id'])){
                http_response_code(401);
                echo json_encode([
                    "success" => false,
                    "message" => "No tiene acceso. Inicie sesión."
                ]);
                return;
            }
            $id_usuario = $_SESSION['id'];
            $tareas = $this->model->obtenerTareasPorResponsable($id_usuario);
            echo json_encode([
                "success" => true,
                "tareas" => $tareas
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
