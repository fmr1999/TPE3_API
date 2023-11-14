<?php
  

class accessorysApiModel {  

    private $db;

    function __construct()
    {
        $this->db = $this->connect();
    }

    
    private function connect() {
        $db = new PDO('mysql:host=localhost;' . 'dbname=db_tpe2;charset=utf8', 'root', '');
        return $db;
    }

    function getAll(){
        $query = $this->db->prepare ('SELECT * FROM tipo_joya');
        $query->execute();
        $tipos = $query->fetchAll(PDO:: FETCH_OBJ);
        return $tipos;
    }


    function get($id){
        $query = $this->db->prepare ('SELECT * FROM tipo_joya WHERE id = ?' );
        $query->execute([$id]);
        $tipo = $query->fetch(PDO:: FETCH_OBJ);
        return $tipo;
    }

    
    function delete($id){
        $query = $this->db->prepare('DELETE FROM tipo_joya WHERE id = ?');
        $query->execute([$id]);
    }

    function insertar($id_joya){
        $query = $this->db->prepare ('INSERT INTO tipo_joya (id_joya) VALUES (?)');
        $query->execute([$id_joya]);

        return $this->db->lastInsertId();
    }


    function actualizar($id_joya,$id){
        $query = $this->db->prepare('UPDATE tipo_joya SET id_joya = ? WHERE id = ? ');
        $query->execute([$id_joya,$id]);
    }


    function order($sort = null, $order = null){
        $query = $this->db->prepare("SELECT * FROM tipo_joya ORDER BY $sort $order");
        $query->execute();
        $joya = $query->fetchAll(PDO::FETCH_OBJ);
        return $joya;
    }


    public function getAccessorysFiltradas($parametros){
        $query = $this->db->prepare("SELECT * FROM tipo_joya WHERE id_joya = ?");
        $query->execute([($parametros['id_joya'])]);
        $accessorys = $query->fetchAll(PDO::FETCH_OBJ);

        return $accessorys;
    }
}