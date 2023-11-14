<?php
  

class JoyeriaApiModel {  

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
        $query = $this->db->prepare ('SELECT * FROM joyerias');
        $query->execute();
        $joyas = $query->fetchAll(PDO:: FETCH_OBJ);
        return $joyas;
    }

    
    function get($id) {
        $query = $this->db->prepare('SELECT * FROM joyerias WHERE id = ?');
        $query->execute([$id]);

    
        $tipo = $query->fetchAll(PDO::FETCH_OBJ);

        return $tipo;
    }

    
    function delete($id){
        $query = $this->db->prepare('DELETE FROM joyerias WHERE id = ?');
        $query->execute([$id]);
    }
    

    function insertar($marca, $precio, $bañado,$id_joya){
        $query = $this->db->prepare ('INSERT INTO joyerias (marca, precio, bañado, id_joya) VALUES (?,?,?,?)');
        $query->execute([$marca, $precio, $bañado, $id_joya]);

        return $this->db->lastInsertId();
    }


    function actualizar($marca, $precio, $bañado, $id_joya, $id){
        $query = $this->db->prepare('UPDATE joyerias SET marca = ?, precio = ? , bañado = ? , id_joya = ? WHERE id = ? ');
        $query->execute([$marca,$precio,$bañado,$id_joya,$id]);
    }


    function order($sort = null, $order = null){
        $query = $this->db->prepare("SELECT * FROM joyerias ORDER BY $sort $order");
        $query->execute();
        $joyerias = $query->fetchAll(PDO::FETCH_OBJ);
        return $joyerias;
    }
    

    public function getMarcasFiltradas($parametros){
        $query = $this->db->prepare("SELECT * FROM joyerias WHERE bañado = ?");
        $query->execute([($parametros['bañado'])]);
        $bañado = $query->fetchAll(PDO::FETCH_OBJ);

        return $bañado;
    }
   
}