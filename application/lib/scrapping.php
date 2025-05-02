<?php

function scandirectory($dir){
    return array_diff(scandir($dir), array('.', '..'));
}

function scrapp($directory) {
     
    $paths = array();

    $files = scandirectory($directory);
    foreach($files as $file){
        if (is_file($directory . DIR_SEPARATOR . $file)) {
            array_push($paths, $directory . DIR_SEPARATOR . $file);
            
        } else {
            if ($file != "no-scrapping"){
                $paths = array_merge($paths, scrapp($directory . DIR_SEPARATOR . $file));
            }
        }
    }
    return $paths;
}