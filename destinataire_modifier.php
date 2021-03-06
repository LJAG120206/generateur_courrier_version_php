<?php
    error_log("destinataire_modifier.php");

    // === requires =============================
    require_once('lib/common.php');
    require_once('lib/mysql.php');
    require_once('lib/page.php');
    require_once('lib/session.php');
    require_once('lib/html.php');
    require_once('lib/errors.php');
    
    // ==========================================
    if($errors->check($page->referer == "destinataire_formulaire",32768) && $errors->check($session->check(),32768))
    {
        eval(arrayToVars($_POST));  
        
        $db = new DB();
        $set= $db->arrayToSql($_POST);
        //var_dump($set);
        $sql= "UPDATE `destinataires` SET $set WHERE `id`={$id} ;";
        
        //var_dump($sql);
        $db->sql($sql);

        header("Location: destinataire_liste.php");
    }
