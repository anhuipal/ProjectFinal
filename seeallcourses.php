<?php
include "header.php";
/*include 'database/dbFunctions.php';*/
$code= $_POST["search"];
$courses = searchCourse($code);

?>


<h1 align="center">Results</h1>


<table class="table table-striped" align="center">
    <?php
    echo "<tr><th>Course Code</th><th>Course Descpriction</th><th>Course Title</th><th>Course Syllabus</th><th>Course Credits</th><th>Major</th></tr>";
    foreach ($courses as $row) {
        echo "<tr><td>". strtoupper($row["course_code"]) . "</td><td>" . $row["course_desc"] . "</td><td>" . $row["course_title"] . "</td> <td>" . $row["course_syllabus"] . "</td><td>" . $row["course_credits"] . "</td><td>" . $row["major_id"] . "</td></tr>";
    }
    ?>
</table>

<?php echo $code;?>

<?php

include "footer.php";

?>
