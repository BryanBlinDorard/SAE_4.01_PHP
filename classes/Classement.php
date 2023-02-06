<?php 
class Classement {
    public $id;
    public $idQuestionnaire;
    public $nomQuestionnaire;

    public function __construct($id, $idQuestionnaire, $nomQuestionnaire) {
        $this->id = $id;
        $this->idQuestionnaire = $idQuestionnaire;
        $this->nomQuestionnaire = $nomQuestionnaire;
    }
}
?>