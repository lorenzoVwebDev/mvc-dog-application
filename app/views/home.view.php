<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MVC-dog-application</title>
  <script src="<?=ROOT?>public/assets/bootstrap.assets/js/color-modes.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/headers/">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
  <link href="<?=ROOT?>public/assets/bootstrap.assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?=ROOT?>public/assets/css/home.css"/>
  <link rel="stylesheet" href="<?=ROOT?>public/assets/css/common.css"/>
</head>
<body>
  <section class="git-header-section"></section>
  <section class="main-header">
  </section>
  <section class="main-section">
    <div class="welcome-container">
      <div class="wcontainer-left">
        <h1>Welcome to the Dog Creation Center</h1>
        <p>Here you can create a new Dog or modify your previoulsy created ones. Moreover, you have the opportunity to manage logs and send them to your email as a table!</p>
        <button class="start-creation-button"><a href="<?=ROOT?>public/admin/dashboard/dashboard">Start Your Creation Now!</a></button>
      </div>
      <div class="wcontainer-right">
        <img src="https://i.ibb.co/ZRL6K3dB/German-Shepherd-DSC-0346-10096362833.jpg" alt=""/>
      </div>
    </div>
  </section>
  <div class="modal-container"></div>
  <div class="edit-modal-container"></div>
  <section class="footer-section"></section>
  <script src="<?= ROOT?>public/assets/bootstrap.assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= ROOT?>public/assets/js/common-components/index.js" type="module"></script>
  <script async src="<?= ROOT?>public/assets/js/main/home.js" type="module"></script>
</body>
</html>