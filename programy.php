<?php include_once "./includes/functions.php";  // pomocne funkce ?>
<?php include_once "./includes/db_connect.php"; // pripojeni k databazi ?>
<?php include_once "./includes/head.php";       // hlavicka souboru ?>
<?php include_once "./includes/navbar.php";     // menu ?>
<?php include_once "./includes/header.php";     // logo ?>

<!-- First Grid -->
<?php
$sql = "SELECT programy.nazev, programy.termin, programy.termin_alt, programy.lektor_jmeno, programy.fb_event, typy.img_name AS typ_ikona, typy.nazev AS typ_nazev
FROM programy
LEFT JOIN typy ON programy.typ_id = typy.id
LEFT JOIN mista ON programy.misto_id = mista.id
WHERE published=1 AND termin>=CURRENT_TIMESTAMP
ORDER BY termin DESC";
$result = $conn->query($sql);
$pocet_programu = $result->num_rows;
?>
<div class="w3-row-padding w3-padding-64 w3-container">
  <div class="w3-content">

    <h1>Plánované programy</h1>
    <?php $pocitadlo = 0; ?>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <?php $termin_dt = get_date_string($row["termin"], $row["termin_alt"], 'j. n. Y'); ?>
      <?php $pocitadlo++; ?>
      <div class="w3-row w3-margin-bottom w3-margin-top">
      
        <?php // TERMIN ?>
        <div class="w3-quarter w3-center">
          <h5><?=$termin_dt?></h5>
          <?php if ($pocitadlo == $pocet_programu) { ?>
            <p class="font-italic">(nejbližší program)</p>
          <?php } ?>
        </div>
        
        <?php // NAZEV, LEKTOR ?>
        <div class="w3-half">
          <h4><?=$row["nazev"]?></h4>
          <p><?=$row["lektor_jmeno"]?></p>
        </div>

        <?php // IKONA ?>
        <div class="w3-quarter">
          <p>
            <img class="w3-show-inline-block xxsmall-img" src=<?="'img/icons/".$row["typ_ikona"]."'"?> />
            <span class="w3-hide-medium w3-hide-large font-bold font-color-sec"><?=$row["typ_nazev"]?></span>
          </p>
        </div>
      </div>

    <?php } ?>

  </div>
</div>

<!-- Second Grid -->
<?php
$sql = "SELECT programy.nazev, programy.termin, programy.termin_alt, programy.lektor_jmeno, programy.fb_event, typy.img_name AS typ_ikona, typy.nazev AS typ_nazev
FROM programy
LEFT JOIN typy ON programy.typ_id = typy.id
LEFT JOIN mista ON programy.misto_id = mista.id
WHERE published=1 AND termin<CURRENT_TIMESTAMP
ORDER BY termin DESC";
$result = $conn->query($sql);
$pocet_programu = $result->num_rows;
?>
<div class="w3-row-padding w3-light-grey w3-padding-64 w3-container">
  <div class="w3-content">

    <h1>Proběhlé programy</h1>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <?php $termin_dt = get_date_string($row["termin"], $row["termin_alt"], 'j. n. Y'); ?>
      
      <div class="w3-row w3-margin-bottom w3-margin-top">
      
        <?php // TERMIN ?>
        <div class="w3-quarter w3-center">
          <h5><?=$termin_dt?></h5>
        </div>
        
        <?php // NAZEV, LEKTOR ?>
        <div class="w3-half">
          <h4><?=$row["nazev"]?></h4>
          <p><?=$row["lektor_jmeno"]?></p>
        </div>

        <?php // IKONA ?>
        <div class="w3-quarter">
          <p>
            <img class="w3-show-inline-block xxsmall-img" src=<?="'img/icons/".$row["typ_ikona"]."'"?> />
            <span class="w3-hide-medium w3-hide-large font-bold font-color-sec"><?=$row["typ_nazev"]?></span>
          </p>
        </div>
      </div>

    <?php } ?>

  </div>
</div>

<?php include_once "./includes/lecturer_banner.php"; // banner na shánění lektorů ?>
<?php include_once "./includes/footer.php";          // paticka stranky ?>
<?php include_once "./includes/db_close.php";        // ukonceni spojeni s databazi ?>