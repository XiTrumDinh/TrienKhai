<?php
class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "kipeeda";

    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->dbname
        );

        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8mb4");
    }

    /* =======================
        SELECT
    ======================= */

    public function select($sql, $types = "", $params = [])
    {
        $stmt = $this->conn->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        $stmt->close();

        return $data;
    }

    /* =======================
        INSERT UPDATE DELETE
    ======================= */

    public function execute($sql, $types = "", $params = [])
    {
        $stmt = $this->conn->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $success = $stmt->execute();

        if (!$success) {
            echo "Lỗi truy vấn: " . $stmt->error;
        }

        $stmt->close();

        return $success;
    }

    /* =======================
        COUNT
    ======================= */

    public function count($sql, $types = "", $params = [])
    {
        $stmt = $this->conn->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();

        $stmt->bind_result($total);

        $stmt->fetch();

        $stmt->close();

        return $total ?? 0;
    }

    /* =======================
        PAGINATION
    ======================= */

    public function paginate($table, $limit, $page)
    {
        $offset = ($page - 1) * $limit;

        $sql = "SELECT * FROM $table LIMIT ?, ?";

        return $this->select($sql, "ii", [$offset, $limit]);
    }

    /* =======================
        TOTAL PAGE
    ======================= */

    public function totalPage($table, $limit)
    {
        $total = $this->count("SELECT COUNT(*) FROM $table");

        return ceil($total / $limit);
    }

    /* =======================
        CLOSE
    ======================= */

    public function close()
    {
        $this->conn->close();
    }
    public function getConnection()
    {
        return $this->conn;
    }
}
