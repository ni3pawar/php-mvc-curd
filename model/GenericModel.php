<?php
class GenericModel {
	protected $table = "";
    protected $conexion;
    protected $id;

    public function __construct($conexion) {
		$this->conexion = $conexion;
        
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getAll(){

        $consulta = $this->conexion->prepare("SELECT * FROM " . $this->table);
        $consulta->execute();
        
        $resultados = $consulta->fetchAll();
        $this->conexion = null;         return $resultados;

    }
    
    
    public function getById($id){
        $consulta = $this->conexion->prepare("SELECT * 
                                                FROM " . $this->table . "  WHERE id = :id");
        $consulta->execute(array(
            "id" => $id
        ));
        
        $resultado = $consulta->fetchObject();
        $this->conexion = null;         return $resultado;
    }
    
    public function getByColumn($column,$value){
        $consulta = $this->conexion->prepare("SELECT * 
                                                FROM " . $this->table . " WHERE " . $column . " = :value");
        $consulta->execute(array(
            "value" => $value
        ));
        $resultados = $consulta->fetchAll();
        $this->conexion = null;         return $resultados;
    }
    
    public function deleteById($id){
        try {
            $consulta = $this->conexion->prepare("DELETE FROM " . $this->table . " WHERE id = :id");
            $consulta->execute(array(
                "id" => $id
            ));
            $conexion = null;
        } catch (Exception $e) {
            echo 'Falló el DELETE (deleteById): ' . $e->getMessage();
            return -1;
        }
    }
    
    public function deleteByColumn($column,$value){
        try {
            $consulta = $this->conexion->prepare("DELETE FROM " . $this->table . " WHERE :column = :value");
            $consulta->execute(array(
                "column" => $value,
                "value" => $value,
            ));
            $conexion = null;
        } catch (Exception $e) {
            echo 'Falló el DELETE (deleteBy): ' . $e->getMessage();
            return -1;
        }
    }
}
?>