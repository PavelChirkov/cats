<?php

class Cats {
    private $xml;
    private $fP = 'cats.xml';
    private $filtre = false;
    private $gender = null;
    private $age = null;

    public function __construct() {
        if (!file_exists($this->fP)) {
            $this->xml = new SimpleXMLElement('<?xml version="1.0"?><cats></cats>');
        } else {
            $this->xml = new SimpleXMLElement(file_get_contents($this->fP));
        }
        if(isset($_GET['filter_gender'])){
            $this->gender = $_GET['filter_gender'];
            $this->filtre = true;
        }
        if(isset($_GET['filter_age'])){
            $this->age = $_GET['filter_age'];
            $this->filtre = true;
        }
    }

    public function print($type = 'text',$gender = 'male'){
        foreach ($this->xml->cat as $cat) {
            if($type === 'text') {
                if ($this->filtre) {
                    if ((int)$cat->age === (int)$this->age || (string)$cat->gender === (string)$this->gender) $this->displayCat($cat);
                } else $this->displayCat($cat);

            }elseif ($type === 'select') {
                if((string)$cat->gender === (string)$gender) $this->displayCatSelect($cat);
            }
        }
    }
    public function one($id){
        foreach ($this->xml->cat as $cat) {
            if($id === (int)$cat->id){
                return $cat;
            }
        }
    }

    public function save() {
        $this->xml->asXML($this->fP);
    }

    public function addCat($name, $gender, $age) {
        $id = $this->max() + 1;
        $cat = $this->xml->addChild('cat');
        $cat->addChild('id', $id);
        $cat->addChild('name', $name);
        $cat->addChild('gender', $gender);
        $cat->addChild('age', $age);
        $this->save();
    }
    public function updateCat($id, $type, $name='', $gender='', $age='')
    {
        print_r($name);
        foreach ($this->xml->cat as $cat) {
            if ((int)$cat->id === (int)$id) {
                switch ($type) {
                    case 'update':
                        $cat->name = $name;
                        $cat->gender = $gender;
                        $cat->age = $age;
                    break;
                    case 'updateMother':
                        $cat->addChild('mother', $name);
                    break;
                    case 'updateFather':
                        $cat->addChild('father', $name);
                    break;
                    case 'deleteMother':
                        unset($cat->mother);
                    break;
                    case 'delete':
                        $dom=dom_import_simplexml($cat);
                        $dom->parentNode->removeChild($dom);
                    break;
                    case 'deleteFather':
                        $i = 0;
                        foreach($cat->father as $father){
                            if($i==$name){
                                $dom=dom_import_simplexml($father);
                                $dom->parentNode->removeChild($dom);
                            }

                            $i++;
                        }
                    break;
              }
            }
        }
        $this->save();
    }
    private function displayCat($cat){
        $gender = ((string)$cat->gender === "male")?"Мужской":"Женский";
        echo "<p>Кличка: {$cat->name}, Возраст: {$cat->age}, {$gender} <a href=\"One.php?id={$cat->id}\">Подробнее</a> <a href=\"/cat_management.php?action=delete&id={$cat->id}\">Удалить</a></p>";
    }
    private function displayCatSelect($cat){
        echo "<option value=\"{$cat->name}\">{$cat->name}</option>";
    }
    public function max(){
        $max = 0;
        foreach ($this->xml->cat as $cat) {
            if((int)$cat->id > $max) $max = (int)$cat->id;
        }
        return (int)$max;
    }

}