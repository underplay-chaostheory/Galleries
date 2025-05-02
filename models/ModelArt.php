<?php
define('DIR_SEPARATOR', '\\');

final class ModelArt extends Model
{
    private array $defaultValue = array('', 'none', 'all');


    public function updateDB(){
        $this->getConnection("art");

        require_once(ROOT . "/application/lib/scrapping.php");
        $files = scrapp("D:\Autre\Image\Art");
        

        $insert = "INSERT INTO images (id, path, name, type, category, fullscreen) VALUES (:id, :path, :name, :type, :category, :fullscreen)";
        $update = "UPDATE images SET path = :newPath WHERE id = :id";

        try {
            $query = $this->_connexion->prepare("TRUNCATE TABLE images");
            $query->execute();
            $id = 1;

            foreach($files as $path){
                $file = pathinfo($path, PATHINFO_ALL);

                $info = explode(" - ", $file['basename']);
                $name = explode(" (", $info[0])[0];
                $type = strtolower($info[1]);
                $category = intval($info[2]);
                $fullscreen = (array_key_exists(3, $info) && $info[3] == "FS") ? 1 : 0;
                
                $this->_connexion->beginTransaction();
                $query = $this->_connexion->prepare($insert);
                $query->execute(array(
                    'id' => $id,
                    'path' => $path,
                    'name' => $name,
                    'type' => $type,
                    'category' => $category,
                    'fullscreen' => $fullscreen
                ));

                $newPath = $file['dirname'] . '\\' . $name . " (" . $id . ") - " . ucfirst($type) . " - " . $category ;
                if ($fullscreen == 1){
                    $newPath = $newPath . " - FS";
                }
                $newPath = $newPath . "." . $file['extension'];
                //var_dump($newPath);
                
                $query = $this->_connexion->prepare($update);
                $query->execute(array(
                    'newPath' => $newPath,
                    'id' => $id
                ));

                $this->_connexion->commit();

                rename($path, $newPath);
                $id++;
            }
            return true;
        } catch (Exception $e) {
            if ($this->_connexion->inTransaction()) {
                $this->_connexion->rollBack();
            }
            echo $e->getMessage();
            return false;
        }
    }

    public function getSettings(){
        $settingsfile = fopen(ROOT . "/data/settings/art.txt", "r") or die("Unable to open file !");
        $settings = array(); 

        while(!feof($settingsfile)) {
            $line = str_replace("\n", "", fgets($settingsfile));
            $temp = explode(" : ", $line);
            $ruleName = $temp[0];
            $ruleParameters = explode("|", $temp[1]);
            if (count($ruleParameters) == 0){
                $ruleParameters = null;
            }
            if (count($ruleParameters) == 1  && in_array($ruleParameters[0], $this->defaultValue)){
                $ruleParameters = $ruleParameters[0];
            }

            $settings[$ruleName] = $ruleParameters;
        }
        $settings['fullscreen_only'] = $settings['fullscreen_only'][0];
        //var_dump($settings);
        fclose($settingsfile);
        return $settings;
    }

    public function getInfo($id, $info){
        $this->getConnection("art");
        $sql = "SELECT " . $info . " FROM images WHERE id = :id";
        $query = $this->_connexion->prepare($sql);
        $query->execute(array('id'=> $id));
        $res = $query->fetch(PDO::FETCH_ASSOC);
        return $res[$info];
    }

    public function constructRequeteSettings(){
        $settings = $this->getSettings();
        $sql = "";
        
        if($settings['name_like'] != ""){
            $sql = $sql . "\nAND images.name LIKE " . $settings['name_like'];
        }
        if (is_array($settings['type'])){
            $sql = $sql . "\nAND images.type IN ('" . implode("', '", $settings['type']) . "')";
        }
        if (is_array($settings['category'])){
            $sql = $sql . "\nAND images.category IN (" . implode(", ", $settings['category']) . ")";
        }
        if($settings['fullscreen_only'] == 'true'){
            $sql = $sql . "\nAND images.fullscreen = 1";
        }
        if (is_array($settings['exclude_directory'])){
            $sql = $sql . "\nAND images.category IN ('" . implode("', '", $settings['exclude_directory']) . "')";
        }
        if (is_array($settings['restrict_directory'])){
            $sql = $sql . "\nAND images.category IN ('" . implode("', '", $settings['restrict_directory']) . "')";
        }
        return $sql;
    }

    public function getOne($id){
        $this->getConnection("art");

        $sql = "SELECT id, path, name, type, category, fullscreen FROM images WHERE id = :id";
        
        try {
            $query = $this->_connexion->prepare($sql);
            $query->execute(array('id' => $id));
            $data = $query->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function getNext($id){
        $this->getConnection("art");

        $sql = "SELECT id, path, name, type, category, fullscreen FROM images WHERE id > :id";
        $sql = $sql . $this->constructRequeteSettings();
        $sql = $sql . "\nLIMIT 1";

        try {
            $query = $this->_connexion->prepare($sql);
            $query->execute(array('id' => $id));
            $data = $query->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }
    public function getPrev($id){
        $this->getConnection("art");

        $sql = "SELECT id, path, name, type, category, fullscreen FROM images WHERE id < :id";
        $sql = $sql . $this->constructRequeteSettings();
        $sql = $sql . "\nLIMIT 1";

        try {
            $query = $this->_connexion->prepare($sql);
            $query->execute(array('id' => $id));
            $data = $query->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function getOneRandom(){
        $this->getConnection("art");

        $sql = "SELECT id, path, name, type, category, fullscreen FROM images WHERE 1=1";
        $sql = $sql . $this->constructRequeteSettings();
        
        try {
            $query = $this->_connexion->prepare($sql);
            $query->execute();
            $data = $query->fetchall(PDO::FETCH_ASSOC);
            return $data[rand(0, count($data)-1)];
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function updateSettings($data){
        $settingsfile = fopen(ROOT . "/data/settings/art.txt", "w") or die("Unable to open file !");

        $line = "name_like : " . $data['name_like'];
        fwrite($settingsfile, $line . "\n");

        $line = "type : ";
        $type = array();
        if(array_key_exists("wallpaper", $data)){
            array_push($type, "wallpaper");
        }
        if(array_key_exists("portrait", $data)){
            array_push($type, "portrait");
        }
        if(array_key_exists("other", $data)){
            array_push($type, "other");
        }
        if(count($type) == 3 || count($type) == 0 ){
            $line = $line . "all";
        } else {
            $line = $line . implode("|", $type);
        }
        fwrite($settingsfile, $line . "\n");

        $line = "category : ";
        $category = array();
        for($i = 0; $i < 6; $i++){
            if(array_key_exists("code_" . $i, $data)){
                array_push($category, $i);
            }
        }
        if(count($category) == 6 || count($category) == 0 ){
            $line = $line . "all";
        } else {
            $line = $line . implode("|", $category);
        }
        fwrite($settingsfile, $line . "\n");

        if ($data['fullscreen'] == "Oui"){
            $line = "fullscreen_only : true";
        } else {
            $line = "fullscreen_only : false";
        }
        fwrite($settingsfile, $line . "\n");

        if ($data['exclude_directory'] == ""){
            $line = "exclude_directory : none";
        } else {
            if (substr($data['exclude_directory'], -2) == '\n'){
                $data['exclude_directory'] = substr($data['exclude_directory'], 0, -2);
            }
            $line = "exclude_directory : " . str_replace('\n', "|", $data['exclude_directory']);
        }
        fwrite($settingsfile, $line . "\n");

        if ($data['restrict_directory'] == ""){
            $line = "restrict_directory : none";
        } else {
            if (substr($data['restrict_directory'], -2) == '\n'){
                $data['restrict_directory'] = substr($data['restrict_directory'], 0, -2);
            }
            $line = "restrict_directory : " . str_replace('\n', "|", $data['restrict_directory']);
        }
        fwrite($settingsfile, $line);

        fclose($settingsfile);
        return true;
    }

    public function updateImg($data){
        $file = pathinfo($data['path']);

        $newFileName = $data['name'] . " (" . $data['id'] . ") - " . ucfirst($data['type'])  . " - " . $data['category'];
        if ($data['fullscreen'] == 'yes'){
            $newFileName = $newFileName . " - FS";
        }
        $newFileName = $newFileName . "." . $file['extension'];
        $newPath = $file['dirname'] . DIR_SEPARATOR . $newFileName;

        if($data['path'] != $newPath){
            if(file_exists($newPath)){
                return false;
            }
            rename($data['path'], $newPath);
        }

        try{
            $this->getConnection('art');
            $sql = "UPDATE images SET path = :newPath, name = :name, type = :type, category = :category, fullscreen = :fullscreen
                    WHERE id = :id";
            $query = $this->_connexion->prepare($sql);
            $query->execute(array(
                'newPath' => $newPath,
                'name' => $data['name'],
                'type' => $data['type'],
                'category' => $data['category'],
                'fullscreen' => ($data['fullscreen'] == 'no') ? 0 : 1,
                'id' => $data['id']
            ));
            return true;
        } catch (Exception $exception) {
            echo $exception->getMessage();
            return false;
        }
    }
}