<?

	class sql{
		var $connection;
		var $connectioninfo;
		var $queries;
		var $error;
	
			
		function sql(){
			global $config;
			$this->connectioninfo=$config['sql'];
			$this->connect();			
		}
	
		
		function connect(){
			$this->connection=@mysql_connect($this->connectioninfo['host'],$this->connectioninfo['user'],$this->connectioninfo['pass'])  or $this->add_error(@mysql_error($this->connection));
			@mysql_select_db($this->connectioninfo['name'],$this->connection)  or $this->add_error(@mysql_error($this->connection));
			
		}
	

		function query($string){
			$string=str_replace("[prefix]",$_COOKIE['klant']."_",$string);
			$query=@mysql_query($string,$this->connection) or $this->add_error(@mysql_error($this->connection));
			$this->queries++;
			return $query;
		}
			
		
		function fetch($query){
			$fetch=@mysql_fetch_assoc($query) ;
			return $fetch;
		}
		function fetch_object($query){
			$fetch=@mysql_fetch_object($query) ;
			return $fetch;
		}
	

		function result($query){
			$fetch=$this->fetch($this->query($query));
			return $fetch;
		}
	
			
		function aantal($query){
			$aant=@mysql_num_rows($query);
			return $aant;
		}
		
	
		
		function add_error($fout){
			global $error;
			$error->add('Er is een fout opgetreden met de database','database',$fout);
		}
			
		function goRow($query,$row){
			return @mysql_data_seek($query,$row,$this->connection);
		}
		
	}
	$sql=new sql;
	
	

?>
