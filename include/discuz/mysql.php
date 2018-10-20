<?php
if(!defined('IN_SMSOT')) {
	exit;
}

class DZ {
	public static $dz;
  
	public static function star() {
    global $_S;
		self::$dz = new $_S['driver'];
		self::$dz->set_config($_S['db'],2);
		self::$dz->connect(2);
	}

	public static function object() {
		return self::$dz;
	}
	
	public static function table($table) {
		return self::$dz->table_name($table);
	}
	
	public static function delete($table, $where='',$limit=0,$unbuffered = true) {
		$limit = dintval($limit);
		$sql = "DELETE FROM " . self::table($table) . " WHERE $where " . ($limit > 0 ? "LIMIT $limit" : '');
		return self::query($sql, ($unbuffered ? 'UNBUFFERED' : ''));
	}
	
	public static function insert($table, $data, $return_insert_id = false, $replace = false, $silent = false) {

		$sql = self::implode($data);

		$cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';

		$table = self::table($table);
		$silent = $silent ? 'SILENT' : '';

		return self::query("$cmd $table SET $sql", null, $silent, !$return_insert_id);
	}
	
	public static function update($table, $data, $condition, $unbuffered = false, $low_priority = false) {
		$sql = self::implode($data);
		if(empty($sql)) {
			return false;
		}
		$cmd = "UPDATE " . ($low_priority ? 'LOW_PRIORITY' : '');
		$table = self::table($table);
		$where = '';
		if (empty($condition)) {
			$where = '1';
		} elseif (is_array($condition)) {
			$where = self::implode($condition, ' AND ');
		} else {
			$where = $condition;
		}
		$res = self::query("$cmd $table SET $sql WHERE $where", $unbuffered ? 'UNBUFFERED' : '');
		return $res;
	}
	
	public static function insert_id() {
		return self::$dz->insert_id();
	}

	public static function fetch($resourceid, $type = MYSQL_ASSOC) {
		return self::$dz->fetch_array($resourceid, $type);
	}

	public static function fetch_first($sql, $arg = array(), $silent = false) {
		$res = self::query($sql, $arg, $silent, false);
		$ret = self::$dz->fetch_array($res);
		self::$dz->free_result($res);
		return $ret ? $ret : array();
	}

	public static function fetch_all($sql, $arg = array(), $keyfield = '', $silent=false) {

		$data = array();
		$query = self::query($sql, $arg, $silent, false);
		while ($row = self::$dz->fetch_array($query)) {
			if ($keyfield && isset($row[$keyfield])) {
				$data[$row[$keyfield]] = $row;
			} else {
				$data[] = $row;
			}
		}
		self::$dz->free_result($query);
		return $data;
	}
	
	public static function result($resourceid, $row = 0) {
    return self::$dz->result($resourceid, $row);
	}

	public static function result_first($sql, $arg = array(), $silent = false) {
		$res = self::query($sql, $arg, $silent, false);
		$ret = self::$dz->result($res, 0);
		self::$dz->free_result($res);
		return $ret;
	}
	
	public static function query($sql, $arg = array(), $silent = false, $unbuffered = false) {
		if (!empty($arg)) {
			if (is_array($arg)) {
				$sql = self::format($sql, $arg);
			} elseif ($arg === 'SILENT') {
				$silent = true;

			} elseif ($arg === 'UNBUFFERED') {
				$unbuffered = true;
			}
		}

		$ret = self::$dz->query($sql, $silent, $unbuffered);
		if (!$unbuffered && $ret) {
			$cmd = trim(strtoupper(substr($sql, 0, strpos($sql, ' '))));
			if ($cmd === 'SELECT') {

			} elseif ($cmd === 'UPDATE' || $cmd === 'DELETE') {
				$ret = self::$dz->affected_rows();
			} elseif ($cmd === 'INSERT') {
				$ret = self::$dz->insert_id();
			}
		}
		return $ret;
	}
	
	public static function num_rows($resourceid) {
		return self::$dz->num_rows($resourceid);
	}

	public static function affected_rows() {
		return self::$dz->affected_rows();
	}

	public static function free_result($query) {
		return self::$dz->free_result($query);
	}
	
	
}

?>