<nav class="navbar navbar-expand-lg navbar-dark primary-color" style="background-color:#0D7FC1; color:white">

  <!-- Navbar brand -->
  <a class="navbar-brand" href="#">e-Letter</a>

  <!-- Collapse button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
    aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Collapsible content -->
  <div class="collapse navbar-collapse" id="basicExampleNav">

    <!-- Links -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url() ?>admin/component">Component</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url() ?>admin/format">Format</a>
      </li>

    </ul>
    <!-- Links -->

    <form class="form-inline">
      <div class="md-form my-0">
        <a href="#" style="color:white"><i class="fa fa-sign-out"> Logout</i></a>
      </div>
    </form>
  </div>
  <!-- Collapsible content -->
</nav>
