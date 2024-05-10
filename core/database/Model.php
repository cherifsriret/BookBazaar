<?php

/**
* The Model class
*/
class Model
{
    // may interfere with IDEs offering auto-completion
    public function __get($attribute) {
       return $this->$attribute;
    }

    public function __set($attribute, $value) {
       $this->$attribute = $value;
    }

    public static function fetchAll(){
        $dbh = App::get('dbh');
        $statement = $dbh->prepare("SELECT * FROM " . strtolower(get_called_class()) . " ");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }

    public static function fetchId($id)
    {
        // ASSUMPTION
        //    - $id was validated by the caller

        $dbh = App::get('dbh');

        // prepared statement with positionnal parameters
        $statement = $dbh->prepare("SELECT * FROM " . strtolower(get_called_class()) . " WHERE id=?");
        $statement->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public static function placeholders($keys) {
       return array_map(function ($k) {
                           return ":" . $k;
                        },
                        $keys);
    }

    public static function placeholders_equals($keys) {
       return array_map(function ($k) {
                           return $k . " = :" . $k;
                        },
                        $keys);
    }

    public function update()
    {
        $dbh = App::get('dbh');

        $attributes = get_object_vars($this);
        $keys = $attributes;
        $keys = array_keys($keys);

        // prepared statement with question mark placeholders (marqueurs de positionnement)
        $req = "UPDATE "
               . strtolower(get_class($this))
               . " SET " . join(", ", static::placeholders_equals($keys))
               . " WHERE (id = :id)";

        $statement = $dbh->prepare($req);
        // use exec() because no results are returned
        $statement->execute($attributes);
    }

    public function create()
    {
        $dbh = App::get('dbh');

        $attributes = get_object_vars($this);
        if (array_key_exists('id', $attributes)) {
           $id_exists = 1;
           unset($attributes['id']);
        }

        // prepared statement with question mark placeholders (marqueurs de positionnement)
        $req = "INSERT INTO "
               . strtolower(get_class($this))
               . " (" . join(", ", array_keys($attributes)) . ")"
               . " VALUES(" . join(", ", static::placeholders(array_keys($attributes))) . ")";
       
          $statement = $dbh->prepare($req);
       
        // use exec() because no results are returned
        $statement->execute($attributes);

        if (isset($id_exists)) {
           $this->id = $dbh->lastInsertId();
        }
    }

    public function delete()
    {
       $dbh = App::get('dbh');
       $statement = $dbh->prepare("DELETE FROM " . strtolower(get_class($this)) . " WHERE id = ?");
       $statement->execute([$this->id]);
       return true;
    }
}
