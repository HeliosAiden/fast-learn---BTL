<?php
class Database
{

    private $__connection;

    function __construct()
    {
        global $db_config;
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

    private function getLastInsertId($table, $primaryKey = 'id') {
        $sql = "SELECT MAX($primaryKey) as last_id FROM $table";
        $result = $this->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $result['last_id'] ?? null;
    }

    /**
     * select data from table in mySQL database
     *
     * This function takes table's name and condition
     *
     * @param string $table The exact name of the table inside mySQL database.
     * @param string $condition The condition to selected row(s).
     * @return array The array consists of two value: [(string) $data, (bool) $status]
     */
    public function select($table, $conditions = []) {
        $sql = "SELECT * FROM $table";
        if (!empty($conditions)) {
            $sql .= ' WHERE ' . implode(' AND ', array_map(function ($key) {
                return "$key = :$key";
            }, array_keys($conditions)));
        }
        $stmt = $this->query($sql, $conditions);
        return $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : null;  // Fetch the results
    }

    /**
     * insert data into table in mySQL database
     *
     * This function takes table's name and new data
     *
     * @param string $table The exact name of the table inside mySQL database.
     * @param array $data The data array of key and value pairs.
     * @return bool $status The status of operation
     */
    function insert($table, $data, $primaryKey = 'id') {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = $this->query($sql, $data);

        return $stmt->rowCount() > 0 ? $this->getLastInsertId($table, $primaryKey) : null;;
    }

    /**
     * update one or multiple data into table in mySQL database
     *
     * This function takes table's name, new data and one or multiple ids to update
     *
     * @param string $table The exact name of the table inside mySQL database.
     * @param array $data The data array of key and value pairs.
     * @param array $id The array contains one or multiple ids.
     * @return array The array consists of two value: [(array) $selected_id, (bool) $status]
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

        return $stmt->rowCount() > 0 ? $stmt->rowCount() : null;// Return affected rows
    }

    /**
     * delete data from table in mySQL database
     *
     * This function takes table's name and a condition
     *
     * @param string $table The exact name of the table inside mySQL database.
     * @param string $condition The condition to select deleting row.
     * @return bool $status The status of operation
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
