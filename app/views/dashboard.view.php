<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MVC-dog-application</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/headers/">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
  <link href="<?=ROOT?>public/assets/bootstrap.assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?=ROOT?>public/assets/css/dashboard.css"/>
  <link rel="stylesheet" href="<?=ROOT?>public/assets/css/home.css"/>
  <link rel="stylesheet" href="<?=ROOT?>public/assets/css/common.css"/>
</head>
<body>
  <script src="<?= ROOT?>public/assets/js/services/home/get_breeds.js"></script>
  <script src="<?= ROOT?>public/assets/js/utils/globalVariables.nomodule.js"></script>
  <section class="git-header-section"></section>
  <section class="main-header">
  </section>
  <section class="wrapper-section">
  <section class="dashboard-nav-section">
    <div class="dnav-container">
      <button id="toggle-creation">
        Dog Creation
      </button>
      <button id="toggle-admin">
        Admin Dashboard
      </button>
    </div>
  </section>
  <section class="main-section">
    <section class="creation-section dashboard-sections">
      <div style="
        display: inline-flex;
        border: solid 1px black;
        border-radius: 8px;
        padding-right: calc(1vw + 1vh);
        padding-left: calc(1vw + 1vh);
        margin-bottom: calc(0.4vw + 0.4vh);
      ">
      <h1 style="
        font-size: calc(1.5vw + 1.5vh);
      ">Dog Creation</h1>
      </div>
      <form  method="post" id="insert-dog-form">
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
            <div class="radio-input-container" required>
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
            AjaxRequest(`${url}dog/getbreeds?type=selectbox`)
          </script>
          <div id="AjaxResponse"></div>
          <input type="hidden" name="dog_app" id="dog_app" value="dog"/>
          <input type="submit" value="click to create your dog"/>
        </form>
        <div class="toggle-list">
          <button id="read-dogs" data-id="ALL">Select All Dogs</button>
          <button id="clear-dogs">Clear All Dogs</button>
        </div>
        <div class="edit-modal-container">
        </div>
      <section id="doglist">
      </section>
    </section>
    <section class="admin-section dashboard-sections">
      <div style="
        display: inline-flex;
        border: solid 1px black;
        border-radius: 8px;
        padding-right: calc(1vw + 1vh);
        padding-left: calc(1vw + 1vh);
        margin-bottom: calc(0.4vw + 0.4vh);
      ">
        <h1 style="
          font-size: calc(1.5vw + 1.5vh);
        ">Admin Dashboard</h1>
        </div>
          <section class="mail-section">
          <h3>Send events table to the admin's mail</h3>      
          <form id="mail-form">
              <div class="input-container">
                <label class="name">
                  Name
                  <input type="text" placeholder="Insert your name" pattern="[A-Za-z]+" minlenght="5" maxlenght="25" name="name" value="<?=ADMINNAME?>" required />
                </label>
                <label class="surname">
                  Surname
                  <input type="text" placeholder="Insert your Surname" pattern="[A-Za-z]+" minlenght="5" maxlenght="25" name="surname" value="<?=ADMINSURNAME?>"required/>
                </label>
                <label class="birthdate">
                  Log Date
                  <input type="date" name="log-date" id="log-date" value="<?=date('Y-m-d')?>"/>
                </label>
                <label class="social">
                  Log Table
                  <select id="mail-form" name="type">
                    <option value="exception" selected>Exception</option>
                    <option value="error">Error</option>
                    <option value="access">Access</option>
                  </select>
                </label>
                <label> 
                  e-mail
                  <input type="email" placeholder="insert your mail" name="email" value="<?=ADMINMAIL?>"required/>
                </label>
                <input type="text" value="table-mail" id="mail" name="form-hidden" hidden/>
                <input type="submit" value="Submit"/>
              </div>
            </form>
            <section class="logs-section">
              <h3>Download events table o render it</h3>
                <form id="log-form">  
                  <select id="mail-form" name="log-type" form="log-form">
                    <option value="exception" selected>Exception</option>
                    <option value="error">Error</option>
                    <option value="access">Access</option>
                  </select>
                    <label class="birthdate">
                        Log Date
                    <input type="date" name="log-date" id="log-date" value="<?=date('Y-m-d')?>"/>
                    </label>
                    <input type="submit" name="download" value="download"/>
                    <input type="submit" name="show-table" value="show-table"/>
                </form>
              </section>
              <section class="admin-table-section">
              </section>
            </section>
    </section>
  </section>
  </section>
  <section class="footer-section"></section>
  <div class="modal-container">
  </div>
  <script src="<?= ROOT?>public/assets/bootstrap.assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= ROOT?>public/assets/js/common-components/index.js" type="module"></script>
<!--   <script async src="<?= ROOT?>public/assets/js/main/home.js" type="module"></script> -->
  <script src="<?= ROOT?>public/assets/js/main/dashboard.js" type="module"></script>
</body>
</html>