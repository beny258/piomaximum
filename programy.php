<?php include_once "./includes/db_connect.php"; // pripojeni k databazi ?>
<?php include_once "./includes/head.php";       // hlavicka souboru ?>
<?php include_once "./includes/navbar.php";     // menu ?>

<?php
  function get_date_string($datetime, $alttext) {
    if (!is_null($alttext)) {
      return $alttext;
    }
    $datetime_obj = new DateTime($datetime);
    return $datetime_obj->format('j. n. Y');
  }
?>

<!-- Header -->
<header class="w3-container w3-center" style="padding: 100px 0px 0px 0px;">
  <img src="img/logo-safezone.png" alt="Piomaximum" />
</header>

<!-- First Grid -->
<?php
$sql = "SELECT programy.nazev, programy.popis, programy.termin, programy.termin_alt, programy.lektor_jmeno, programy.fb_event, typy.img_name AS typ, mista.nazev AS misto
FROM programy
LEFT JOIN typy ON programy.typ_id = typy.id
LEFT JOIN mista ON programy.misto_id = mista.id
WHERE published=1 AND termin>CURRENT_TIMESTAMP
ORDER BY termin";
$result = $conn->query($sql);
$pocet_programu = $result->num_rows;
?>
<div class="w3-row-padding w3-padding-64 w3-container">
  <div class="w3-content">

    <div class="w3-twothird">
      <h1>Nejbližší program</h1>
      <?php if ($pocet_programu > 0) { ?>
        <?php $row = $result->fetch_assoc(); ?>
        <?php $termin_dt = new DateTime($row["termin"]); ?>
        <h3><?=$row["nazev"]?></h3>
        <h5><strong>Vedoucí: </strong><?php echo( is_null($row["lektor_jmeno"]) ? "<em>(bude doplněno)</em>" : $row["lektor_jmeno"] ); ?></h5>
        <h5><strong>Kdy a kde: </strong><?php echo $termin_dt->format('j. n. \o\d G:i'); ?> <?php echo( is_null($row["misto"]) ? "<em>(místo bude doplněno)</em>" : $row["misto"] ); ?></h5>

        <?php if (!is_null($row["popis"])) { ?>
          <p class="w3-text-grey"><?=$row["popis"]?></p>
        <?php } ?>

        <?php if (!is_null($row["fb_event"])) { ?>
          <a href=<?php echo "'".$row["fb_event"]."'"; ?> target="_blank"><h6>Odkaz na FB událost</h6></a>
        <?php } ?>
      <?php } else { ?>
        <p>Momentálně není v blízké době naplánován žádný program.</p>
      <?php } ?>
    </div>

    <?php if ($pocet_programu > 0) { ?>
      <div class="w3-third w3-padding-24 w3-center photo">
        <img src=<?="'img/icons/".$row["typ"]."'"?> />
      </div>
    <?php } ?>
    
    <?php if ($pocet_programu > 1) { ?>
      <div class="w3-row">
        <h1>Další chystané programy</h1>
        <table class="timetable">
          <?php while ($row = $result->fetch_assoc()) { ?>
            <?php $termin_dt = get_date_string($row["termin"], $row["termin_alt"]); ?>
            <tr><th><?=$termin_dt?></th><td><?php echo $row["nazev"]; echo( !is_null($row["lektor_jmeno"]) ? " (".$row["lektor_jmeno"].")" : "" ); ?></td></tr>
          <?php } ?>
        </table>
      </div>
    <?php } ?>

  </div>
</div>

<!-- Second Grid -->
<?php
$sql = "SELECT programy.nazev, programy.termin, programy.termin_alt, programy.lektor_jmeno, programy.fb_event, typy.img_name AS typ
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
      <?php $termin_dt = get_date_string($row["termin"], $row["termin_alt"]); ?>
      
      <div class="w3-row w3-margin-bottom w3-margin-top">
        <div class="w3-quarter w3-center">
          <h5><?=$termin_dt?></h5>
        </div>
        
        <div class="w3-half">
          <h4><?=$row["nazev"]?></h4>
          <p><?=$row["lektor_jmeno"]?></p>
        </div>

        <div class="w3-quarter">
          <img src=<?="'img/icons/".$row["typ"]."'"?> style="max-height:48px;" />
        </div>
      </div>

    <?php } ?>

  </div>
</div>

<div id="contact" class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Sháníme lektory! Máš nápad na zajímavý program? <a href="https://docs.google.com/forms/d/e/1FAIpQLSc0qoqgLFYXaPiJARWmDNMSZYFFIvH8Bu3zEe-0TD1QELENYA/viewform?usp=sf_link" target="_blank">Ozvi se nám!</a></h1>
</div>

<?php include_once "./includes/footer.php";   // paticka stranky ?>
<?php include_once "./includes/db_close.php"; // ukonceni spojeni s databazi ?>