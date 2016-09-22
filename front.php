<html>
  <head>
    <link href="stylesheet.css" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="realtime.js"></script>
  </head>
  <body>
    <div id="Clock">
      <canvas id="analogClock" width="320" height="320"/>
      <script src="clock.js"></script>
    </div>
    <div id="Tasks">
      <div class="wrapper">
        <?php
          include_once("block-tasks.php");
          buildTasks();
        ?>
      </div>
    </div>
    <div id="Weather" class="block">
    </div>
    <div id="Notif">
      <div class="wrapper">
        <p id="NotifText">Testing text for future notification (41)</p>
      </div>
    </div>
  </body>
</html>
