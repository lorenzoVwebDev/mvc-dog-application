<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MVC-dog-application</title>
  <link rel="stylesheet" href="<?=ROOT?>public/assets/css/style.css"/>
</head>
<body>
  <script src="<?= ROOT?>public/assets/js/services/get_breeds.js"></script>
  <section class="git-header-section"></section>
  <section class="main-section">
  <!-- action="http://mvc-dog-application/public/dog/insertdog" -->
   <form  method="post" class="insert-dog-form">
      <h2>Please, complete ALL fields. Please note the required format of information.</h2>
      Enter your dog's name (max 20 characters, alphabetic)
      <input type="text" maxlength="20" placeholder="Use up to 20 characters for the name" name="dog_name" id="dog_name" required/>
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
          <input type="radio" name="dog_color" id="dog_color" value="brown" /><br/>
          <input type="radio" name="dog_color" id="dog_color" value="black"/><br/>
          <input type="radio" name="dog_color" id="dog_color" value="yellow"/><br/>
          <input type="radio" name="dog_color" id="dog_color" value="white"/><br/>
          <input type="radio" name="dog_color" id="dog_color" value="mixed"/><br/><br/>
        </div>
      </div>
      Enter your dog's weight here (numeric only)
      <input type="number" min="0" max="120" name="dog_weight" id="dog_weight" required/><br/>
      <script>
        AjaxRequest('http://mvc-dog-application/public/dog/getbreeds?type=selectbox')
      </script>
      <div id="AjaxResponse"></div>
      <input type="hidden" name="dog_app" id="dog_app" value="dog"/>
      <input type="submit" value="click to create your dog"/>
    </form>
  </section>
  <section class="table-section">
  </section>
  <section class="footer-section"></section>
  <script src="<?= ROOT?>public/assets/js/common-components/index.js" type="module"></script>
  <script async src="<?= ROOT?>public/assets/js/index.js" type="module"></script>
</body>
</html>