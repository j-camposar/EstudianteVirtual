<?php
header("Content-disposition: attachment; filename=plantilla.xlsx");
header("Content-type: MIME");
readfile("plantilla.xlsx");
?>