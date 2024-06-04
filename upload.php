<?php

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
  <style>
    .clickable-image {
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="mt-5">Upload Picture</h2>
        <form id="uploadForm" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="picture" class="form-label">Select Picture</label>
            <input type="file" class="form-control" accept="image/png, image/gif, image/jpeg" id="picture" name="picture" required>
          </div>
          <button type="submit" class="btn btn-primary">Upload</button>
        </form>
        <div id="message" class="mt-3"></div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-12">
        <h2 class="mt-5">Picture Gallery</h2>
        <div id="gallery" class="row mt-4">
          <!-- Pictures will be loaded here -->
        </div>
      </div>
    </div>
    <!-- Modal HTML -->
    <div id="imageModal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <img id="modalImage" src="" class="img-fluid" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
<script type="text/javascript" src="./vendor/components/jquery/jquery.min.js"></script>
<script type="text/javascript" src="./vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    loadTmages();

    $("#uploadForm").submit(function (event) {
      event.preventDefault();
      var formData = new FormData(this);

      $.ajax({
        url: 'http://localhost/php-image-be/upload_handler.php/upload',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          if (response) {
            loadTmages();
            $("#message").html('<div class="alert alert-success">Upload successful!</div>');
          } else {
            $("#message").html('<div class="alert alert-danger">Upload failed</div>');
          }
        }
      });
    });
  });

  function loadTmages() {
    $.ajax({
      url: 'http://localhost/php-image-be/pictures_api.php/list',
      method: 'GET',
      success: function (data) {
        var gallery = $('#gallery');
        data.forEach(function (picture) {
          var mimeType = `image/${picture.extension}`;
          var pictureHtml = `
                    <div class="col-md-3">
                        <div class="card mb-4 shadow-sm">
                            <img src="data:${mimeType};base64,${picture.base64}" class="card-img-top clickable-image" alt="${picture.name}" data-name="${picture.name}" data-src="data:${mimeType};base64,${picture.base64}">
                            <div class="card-body">
                                <p class="card-text">${picture.name}</p>
                            </div>
                        </div>
                    </div>
                `;
          gallery.append(pictureHtml);
        });

        // Add click event listener to the images
        $('.clickable-image').on('click', function () {
          var imageName = $(this).data('name');
          var imageSrc = $(this).data('src');

          $('#modalTitle').text(imageName);
          $('#modalImage').attr('src', imageSrc);

          $('#imageModal').modal('show');
        });
      },
      error: function () {
        alert('Failed to load pictures');
      }
    });
  }
</script>