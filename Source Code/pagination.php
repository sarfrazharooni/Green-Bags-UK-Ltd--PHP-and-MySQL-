<?php 
/*
File Name:        pagination.php
Date Created:     3 April 2009
Author:           Sarfraz Ahmad
Purpose:          This file is used to implement an page navigation system.
Dependancy:       None
  
*/

?>

<?php
class Pagination {
	var $php_self;          // link to self page
	var $rows_per_page;     // Number of records to display per page
	var $total_rows;        // Total number of rows returned by the query
	var $links_per_page;    // Number of links to display per page
	var $sql;               // sql statement to execute
	var $debug = false;     // set debuging the page
	var $conn;              // connection to MySQL 
	var $page;              // current page number
	var $max_pages;         // total pages
	var $offset;            // offset between pages
	
	/**
	 * Constructor function with arguments
	 */
	function Pagination($connection, $sql, $rows_per_page = 10, $links_per_page = 5) {
		$this->conn = $connection;
		$this->sql = $sql;
		$this->rows_per_page = $rows_per_page;
		$this->links_per_page = $links_per_page;
		$this->php_self = htmlspecialchars($_SERVER['PHP_SELF']);
		
		if(isset($_GET['page'])) {
			$this->page = intval($_GET['page']);
		}
		
	}
	
	/**
	 * Executes the SQL query and initializes internal variables
	 */
	function paginate() {
		if(!$this->conn) {
			if($this->debug) echo "MySQL connection not found <br />";
			return false;
		}
		
		$all_rs = @mysql_query($this->sql);
		if(!$all_rs) {
			if($this->debug) echo "Query failed to execute. Check your query <br />";
			return false;
		}
		$this->total_rows = mysql_num_rows($all_rs);
		@mysql_close($all_rs);
		
		$this->max_pages = ceil($this->total_rows/$this->rows_per_page);
		// If someone clever, tries to show the page not in the 0 and last page, then set page to 1
		if($this->page > $this->max_pages || $this->page <= 0) {
			$this->page = 1;
		}
		
		//Calculate 0ffset
		$this->offset = $this->rows_per_page * ($this->page-1);
		
		//Fetch the required result set
		$rs = @mysql_query($this->sql." LIMIT {$this->offset}, {$this->rows_per_page}");
		if(!$rs) {
			if($this->debug) echo "Pagination failed. Please make sure query is ok.<br />";
			return false;
		}
		return $rs;
	}
	
	/**
	 * Display the link to the first page
	 */
	function renderFirst($tag='First') {
		if($this->page == 1) {
			return $tag;
		}
		else {
			return '<a href="'.$this->php_self.'?page=1">'.$tag.'</a>';
		}
	}
	
	/**
	 * Link to the last page
	 */
	function renderLast($tag='Last') {
		if($this->page == $this->max_pages) {
			return $tag;
		}
		else {
			return '<a href="'.$this->php_self.'?page='.$this->max_pages.'">'.$tag.'</a>';
		}
	}
	
	/**
	 * Link to next page
	 */
	function renderNext($tag=' &gt;&gt;') {
		if($this->page < $this->max_pages) {
			return '<a href="'.$this->php_self.'?page='.($this->page+1).'">'.$tag.'</a>';
		}
		else {
			return $tag;
		}
	}
	
	/**
	 * Link to previous page
	 */
	function renderPrev($tag='&lt;&lt;') {
		if($this->page > 1) {
			return '<a href="'.$this->php_self.'?page='.($this->page-1).'">'.$tag.'</a>';
		}
		else {
			return $tag;
		}
	}
	
	/**
	 * Display the page links
	 */
	function renderNav() {
		for($i=1;$i<=$this->max_pages;$i+=$this->links_per_page) {
			if($this->page >= $i) {
				$start = $i;
			}
		}
		
		if($this->max_pages > $this->links_per_page) {
			$end = $start+$this->links_per_page;
			if($end > $this->max_pages) $end = $this->max_pages+1;
		}
		else {
			$end = $this->max_pages;
		}
			
		$links = '';
		
		for( $i=$start ; $i<$end ; $i++) {
			if($i == $this->page) {
				$links .= " $i ";
			}
			else {
				$links .= ' <a href="'.$this->php_self.'?page='.$i.'">'.$i.'</a> ';
			}
		}
		
		return $links;
	}
	
	/**
	 * Display full pagination navigation
	 */
	function renderFullNav() {
		return $this->renderFirst().'&nbsp;'.$this->renderPrev().'&nbsp;' .
		       $this->renderNav().'&nbsp;'.$this->renderNext().'&nbsp;'.$this->renderLast();	
	}
	
	/**
	 * @param bool $debug Set to TRUE to enable debug messages
	 */
	function setDebug($debug) {
		$this->debug = $debug;
	}
}
?>