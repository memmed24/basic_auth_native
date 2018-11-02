<?php
class database{
    public $db;
    private $sql;
    private $table;
    private $query;
    public function __construct($dbname, $user, $pass)
    {
        try{
            $this->db = new PDO("mysql:host=localhost;dbname=$dbname",$user, $pass);
        }catch(PDOException $e){
            echo $e->getMessage();
            die();
        }
    }
    public function select($table, $WHERE=NULL)    {
        $this->table = $table;
        $this->sql = "SELECT * FROM $table $WHERE";
        if($WHERE != NULL){
            $this->sql = "SELECT * FROM $table WHERE $WHERE";
        }
        return $this;
    }
    public function like($value, $like){
        $this->sql = "SELECT * FROM $this->table WHERE $value LIKE '%$like%'";
        return $this;
    }
    public function insert($table, $columns){
        $val = array();
        $col = array();
        foreach ($columns as $column => $value){
            $val[] = $value;
            $col[] = $column;
        }
        $col = implode(',', $col);
        for($i = 0; $i < count($val); $i++){
            $val[$i] = "'".$val[$i]."'";
        }
        $val = implode(',', $val);
        $this->sql = "INSERT INTO $table ($col) VALUES ($val)";
        return $this;
    }
    public function update($table, $where, $array){
        $val = array();
        $col = array();
        $all = array();
        foreach ($array as $arra => $value){
            $val[] = $value;
            $col[] = $arra;
        }
        for($i = 0; $i < count($val); $i++){
            $val[$i] = "'".$val[$i]."'";
        }
        for($i = 0; $i < count($val); $i++){
            $all[] = "$col[$i] = $val[$i]";
        }
        $all = implode(',',$all);
        $this->sql = "UPDATE $table SET $all WHERE $where";
        return $this;
    }
    public function remove($table, $where){
        $this->sql = "DELETE FROM $table WHERE $where";
        return $this;
    }
    public function get(){
        $this->query = $this->db->prepare($this->sql);
        $this->query->execute();
        return $this->query->fetchAll(PDO::FETCH_ASSOC);
    }
}