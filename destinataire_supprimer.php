<?php
    error_log("destinataire_supprimer.php");

    // === requires =============================
    require_once('lib/common.php');
    require_once('lib/mysql.php');
    require_once('lib/page.php');
    require_once('lib/session.php');
    require_once('lib/html.php');
    require_once('lib/errors.php');
    
    // ==========================================
    if($errors->check($page->referer == "destinataire_liste",32768) && $errors->check($session->check(),32768))
    {
        
        $ids = "";
        $arr_sql = [];
        foreach ($_POST['destinataires'] as $value) 
        {
            array_push($arr_sql,"`id`=$value");
        }
        
        $ids = implode(" OR ",$arr_sql);
        
        $db = new DB();
        
        $sql= "UPDATE `destinataires` SET `status`= \"Supprimé\" WHERE $ids;";
        
        $db->sql($sql);

        header("Location: destinataire_liste.php");


    }