<?php
require_once("database.php");

class QueryBuilder extends Database
{
	protected $db;

	protected $from;

	protected $like;

	protected $join;

	protected $limit;

	protected $where;

	protected $group;

	protected $order;

	protected $query;

	protected $fields;

	public function __construct($arg)
	{
		$this->DBConnection($arg);
		$this->db = $arg == '' ? $this->default : $this->{$arg};
	}

	public function __toString(): string
	{
		$join = $this->join == null ? "" : "{$this->join}";
		$field = $this->fields == null ? "*" : "{$this->fields}";
		$where = $this->where == null ? "" : " WHERE {$this->where}";
		$limit = $this->limit == null ? "" : " LIMIT {$this->limit}";
		$group = $this->group == null ? "" : " GROUP BY {$this->group}";
		$order = $this->order == null ? "" : " ORDER BY {$this->order}";
		$where == "" ? $like = $this->like == null ? "" : " WHERE {$this->like}" : $like = $this->like == null ? "" : " AND {$this->like}";

		$this->query == null ? $return = "SELECT {$field} FROM {$this->from} {$join} {$where} {$like} {$group} {$order} {$limit}" : $return = "{$this->query} {$where}";
		return $return;
	}

	public function query(string $query): self
	{
		$this->query = $query;
		return $this;
	}

	public function insert(string $table, $arg): self
	{
		$i = 0;
		$value = "";
		$column = "";
		$key = array_keys($arg);

		foreach ($arg as $row) : $i++;
			if (sizeof($arg) > $i) :
				$value .= "'$row', ";
				$column .= $key[$i - 1] . ", ";
			else :
				$value .= "'$row'";
				$column .= $key[$i - 1];
			endif;
		endforeach;

		$this->query = "INSERT INTO {$table} ($column) VALUES ($value)";
		return $this;
	}

	public function set(string $table, $arg): self
	{
		$this->insert($table, $arg);
		return $this;
	}

	public function insertBatch(string $table, $arg): self
	{
		$i = 0;
		$j = 0;
		$value = "";
		$column = "";
		$key = array_keys($arg[0]);

		foreach ($key as $row) : $i++;
			if (sizeof($key) > $i) :
				$column .= $key[$i - 1] . ", ";
			else :
				$column .= $key[$i - 1];
			endif;
		endforeach;

		foreach ($arg as $val) : $i = 0;
			$j++;
			if (sizeof($arg) > $j) :
				$value .= "(";
				foreach ($val as $row) : $i++;
					if (sizeof($val) > $i) :
						$value .= "'$row', ";
					else :
						$value .= "'$row'";
					endif;
				endforeach;
				$value .= "), ";
			else :
				$value .= "(";
				foreach ($val as $row) : $i++;
					if (sizeof($val) > $i) :
						$value .= "'$row', ";
					else :
						$value .= "'$row'";
					endif;
				endforeach;
				$value .= ")";
			endif;
		endforeach;

		$this->query = "INSERT INTO {$table} ($column) VALUES {$value}";
		return $this;
	}

	public function edit(string $table, $arg, $condition = null): self
	{
		$this->update($table, $arg, $condition);
		return $this;
	}

	public function update(string $table, $arg, $condition = null): self
	{
		$i = 0;
		$cnd = "";
		$field = "";
		$key = array_keys($arg);

		foreach ($arg as $row) : $i++;
			if (sizeof($arg) > $i) :
				$field .= $key[$i - 1] . " = " . "'$row', ";
			else :
				$field .= $key[$i - 1] . " = " . "'$row'";
			endif;
		endforeach;

		if ($condition != null) :
			$i = 0;
			$key = array_keys($condition);
			foreach ($condition as $row) : $i++;
				if (sizeof($condition) > $i) {
					$cnd .= $key[$i - 1] . " = " . "'$row' AND ";
				} else {
					$cnd .= $key[$i - 1] . " = " . "'$row'";
				}
			endforeach;
		endif;

		if ($condition != null) :
			$this->query = "UPDATE {$table} SET {$field} WHERE {$cnd}";
		else :
			$this->query = "UPDATE {$table} SET {$field}";
		endif;

		return $this;
	}

	public function delete(string $table, $arg = null): self
	{
		if ($arg != null) :
			$i = 0;
			$cnd = "";
			$key = array_keys($arg);

			foreach ($arg as $row) : $i++;
				if (sizeof($arg) > $i) :
					$cnd .= $key[$i - 1] . " = " . "'$row' AND ";
				else :
					$cnd .= $key[$i - 1] . " = " . "'$row'";
				endif;
			endforeach;
		endif;

		if ($arg != null) :
			$this->query = "DELETE FROM {$table} WHERE {$cnd}";
		else :
			$this->query = "DELETE FROM {$table}";
		endif;

		return $this;
	}

	public function truncate(string $table): self
	{
		$this->query = "TRUNCATE TABLE {$table}";
		return $this;
	}

	public function get(string ...$table): self
	{
		if ($table != null) :
			$this->select('*')->from(...$table);
			return $this;
		else :
			return $this;
		endif;
	}

	public function get_where(string $table, $arg): self
	{
		$i = 0;
		$condition = "";
		$key = array_keys($arg);

		foreach ($arg as $row) : $i++;
			if (sizeof($arg) > $i) :
				$condition .= $key[$i - 1] . " = " . "'$row' AND ";
			else :
				$condition .= $key[$i - 1] . " = " . "'$row'";
			endif;
		endforeach;

		$this->select('*')->from($table)->where($condition);
		return $this;
	}

	public function select(string ...$fields): self
	{
		$this->fields = implode(', ', $fields);
		return $this;
	}

	public function selectMax(string ...$fields): self
	{
		$this->fields = "MAX(" . implode(', ', $fields) . ") as " . implode(', ', $fields);
		return $this;
	}

	public function selectMin(string ...$fields): self
	{
		$this->fields = "MIN(" . implode(', ', $fields) . ") as " . implode(', ', $fields);
		return $this;
	}

	public function selectAvg(string ...$fields): self
	{
		$this->fields = "AVG(" . implode(', ', $fields) . ") as " . implode(', ', $fields);
		return $this;
	}

	public function selectSum(string ...$fields): self
	{
		$this->fields = "SUM(" . implode(', ', $fields) . ") as " . implode(', ', $fields);
		return $this;
	}

	public function selectCount(string ...$fields): self
	{
		$this->fields = "COUNT(" . implode(', ', $fields) . ") as " . implode(', ', $fields);
		return $this;
	}

	public function from(string ...$from): self
	{
		$this->from = implode(', ', $from);
		return $this;
	}

	public function table(string ...$table): self
	{
		$this->from = implode(', ', $table);
		return $this;
	}

	public function where(string ...$where): self
	{
		$condition = array();
		if ($this->where != null) :
			foreach ($where as $arg) {
				$condition[] = $arg;
			}

			$this->where = $this->where . " AND " . implode(' AND ', $condition);
			return $this;
		else :
			foreach ($where as $arg) {
				$condition[] = $arg;
			}

			$this->where = implode(' AND ', $condition);
			return $this;
		endif;
	}

	public function orWhere(string ...$where): self
	{
		$condition = array();
		if ($this->where != null) :
			foreach ($where as $arg) {
				$condition[] = $arg;
			}

			$this->where = $this->where . " OR " . implode(' AND ', $condition);
			return $this;
		else :
			foreach ($where as $arg) {
				$condition[] = $arg;
			}

			$this->where = implode(' AND ', $condition);
			return $this;
		endif;
	}

	public function join(string $table, string ...$join): self
	{
		if ($this->join != null) :
			$this->join = $this->join . " JOIN {$table} ON " . implode(' AND ', $join);
			return $this;
		else :
			$this->join = "JOIN {$table} ON " . implode(' AND ', $join);
			return $this;
		endif;
	}

	public function innerJoin(string $table, string ...$join): self
	{
		if ($this->join != null) :
			$this->join = $this->join . " INNER JOIN {$table} ON " . implode(' AND ', $join);
			return $this;
		else :
			$this->join = "INNER JOIN {$table} ON " . implode(' AND ', $join);
			return $this;
		endif;
	}

	public function leftJoin(string $table, string ...$join): self
	{
		if ($this->join != null) :
			$this->join = $this->join . " LEFT JOIN {$table} ON " . implode(' AND ', $join);
			return $this;
		else :
			$this->join = "LEFT JOIN {$table} ON " . implode(' AND ', $join);
			return $this;
		endif;
	}

	public function rightJoin(string $table, string ...$join): self
	{
		if ($this->join != null) :
			$this->join = $this->join . " RIGHT JOIN {$table} ON " . implode(' AND ', $join);
			return $this;
		else :
			$this->join = "RIGHT JOIN {$table} ON " . implode(' AND ', $join);
			return $this;
		endif;
	}

	public function limit(string ...$limit): self
	{
		$this->limit = implode(', ', $limit);
		return $this;
	}

	public function like(...$like): self
	{
		if ($this->like != null) :
			$this->like = $this->like . " AND {$like[0]} LIKE '%{$like[1]}%'";
			return $this;
		else :
			$this->like = "{$like[0]} LIKE '%{$like[1]}%'";
			return $this;
		endif;
	}

	public function orLike(...$like): self
	{
		if ($this->like != null) :
			$this->like = $this->like . " OR {$like[0]} LIKE '%{$like[1]}%'";
			return $this;
		else :
			$this->like = "{$like[0]} LIKE '%{$like[1]}%'";
			return $this;
		endif;
	}

	public function notLike(...$like): self
	{
		if ($this->like != null) :
			$this->like = $this->like . " AND {$like[0]} NOT LIKE '%{$like[1]}%'";
			return $this;
		else :
			$this->like = "{$like[0]} NOT LIKE '%{$like[1]}%'";
			return $this;
		endif;
	}

	public function orNotLike(...$like): self
	{
		if ($this->like != null) :
			$this->like = $this->like . " OR {$like[0]} NOT LIKE '%{$like[1]}%'";
			return $this;
		else :
			$this->like = "{$like[0]} NOT LIKE '%{$like[1]}%'";
			return $this;
		endif;
	}

	public function orderBy(string ...$order): self
	{
		$this->order = implode(' ', $order);
		return $this;
	}

	public function count(string ...$field)
	{
		if ($field != null) :
			$this->fields = "COUNT(" . implode(', ', $field) . ") as " . implode(', ', $field);
			return $this;
		else :
			$result = $this->db->query($this);
			return mysqli_num_rows($result);
		endif;
	}

	public function groupBy(string ...$group): self
	{
		$this->group = implode(', ', $group);
		return $this;
	}

	public function findOne()
	{
		$result = $this->db->query($this);
		return mysqli_fetch_assoc($result);
	}

	public function findAll()
	{
		$result = $this->db->query($this);
		return mysqli_fetch_array($result);
	}

	public function execute()
	{
		return $this->db->query($this);
	}
}
