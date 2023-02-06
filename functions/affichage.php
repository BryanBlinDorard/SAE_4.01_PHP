<?php
    function bonneReponse($reponse) {
        echo "<p><span style='color:mediumseagreen'>Vous avez bien répondu à la question</span>, c'était bien : ".$reponse."</p>";
    }

    function mauvaiseReponse($reponse) {
        echo "<p><span style='color:crimson'>Vous avez mal répondu à la question.</span> ". "La bonne réponse était : ".$reponse."</p>";
    }
?>