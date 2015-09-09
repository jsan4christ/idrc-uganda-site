<?PHP

    # retrieve id
    $id = $_GET['id'];
    #house details
    $displaySQL = "SELECT fq.*,C.value FROM sionapros_faqs AS fq INNER JOIN sionapros_categories AS C";
    $displaySQL .= " ON fq.category = C.id WHERE fq.id = '$id' ORDER BY C.id,fq.id";
    $result = $db->execute($displaySQL);
    
    $smarty->assign('fq', $result[0]);
    #fetch tpl
    $content = $smarty->fetch("./faqs/faqs.disp_faq.tpl.html");

?>