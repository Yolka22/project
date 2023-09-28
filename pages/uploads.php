<h1>Uploads</h1>

<?php Message::show() ?>
<form action="/uploads" method="post" enctype="multipart/form-data">
  <input type="file" name="file">
  <input type="text" name="folder" placeholder="Название папки">
  <button class="btn btn-primary" name="action" value="uploadImage">Send</button>
</form>