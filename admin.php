<?php
include('php/moderator.php');
if (! $moderators and ! $admins){
  echo 'You have not enabled moderators or admins. Do this by editing php/moderator.php and set at least one to true.';
  echo '<br><br>They are disabled by default for security reasons.';
  die(0);
}

if (! file_exists('php/staff.db')){
  touch("php/staff.db");
  class MyDB extends SQLite3 {
     function __construct() {
        $this->open('php/staff.db');
     }
  }
  $db = new MyDB();

  $sql =<<<EOF
     CREATE TABLE Staff
     (username text PRIMARY KEY NOT NULL,
      password text not null,
    rank text not null);
EOF;

  $ret = $db->exec($sql);
  if(!$ret){
     echo $db->lastErrorMsg();
  } else {
     echo "Table created successfully\n";
  }
  $db->close();
}
?>
