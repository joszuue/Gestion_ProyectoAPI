<?php
session_start();
header("Content-Type: application/json");

class ProyectosAsignadosController extends Controller {
    public function __construct(){
        $this->loadModel("ProyectosAsignados");
    }
    
    // Endpoint para obtener los proyectos asignados al usuario logueado
    public function obtener() {
        parent::__construct();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if(empty($_SESSION['id'])){
                http_response_code(401);
                echo json_encode([
                    "success" => false,
                    "message" => "No tiene acceso. Inicie sesión."
                ]);
                return;
            }
            $id_responsable = $_SESSION['id'];
            $proyectos = $this->model->obtenerProyectosPorResponsable($id_responsable);
            echo json_encode([
                "success" => true,
                "proyectos" => $proyectos
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
