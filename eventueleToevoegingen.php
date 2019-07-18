<!-- Scroll bar vacatures -->
<div class="container unselectable">
    <div class="row">
        <div class="col-12 mt-3 text-center">
            <?php
            if ($r2[0]["ID"] > 0) {
                echo '<a href="vacature.php?id=' . $min1 . '" class="mr-2"><i class="fas fa-chevron-circle-left fa-2x"></i></a>';
            } else {
                echo '<span class="mr-2 text-muted"><i class="fas fa-chevron-circle-left fa-2x"></i></span>';
            }
            echo "<span class='text-secondary'>Vacature $id van de ".--$aantal."</span>";
            if ($id != $aantal) {
                echo '<a href="vacature.php?id=' . $plus1 . '" class="ml-2"><i class="fas fa-chevron-circle-right fa-2x"></i></a>';
            } else {
                echo '<span class="ml-2 text-muted"><i class="fas fa-chevron-circle-right fa-2x"></i></span>';
            }
            ?>
        </div>
    </div>
</div>