<?php

$token = '';
$userId = "";
$codeFriend = urlencode("return API.friends.get(
{
    'user_ids': '$userId',
    'v':'5.68',
});
");
$codeUser = urlencode("return API.users.getFollowers(
{
    'user_ids':'$userId',
    'v':'5.68',
});
");

$responseData = function ($data,$str){
    $result = $str."\n";
    $res = json_decode($data,true);
    foreach ($res['response']['items'] as $item){
        $result.="$item\n";
    }
    return $result;
};


$queryFriend = file_get_contents("https://api.vk.com/method/execute?code=".$codeFriend."&access_token=".$token."&v=5.78");
$queryUser = file_get_contents("https://api.vk.com/method/execute?code=".$codeUser."&access_token=".$token."&v=5.78");
$fd = fopen("$userId.txt", 'w+') or die("не удалось открыть файл");

fwrite($fd, $responseData($queryFriend,"Friend"));
fwrite($fd, $responseData($queryUser,"Followers"));
fclose($fd);

?>
