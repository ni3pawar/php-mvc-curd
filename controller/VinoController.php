<?php
class VinoController{

    private $conectar;
    private $conexion;

    public function __construct() {
		require_once  __DIR__ . "/../core/Conectar.php";
        require_once  __DIR__ . "/../model/Vino.php";
        
        $this->conectar=new Conectar();
        $this->conexion=$this->conectar->conexion();

    }

   
    public function run($accion){
        switch($accion)
        { 
            case "index" :
                $this->index();
                break;
            case "nuevo" :
                $this->nuevo();
                break;
            case "alta" :
                $this->crear();
                break;
            case "detalle" :
                $this->detalle();
                break;
            case "actualizar" :
                $this->actualizar();
                break;
            case "borrar" :
                $this->borrar();
                break;
            default:
                $this->index();
                break;
        }
    }

     
    public function detalle(){


        $vino = new Vino($this->conexion);
        $result = $vino ->getById($_GET["id"]);
        
        $this->view("detalleVino",array(
            "vino" => $result,
            "bodega" => $_GET["bodega"],
            "titulo" => "Detalle Vino"
        ));
    }

    public function nuevo(){
        $this->view("nuevoVino",array(
            "bodega" => $_GET["bodega"],
            "titulo" => "Nuevo Vino"
        ));
    }

    public function borrar(){
        
                $vino = new Vino($this->conexion);
                $vino = $vino->deleteById($_GET["id"]);
        
        header("Location: index.php?controller=bodega&action=detalle&id=" . $_GET["bodega"]);
    }
    
   
    public function crear(){
        if(isset($_POST["nombre"])){
            
                        $vino=new Vino($this->conexion);
            $vino->setNombre($_POST["nombre"]);
            $vino->setDescripcion($_POST["descripcion"]);
            $vino->setBodega($_POST["bodega"]);
            $vino->setTipo($_POST["tipo"]);
            $vino->setAno($_POST["ano"]);
            $vino->setAlcohol($_POST["alcohol"]);

            $save = $vino->guardar();
        }
        header("Location:index.php?controller=bodega&action=detalle&id=".$_POST["bodega"]);
    }

   
    public function actualizar(){
        if(isset($_POST["id"])){
            
                        $vino=new Vino($this->conexion);
            $vino->setId($_POST["id"]);
            $vino->setNombre($_POST["nombre"]);
            $vino->setDescripcion($_POST["descripcion"]);
            $vino->setBodega($_POST["bodega"]);
            $vino->setTipo($_POST["tipo"]);
            $vino->setAno($_POST["ano"]);
            $vino->setAlcohol($_POST["alcohol"]);
            $save=$vino->actualizar();
        }
        header("Location:index.php?controller=bodega&action=detalle&id=".$_POST["bodega"]);
    }
    
    
   
    public function view($vista,$datos){
        $data = $datos;  
        require_once  __DIR__ . "/../view/" . $vista . "View.php";

    }

}
?>
