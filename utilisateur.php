<?php
error_log("utilisateur.php");

// === requires =============================
require_once('lib/mysql.php');
require_once('lib/page.php');
require_once('lib/session.php');
require_once('lib/html.php');
require_once('lib/errors.php');

// === Init =================================
$HTML = new HTML("Courriers - Connexion");

// ==========================================

if ($errors->check(($page->referer == "index" || $page->referer == "liste" || $page->referer == "destinataire_liste" || $page->referer == "destinataire_formulaire" || $page->referer == "formulaire" ), 32768))
{
    $db = new DB();

    $utilisateur = $db->sql("SELECT titre,nom,prenom,telephone,email,adresse,code_postal,localite,identifiant FROM utilisateurs WHERE id={$_SESSION['uid']};");

    $titre          = $utilisateur[0][0];
    $nom            = $utilisateur[0][1];
    $prenom         = $utilisateur[0][2];
    $telephone      = $utilisateur[0][3];
    $email          = $utilisateur[0][4];
    $adresse        = htmlentities($utilisateur[0][5]);
    $code_postal    = $utilisateur[0][6];
    $localite       = $utilisateur[0][7];
    $identifiant    = $utilisateur[0][8];

    // --------------------------------------
    if (($page->referer == 'index'|| $page->referer == "liste" || $page->referer == "destinataire_liste") && ($errors->check($session->check(), 32768))) {
        $header = new HTML();
            $header->a('','utilisateur.php',$_SESSION['identite'],['title'=>"Mes informations."]);
            $header->space();
            $header->a('','destinataire_liste.php',"Mes destinataires",['title'=>"Liste des destinataires."]);
            $header->space();
            $header->a('','liste.php',"Mes courriers",['title'=>"Liste de mes courriers."]);
            $header->space();
            $header->a('','deconnecter.php','Déconnecter',['title'=>"Déconnecter la session et retourner à la page d'identification."]);
        $HTML->header($header->HTML);
    }
    // --------------------------------------
    $HTML->form_('formUtilisateur', 'connecter.php');

    $HTML->fieldSelect('titre', 'titre', ["Mme"=>"Madame", "Melle"=>"Mademoiselle", "M."=>"Monsieur"], $titre,["placeholder"=>"Titre"]);
    $HTML->fieldInput('prenom', 'prenom', 'text', $prenom, ["placeholder"=>"Prénom","title"=>"Votre prénom."]);
    $HTML->fieldInput('nom', 'nom', 'text', $nom, ["placeholder"=>"NOM","title"=>"Votre NOM de famille."]);
    $HTML->fieldInput('telephone', 'telephone', 'text', $telephone, ["placeholder"=>"Téléphone","title"=>"Votre numéro de téléphone."]);
    $HTML->fieldInput('email', 'email', 'text', $email, ["placeholder"=>"E-mail","title"=>"Votre adresse électronique."]);
    $HTML->fieldTextarea('adresse', 'adresse', $adresse, [ "placeholder" => "Adresse", "title"=>'Votre adresse postale.'] );
    $HTML->fieldInput('code_postal', 'code_postal', 'text', $code_postal, ["placeholder"=>"Code postal","title"=>"Le code postal de votre commune."]);
    $HTML->fieldInput('localite', 'localite', 'text', $localite, ["placeholder"=>"Localité","title"=>"Le nom de votre localité."]);
    $HTML->fieldInput('identifiant', 'identifiant', 'text', $identifiant, ["placeholder"=>"Identifiant","title"=>"Votre identifiant de connexion."]);
    $HTML->fieldInput('mot_de_passe ', 'mot_de_passe', 'password', '', ["placeholder"=>"Mot de passe actuel","title"=>"Votre mot de passe actuel."]);
    $HTML->fieldInput('nouveau_mot_de_passe  ', 'nouveau_mot_de_passe', 'password', '', ["placeholder"=>"Nouveau mot de passe","title"=>"Votre nouveau mot de passe."]);
    $HTML->fieldInput('confirmation_mot_de_passe ', 'confirmation_mot_de_passe', 'password', '', ["placeholder"=>"Confirmation mot de passe","title"=>"Confirmez votre nouveau mot de passe."]);

    if (($page->referer == 'liste') && ($errors->check($session->check(), 32768))) {
        $HTML->submit('', 'Valider', ["title"=>"Valider vos informations pour les modifier."]);
        $HTML->a('', "{$page->referer}.php", "Retour", ["title"=>"Retourner à la page de connexion."]);
        $HTML->_form();
        $HTML->output();
    } 
    else 
    {
        $HTML->submit('', 'Valider', "Valider vos informations pour vous inscrire.");
        $HTML->a('', "{$page->referer}.php", "Retour", "Retourner à la page de connexion.");
        $HTML->_form();
        $HTML->output();
    }
}
