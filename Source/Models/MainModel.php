<?php

namespace Source\Models;

use Lib\config\Database;

/**
 * CRUD
 * 
 * findAll() -
 * findBy() - 
 * find() - 
 * create() - 
 * update() -
 * delete () -
 * 
 *  
 * */
class MainModel extends Database
{
    protected $table;
    private $database;
    protected $id;

    public function getId($id, $table)
    {
        return $id . '_' . $table;
    }

    //findAll
    public function findAll($table)
    {
        $query = $this->request('SELECT * FROM ' . $table);
        return $query->fetchAll();
    }

    //findBy
    public function findBy(array $criteria)
    {
        $fields = [];
        $values = [];

        foreach ($criteria as $field => $value) {
            $fields[] = "$field = ?";
            $values[] = $value;
        }

        $fieldsString = implode(' AND ', $fields);
        return $this->request('SELECT * FROM ' . $this->table . ' WHERE ' . $fieldsString, $values)->fetchAll();
    }

    //find
    public function find(int $id)
    {
        return $this->request('SELECT * FROM ' . $this->table . " WHERE id = " . $id)->fetch();
    }

    //create
    public function create()
    {
        $fields = [];
        $in = [];
        $values = [];

        foreach ($this as $field => $value) {

            if ($value !== null && $field != 'database' && $field != 'table') {
                $fields[] = $field;
                $in[] = "?";
                $values[] = $value;
            }
        }

        $fieldsString = implode(', ', $fields);
        $inString = implode(', ', $in);


        return $this->request('INSERT INTO ' . $this->table . ' (' . $fieldsString . ')VALUES(' . $inString . ')', $values);
    }

    //update
    public function update()
    {
        $fields = [];
        $values = [];

        foreach ($this as $field => $value) {

            if ($value !== null && $field != 'database' && $field != 'table')
                $fields[] = "$field = ?";
            $values[] = $value;
        }

        $values[] = $this->id;
        $fieldsString = implode(', ', $fields);

        return $this->request('UPDATE ' . $this->table . ' SET ' . $fieldsString . ' WHERE id = ?', $values);
    }

    //delete
    public function delete(int $id)
    {
        return $this->request("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    //request
    public function request(string $sql, array $attributes = null)
    {
        $this->database = Database::getInstance();

        if ($attributes !== null) {
            $query = $this->database->prepare($sql);
            $query->execute($attributes);
            return $query;
        } else {
            return $this->database->query($sql);
        }
    }

    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
        return $this;
    }
}
