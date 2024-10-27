<?php
class Database
{

    private $__connection;

    function __construct($db_config = null)
    {
        if (!$db_config) {
            global $db_config;
        }
        $this->__connection = DB_Connection::get_instance($db_config);
    }

    function query($sql, $params = []) {
        try {

            $stmt = $this->__connection->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            // Handle the exception, for example, log it or rethrow it
            throw new Exception("Database query error: " . $e->getMessage());
        }
    }

    private function getLastInsertId($table, $priority = 'created_at', $id = 'id') {
        $sql = "SELECT * FROM $table ORDER BY $priority DESC LIMIT 1;";
        $result = $this->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $result[$id] ?? null;
    }

    /**
     * select data from table in mySQL database
     *
     * This function takes table's name and condition
     *
     * @param string $table The exact name of the table inside mySQL database.
     * @param array $condition The condition to get selected row(s).
     * @param array $keys The selected keys for query row(s).
     * @param array $exeption The exeption to not get selected row(s).
     * @return array Rows selected
     */
    public function select($table, $conditions = [], $keys = [], $exeptions = [], $order_by = [], $limit=0) {
        $sql = "SELECT * FROM $table";
        if (!empty($keys)) {
            $key_str = '';
            foreach($keys as $key) {
                $key_str .= $key . ', ';
            }
            $key_str = rtrim($key_str, ', ');
            $sql = "SELECT $key_str FROM $table";
        }
        if (!empty($conditions)) {
            $sql .= ' WHERE ' . implode(' AND ', array_map(function ($key) {
                return "$key = :$key";
            }, array_keys($conditions)));
        }
        if (!empty($exeptions)) {
            if (!empty($conditions)) {
                $sql .= ' AND ';
            } else {
                $sql .= ' WHERE ';

            }
            $sql .= implode(' AND ', array_map(function ($key) {
                return "$key != :$key";
            }, array_keys($exeptions)));
        }
        if (!empty($order_by)) {
            $order_str = is_array($order_by) ? implode(', ', $order_by) : $order_by;
            $sql .= " ORDER BY $order_str";
        }
        if ($limit !== 0) {
            $sql .= " LIMIT $limit";
        }
        $stmt = $this->query($sql, array_merge($conditions, $exeptions));
        return $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];  // Fetch the results
    }

    /**
     * insert data into table in mySQL database
     *
     * This function takes table's name and new data
     *
     * @param string $table The exact name of the table inside mySQL database.
     * @param array $data The data array of key and value pairs.
     * @return string The uuid of the last insert element
     */
    function insert($table, $data) {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = $this->query($sql, $data);

        return $stmt->rowCount() > 0 ? $this->getLastInsertId($table) : null;;
    }

    /**
     * update one or multiple data into table in mySQL database
     *
     * This function takes table's name, new data and one or multiple ids to update
     *
     * @param string $table The exact name of the table inside mySQL database.
     * @param array $data The data array of key and value pairs.
     * @param array $conditions The array contains one or multiple conditions to select update.
     * @return int The number of affect rows
     */
    function update($table, $data, $conditions) {
        $setClause = implode(', ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($data)));

        $conditionClause = implode(' AND ', array_map(function ($key) {
            return "$key = :cond_$key";
        }, array_keys($conditions)));

        $sql = "UPDATE $table SET $setClause WHERE $conditionClause";

        // Combine data and conditions in a single array
        $params = array_merge($data, array_combine(
            array_map(fn($key) => "cond_$key", array_keys($conditions)),
            array_values($conditions)
        ));

        $stmt = $this->query($sql, $params);

        return $stmt->rowCount() > 0 ? $stmt->rowCount() : null;// Return number of affected rows
    }

    /**
     * delete data from table in mySQL database
     *
     * This function takes table's name and a condition
     *
     * @param string $table The exact name of the table inside mySQL database.
     * @param string $condition The condition to select deleting row.
     * @return int The number of affect rows
     */
    public function delete($table, $conditions) {
        $conditionClause = implode(' AND ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($conditions)));

        $sql = "DELETE FROM $table WHERE $conditionClause";

        $stmt = $this->query($sql, $conditions);
        return $stmt->rowCount() > 0 ? $stmt->rowCount() : null; // Return affected rows
    }
}
