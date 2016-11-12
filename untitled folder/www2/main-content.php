<?php
$pdo = new PDO("mysql:host=localhost port=8888 user=root password=root dbname=recitationreport");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$sql = <<<END
SELECT id FROM course
ORDER BY id ASC;
END;

$query = $pdo->prepare($sql);
$query->execute();
$courses = $query->fetchAll(PDO::FETCH_COLUMN);
?>

<label class="form-label">Student:
    <input type="number" id="student" class="form-control" min="0">
</label>

<submit id="log-in" class="btn btn-primary">Log in</submit>

Logged in as <strong class="student-name">unknown</strong>

<div class="row">
    <div class="col-md-3">
        <h3>Course</h3>
        <div id="courses" class="list-group">
            <?php foreach ($courses as $course): ?>
                <button type="button" class="list-group-item course"><?php echo $course; ?></button>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-3">
        <h3>Recitation</h3>
        <div id="recitations" class="list-group">
        </div>
    </div>
    <div class="col-md-3">
    <h3>Group</h3>
        <div id="groups" class="list-group">
        </div>
    </div>
    <div class="col-md-3" id="solution-container">
        <h3>Solutions</h3>
        <form action="submit-solutions.php" method="post">
            <div id="solutions"></div>
            <input type="hidden" name="student">
            <input type="hidden" name="recitation">
            <input type="hidden" name="course">
            <button id="submit-solutions" class="btn btn-primary">Submit solutions</button>
        </form>
    </div>
</div>