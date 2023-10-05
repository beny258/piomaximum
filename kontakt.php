<?php include_once "./includes/functions.php";  // pomocne funkce ?>
<?php include_once "./includes/db_connect.php"; // pripojeni k databazi ?>
<?php include_once "./includes/head.php";       // hlavicka souboru ?>
<?php include_once "./includes/navbar.php";     // menu ?>
<?php include_once "./includes/header.php";     // logo ?>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
  <div class="w3-content">
    
    <h1>Kde nás najdete</h1>
    
    <div class="w3-half">
      <iframe style="border:none" src="https://frame.mapy.cz/s/mucemeleju" width="400" height="280" frameborder="0"></iframe>
    </div>

    <div class="w3-half w3-large">
      <h2>Adresa</h2>
      <p>
        Jihomoravská krajská organizace Pionýra <br />
        Údolní 58a <br />
        Brno 60200
      </p>

      <h2>Kontakt</h2>
      <a href="mailto:david@stezka.org?subject=Piomaximum" class="font-no-decor" target="_blank"><i class="fa fa-envelope"></i> david@stezka.org</a>
    </div>

  </div>
</div>

<?php /*
<!-- Second Grid -->
<div class="w3-row-padding w3-light-grey w3-padding-64 w3-container">
  <div class="w3-content">
    
  </div>
</div>
*/ ?>

<?php include_once "./includes/lecturer_banner.php"; // banner na shánění lektorů ?>
<?php include_once "./includes/footer.php";          // paticka stranky ?>
<?php include_once "./includes/db_close.php";        // ukonceni spojeni s databazi ?>