    <?php  
     $ch = curl_init();
     $url= "https://tieba.baidu.com/p/5308027837";
     curl_setopt($ch, CURLOPT_URL,$url);  
     curl_setopt($ch, CURLOPT_HEADER, false);  
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果把这行注释掉的话，就会直接输出  
     $result=curl_exec($ch);  
     curl_close($ch);
$re1 = '/d_post_content j_d_post_content .*?<\/div>/ism';
$re2 = '/\d{1,2}楼<\/span>.*?<\/span>/ism';
preg_match_all($re1, $result, $huitie);
preg_match_all($re2, $result, $tail_info);
foreach ($huitie[0] as $key => $value) {
    $info[$key]["回帖"]=preg_replace("/^d_post_content j_d_post_content.*\">/",' ', $value);
}
foreach ($tail_info[0] as $key => $value) {
    $info[$key]["楼层"]=preg_replace("/<span .*/",'', $value);
    preg_match("/\d{4}-\d{2}-\d{2}.*\d/",$value,$RETURN);
    $info[$key]["时间"]=$RETURN[0];
}
$info=json_encode($info);
return $info;