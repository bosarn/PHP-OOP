<?php
require_once "lib/autoload.php";

$css = array( "style.css");
$header = new printHead($css);

$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Vacatures</h1>
</div>

<?php
$menu = new menuLoader();
$menu->printNav();
?>

<div class="container">
    <div class="row">

    </div>
</div>

</body>
</html>