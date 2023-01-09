<?php
class database
{
    private $host = "localhost";
    private $dbname = "coffee_shop";
    private $uname = "root";
    private $pass = "";
    private $con = false;
    private $result = [];
    private $mysqli = "";

    public function __construct()
    {
        if ($this->con) {
            return true;
        } else {
            try {
                $this->mysqli = new PDO("mysql:hsotname=$this->host;dbname=$this->dbname", $this->uname, $this->pass);
            } catch (PDOException $e) {
                array_push($this->result, "Connection failed: " . $e->getMessage());
                return false;
                die();
            }
        }
    }

    // check Table Exist or not

    public function tableExist($table)
    {
        $tb = $this->mysqli->prepare("SHOW TABLES LIKE ?");
        $tb->bindParam(1, $table);
        if ($tb->execute()) {
            if ($tb->rowCount() > 0) {
                return true;
            } else {
                array_push($this->result, "Thare is no table like $table");
                return false;
            }
        }
    }

    // Insert function 
    public function insert($table, array $arr)
    {
        if ($this->tableExist($table)) {
            $sql = "insert into $table(";
            $k = implode(",", array_keys($arr));

            $val = [];
            foreach ($arr as $key) {
                array_push($val, "?");
            }
            $sql .= $k . ") values(" . implode(",", $val) . ")";

            try {
                $res = $this->mysqli->prepare($sql);
                $res->execute(array_values($arr));
                array_push($this->result, $this->mysqli->lastInsertId());
                return true;
            } catch (PDOException $e) {
                array_push($this->result, $res->errorInfo()[2]);
                return false;
                die();
            }
        }
    }

    // update data 
    public function update($table, array $arr, $where = null)
    {
        if ($this->tableExist($table)) {
            $ar = [];
            foreach ($arr as $key => $value) {
                array_push($ar, $key . "= ?");
            }
            $sql = "update $table set " . implode(",", $ar);
            if (!$where == null) {
                $sql .= " where $where";
            }
            try {
                $res = $this->mysqli->prepare($sql);
                $res->execute(array_values($arr));
                array_push($this->result, $res->rowCount());
                return true;
            } catch (PDOException $e) {
                array_push($this->result, $res->errorInfo()[2]);
                return false;
                die();
            }
        }
    }


    // Delete  data 
    public function delete($table, $where = null)
    {
        if ($this->tableExist($table)) {
            $sql = "delete from $table";
            if ($where == null) {
            } else {
                $sql .= " where $where";
            }

            try {
                $res = $this->mysqli->prepare($sql);
                $res->execute();
                array_push($this->result, $res->rowCount());
                return true;
            } catch (PDOException $e) {
                array_push($this->result, $res->errorInfo()[2]);
                return false;
                die();
            }
        }
    }
    // select data

    public function select($table, $clm = null, $join = null, $where = null, $order = null, $limit = null)
    {
        if ($this->tableExist($table)) {
            $sql = "select";
            if (!$clm == null) {
                $sql .= " $clm from $table";
            } else {
                $sql .= " * from $table";
            }

            if (!$join == null) {
                $sql .= " inner join $join";
            }
            if (!$where == null) {
                $sql .= " where $where";
            }
            if (!$order == null) {
                $sql .= " order by $order";
            }
            if (!$limit == null) {
                $sql .= " limit 0,$limit";
            }
            try {
                $res = $this->mysqli->prepare($sql);
                $res->execute();
                array_push($this->result, $res->fetchAll(PDO::FETCH_ASSOC));
                return true;
                echo $sql;
            } catch (PDOException $e) {
                echo $sql;
                array_push($this->result, $res->errorInfo()[2]);
                return false;
                die();
            }

        }
    }
    // show query result

    public function show_result()
    {
        $res = $this->result;
        $this->result = [];
        return $res;
    }



    // close function 
    public function __destruct()
    {
        if ($this->con) {
            if ($this->mysqli = null) {
                return true;
            }
        } else {
            return false;
        }
    }
}
