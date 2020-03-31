<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 20:52
 * PHP version 7
 */

namespace Model;

use App\Connection;

/**
 * Abstract class handling default manager.
 */
abstract class AbstractManager
{
    protected $pdoConnection; //variable de connexion

    protected $table;
    protected $className;


    /**
     *  Initializes Manager Abstract class.
     *
     * @param string $table Table name of current model
     */
    public function __construct(string $table)
    {
        $connexion = new Connection();
        $this->pdoConnection = $connexion->getPdoConnection();
        $this->table = $table;
        $this->className = __NAMESPACE__ . '\\' . ucfirst($table);
    }

    /**
     * Get all row from database.
     *
     * @return array
     */
    public function selectAll(): array
    {
        return $this->pdoConnection->query("SELECT * FROM `$this->table`")
            ->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get one row from database by ID.
     *
     * @param int $id
     *
     * @return array
     */
    public function selectOneById(int $id)
    {
        // prepared request
        $statement = $this->pdoConnection->prepare("SELECT * FROM `$this->table` WHERE id=:id");
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }


    /**
     * Add Entity 
     * @param array $data
     */
    public function add(array $data)
    {
        $columns = "";
        $values = "";
        foreach ($data as $column => $value){
            $columns .= $column.', ';
            $values .= '"'.$value.'", ';
        }
       
        $columns=substr($columns, 0, strlen($columns)-2);
        $values=substr($values, 0, strlen($values)-2);
        
       $statement = $this->pdoConnection->prepare('INSERT INTO '.$this->table.' ('.$columns.') VALUES ('.$values.')');

       $statement->execute();
    }
    /**
     * Update Entity
     *  @param int $id
     *  @param array $data
     */
    public function update(int $id, array $data)
    {
        $modifs = "";
        foreach ($data as $column => $value){
            $modifs.=$column.'="'.$value.'", ';
        }
        $modifs=substr($modifs, 0, strlen($modifs)-2);
        $statement = $this->pdoConnection->prepare('UPDATE '.$this->table.' SET '.$modifs.' WHERE id='.$id);

        $statement->execute();

    }
    /**
     * Delete Entity
     * @param int $id
     */
    public function delete($id)
    {
        // prepared request
        $statement = $this->pdoConnection->prepare("DELETE FROM ".$this->table." WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

    }
}
