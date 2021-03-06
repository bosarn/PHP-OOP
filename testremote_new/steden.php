<?php
ini_set("error_reporting", E_ALL);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);

require_once "lib/autoload.php";

$css = array( "style.css");
$header = new printHead($css);

$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Leuke plekken in Europa</h1>
    <p>Tips voor citytrips voor vrolijke vakantiegangers!</p>
</div>

<?php
$menu = new menuLoader();
$menu->printNav();
?>

<div class="container">
    <div class="row">

        <?php
        $cityLoader = new CityLoader();
        $cities = $cityLoader->Load();
        $template = $TemplateLoader->LoadTemplate("steden");
        $ReplaceContent->ReplaceCities( $cities, $template);
        ?>

    </div>
</div>

</body>
</html>