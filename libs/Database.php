<?php

class Database extends PDO
{

    public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
    {
        parent::__construct($DB_TYPE . ':host=' . $DB_HOST . ';dbname=' . $DB_NAME, $DB_USER, $DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        // parent::setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    }


    /**
     * insert
     * @param string $table A name of table to insert into
     * @param string $data an associative array
     */
    public function insert($table, $data)
    {

        $fieldName = implode('`,`', array_keys($data));
        $fieldValues = implode("','", array_values($data));
        $stmt = $this->prepare("INSERT INTO `$table` (`$fieldName`) VALUES ('$fieldValues')");
        $stmt->execute();
         if ($stmt->rowCount()>0)
         {
             $log=new Log();
             $log->insert('add',$table);
             return true;
         }else
         {
             return false;
         }
    }

    /**
     * @param $sql string An SQl String
     * @param $array array Paramters to bind
     * @param  int $fetchMode constant A PDO fetch Mode
     * @return array
     */

    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {


        $stmt = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll($fetchMode);
    }

    /**
     * insert
     * @param string $table A name of table to insert into
     * @param string $data an associative array
     * @param string $where the where query part
     */
    public function update($table, $data, $where)
    {
        $fieldDetails = NULL;
        $fieldData = NULL;
        foreach ($data as $key => $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        $stmt = $this->prepare("UPDATE {$table} SET $fieldDetails WHERE {$where}");
        foreach ($data as $key => $value) {
            $stmt->bindValue(':'.$key,$value);
        }
        $stmt->execute();

        $log=new Log();
        $log->insert('edit',$table);


        return $stmt;
    }

    /**
     * @param $table
     * @param $where
     * @param int $limit
     * @return int
     */

    public function delete($table, $where, $limit = 1)
    {
        $log=new Log();
        $log->insert('delete',$table);
        return $this->exec("DELETE FROM `$table` WHERE  $where ");

    }


    public function cht($table = array())
    {
        $tableCreated = array();
        $tableNotCreated = array();
        foreach ($table as $tb) {
            $result = $this->query("SELECT 1 FROM $tb LIMIT 1");
            if ($result) {
                $tableCreated[] = $tb;
            } else {
                $tableNotCreated[] = $tb;
            }
        }
        return array($tableCreated, $tableNotCreated);

    }

}





























