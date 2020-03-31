<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace Model;

/**
 * Class UserManager
 * @package Model
 */
class UserManager extends AbstractManager
{
    const TABLE = 'user';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    public function searchByName (string $search)
    {
        $statement = $this->pdoConnection->prepare("SELECT * FROM `$this->table` WHERE firstName LIKE :search OR lastName LIKE :search" );
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->bindValue('search', $search.'%', \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
