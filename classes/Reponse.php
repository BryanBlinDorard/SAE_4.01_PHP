<?php 
class Reponse {
    public $id;
    public $reponse;

    public function __construct($id, $reponse){
        $this->id = $id;
        $this->reponse = $reponse;
    }

    public function getId(){
        return $this->id;
    }

    public function getReponse(){
        return $this->reponse;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setReponse($reponse){
        $this->reponse = $reponse;
    }

}
