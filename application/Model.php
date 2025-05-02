<?php
abstract class Model{
    //Information de base de donnée
    private   $host = "localhost";
    private   $username = "root";
    private   $password = "root";

    //Propiété contenant la connexion
    protected $_connexion;

    public function column_to_array($fetchall_res, $key)
    {
        $temp = array();
        foreach($fetchall_res as $row){
            array_push($temp, $row[$key]);
        }
        return $temp;
    }

    protected function getConnection(string $database_name)
    {
        $this->_connexion = null;

        try
        {
            $this->_connexion = new PDO(
                'mysql:host='.$this->host.';dbname='.$database_name,
                $this->username,
                $this->password);
            $this->_connexion->exec('set names utf8');
        }catch(PDOException $exception){
            echo 'Erreur : '.$exception->getMessage();
        }
    }

    public function getConfig(string $page)
    {
        $this->getConnection("website");

        try
        {
            $sql = "SELECT title, template, header, footer
                    FROM pages
                    WHERE pages.path = :page";
            $query = $this->_connexion->prepare($sql);
            $query->execute(['page'  => $page]);
            $info =  $query->fetch(PDO::FETCH_ASSOC);

            $sql = "SELECT js.path as js FROM pages
                    JOIN include_js on pages.path = include_js.page
                    JOIN js on js.nom = include_js.js 
                    WHERE pages.path = :page";
            $query = $this->_connexion->prepare($sql);
            $query->execute(['page'  => $page]);
            $js = array();
            $js = $this->column_to_array($query->fetchall(PDO::FETCH_ASSOC), "js");

            $sql = "SELECT css.path as css FROM pages
                    JOIN include_css on pages.path = include_css.page
                    JOIN css on css.nom = include_css.css
                    WHERE pages.path = :page";
            $query = $this->_connexion->prepare($sql);
            $query->execute(['page'  => $page]);
            $css = $this->column_to_array($query->fetchall(PDO::FETCH_ASSOC), "css");

            $police = null;
            $meta = null;

            return array_merge($info, compact('js', 'css', 'police', 'meta'));
        }
        catch(Exception $exception)
        {
            echo $exception->getMessage();
        }
    }
}