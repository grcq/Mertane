<?php

namespace App\Container;

use App\Container\Container;

class DatabaseContainer extends Container {

    private function connect()
    {
        $details = $this->get("config")->fetch("database");
        return new \mysqli($details["address"], $details["username"], $details["password"], $details["database_name"]);
    }

    public function update(string $query): void
    {
        $conn = $this->connect();
        $conn->query($query);

        $conn->close();
    }

    public function execute(string $query)
    {
        $conn = $this->connect();
        $res = $conn->query($query);

        $conn->close();

        return $res;
    }

    public function select(string $table, array $select = ["*"], array $where = []): array
    {
        $res = $this->execute("SELECT " . implode(", ", $select) . " FROM " . $table . (empty($where) ? ";" : " WHERE " . implode(" AND ", $where) . ";"));
        if ($res->num_rows === 0) return [];
        
        return $res->fetch_assoc();
    }

    public function set(string $table, array $vars, array $where = []): void
    {
        $keys = [];
        $vals = [];
        $arr = [];
        foreach ($vars as $key => $val)
        {
            array_push($arr, $key . "=" . $val);
            array_push($vals, $val);
            array_push($keys, $key);
        }

        if (empty($this->select($table, ["*"], $where)))
        {
            $this->update("INSERT INTO " . $table . " (" . implode(", ", $keys) . ") VALUES (" . implode(", ", $vals) . ");");
            return;
        }

        $this->update("UPDATE " . $table . " SET " . implode(", ", $arr) . " WHERE " . implode(" AND ", $where) . ";");
    }

    public function createTable(string $table, array $vars): void
    {
        $this->update("CREATE TABLE IF NOT EXISTS " . $table . "(" . implode(", ", $vars) . ");");
    }

}