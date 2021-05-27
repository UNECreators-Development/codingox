<?php

/**
 * CodingOx
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author		Satyendra Sagar Singh
 * @license		https://opensource.org/licenses/MIT	MIT License
 * @link		http://framework.upgradeads.in
 * @since		Version 1.0.0
 * @filesource
 **/

defined('APP_PATH') or exit('No direct script access allowed');

require_once("database.php");

/* This is database query builder */

class QueryBuilder extends Database
{
	/* Global variables */
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

	protected $prefix;

	/**
	 * Class constructor
	 * @param	string $arg
	 * @return	object Database Connection
	 **/
	public function __construct($arg)
	{
		$this->DBConnection($arg);
		mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
		$this->db = $arg == '' ? $this->default : $this->{$arg};
	}

	/**
	 * @return	string Database Query
	 **/
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

	/**
	 * Database Query
	 * @param	string $query
	 * @return	string
	 **/
	public function query(string $query, $bind = NULL): self
	{
		if ($bind != NULL && is_array($bind)) {
			$bindArray = array();
			$query = array_values(array_filter(explode('?', $query)));

			foreach ($query as $key => $value) {
				$bindArray[] = "{$value} '{$bind[$key]}'";
			}

			$this->query = implode('', $bindArray);
		} else {			
			$this->query = $query;
		}
		
		return $this;
	}

	/**
	 * Insert data
	 * @param	string 	$table (table name)
	 * @param	array 	$arg (data to insert)
	 * @return	string
	 **/
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

	/**
	 * Alias of insert(string $table, $arg)
	 * @param	string 	$table (table name)
	 * @param	array 	$arg (data to insert)
	 * @return	string
	 **/
	public function set(string $table, $arg): self
	{
		$this->insert($table, $arg);
		return $this;
	}

	/**
	 * Insert multiple data
	 * @param	string 	$table (table name)
	 * @param	array 	$arg (data to insert)
	 * @return	string
	 **/
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

	/**
	 * Alias of update(string $table, $arg, ...$condition)
	 * @param	string 					$table (table name)
	 * @param	array 					$arg (data to update)
	 * @param	string|array|(optional) $condition (condition)
	 * @return	string
	 **/
	public function edit(string $table, $arg, $condition = null): self
	{
		$this->update($table, $arg, $condition);
		return $this;
	}

	/**
	 * Update data
	 * @param	string 					$table (table name)
	 * @param	array 					$arg (data to update)
	 * @param	string|array|(optional) $condition (condition)
	 * @return	string
	 **/
	public function update(string $table, $arg, ...$condition): self
	{
		$i = 0;
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
			$this->where(...$condition);
			$this->query = "UPDATE {$table} SET {$field}";
		else :
			$this->query = "UPDATE {$table} SET {$field}";
		endif;

		return $this;
	}

	/**
	 * Delete data
	 * @param	string 					$table (table name)
	 * @param	string|array|(optional) $arg (condition)
	 * @return	string
	 **/
	public function delete(string $table, ...$arg): self
	{
		if ($arg != null) :
			$this->where(...$arg);
			$this->query = "DELETE FROM {$table}";
		else :
			$this->query = "DELETE FROM {$table}";
		endif;

		return $this;
	}

	/**
	 * Truncate table
	 * @param	string	$table (table name)
	 * @return	string
	 **/
	public function truncate(string $table): self
	{
		$this->query = "TRUNCATE TABLE {$table}";
		return $this;
	}

	/**
	 * Fetch data
	 * @param	string|(optional)	$table (table name)
	 * @return	string
	 **/
	public function get(string ...$table): self
	{
		if ($table != null) :
			$this->select('*')->from(...$table);
			return $this;
		else :
			return $this;
		endif;
	}

	/**
	 * Fetch specific data
	 * @param	string					$table (table name)
	 * @param	string|array|(optional)	$arg (condition)
	 * @return	string
	 **/
	public function get_where(string $table, $arg = null): self
	{
		$this->select('*')->from($table)->where($arg);
		return $this;
	}

	/**
	 * Select fields
	 * @param	string	$fields (table column)
	 * @return	string
	 **/
	public function select(string ...$fields): self
	{
		$this->fields = implode(', ', $fields);
		return $this;
	}

	/**
	 * Fetch maximum value
	 * @param	string	$fields (table column)
	 * @return	string
	 **/
	public function selectMax(string ...$fields): self
	{
		$this->fields = "MAX(" . implode(', ', $fields) . ") as " . implode(', ', $fields);
		return $this;
	}

	/**
	 * Fetch minimum value
	 * @param	string	$fields (table column)
	 * @return	string
	 **/
	public function selectMin(string ...$fields): self
	{
		$this->fields = "MIN(" . implode(', ', $fields) . ") as " . implode(', ', $fields);
		return $this;
	}

	/**
	 * Fetch average value
	 * @param	string	$fields (table column)
	 * @return	string
	 **/
	public function selectAvg(string ...$fields): self
	{
		$this->fields = "AVG(" . implode(', ', $fields) . ") as " . implode(', ', $fields);
		return $this;
	}

	/**
	 * Fetch sum of column value
	 * @param	string	$fields (table column)
	 * @return	string
	 **/
	public function selectSum(string ...$fields): self
	{
		$this->fields = "SUM(" . implode(', ', $fields) . ") as " . implode(', ', $fields);
		return $this;
	}

	/**
	 * Fetch count of column value
	 * @param	string	$fields (table column)
	 * @return	string
	 **/
	public function selectCount(string ...$fields): self
	{
		$this->fields = "COUNT(" . implode(', ', $fields) . ") as " . implode(', ', $fields);
		return $this;
	}

	/**
	 * Table Name
	 * @param	string	$from (table name)
	 * @return	string
	 **/
	public function from(string ...$from): self
	{
		$this->from = implode(', ', $from);
		return $this;
	}

	/**
	 * Alias of from(string ...$from)
	 * @param	string	$table (table name)
	 * @return	string
	 **/
	public function table(string ...$table): self
	{
		$this->from = implode(', ', $table);
		return $this;
	}

	/**
	 * Condition
	 * @param	string|array	$where (condition)
	 * @return	string
	 **/
	public function where(...$where): self
	{
		$condition = array();
		if (is_array($where[0])) {
			foreach ($where[0] as $key => $value) {
				$condition[] = "{$key} = '{$value}'";
			}
		} else {
			foreach ($where as $arg) {
				$condition[] = $arg;
			}
		}

		$this->where = implode(' AND ', $condition);
		return $this;
	}

	/**
	 * Add more condition
	 * @param	string	$where (condition)
	 * @return	string
	 **/
	public function andWhere(string ...$where): self
	{
		$condition = array();

		foreach ($where as $arg) {
			$condition[] = $arg;
		}

		$this->where = $this->where . " AND " . implode(' AND ', $condition);
		return $this;
	}

	/**
	 * Add more condition
	 * @param	string	$where (condition)
	 * @return	string
	 **/
	public function orWhere(string ...$where): self
	{
		$condition = array();

		foreach ($where as $arg) {
			$condition[] = $arg;
		}

		$this->where = $this->where . " OR " . implode(' AND ', $condition);
		return $this;
	}

	/**
	 * Join
	 * @param	string	$table (table name)
	 * @param	string	$join (condition)
	 * @return	string
	 **/
	public function join(string $table, string ...$join): self
	{
		$this->join = "JOIN {$table} ON " . implode(' AND ', $join);
		return $this;
	}

	/**
	 * Join
	 * @param	string	$table (table name)
	 * @param	string	$join (condition)
	 * @return	string
	 **/
	public function andJoin(string $table, string ...$join): self
	{
		$this->join = $this->join . " JOIN {$table} ON " . implode(' AND ', $join);
		return $this;
	}

	/**
	 * Inner Join
	 * @param	string	$table (table name)
	 * @param	string	$join (condition)
	 * @return	string
	 **/
	public function innerJoin(string $table, string ...$join): self
	{

		$this->join = "INNER JOIN {$table} ON " . implode(' AND ', $join);
		return $this;
	}

	/**
	 * Inner Join
	 * @param	string	$table (table name)
	 * @param	string	$join (condition)
	 * @return	string
	 **/
	public function andInnerJoin(string $table, string ...$join): self
	{
		$this->join = $this->join . " INNER JOIN {$table} ON " . implode(' AND ', $join);
		return $this;
	}

	/**
	 * Left Join
	 * @param	string	$table (table name)
	 * @param	string	$join (condition)
	 * @return	string
	 **/
	public function leftJoin(string $table, string ...$join): self
	{
		$this->join = "LEFT JOIN {$table} ON " . implode(' AND ', $join);
		return $this;
	}

	/**
	 * Left Join
	 * @param	string	$table (table name)
	 * @param	string	$join (condition)
	 * @return	string
	 **/
	public function andLeftJoin(string $table, string ...$join): self
	{
		$this->join = $this->join . " LEFT JOIN {$table} ON " . implode(' AND ', $join);
		return $this;
	}

	/**
	 * Right Join
	 * @param	string	$table (table name)
	 * @param	string	$join (condition)
	 * @return	string
	 **/
	public function rightJoin(string $table, string ...$join): self
	{
		$this->join = "RIGHT JOIN {$table} ON " . implode(' AND ', $join);
		return $this;
	}

	/**
	 * Right Join
	 * @param	string	$table (table name)
	 * @param	string	$join (condition)
	 * @return	string
	 **/
	public function andRightJoin(string $table, string ...$join): self
	{
		$this->join = $this->join . " RIGHT JOIN {$table} ON " . implode(' AND ', $join);
		return $this;
	}

	/**
	 * Get limited data
	 * @param	string	$limit
	 * @return	string
	 **/
	public function limit(string ...$limit): self
	{
		$this->limit = implode(', ', $limit);
		return $this;
	}

	/**
	 * Fetch related data
	 * @param	string	$like (condition)
	 * @return	string
	 **/
	public function like(...$like): self
	{
		$this->like = "{$like[0]} LIKE '%{$like[1]}%'";
		return $this;
	}

	/**
	 * And Like
	 * @param	string	$like (condition)
	 * @return	string
	 **/
	public function andLike(...$like): self
	{
		$this->like = $this->like . " AND {$like[0]} LIKE '%{$like[1]}%'";
		return $this;
	}

	/**
	 * Or Like
	 * @param	string	$like (condition)
	 * @return	string
	 **/
	public function orLike(...$like): self
	{
		$this->like = $this->like . " OR {$like[0]} LIKE '%{$like[1]}%'";
		return $this;
	}

	/**
	 * Not Like
	 * @param	string	$like (condition)
	 * @return	string
	 **/
	public function notLike(...$like): self
	{
		$this->like = "{$like[0]} NOT LIKE '%{$like[1]}%'";
		return $this;
	}

	/**
	 * Or Not Like
	 * @param	string	$like (condition)
	 * @return	string
	 **/
	public function orNotLike(...$like): self
	{
		$this->like = $this->like . " OR {$like[0]} NOT LIKE '%{$like[1]}%'";
		return $this;
	}

	/**
	 * Fetch Sorted data
	 * @param	string	$order (sort order)
	 * @return	string
	 **/
	public function orderBy(string ...$order): self
	{
		$this->order = implode(' ', $order);
		return $this;
	}

	/**
	 * Count column data or table rows
	 * @param	string|(optional)	$field (table column)
	 * @return	string|int
	 **/
	public function count(string ...$field)
	{
		if ($field != null) :
			$this->fields = "COUNT(" . implode(', ', $field) . ") as " . implode(', ', $field);
			return $this;
		else :
			if ($this->prepare($this)) {
				$result = $this->db->query($this);
				return mysqli_num_rows($result);
			}
		endif;
	}
	
	/**
	 * Count fields in query result
	 * @return	int
	 */
	public function field_count()
	{
		if ($this->prepare($this)) {
			$result = $this->db->query($this);
			return mysqli_num_fields($result);
		}
	}
	
	/**
	 * Offset data from query result
	 * @param	int $offset
	 * @return	bool
	 */
	public function offset(int $offset)
	{
		if ($this->prepare($this)) {
			$result = $this->db->query($this);
			return mysqli_data_seek($result);
		}
	}

	/**
	 * Group By Clause
	 * @param	string	$group (table column)
	 * @return	string
	 **/
	public function groupBy(string ...$group): self
	{
		$this->group = implode(', ', $group);
		return $this;
	}

	/**
	 * Execute query for get table row
	 * @return	array
	 **/
	public function findOne()
	{
		if ($this->prepare($this)) {
			$result = $this->db->query($this);
			return mysqli_fetch_assoc($result);
		}
	}

	/**
	 * Execute query for get all table row
	 * @return	array
	 **/
	public function findAll()
	{
		if ($this->prepare($this)) {
			$resultArray = array();
			$result = $this->db->query($this);

			while ($row = mysqli_fetch_array($result)) {
				$resultArray[] = $row;
			}
			return $resultArray;
		}
	}

	/**
	 * Execute query for get table row
	 * @return	array
	 **/
	public function findRow()
	{
		if ($this->prepare($this)) {
			$result = $this->db->query($this);
			return mysqli_fetch_row($result);
		}
	}

	/**
	 * Execute query for get table row object
	 * @return	array|object
	 **/
	public function findObject()
	{
		if ($this->prepare($this)) {
			$result = $this->db->query($this);
			return mysqli_fetch_object($result);
		}
	}

	/**
	 * Find last inserted id
	 * @return	int
	 **/
	public function findLastId()
	{
		return mysqli_insert_id($this->id);
	}

	/**
	 * Find affected row in table
	 * @return	int
	 **/
	public function affectedRow()
	{
		return mysqli_affected_rows($this->db);
	}

	/**
	 * Prepare query for execute
	 * @return	object
	 **/
	public function prepare()
	{
		try {
			return mysqli_prepare($this->db, $this);
		} catch (mysqli_sql_exception $ex) {
			$dbError = $ex->getTrace();

			$query = null;
			foreach ($dbError[0]['args'] as $key => $value) {
				if (!is_object($value)) {
					$query .= $value;
				}
			}

			unset($dbError[array_key_last($dbError)]);
			unset($dbError[array_key_last($dbError)]);
			unset($dbError[array_key_first($dbError)]);
			unset($dbError[array_key_first($dbError)]);
			$dbError = array_values(array_filter($dbError));

			$query = $query == null ? '' : "(<i class='text-info'>" . trim($query) . "</i>)";
			$errorMsg = "{$ex->getMessage()} {$query}";
			$errorMsg .= " in <b>{$dbError[0]['file']}</b> on line <b class='text-danger'>{$dbError[0]['line']}</b>";
			errorHandler(E_USER_WARNING, $errorMsg, null, null, null);
		}
	}

	/**
	 * Execute query to find result
	 * @return	bool|object
	 **/
	public function execute()
	{
		if ($this->prepare($this)) {
			return $this->db->query($this);
		}
	}

	/**
	 * Set Database Prefix
	 * @param	string $prefix
	 * @return	void
	 */
	public function set_prefix(string $prefix)
	{
		$this->prefix = trim($prefix);
	}

	/**
	 * Get Database With Prefix
	 * @param	string $table
	 * @return	string
	 */
	public function prefix(string $table)
	{
		return $this->prefix . $table;
	}

	/**
	 * Re-Connect database connection
	 * @return	bool
	 */
	public function reconnect()
	{
		return mysqli_ping($this->db);
	}

	/**
	 * Close database connection
	 * @return	bool
	 */
	public function close()
	{
		return mysqli_close($this->db);
	}
}
