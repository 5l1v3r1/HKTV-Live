<?php
$url = 'http://live.eservice-hk.net/hktv?vid=';
$lists_page = $_GET['page'] ? $_GET['page'] : '0';
$lists_ofs = $lists_page * '6';
$lists_json = json_decode(file_get_contents("https://ott-www.hktvmall.com/api/lists/getProgram?lim=6&ofs={$lists_ofs}"), true);
foreach($lists_json['videos'] as $program_x => $program_x_value) {
    foreach($program_x_value['child_nodes'] as $program_y => $program_y_value) {
        echo "<span>{$program_y_value['title']}</span>";
        echo "<br>";
        foreach($program_y_value['child_nodes'] as $program_z => $program_z_value) {
            echo "<a href='{$url}{$program_z_value['video_id']}'>{$program_z_value['title']}</a>";
            echo "<br>";
        }
    }
    echo "<br>";
}
?>
