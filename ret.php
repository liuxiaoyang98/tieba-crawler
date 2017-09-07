    <?php  
     $ch = curl_init();
     $url= "https://tieba.baidu.com/p/".$_GET[id];
     curl_setopt($ch, CURLOPT_URL,$url);  
     curl_setopt($ch, CURLOPT_HEADER, false);  
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果把这行注释掉的话，就会直接输出  
     $result=curl_exec($ch);  
     curl_close($ch);
$re1 = '/d_post_content j_d_post_content .*?<\/div>/ism';
$re2 = '/\d{1,8}楼<\/span>.*?<\/span>/ism';
$re3 = '/class="p_author_name.*?<\/a>/ism';
$re4 = '/<li class="l_reply_num".*?<\/li>/ism';
preg_match_all($re1, $result, $huitie);
preg_match_all($re2, $result, $tail_info);
preg_match_all($re3, $result, $author);
preg_match_all($re4, $result, $high);



foreach ($author[0] as $key => $value) {
    $info[$key]["作者"]=preg_replace('/class="p_author_name.*?>/','',$value);
    $info[$key]["作者"]=preg_replace("/<\/a>/",'',$info[$key]["作者"]);
}
preg_match("/red\">\d{1,}.*页/",$high[0][0],$high2);
$info[0]["页数"]=preg_replace("/[red\">页<\/span]/",'',$high2)[0];
foreach ($huitie[0] as $key => $value) {
    $info[$key]["回帖"]=preg_replace("/^d_post_content j_d_post_content.*?\">            /",'', $value);
    $info[$key]["回帖"]=preg_replace("/<\/div>/","",$info[$key]["回帖"]);
    $info[$key]["回帖"]=preg_replace("/<a.*?>/","",$info[$key]["回帖"]);
    $info[$key]["回帖"]=preg_replace("/<\/a>/","",$info[$key]["回帖"]);
}

foreach ($tail_info[0] as $key => $value) {
    $info[$key]["楼层"]=preg_replace("/<span .*/",'', $value);
    preg_match("/\d{4}-\d{2}-\d{2}.*\d/",$value,$RETURN);
    $info[$key]["时间"]=$RETURN[0];
}

/*function array_iconv($arr, $in="gbk", $out="utf-8"){
    if(is_array($arr)){
        foreach ($arr as $key => $value) {
        $arr[key]="";
       }
}
}*/
//print_r($info);
echo (json_encode($info));
//var_dump(json_last_error());
?>