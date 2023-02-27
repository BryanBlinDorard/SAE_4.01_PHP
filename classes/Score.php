<?php 
    class Score {
        public $id;
        public $scorePersonne;
        public $nomPersonne;

        public function __construct($id, $scorePersonne, $nomPersonne) {
            $this->id = $id;
            $this->scorePersonne = $scorePersonne;
            $this->nomPersonne = $nomPersonne;
        }
    }
?>