<?php
class Task{
  private $html = "";
  public function __construct($row){
    $this->buildHtml($row["Title"],$row["Description"],$row["Created"],$row["ImageUrl"],$row["Completed"]);
  }
  private function buildHtml($title,$desc,$date,$imgurl,$completed){
    $margin = "0%";
    if($completed){
      $completed = "Done";
    }else{
      $completed = "Unfinished";
    }
    $innerHtml = "";
    if($imgurl != null){
      $innerHtml = $innerHtml."<div class='task_image wrapper'><img class='image' src='".$imgurl."'/></div>";
    }
    else{
      $margin = "3%";
    }
    $innerHtml = $innerHtml."<div class='text_panel' style='margin-left:".$margin."'><div class='task_header'><div class='task_title'><p>".$title."</p></div><div class='task_completed'><p>".$completed."</p></div></div>
    <div class='task_description'><p>".$desc."</p></div><div class='task_date'><p>".$date."</p></div>";
    $this->html = "<div class='task_card'>".$innerHtml."</div></div>";
  }
  public function getHtml(){
    return $this->html;
  }
}
function buildTasks(){
  require_once("db_control.php");
  $db_control = new Database_Control;
  $db_control->connect();
  $rows = $db_control->getRows("Tasks",null,null,"Created DESC",5);
  $db_control->disconnect();
  for($i = 0; $i < count($rows); $i++){
    $task = new Task($rows[$i]);
    echo $task->getHtml();
  }
}
?>
