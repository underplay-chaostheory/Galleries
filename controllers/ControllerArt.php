<?php
final class ControllerArt extends Controller
{
    public function display(){
        $this->loadModel("ModelArt");

        $image = $this->model->getOneRandom();

        $config = $this->model->getConfig("art/display");

        $this->render("display", array_merge($config, array('image' => $image)));
    }

    public function show($param){
        $id = intval($param[0]);

        $this->loadModel("ModelArt");

        $image = $this->model->getOne($id);

        $config = $this->model->getConfig("art/show");

        $this->render("display", array_merge($config, array('image' => $image)));
    }

    public function next($param){
        $id = intval(($param[0]));

        $this->loadModel("ModelArt");

        $image = $this->model->getNext($id);
        if(is_bool($image) && !$image){
            $this->show(array($id));
        }else{
            $config = $this->model->getConfig("art/show");

            $this->render("display", array_merge($config, array('image' => $image)));  
        }
    }
    public function prev($param){
        $id = intval(($param[0]));

        $this->loadModel("ModelArt");

        $image = $this->model->getPrev($id);
        if(is_bool($image) && !$image){
            $this->show(array($id));
        }else{
            $config = $this->model->getConfig("art/show");

            $this->render("display", array_merge($config, array('image' => $image)));  
        }
    }

    public function settings(){
        $this->loadModel("ModelArt");

        $settings = $this->model->getSettings();

        $info = array();
        $info['filtrageName'] = $settings['name_like'];
        if (is_string($settings['type']) && $settings['type'] == 'all'){
            $info['wallpaper'] = true;
            $info['portrait'] = true;
            $info['other'] = true;
        } else {
            if (in_array("wallpaper", $settings['type'])){
                $info['wallpaper'] = true;
            } else {
                $info['wallpaper'] = false;
            }
            if (in_array("portrait", $settings['type'])){
                $info['portrait'] = true;
            } else {
                $info['portrait'] = false;
            }
            if (in_array("other", $settings['type'])){
                $info['other'] = true;
            } else {
                $info['other'] = false;
            }
        }
        if (is_string($settings['category']) && $settings['category'] == 'all'){
            for($i = 0; $i<6; $i++){
                $info['code_' . $i] = true;
            }
        } else {
            for($i = 0; $i<6; $i++){
                if(in_array(strval($i), $settings['category'])){
                    $info['code_' . $i] = true;
                } else {
                    $info['code_' . $i] = false;
                }
            }
        }
        if ($settings['fullscreen_only'] == "true"){
            $info['fullscreen'] = true;
        } else {
            $info['fullscreen'] = false;
        }
        if (is_string($settings['exclude_directory']) && $settings['exclude_directory'] == 'none'){
            $info['excludeDirectory'] = "";
        } else {
            $info['excludeDirectory'] = "";
            foreach($settings['exclude_directory'] as $path){
                $info['excludeDirectory'] = $info['excludeDirectory'] . $path . '\n';
            }
        }
        if (is_string($settings['restrict_directory']) && $settings['restrict_directory'] == 'none'){
            $info['restrictDirectory'] = "";
        } else {
            $info['restrictDirectory'] = "";
            foreach($settings['restrict_directory'] as $path){
                $info['restrictDirectory'] = $info['restrictDirectory'] . $path . '\n';
            }
        }
        

        $config = $this->model->getConfig("art/settings");

        $this->render("settings", array_merge(array('info' => $info), $config));
    }

    public function update_img($data){
        $this->loadModel("ModelArt");
        //var_dump($data);

        if ($this->model->updateImg($data)) {
            $this->show(array($data['id']));
        } else {
            echo "Erreur dans le model";
        }
    }

    public function update_settings($data){
        $this->loadModel("ModelArt");
        //var_dump($data);

        if ($this->model->updateSettings($data)) {
            $this->settings();
        } else {
            echo "Erreur dans le model";
        }
    }

    public function update_db(){
        $this->loadModel("ModelArt");

        if ($this->model->updateDB()) {
            $this->settings();
        } else {
            echo "Erreur dans le model";
        }
    }

    public function add_bg($param){
        $id = intval($param[0]);

        $this->loadModel("ModelArt");
        $path = $this->model->getInfo($id, "path");
        
        $filename = pathinfo($path, PATHINFO_BASENAME);

        if (copy($path, 'Folder' . $filename)) {
            $this->show(array($id));
        } else {
            echo "Erreur dans le model";
        }
    }
}
