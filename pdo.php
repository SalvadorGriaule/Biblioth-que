<?php

include "./template/header.php";

require "db.php";

$str = "";

$str .= '<table class="border-2 border-black border-solid">';
$col = array_keys((array)$result[0]);

$str .= '<tr>';
for ($th = 2, $sth = count($col); $th < $sth; $th += 2) {
    $str .= '<th>' . $col[$th] . '</th>';
}
$sth .= '</tr>';
for ($i = 0, $size = count($result); $i < $size; ++$i) {
    $str .= '<tr>';
    for ($j = 1; $j < 10; ++$j) {
        $str .= '<td class="mr-2"><a href="./modif.php?id_employer=' . $result[$i][0] . '">' . $result[$i][$j] . "</a></td>";
    }
    $str .= '<td class="mr-2"></a><a href="./supp.php?id_employer=' . $result[$i][0] . '">Supprimer</a></td></tr>';
}

$str .= '</table>"';

?>
<main class="bg-orange-200 pb-1">
    <nav>
        <ul class="flex space-x-2 p-1">
            <li><a href="./update.php">gestion de livre</a></li>
            <li><a href="./ajoutEmp.php">ajouter employer</a></li>
        </ul>
    </nav>
    <div class="w-full flex items-center justify-center mt-2 ">
        <?php echo $str ?>
    </div>
</main>

<?php include "./template/footer.php"; ?>