<?php
class BodegaController{

    private $conectar;
    private $conexion;

    public function __construct() {
		require_once  __DIR__ . "/../core/Conectar.php";
        require_once  __DIR__ . "/../model/Bodega.php";
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
            case "nueva" :
                $this->nueva();
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
    
    
    public function index(){
        
                $bodega=new Bodega($this->conexion);
        
                $bodegas=$bodega->getAll();
       
                $this->view("index",array(
            "bodegas"=>$bodegas,
            "titulo" => "PHP MVC - Gestión de Bodegas"
        ));
    }

     
    public function detalle(){
        
                $bodega= new Bodega($this->conexion);
                $bodega = $bodega->getById($_GET["id"]);
        
        $vino = new Vino($this->conexion);
        $vinos = $vino->getAllByBodega($_GET["id"]);

        $this->view("detalleBodega",array(
            "bodega" => $bodega,
            "vinos" => $vinos,
            "titulo" => "Detalle Bodega"
        ));
    }

    public function nueva(){
        $this->view("nuevaBodega",array(
            "titulo" => "Nueva Bodega"
        ));
    }

    public function borrar(){
        
                $bodega=new Bodega($this->conexion);
                $bodega = $bodega->deleteById($_GET["id"]);
        
        $this->run("index");
    }
    
   
    public function crear(){
        if(isset($_POST["nombre"])){
            
                        $bodega=new Bodega($this->conexion);
            $bodega->setNombre($_POST["nombre"]);
            $bodega->setDireccion($_POST["direccion"]);
            $bodega->setEmail($_POST["email"]);
            $bodega->setTelefono($_POST["telefono"]);
            $bodega->setContacto($_POST["contacto"]);
            $bodega->setFecha($_POST["fecha"]);
            $bodega->setRestaurante($_POST["restaurante"]);
            $bodega->setHotel($_POST["hotel"]);
            $save=$bodega->guardar();
        }
        $this->run("index");
    }

   
    public function actualizar(){
        if(isset($_POST["id"])){
            
                        $bodega=new Bodega($this->conexion);
            $bodega->setId($_POST["id"]);
            $bodega->setNombre($_POST["nombre"]);
            $bodega->setDireccion($_POST["direccion"]);
            $bodega->setEmail($_POST["email"]);
            $bodega->setTelefono($_POST["telefono"]);
            $bodega->setContacto($_POST["contacto"]);
            $bodega->setFecha($_POST["fecha"]);
            $bodega->setRestaurante($_POST["restaurante"]);
            $bodega->setHotel($_POST["hotel"]);
            $save=$bodega->actualizar();
        }
        header("Location: index.php?controller=bodega&action=detalle&id=" . $_POST["id"]);
    }
    
    
   
    public function view($vista,$datos){
        $data = $datos;  
        require_once  __DIR__ . "/../view/" . $vista . "View.php";

    }

}
?>
