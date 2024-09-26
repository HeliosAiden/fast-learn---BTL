<?php
class Database
{

    private $__connection, $__last_insert_id;

    function __construct()
    {
        global $db_config;
        $this->__connection = DB_Connection::get_instance($db_config);
    }

    function query($sql)
    {
        $statement = $this->__connection->prepare($sql);
        $statement->execute();
        return $statement;
    }

    protected function last_insert_id()
    {
        return $this->__last_insert_id;
    }

    protected function set_last_insert_id($last_insert_id)
    {
        $this->__last_insert_id = $last_insert_id;
    }

    function select($table, $condition = '')
    {
        try {
            if (!empty($condition)) {
                $sql = "SELECT * FROM $table WHERE $condition";
            } else {
                $sql = "SELECT * FROM $table";
            }

            $query = $this->query($sql);
            if ($query) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
                return [$data, true];
            } else {
                return [null, false];
            }
        } catch (PDOException $exception) {
            die('Query failed: ' . $exception->getMessage());
        }
    }

    /**
     * insert data into table in mySQL database
     *
     * This function takes table's name and new data
     *
     * @param string $table The exact name of the table inside mySQL database.
     * @param associative_array $data The data array of key and value pairs.
     * @return array The array consists of two value: [(array) $last_insert_id, (bool) $status]
     */
    function insert($table, $data)
    {
        if (!empty($data)) {
            $fieldStr = '';
            $valueStr = '';
            foreach ($data as $key => $value) {
                $fieldStr .= $key . ',';
                $valueStr .= "'" . $value . "',";
            }
            $fieldStr = rtrim($fieldStr, ',');
            $valueStr = rtrim($valueStr, ',');

            $sql = "INSERT INTO $table($fieldStr) VALUES ($valueStr)";

            $status = $this->query($sql);
            if ($status) {
                $this->set_last_insert_id($this->__connection->lastInsertId());
                return [$this->last_insert_id(), true];
            }
        } else {
            return [null, false];
        }
    }

    /**
     * update one or multiple data into table in mySQL database
     *
     * This function takes table's name, new data and one or multiple ids to update
     *
     * @param string $table The exact name of the table inside mySQL database.
     * @param associative_array $data The data array of key and value pairs.
     * @param array $id The array contains one or multiple ids.
     * @return array The array consists of two value: [(array) $selected_id, (bool) $status]
     */
    function update($table, $data, $id)
    {
        if (!empty($data)) {
            $updateStr = '';
            foreach ($data as $key => $value) {
                $updateStr .= "$key='$value'";
            }
            $updateStr = rtrim($updateStr, ',');

            if (count($id) > 1) {
                $selected_ids = $id;
                $condition = '( ';
                foreach ($id as $selected_id) {
                    $condition .= $selected_id . ', ';
                }
                $condition = rtrim($condition, ', ') . ' )';
                $sql = "UPDATE $table SET $updateStr WHERE id IN $condition";
            }
            if (count($id) == 1) {
                $selected_id = $id[0];
                $selected_ids = [$selected_id];
                $sql = "UPDATE $table SET $updateStr WHERE id IN $selected_id";
            }

            $status = $this->query($sql);
            if ($status) {
                return [$selected_id, true];
            }

            return [[], false];
        }
    }

    function delete($table, $condition = '')
    {
        if (!empty($condition)) {
            $sql = "DELETE FROM $table WHERE $condition";
        } else {
            $sql = "DELETE FROM $table";
        }

        $status = $this->query($sql);
        if ($status) {
            return true;
        }

        return false;
    }
}
