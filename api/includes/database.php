<?php 
/*
Tomi - Database Abstraction Layer

15/11/2014

*/

class database_connection {
    static $_connection;

    public static function db_connect() {
	    $database_host=DB_HOST;
		$username=DB_USER;
		$password=DB_PASSWORD;
		$database_name=DB_NAME;
        if (!self::$_connection) {
            self::$_connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME);
            $GLOBALS['_connection']=self::$_connection;
        }
		if (!self::$_connection) {
		    die("Connection failed: " . mysqli_connect_error());
		}
        return self::$_connection;
    }

    public static function database_query($sql_query){
        $connection = self::db_connect();
        $result = $connection->query($sql_query);
        return $result;
    }
}

function connect_to_database() {
    $connection = database_connection::db_connect();
    return $connection;
}

function db_query($sql_query) {
    $result = database_connection::database_query($sql_query);
    return $result;
}

/**
 * @param $query_result
 * @param $column
 * @return array|bool|null
 *
 * Add the query handle and the column of the result to be returned
 * if $column is set to (bool)true then entire row is retuned
 */
function query_row_by_id($query_result, $column) {
    $result_row=mysqli_fetch_row($query_result);
    if ($column === true) {
        return $result_row;
    }

	if (isset($result_row[$column])) {
		return $result_row[$column];
	}
	else {
		return false;
	}
}

/**
 * @param $query_result
 * @param $column
 * @return array|bool|null
 *
 * Add the query handle and the column of the result to be returned
 * if $column is set to (bool)true then entire row is retuned
 */
function query_row_by_name($query_result, $column) {
    $result_row=mysqli_fetch_assoc($query_result);
    if ($column === true) {
        return $result_row;
    }

    if (isset($result_row[$column])) {
        return $result_row[$column];
    }
    else {
        return false;
    }
}

function get_column_from_row($row, $column) {
    if (isset($row[$column])) {
        return $row[$column];
    }
    else {
        return false;
    }
    $column_data = $row[$column];
    return $column_data;
}

function tomi_fetch_array($query_result) {
    return mysqli_fetch_array($query_result);
}

function get_last_insert_id(){
	return mysqli_insert_id(database_connection::$_connection);
}

function tomi_number_of_rows($query_result) {
    $rows=mysqli_num_rows($query_result);
    return $rows;
}

function tomi_escape_string($string) {
    $connection = database_connection::db_connect();
    $escaped_string=mysqli_real_escape_string($connection, $string);
    return $escaped_string;
}