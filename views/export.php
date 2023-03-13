<?php
    require_once('../functions/fonctions.php');

    // récupère l'id du questionnaire
    $idQ = $_POST['questionnaire'];

    // récupérer les infos du questionnaire
    $questionnaire = getQuestionnaire($idQ);

    // récupérer les questions du questionnaire
    $questions = getQuestions($idQ);

    // récupérer les réponses des questions
    $reponsesQ = array();
    foreach ($questions as $question) {
        $id = $question->getID();
        $reponsesQ[$id] = getReponseQuestion($id);
    }

    echo "<pre>";
    print_r($reponsesQ);
    echo "</pre>";

    // créer le fichier json
    $json = array();
    $json['nom'] = $questionnaire['nom'];
    $json['questions'] = array();

    // remplir le fichier json
    foreach ($questions as $question) {
        $numero = $question->getNumero();
        $id = $question->getID();
        $json['questions'][$numero] = array();
        $json['questions'][$numero]['question'] = $question->getQuestion();
        $json['questions'][$numero]['type'] = $question->getTypeQuestion();
        $json['questions'][$numero]['valeur'] = $question->getValeurQuestion();
        $json['questions'][$numero]['reponses'] = array();

        // remplir les réponses
        foreach ($reponsesQ[$id] as $reponse) {
            $json['questions'][$numero]['reponses'][] = array("reponseTexte" => $reponse['reponse'], "estBonne" => $reponse['estBonne']);
        }
    }

    // Conversion en JSON
    $json = json_encode($json,JSON_UNESCAPED_UNICODE);

    // Écriture du JSON dans un fichier
    file_put_contents('../exports/'.$questionnaire['nom'].'.json', $json);

    // Le chemin absolu vers le fichier à télécharger
    $file_path = '../exports/'.$questionnaire['nom'].'.json';

    // Vérifier que le fichier existe
    if (file_exists($file_path)) {

        // définir les en-têtes HTTP pour le téléchargement
        header('Content-Description: File Transfer');
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
            
        // Lire le contenu du fichier et le renvoyer au navigateur
        readfile($file_path);

        // Arrêter l'exécution du script pour éviter d'envoyer d'autres données
        exit;
    }

    // Redirection vers la page d'administration
    header('Location: importExport.php');
?>