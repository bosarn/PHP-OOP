<?php
require_once "lib/autoload.php";

$css = array( "style.css" );
$header = new printHead($css);

?>
<body>

<div class="jumbotron text-center">
    <h1>Formulier Stad</h1>
</div>

<div class="container">
    <div class="row">

        <?php
        $cityLoader = new CityLoader();
        $cities = $cityLoader->Load( $id = $_GET['id'] );
        $template = $TemplateLoader->LoadTemplate("stad_form");
        print $ReplaceContent->ReplaceCities( $cities, $template);
        ?>

    </div>
</div>

</body>
</html>