<?php
$action = $_GET["action"];
$output = "";

$pdo = new PDO("mysql:host=localhost port=8888 user=root password=root dbname=recitationreport");
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1); // Stack queries

switch ($action) {
    case "student-name":
        $sql = <<<END
SELECT full_name FROM student
WHERE id = :id;
END;

        $query = $pdo->prepare($sql);
        $query->execute([
            ":id" => $_GET["student"],
        ]);
        $output = $query->fetch(PDO::FETCH_COLUMN);
        break;

    case "get-problems":
        $sql = <<<END
SELECT number FROM problem
WHERE 
    course = :course AND
    recitation = :recitation;
END;

    $query = $pdo->prepare($sql);
    $query->execute([
        ":course" => $_GET["course"],
        ":recitation" => $_GET["recitation"],
    ]);

    $output = $query->fetchAll(PDO::FETCH_COLUMN);
    break;
case "is-selected":
        $sql = <<<END
SELECT 1 FROM grade
WHERE
    student = :student AND
    course = :course AND
    problem = :problem AND
    recitation = :recitation;
END;

    $query = $pdo->prepare($sql);
    $query->execute([
        ":student" => $_GET["student"],
        ":problem" => $_GET["problem"],
        ":course" => $_GET["course"],
        ":recitation" => $_GET["recitation"],
    ]);

    $output = $query->fetch(PDO::FETCH_COLUMN);
    break;

    case "recitations":
        $sql = <<<END
SELECT number FROM recitation
WHERE course = :course
ORDER BY number ASC;
END;

        $query = $pdo->prepare($sql);
        $query->execute([
            ":course" => $_GET["course"],
        ]);
        $output = $query->fetchAll(PDO::FETCH_COLUMN);
        break;
    case "groups":
        $sql = <<<END
SELECT id FROM recgroup
WHERE
    course = :course AND
    recitation = :recitation
ORDER BY id ASC;
END;

        $query = $pdo->prepare($sql);
        $query->execute([
            ":course" => $_GET["course"],
            ":recitation" => $_GET["recitation"],
        ]);
        $output = $query->fetchAll(PDO::FETCH_COLUMN);
        break;
    case "get-selected-group":
        $sql = <<<END
SELECT rec_group FROM in_group
WHERE
    course = :course AND
    recitation = :recitation AND
    student = :student
LIMIT 1;
END;

        $query = $pdo->prepare($sql);
        $query->execute([
            ":course" => $_GET["course"],
            ":recitation" => $_GET["recitation"],
            ":student" => $_GET["student"],
        ]);
        $output = $query->fetch(PDO::FETCH_COLUMN);
        break;
    case "select-group":
        $sql = <<<END
DELETE FROM in_group
WHERE
    course = :course AND
    recitation = :recitation AND
    student = :student;
INSERT INTO in_group VALUES (:student, :recitation, :group, :course);
END;

        $query = $pdo->prepare($sql);
        $query->execute([
            ":course" => $_GET["course"],
            ":recitation" => $_GET["recitation"],
            ":student" => $_GET["student"],
            ":group" => $_GET["group"],
        ]);
        $output = $query->rowCount();
        break;
    
    default:
        $output = "ERROR: Default case.";
        break;
}

die(json_encode($output));