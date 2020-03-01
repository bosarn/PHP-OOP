<?php
require_once "lib/autoload.php";

$css = array( "style.css");
$header = new printHead($css);
$MS->ShowMessages();

$weekloader = $container-> getWeekLoader();

?>
    <body>

    <div class="jumbotron text-center">
        <h1>Weekoverzicht</h1>
    </div>
    <?php
    $menu = new menuLoader();
    $menu->printNav();
    ?>

    <div class="container">
        <div class="row">



    <table class="table">
        <tr>
            <th>Weekdag</th>
            <th>Datum</th>
            <th>Taken</th>
        </tr>
            <?php

            $week = $weekloader->getWeek();
            $year = $weekloader->getYear();

            for( $day=1; $day <= 7; $day++ )
            {
                $Row = $weekloader->getRow($day);
                echo $Row;
            }

            echo "</table>";

            $link_vorige = "week.php?week=" . ($week == 1 ? 52 : $week - 1 ) . "&year=" . ($week == 1 ? $year - 1 : $year);
            $link_volgende = "week.php?week=" . ($week == 52 ? 1 : $week + 1 ) . "&year=" . ($week == 52 ? $year + 1 : $year);
            echo "<a href=$link_vorige>Vorige Week</a>&nbsp";
            echo "<a href=$link_volgende>Volgende Week</a>&nbsp";
            ?>

        </div>
    </div>
    </body>
</html>