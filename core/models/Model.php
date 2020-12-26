<?php
namespace Core\Models;

use Core\Libs\Db;

abstract class Model{

    public static function findAll()
    {
       $pdo = Db::getInstance();
       return $pdo->query('SELECT * FROM ' . static::getTableName(), [], static::class);
    }

    public static function getById($id)
    {
       $pdo = DB::getInstance();
       $result = $pdo->query('SELECT * FROM ' . static::getTableName() . ' WHERE id=:id', ['id'=>$id], static::class);
       return $result ? $result[0] : null;
    }

    public function save()
    {
      $properties = $this->propertiesToDb();
      // echo '<pre>' . print_r($properties, true) . '</pre>';
      if(array_key_exists('id', $properties)){
         $this->update($properties);
      }
      else{
         $this->insert($properties);
      }
      
    }

    private function propertiesToDb()
    {
      $reflector = new \ReflectionObject($this);
      $properties = $reflector->getProperties();
      $props = [];
      foreach($properties as $property){
         $propertyName = $property->getName(); //id
         $props[$propertyName] = $this->$propertyName;
      }
      return $props;
    }

    private function update(array $properties)
    {
       $columns = [];
       foreach($properties as $column=>$value){
          $columns[] = $column . '=:' . $column;
       }
      //  echo '<pre>' . print_r($columns, true) . '</pre>';
       
      $pdo = Db::getInstance();
      $sql = 'UPDATE '. static::getTableName() . ' SET ' . implode(', ', $columns) . ' WHERE id=:id';
      $pdo->query($sql, $properties, static::class);
    }

    /* $sql = 'UPDATE articles SET name=:name, text=:text, user_id=:user_id WHERE id=:id';
   execute([
    'name'=>'New article',
    'text'=>'Text for New article',
    'user_id'=>2,
    'id'=>1
]);
 */


    private function insert(array $properties)
    {
      $keys = [];
      $values = [];
      foreach($properties as $key=>$value){
         $keys[] = $key;
         $values[] = $value;

      }
      
     $pdo = Db::getInstance();
     $sql = 'INSERT INTO '. static::getTableName() . ' (' . implode(', ', $keys) . ')' . ' VALUES ' . "('" . implode("', '", $values) . "')";
     $pdo->query($sql, $properties, static::class);

    }

    public function delete()
    {
      $pdo = Db::getInstance();
      $sql = ' DELETE FROM '. static::getTableName() . ' WHERE id=' . $this->id;
      $pdo->query($sql);
    }

    abstract protected static function getTableName();
   
}