<?php
    class Stylist
    {
        private $name;
        private $id;

        function __construct($name,$id=null)
        {
            $this->name = $name;
            $this->id = $id;
        }
        function setName($new_name)
        {
            $this->name = $new_name;
        }
        function getName()
        {
            return $this->name;
        }
        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO stylists (name) VALUES ('{$this->getName()}');");
            if ($executed){
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        static function getAll()
        {
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $stylists = array();
            foreach ($returned_stylists as $stylist)
            {
                $name = $stylist['name'];
                $id = $stylist['id'];
                $new_stylist = new Stylist($name, $id);
                array_push($stylists, $new_stylist);
            }
            return $stylists;
        }

        static function deleteAll()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM stylists;");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        static function find($stylist_id)
        {
          $found_stylist = null;
          $returned_stylist = $GLOBALS['DB']->prepare("SELECT * FROM stylists WHERE id = :id");
          $returned_stylist->bindParam(':id', $stylist_id, PDO::PARAM_STR);
          $returned_stylist->execute();
          foreach($returned_stylist as $stylist) {
              $name = $stylist['name'];
              $id = $stylist['id'];
              if ($id == $stylist_id) {
                  $found_stylist = new Stylist($name, $id);
              }
          }
          return $found_stylist;
        }

        function update($new_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE stylists SET name = '{$new_name}' WHERE id = {$this->getId()};");
            if ($executed) {
                $this->setName($new_name);
                return true;
            } else {
                return false;
            }
        }

        function delete()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getId()};");
            if (!$executed) {
                return false;
            }
            $executed = $GLOBALS['DB']->exec("DELETE FROM clients WHERE stylist_id = {$this->getId()};");
            if (!$executed) {
                return false;
            } else {
                return true;
            }
        }
    }


?>
