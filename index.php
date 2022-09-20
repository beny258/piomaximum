<?php include_once "./db_connect.php"; // pripojeni k databazi ?>

<!DOCTYPE html>
<html lang="cs">
<head>
<title>Piomaximum</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="main.css">
<link rel="shortcut icon" href="img/logo-icon.png" />
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
.w3-bar,h1,button {font-family: "Montserrat", sans-serif}
.fa-anchor,.fa-coffee {font-size:200px}
</style>
</head>
<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-card w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-white" href="javascript:void(0);" onclick="toggleMenu()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="#" class="w3-bar-item w3-button w3-padding-large w3-white">Domů</a>
    <a href="#programy" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-white">Programy</a>
    <a href="#about" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-white">O Piomaximu</a>
    <a href="#contact" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-white">Kontakt</a>
  </div>

  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
    <a href="#programy" class="w3-bar-item w3-button w3-padding-large" onclick="toggleMenu()">Programy</a>
    <a href="#about" class="w3-bar-item w3-button w3-padding-large" onclick="toggleMenu()">O Piomaximu</a>
    <a href="#contact" class="w3-bar-item w3-button w3-padding-large" onclick="toggleMenu()">Kontakt</a>
  </div>
</div>

<!-- Header -->
<header class="w3-container w3-center" style="padding: 100px 0px 0px 0px;">
  <img src="img/logo-safezone.png" alt="Piomaximum" />
</header>

<!-- First Grid -->
<?php
$sql = "SELECT programy.nazev, programy.popis, programy.termin, programy.lektor_jmeno, programy.fb_event, typy.img_name AS typ, mista.nazev AS misto
FROM programy
LEFT JOIN typy ON programy.typ_id = typy.id
LEFT JOIN mista ON programy.misto_id = mista.id
WHERE published=1 AND termin>CURRENT_TIMESTAMP
ORDER BY termin";
$result = $conn->query($sql);
$pocet_programu = $result->num_rows;
?>
<div id="programy" class="w3-row-padding w3-padding-64 w3-container">
  <div class="w3-content">

    <div class="w3-twothird">
      <h1>Nejbližší program</h1>
      <?php if ($pocet_programu > 0) { ?>
        <?php $row = $result->fetch_assoc(); ?>
        <?php $termin_dt = new DateTime($row["termin"]); ?>
        <h3><?php echo $row["nazev"]; ?></h3>
        <h5><strong>Vedoucí: </strong><?php echo( is_null($row["lektor_jmeno"]) ? "<em>(bude doplněno)</em>" : $row["lektor_jmeno"] ); ?></h5>
        <h5><strong>Kdy a kde: </strong><?php echo $termin_dt->format('j. n. \o\d G:i'); ?> <?php echo( is_null($row["misto"]) ? "<em>(místo bude doplněno)</em>" : $row["misto"] ); ?></h5>

        <?php if (!is_null($row["popis"])) { ?>
          <p class="w3-text-grey"><?php echo $row["popis"]; ?></p>
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
        <img src=<?php echo "'img/icons/".$row["typ"]."'"; ?> />
      </div>
    <?php } ?>
    
    <?php if ($pocet_programu > 1) { ?>
      <div>
        <h1>Další chystané programy</h1>
        <table class="timetable">
          <?php while ($row = $result->fetch_assoc()) { ?>
            <?php $termin_dt = new DateTime($row["termin"]); ?>
            <tr><th><?php echo $termin_dt->format('j. n.'); ?></th><td><?php echo $row["nazev"]; echo( !is_null($row["lektor_jmeno"]) ? " (".$row["lektor_jmeno"].")" : "" ); ?></td></tr>
          <?php } ?>
        </table>
      </div>
    <?php } ?>

  </div>
</div>

<!-- Second Grid -->
<div id="about" class="w3-row-padding w3-light-grey w3-container">
  <div class="w3-content">
    <div class="w3-third w3-center">
      <div class="linesdown"></div>
    </div>

    <div class="w3-twothird w3-padding-64">
      <h1>O Piomaximu</h1>
      <h5 class="w3-padding-32">Piomaximum je vzdělávací koncept, který probíhá
        celý školní rok a jehož cílem je prohloubit znalosti a dovednosti vedoucích
        dětských organizací, ať už v tématech týkajících se přímo oddílové
        činnosti (třeba workshop o seznamovacích hrách či seminář o dotacích),
        nebo v oblastech zcela nesouvisejících (například Acroyoga nebo Cestování
        po Skandinávii).</h5>

      <p class="w3-text-grey">Nápad s Piomaximem přišel začátkem roku 2020, kdy
        chtěli Chemik a Ledy během covidové karantény zprostředkovat pionýrským
        vedoucím možnost vzájemného vzdělávání. Ze začátku probíhaly programy
        online, a to jak přednášky, tak i praktické workshopy. Po rozvolnění
        opatření naznali spolu s účastníky proběhlých bloků, že tento vzdělávací
        koncept není k zahození, a tak ho rozjeli i v osobní formě a ve větším
        měřítku. Nyní probíhají programy obvykle jednou měsíčně a jsou určené
        nejen pro pionýry, ale i pro další zájemce z řad vedoucích dětských
        oddílů.</p>
    </div>

    <div class="w3-padding-64">
      <h1>Organizátoři</h1>
      <h5 class="w3-padding-32">Organizátorský tým Piomaxima je složen
        z dlouholetých pionýrských vedoucích, kteří jsou přesvědčeni, že
        pravidelné vzdělávání vedoucích dětských organizací (ať už se jedná o
        pionýry, skauty, tomíky či jiné) je velice důležité, a proto jsme spojili
        své síly a nápady, abychom mohli tento koncept společně vytvořit.</h5>

      <p class="w3-text-grey">Hlavními organizátory jsou Ledy a Chemik, kteří
        od začátku Piomaxima zaštiťují jeho fungování a celý projekt rozjížděli.
        Jak se povědomí o Piomaximu začalo rozšiřovat, přibrali do týmu Sluníčko,
        která má za úkol zajišťování dotací a materiálového supportu akcí.
        Ledy řeší zajišťování lektorů, komunikaci s nimi a tvorbu grafiky.
        Chemik se stará o PR, komunikuje s vedením Pionýra i ostatními dětskými
        organizacemi a zvyšuje povědomí o tomto vzdělávacím konceptu.</p>
    </div>

    <div>
      <div class="w3-third w3-center w3-margin-bottom">
        <img class="w3-badge w3-transparent smallimg" src="img/ledy.jpg" alt="Organizátoři" />
        <h4>David „Ledy“ Beneš</h4>
      </div>
      <div class="w3-third w3-center w3-margin-bottom">
        <img class="w3-badge w3-transparent smallimg" src="img/chemik.jpg" alt="Organizátoři" />
        <h4>Martin „Chemik“ Zapletal</h4>
      </div>
      <div class="w3-third w3-center w3-margin-bottom">
        <img class="w3-badge w3-transparent smallimg" src="img/slunicko.jpg" alt="Organizátoři" />
        <h4>Radka „Sluníčko“ Mikušková</h4>
      </div>
    </div>
  </div>
</div>

<div id="contact" class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Sháníme lektory! Máš nápad na zajímavý program? <a href="https://docs.google.com/forms/d/e/1FAIpQLSc0qoqgLFYXaPiJARWmDNMSZYFFIvH8Bu3zEe-0TD1QELENYA/viewform?usp=sf_link" target="_blank">Ozvi se nám!</a></h1>
</div>

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity">
  <div class="w3-xxxlarge">
    <a href="mailto:david@stezka.org?subject=Piomaximum" target="_blank"><i class="fa fa-envelope w3-hover-opacity"></i></a>
    <a href="https://www.facebook.com/piomaximum" target="_blank"><i class="fa fa-facebook-official w3-hover-opacity"></i></a>
    <a href="https://www.instagram.com/piomaximum/" target="_blank"><i class="fa fa-instagram w3-hover-opacity"></i></a>
 </div>
 <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
</footer>

<script>
// Used to toggle the menu on small screens when clicking on the menu button
function toggleMenu() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>

</body>
</html>

<?php include_once "./db_close.php"; // ukonceni spojeni s databazi ?>