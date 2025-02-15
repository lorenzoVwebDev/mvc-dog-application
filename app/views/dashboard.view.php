<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Logs Table Reader</title>
  <link rel="stylesheet" href="<?=ROOT?>public/assets/css/dashboard.css"/>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <section class="git-header-section"></section>
  <section class="main-section">
    <a href="<?= ROOT?>public"class="toggle-dashboard">Home Page<i class='bx bx-book-content'></i></a>
      <section class="mail-section">
      <h1>Send events table to the admin's mail</h1>      
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
      </section>
      <h1 style="
        text-align: center;
      ">Download events table o render it</h1>
    <section class="logs-section">
      
    </section>
    <section class="table-section">
    </section>
  </section>
  <section class="footer-section"></section>
  <script src="<?= ROOT?>public/assets/js/common-components/index.js" type="module"></script>
  <script src="<?= ROOT?>public/assets/js/dashboard.js" type="module"></script>
</body>
</html>