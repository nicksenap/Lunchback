<?php
$problems = [];

foreach ($_POST as $key => $value) {
    if (isset($value) && $value == "on")
        array_push($problems, $key);
}

$student = $_POST["student"];
$course = $_POST["course"];
$recitation = $_POST["recitation"];

$pdo = new PDO("mysql:host=localhost port=8888 user=root password=root dbname=recitationreport");
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1); // Stack queries

$sql = <<<END
INSERT INTO grade VALUES (:student, :course, :recitation, :problem, NULL);
END;

foreach ($problems as $problem) {
    $query = $pdo->prepare($sql);
    $query->execute([
        ":course" => $_POST["course"],
        ":recitation" => $_POST["recitation"],
        ":student" => $_POST["student"],
        ":problem" => $problem,
    ]);
}

?>
Solution submitted!