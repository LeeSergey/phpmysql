<?php

namespace App\Db;

class Db {

    /**
     * @var string
     */
    private static $host= '127.0.0.1';
    private static $database= 'test_database';
    private static $username= 'SL';
    private static $password= '$Password1983$';

    private static $connect;


    public static function getConnect() {
        if (is_null(static::$connect)){
            static::$connect = static::connect();
        }
        return static::$connect;
    }

    public static function query($query) {

        $conn = static::getConnect();
        $result = mysqli_query($conn, $query);

        if (mysqli_errno($conn)){
            var_dump(mysqli_errno($conn), mysqli_error($conn));
            exit;
        }

        return $result;

    }

    public static function fetchAll(string $query): array
    {
        $result = static::query($query);

        $data = [];
        while ($row = static::fetchAssoc($result)){
            $data[] = $row;
        }

        return $data;
    }

    public static function fetchAssoc($result): ?array
    {
        return mysqli_fetch_assoc($result);
    }

    public static function fetchRow(string $query): array
    {
        $result = static::query($query);
        $row = mysqli_fetch_assoc($result);

        if (is_null($row)){
            $row = [];
        }

        return $row;
    }

    public static function fetchOne(string $query): string
    {
        $result = Db::query($query);

        $row = mysqli_fetch_row($result);

        return (string) ($row[0] ?? '');
    }

    public static function delete(string $table_name, string $where)
    {
        $query = "DELETE FROM " . $table_name;

        if ($where) {
            $query .= ' WHERE ' . $where;
        }

        static::query($query);

        return static ::affectedRows();

    }

    public static function insert(string $table_name, array $fields): int
    {
        $field_names = [];
        $field_values = [];

        foreach ($fields as $field_name=>$field_value) {

            if ($field_name == 'id') {
                continue;
            }
            $field_names[] = "`$field_name`";
            if ($field_value instanceof DbExp) {
                $field_values[] = "$field_value";
            } else {
                $field_value = Db::escape($field_value);
                $field_values[] = "'$field_value'";
            }
        }

        $field_names = implode(',', $field_names);
        $field_values = implode(',', $field_values);

        $query = "INSERT INTO $table_name($field_names) VALUES ($field_values)";

        static::query($query);

        return static::lastInsertId();

    }

    public static function update(string $table_name, array $fields, string $where)
    {
        $set_fields = [];

        foreach ($fields as $field_name=>$field_value) {
            if ($field_value instanceof DbExp) {
                $set_fields[] = "`$field_name` = $field_value";
            } else {
                $field_value = Db::escape($field_value);
                $set_fields[] = "`$field_name` = '$field_value'";
            }
        }

        $set_fields = implode(',', $set_fields);

        $query = "UPDATE $table_name SET $set_fields";

        if ($where){
            $query .= (' WHERE ' . $where);
        }

        static::query($query);

        return static::affectedRows();

    }

    public static function affectedRows()
    {
        $connect = static::getConnect();
        return mysqli_affected_rows($connect);
    }

    public static function lastInsertId(): int
    {
        $connect = static::getConnect();
        return mysqli_insert_id($connect);
    }

    public static function escape(string $value)
    {
        $connect = static ::getConnect();
        return mysqli_real_escape_string($connect , $value);
    }

    public static function expr(string $value)
    {
        return new DbExp($value);
    }

    private static function connect() {

        $connect = mysqli_connect(static::$host, static::$username, static::$password, static::$database);

        if (mysqli_connect_errno()) {
            $error = mysqli_connect_error();
            var_dump($error);

            exit;
        }

        return $connect;
    }
}
