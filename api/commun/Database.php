<?php

abstract class Database
{
    private $username = '';
    private $dataBase = '';
    private $host = '';
    private $password = '';

    /**
     * Database constructor.
     */
    public function __construct()
    {
    }

    private function connection(){
        $co = new mysqli($this->host,$this->username,$this->password,$this->dataBase);
        if ($co->connect_error){
            throw new Exception('error connection mysql');
        } else {
            $co->set_charset('utf8');
            return $co;
        }
    }


    protected function insert($request){
        $database = $this->connection();
        if (!$database->query($request)){
            throw new Exception($database->error);
        }
        $last_id = $database->insert_id;
        $database->close();
        return $last_id;
    }

    protected function select($request){
        $database = $this->connection();
        $result = $database->query($request);
        $database->close();

        if ($result->num_rows > 0 ){
            return $result;
        }else {
            return null;
        }
    }

}