<?php
include('php/csrf.php');

function setInnerHTML($element, $html) {
    $fragment = $element->ownerDocument->createDocumentFragment();
    $fragment->appendXML($html);
    while ($element->hasChildNodes())
        $element->removeChild($element->firstChild);
    $element->appendChild($fragment);
}


function deleteReply($thread, $id){
  $doc = new DOMDocument;

  $doc->loadHTML(mb_convert_encoding(file_get_contents($thread), 'HTML-ENTITIES', 'UTF-8'));
  $reply = $doc->getElementById($id);

  while ($reply->hasChildNodes()){
       $reply->removeChild($reply->firstChild);
  }
  $new = $doc->createElement('p', 'This reply has been removed by a site admin');
  $reply->setAttribute('class', 'deletedPost');
  $reply->appendChild($new);
  file_put_contents($thread, nl2br($doc->saveHTML(), false));
}

if ($_POST['CSRF'] != $_SESSION['CSRF']){
  die('Invalid csrf');
}


  $thread = $_POST['thread'];
  $threadID = str_replace('\\', '', str_replace('/', '', $thread));
  $threadFile = 'posts/' . $threadID . '.html';
  $replyID = 'cont-' . $_POST['replyID'];
  deleteReply($threadFile, $replyID);
  $previous = "javascript:history.go(-1)";
  if(isset($_SERVER['HTTP_REFERER'])) {
      $previous = $_SERVER['HTTP_REFERER'];
  }

  echo 'deleted reply<br><a href="' . $previous . '">go back</a>';

?>
