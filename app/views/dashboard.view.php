<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Logs Table Reader</title>
  <link rel="stylesheet" href="<?=ROOT?>public/assets/css/style.css"/>
</head>
<body>
  <section class="git-header-section"></section>
  <section class="main-section">
    <section class="mail-section">
    <h1>Request Your Table via e-mail</h1>      
    <form id="mail-form">
        <div class="input-container">
          <label class="name">
            <h3>Name</h3>
            <input type="text" placeholder="Insert your name" pattern="[A-Za-z]+" minlenght="5" maxlenght="25" name="name" required />
          </label>
          <label class="surname">
            <h3>Surname</h3>
            <input type="text" placeholder="Insert your Surname" pattern="[A-Za-z]+" minlenght="5" maxlenght="25" name="surname" required/>
          </label>
          <label class="birthdate">
            <h3>Log Date</h3>
            <input type="date" name="log-date" id="log-date" value="<?=date('Y-m-d')?>"/>
          </label>
          <label class="social">
            <h3>Log Table</h3>
            <select id="mail-form" name="type">
              <option value="exception" selected>Exception</option>
              <option value="error">Error</option>
              <option value="access">Access</option>
            </select>
          </label>
          <label> 
            <h3>e-mail</h3> 
            <input type="email" placeholder="insert your mail" name="email" required/>
          </label>
        </div>
        <input type="text" value="table-mail" id="mail" name="form-hidden" hidden/>
        <input type="submit" value="Submit"/>
      </form>
    </section>
    <h1 style="
      text-align: center;
    ">Or Create a new Log and display its respective table</h1>
  <section class="logs-section">
    <div class="exception-container log-form">
      <form method="post" id="exception-form">
        <input type="text" name="exception-name" minlength="3" maxlength="20" placeholder="insert exception name" pattern="^[A-Za-z0-9 ]+$" required/>
        <input type="hidden" name="type" id="type" value="exception"/>
        <input type="submit"/>
      </form>
    </div>
    <div class="error-container log-form">
      <form method="post" id="error-form">
        <input type="text" name="error-name" minlength="3" maxlength="20" placeholder="insert error name" pattern="^[A-Za-z0-9 ]+$" required/>
        <input type="hidden" name="type" id="type" value="error"/>
        <input type="submit"/>
      </form>
    </div>
    <div class="access-container log-form">
      <form method="post" id="access-form">
        <input type="text" name="access-name" minlength="3" maxlength="20" placeholder="insert access name" pattern="^[A-Za-z0-9 ]+$" required/>
        <input type="hidden" name="type" id="type" value="access"/>
        <input type="submit"/>
      </form>
    </div>
  </section>
  <section class="table-section">
  </section>
  </section>
  <section class="footer-section"></section>
  <script src="<?= ROOT?>public/assets/js/index.js" type="module"></script>
  <script src="<?= ROOT?>public/assets/js/common-components/index.js" type="module"></script>
</body>
</html>