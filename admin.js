function deletePost(post){
  var url = "admin.php";
  var csrf = document.getElementById('CSRF').value;
  var params = "post=" + post + "&delete=true&csrf=" + csrf;
  var xhr = new XMLHttpRequest();

  xhr.open("POST", url, true);

  //Send the proper header information along with the request
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function() {
      if (xhr.readyState == XMLHttpRequest.DONE ) {
         if (xhr.status == 200) {
             alert('Thread deleted');
             var toDelete = document.getElementById(post);
             toDelete.innerHTML = "";
             toDelete.style.display = "none";
             delete toDelete;
         }
         else{
           alert('An error happened while deleting the thread.');
         }
      }
  };

  xhr.send(params);


}
