<?php
ini_set("error_reporting", E_ALL);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
$login_form = true;
require_once "lib/autoload.php";

//redirect naar homepage als de gebruiker al ingelogd is
if ( isset($_SESSION['usr']) )
{
    $MS->AddMessage( "U bent al ingelogd!" );
    header("Location: " . $_application_folder . "/steden.php");
    exit;
}

$css = array( "style.css");
$header = new printHead($css);
$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Login</h1>
</div>

<div class="container">
    <div class="row">

        <?php
        print $TemplateLoader->LoadTemplate("login");
        ?>

    </div>
</div>

</body>
</html>