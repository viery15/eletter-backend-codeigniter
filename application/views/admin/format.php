<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet"> -->
    <link  rel="stylesheet" href="<?= base_url() ?>css/bootstrap.min.css"/>
    <link  rel="stylesheet" href="<?= base_url() ?>font-awesome/css/font-awesome.min.css"/>
    <!-- <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet"> -->
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.8/dist/vue.js"></script>
    <script src="https://unpkg.com/vuex@3.1.0/dist/vuex.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://cdn.jsdelivr.net/npm/vee-validate@latest/dist/vee-validate.js"></script>
    <script src="//cdn.ckeditor.com/4.11.3/full/ckeditor.js"></script>

    <title>e-Letter</title>
  </head>
  <body>
    <!--Navbar-->
    <?php $this->load->view('admin/partials/navbar.php') ?>
    <!--/.Navbar-->

    <div id="app">
      <div class="container" style="max-width:93%">

        <br /><br /><br />
        <textarea id="format" rows="10" cols="80"></textarea>
      </div>
    </div>
  </body>
</html>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="<?= base_url() ?>frontend/format.js"></script>
<script>
  // Replace the <textarea id="editor1"> with a CKEditor
  // instance, using default configuration.
  CKEDITOR.replace( 'format' );
</script>
