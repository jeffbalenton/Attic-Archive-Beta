<?php
 $show_raw_import = true;
?>
<nav class="navbar navbar-expand-md navbar-dark bg-primary mt-2">
  <div class="container"> <a class="navbar-brand" href="#">Attic Archive</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item"> <a class="nav-link active" aria-current="page" href="#">Home</a> </li>
        <li class="nav-item"> <a class="nav-link" href="#">Link</a> </li>
        <li class="nav-item"> <a class="nav-link disabled">Disabled</a> </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
</div>
<main class="container bg-light p-5 rounded">
  <div class="row">
    <div class="col"></div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <h2>
        <?php esc_html_e( 'Upload a CSV file', 'acf-city-selector' ); ?>
      </h2>
      <form enctype="multipart/form-data" method="post" class="row">
        <input name="place_upload_csv_nonce" type="hidden" value="<?php echo wp_create_nonce( 'place-upload-csv-nonce' ); ?>" />
        <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
        <div class="mb-3">
          <label for="csv_upload" class="form-label">
            <?php esc_html_e( 'Choose a (CSV) file to upload', 'acf-city-selector' ); ?>
          </label>
          <input class="form-control" type="file" id="formFile">
        </div>
        <div class="mb-3">
          <button type="submit" class="btn btn-primary">
          <?php esc_html_e( 'Upload CSV', 'acf-city-selector' ); ?>
          </button>
        </div>
      </form>
      <hr>
  
      </div>
 
    </div>

</main>
