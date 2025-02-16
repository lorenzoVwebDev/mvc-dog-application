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
  <script src="<?= ROOT?>public/assets/js/services/home/get_breeds.js"></script>
  <section class="git-header-section"></section>
  <section class="main-header">
  </section>
  <section class="main-section">
   <form  method="post" class="insert-dog-form">
      <h2>Please, complete ALL fields. Please note the required format of information.</h2>
      Enter your dog's name (max 20 characters, alphabetic)
      <input type="text" maxlength="20" placeholder="Use up to 20 characters for the name" name="dog_name" id="dog_name" value="lorenzo" required/>
      <h3>Select your Dog's Color:</h3> 
      <div class="radio-container">
        <div class="radio-name-container">
          <span>Brown</span>
          <span>black</span>
          <span>yellow</span>
          <span>white</span>
          <span>mixed</span>
        </div>
        <div class="radio-input-container">
          <input type="radio" name="dog_color" id="dog_color" value="brown" checked/><br/>
          <input type="radio" name="dog_color" id="dog_color" value="black"/><br/>
          <input type="radio" name="dog_color" id="dog_color" value="yellow"/><br/>
          <input type="radio" name="dog_color" id="dog_color" value="white"/><br/>
          <input type="radio" name="dog_color" id="dog_color" value="mixed"/><br/><br/>
        </div>
      </div>
      Enter your dog's weight here (numeric only)
      <input type="number" min="0" max="120" name="dog_weight" id="dog_weight" value="15" required/><br/>
      <script>
        AjaxRequest('https://apachebackend.lorenzo-viganego.com/mvc-dog-application/public/dog/getbreeds?type=selectbox')
      </script>
      <div id="AjaxResponse"></div>
      <input type="hidden" name="dog_app" id="dog_app" value="dog"/>
      <input type="submit" value="click to create your dog"/>
    </form>
  </section>
  <section class="table-section">
  </section>
  <div class="modal-container"></div>
  <section class="footer-section"></section>
  <script src="<?= ROOT?>public/assets/bootstrap.assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= ROOT?>public/assets/js/common-components/index.js" type="module"></script>
  <script async src="<?= ROOT?>public/assets/js/home.js" type="module"></script>
</body>
</html>