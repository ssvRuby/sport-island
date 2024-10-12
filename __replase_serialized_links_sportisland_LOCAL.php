<?php
require_once("wp-load.php");
$r = maybe_unserialize(get_theme_mods());
foreach ($r as $k => $v){
    if(!empty($k)){
        $ListOptions[] = $k;
    }
}
foreach($ListOptions as $option){
    $str = get_theme_mod($option);
    $str = str_replace('http://localhost/sport-island', 'http://ssv-sr.byethost5.com', $str);
    $str = str_replace('http:\\/\\/localhost\\/sport-island', 'http:\\/\\/ssv-sr.byethost5.com', $str);
    set_theme_mod($option, $str);
    var_dump('|'.$option.': '.get_theme_mod($option).' ===> '.$str . '<br>' . '==========================' . '<br>' );
    echo "\n";
}