<?php

error_log("destinataire_formulaire.php");

// === requires =============================
require_once('lib/common.php');
require_once('lib/mysql.php');
require_once('lib/page.php');
require_once('lib/session.php');
require_once('lib/html.php');
require_once('lib/errors.php');

// === Init =================================
$HTML = new HTML("Formulaire - Destinataire");

// ==========================================

$cmd = (isset($_GET['cmd'])) ? $_GET['cmd'] : '';
//print_r([$_POST['destinataires'][0]]);
$db = new DB();

$sql = "SELECT `id`,`titre`,`prenom`,`nom`,`fonction`,`denomination`,`adresse`, `code_postal`, `localite`, `telephone`, `email`, `commentaire` FROM destinataires WHERE id={$_POST['destinataires'][0]};";

// ----------------------------------------------
if($cmd == "ajouter")
{
    $fields = extractFields($sql,"`");

    foreach ($fields as $f) 
    {
        eval("\$$f='';");
    }
}

// ----------------------------------------------
if($cmd == "modifier")
{
   

    $destinataire = $db->sql($sql, "ASSOC")[0];
    eval($db->fieldsToVars());
}

// ----------------------------------------------

$header = new HTML();
    $header->a('','utilisateur.php',$_SESSION['identite'],['title'=>"Mes informations."]);
    $header->space();
    $header->a('','destinataire_liste.php',"Mes destinataires",['title'=>"Liste des destinataires."]);
    $header->space();
    $header->a('','liste.php',"Mes courriers",['title'=>"Liste de mes courriers."]);
    $header->space();
    $header->a('','deconnecter.php','Déconnecter',['title'=>"Déconnecter la session et retourner à la page d'identification."]);
$HTML->header($header->HTML);

//-----------------------------------------------

$HTML->form_('formDestinataire', 'destinataire_formulaire.php','POST',["class"=>"formForm"]);
if ($cmd == "modifier") 
{
    $HTML->fieldInput('id','id',"hidden",$id);
}
$HTML->fieldSelect('titre', 'titre', ["M."=>"Monsieur", "Mme"=>"Madame", "Melle"=>"Mademoiselle"], "",["placeholder"=>"Titre","title"=>"Titre"]);
$HTML->fieldInput('prenom', 'prenom', 'text', $prenom, ["placeholder"=>"Prénom","title"=>"Prénom du destinataire."]);
$HTML->fieldInput('nom', 'nom', 'text', $nom, ["placeholder"=>"Nom","title"=>"Nom du destinataire."]);
$HTML->fieldInput('fonction', 'fonction', 'text', $fonction, ["placeholder"=>"Fonction","title"=>"Fonction du destinataire."]);
$HTML->fieldInput('denomination', 'denomination', 'text', $denomination, ["placeholder"=>"Dénomination","title"=>"Dénomination de l'entreprise."]);
$HTML->fieldInput('adresse', 'adresse', 'text', $adresse, ["placeholder"=>"Adresse","title"=>"Adresse."]);
$HTML->fieldInput('code_postal', 'code_postal', 'text', $code_postal, ["placeholder"=>"Code postal","title"=>"Code postal."]);
$HTML->fieldInput('localite', 'localite', 'text', $localite, ["placeholder"=>"Localité","title"=>"Localité."]);
$HTML->fieldInput('telephone', 'telephone', 'text', $telephone, ["placeholder"=>"Téléphone","title"=>"Numéro de téléphone."]);
$HTML->fieldInput('email', 'email', 'text', $email, ["placeholder"=>"Email","title"=>"Email."]);
$HTML->fieldTextarea('commentaire', 'commentaire', $commentaire, ["placeholder"=>"Commentaire","title"=>"Commentaire."]);

// ----------------------------------------------
if($cmd == "ajouter")
{
    $HTML->submit('', 'Enregistrer',["title" => "Enregistrer votre destinataire.", "formaction"=>"destinataire_ajouter.php"]);
}

// ----------------------------------------------
if($cmd == "modifier")
{
    $HTML->submit('', 'Modifier',["title" =>"Valider pour enregistrer les modifications.", "formaction"=>"destinataire_modifier.php"]);
}

// ----------------------------------------------
$HTML->a('', "{$page->referer}.php", "Retour",["title" => "Retourner à la page de connexion.", "formaction"=>"destinataire_liste.php"]);

$HTML->_form();

$HTML->output();