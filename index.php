<?php include_once "./includes/db_connect.php"; // pripojeni k databazi ?>
<?php include_once "./includes/head.php";       // hlavicka souboru ?>
<?php include_once "./includes/navbar.php";     // menu ?>

<?php
  function get_date_string($datetime, $alttext) {
    if (!is_null($alttext)) {
      return $alttext;
    }
    $datetime_obj = new DateTime($datetime);
    return $datetime_obj->format('j. n.');
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
<div id="programy" class="w3-row-padding w3-padding-64 w3-container">
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
          <a href=<?="'".$row["fb_event"]."'"?> target="_blank"><h6>Odkaz na FB událost</h6></a>
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

    <div class="w3-row">
      <h1>Sháníme lektory!</h1>
      <p>Bez vás – lektorů to nejde. Stále sháníme nové tváře do lektorského týmu.</p>
      <p>Máš zajímavé hobby? Navštívil(a) jsi nějakou zajímavou destinaci? Máš dovednost, kterou chceš naučit i nové kamarády? Umíš něco, o čem si myslíš, že by oddíloví vedoucí rádi slyšeli? Zvládneš odvést báječnou hru pro dospělé vedoucí?</p>
      <p>Ozvi se nám. Jsme přesvědčeni o tom, že každý z vás má v sobě něco, co může předat ostatním! Neboj se to v sobě objevit. Pomůžeme ti, pokud s lektorováním nemáš zatím zkušenosti.</p>
    </div>


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

<?php include_once "./includes/footer.php";   // paticka stranky ?>
<?php include_once "./includes/db_close.php"; // ukonceni spojeni s databazi ?>