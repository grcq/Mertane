<?php

namespace App\Container;

use App\Container\Container;

class DatabaseContainer extends Container {

    private function connect()
    {
        # Setup config.
    }

    public function update(string $query): bool
    {

    }

    public function execute(string $query)
    {
        
    }

    public function select(string $table, array $select, array $where): array
    {
        $arr = [];
        foreach ($vars as $key => $val)
        {
            array_push($arr, $key . "=" . $val);
        }

        $res = execute("SELECT " . implode(", ", $select) . " FROM " . $table . (empty($where) ? ";" : " WHERE " . implode(", ", $where) . ";"));
        if ($res->num_rows === 0) return [];
        
        return $res->fetch_assoc();
    }

}