<?php
class Database_Control{
  protected $conn = null;
  private $return = array();
  public function __construct(){

  }
  public function connect(){
    if (!defined('PDO::ATTR_DRIVER_NAME'))
      error_log( 'PDO driver unavailable');
    try{
      $this->conn = new PDO('mysql:host=n1plcpnl0058.prod.ams1.secureserver.net; dbname=ProjectMirror', 'atanti98', 'testing123');
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
      error_log( "Connection failed:".$e->getMessage()."");
    }
  }
  public function addToReturn($key,$value){
    $this->return[$key] = $value;
  }
  public function disconnect(){
    $this->conn = null;
  }
  public function getRows($table, $column, $value, $order, $limit){
    $sql = "SELECT * FROM ".$table;
    if($column != null && $value != null){
      $sql = $sql." WHERE ".$column." = :value";
    }
    if($order != null){
      $sql = $sql." ORDER BY ".$order;
    }
    if($limit != null){
      $sql = $sql." LIMIT ".$limit;
    }
    $result = $this->conn->prepare($sql);
    if($column != null && $value != null){
      $result->bindParam(":value", $value, PDO::PARAM_STR);
    }
    $result->execute();
    $results = $result->fetchAll(PDO::FETCH_ASSOC);
    if($result){
      return $results;
    }
    else{
      error_log("SQL_SEARCH_FAIL: SQL search for ".strtoupper($field)." using ".strtoupper($column)." = ".strtoupper($value).";");
      return null;
    }
  }
  public function getField($table, $column, $value, $field, $order, $limit){
    $results = $this->getRows($table,$column,$value,$order,$limit);
    if($results != null){
      return $results[$field];
    }
    return null;
  }
  public function checkExists($table, $column, $value){
    if(!empty($this->getField($table,$column,$value,$column,null,1))){
      return true;
    }
    else{
      return false;
    }
  }
  public function insertRecord($table,$columns,$array){
    $sql = "INSERT INTO ".$table."";
    $table_columns = "(";
    $table_column_values = "(";
    for($i = 0; $i < count($columns); $i++){
      $table_columns = $table_columns.$columns[$i].",";
      $table_column_values = $table_column_values.":value".$i.",";
    }
    $table_columns = substr($table_columns,0,strlen($table_columns)-1);
    $table_column_values = substr($table_column_values,0,strlen($table_column_values)-1);
    $sql = $sql.$table_columns.") VALUES ".$table_column_values.")";
    $result = $this->conn->prepare($sql);
    for($i = 0; $i < count($array); $i++){
      $result->bindParam(":value".$i,$array[$i],PDO::PARAM_STR);
    }
    $result->execute();
  }
}
?>
