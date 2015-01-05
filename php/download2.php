<?php
$url = 'http://live.eservice-hk.net/hktv?vid=';
$lists_page = $_GET['page'] ? $_GET['page'] : '1';
$lists_lim = $_GET['lim'] ? $_GET['lim'] : '6';
$lists_ofs = $lists_page * $lists_lim - $lists_lim;
$lists_json = json_decode(file_get_contents("https://ott-www.hktvmall.com/api/lists/getProgram?lim={$lists_lim}&ofs={$lists_ofs}"), true);
foreach($lists_json['videos'] as $program_x => $program_x_value) {
    rsort($program_x_value['child_nodes']);
    foreach($program_x_value['child_nodes'] as $program_y => $program_y_value) {
        sort($program_y_value['child_nodes']);
        if($program_y_value['video_id'] == $_GET['vid']) {
            echo "@echo off\r\n";
            echo "chcp 65001\r\n";
            echo "title {$program_y_value['title']}\r\n";
            foreach($program_y_value['child_nodes'] as $program_z => $program_z_value) {
                $section .= '"'.$program_z_value['title'].'.ts"+';
                echo 'ffmpeg -i "'."{$url}{$program_z_value['video_id']}".'" -c copy "'."{$program_z_value['title']}".'.ts"'."\r\n";
            }
            echo 'copy /b '."$section".'"" "'."{$program_y_value['title']}".'.ts"'."\r\n";
            echo 'ffmpeg -i "'."{$program_y_value['title']}".'.ts" -c copy -bsf:a aac_adtstoasc "'."{$program_y_value['title']}".'.mp4"'."\r\n";
        }
    }
}
?>