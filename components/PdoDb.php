<?php
namespace Component;

class PdoDb
{
    public static $db;

    public static function connecting($db_config)
    {
        $dsn = "mysql:host=".$db_config['dbhost'].";dbname=".$db_config['dbname'].";charset=".$db_config['dbcharset'];
        $opt = [
            $db_config['dbtype']::ATTR_ERRMODE            => $db_config['dbtype']::ERRMODE_EXCEPTION,
            $db_config['dbtype']::ATTR_DEFAULT_FETCH_MODE => $db_config['dbtype']::FETCH_ASSOC,
            $db_config['dbtype']::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            self::$db = new $db_config['dbtype']($dsn, $db_config['dbuser'], $db_config['dbpassword'], $opt);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }

    public function findAll($sql = NULL, $bindings = array())
    {
        $stmt = self::$db->prepare($sql);
        $stmt->execute($bindings);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOne($sql = NULL, $bindings = array())
    {
        $stmt = self::$db->prepare($sql);
        $stmt->execute($bindings);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($sql = NULL, $bindings = array())
    {
        $stmt = self::$db->prepare($sql);
        $stmt->execute($bindings);

        return self::$db->lastInsertId();

    }

    public function update($sql = NULL, $bindings = array())
    {
        $stmt = self::$db->prepare($sql);
        $stmt->execute($bindings);

    }

    public function delete($sql = NULL, $bindings = array())
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($bindings);
    }
}