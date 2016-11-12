-- All courses
CREATE TABLE Course
(
    id VARCHAR(6) PRIMARY KEY
);

-- All students
CREATE TABLE Student
(
    id INT PRIMARY KEY,
    full_name VARCHAR(50)
);

-- All recitations
CREATE TABLE Recitation
(
    number INT,
    course VARCHAR(6)
);

-- All recitation groups
CREATE TABLE RecGroup
(
    id VARCHAR(1),
    recitation INT,
    course VARCHAR(6)
);

-- All teacher assistants
CREATE TABLE TA
(
    id INT PRIMARY KEY,
    full_name VARCHAR(50)
);

-- The grade of one student on a recitation problem
CREATE TABLE Grade
(
    student INT,
    course VARCHAR(6),
    recitation INT,
    problem VARCHAR(3),
    grade VARCHAR(1)
);

-- Problems
CREATE TABLE Problem
(
    number VARCHAR(3),
    course VARCHAR(6),
    recitation INT
);

-- Student takes a course
CREATE TABLE takes
(
    student INT,
    course VARCHAR(6)
);

-- TA teaches recitation in course
CREATE TABLE teaches
(
    ta INT,
    recitation INT,
    course VARCHAR(6)
);

-- Student in recitation group
CREATE TABLE in_group
(
    student INT,
    recitation INT,
    rec_group VARCHAR(1),
    course VARCHAR(6)
);



/*
 * Database contents
 */

-- Courses
BEGIN;
    INSERT INTO course VALUES ('DD1339');
    INSERT INTO course VALUES ('DD1368');
    INSERT INTO course VALUES ('IS1500');
COMMIT;

-- Students
BEGIN;
    INSERT INTO student VALUES (1, 'Peter Jonsson');
    INSERT INTO student VALUES (2, 'Lucas Ljungberg');
    INSERT INTO student VALUES (3, 'Alexander Manske');
    INSERT INTO student VALUES (4, 'Fredrik Liljedahl');
COMMIT;

-- Recitations
BEGIN;
    INSERT INTO recitation VALUES (1, 'DD1339');
    INSERT INTO recitation VALUES (2, 'DD1339');
    INSERT INTO recitation VALUES (3, 'DD1339');

    INSERT INTO recitation VALUES (1, 'DD1368');
    INSERT INTO recitation VALUES (2, 'DD1368');
    INSERT INTO recitation VALUES (3, 'DD1368');

    INSERT INTO recitation VALUES (1, 'IS1500');
    INSERT INTO recitation VALUES (2, 'IS1500');
    INSERT INTO recitation VALUES (3, 'IS1500');
COMMIT;

-- Recitation groups
BEGIN;
    INSERT INTO recgroup VALUES ('a', 1, 'DD1339');
    INSERT INTO recgroup VALUES ('a', 2, 'DD1339');
    INSERT INTO recgroup VALUES ('a', 3, 'DD1339');
    INSERT INTO recgroup VALUES ('b', 1, 'DD1339');
    INSERT INTO recgroup VALUES ('b', 2, 'DD1339');
    INSERT INTO recgroup VALUES ('b', 3, 'DD1339');
    INSERT INTO recgroup VALUES ('c', 1, 'DD1339');
    INSERT INTO recgroup VALUES ('c', 2, 'DD1339');
    INSERT INTO recgroup VALUES ('c', 3, 'DD1339');
    INSERT INTO recgroup VALUES ('d', 1, 'DD1339');
    INSERT INTO recgroup VALUES ('d', 2, 'DD1339');
    INSERT INTO recgroup VALUES ('d', 3, 'DD1339');

    INSERT INTO recgroup VALUES ('a', 1, 'DD1368');
    INSERT INTO recgroup VALUES ('a', 2, 'DD1368');
    INSERT INTO recgroup VALUES ('a', 3, 'DD1368');
    INSERT INTO recgroup VALUES ('b', 1, 'DD1368');
    INSERT INTO recgroup VALUES ('b', 2, 'DD1368');
    INSERT INTO recgroup VALUES ('b', 3, 'DD1368');
    INSERT INTO recgroup VALUES ('c', 1, 'DD1368');
    INSERT INTO recgroup VALUES ('c', 2, 'DD1368');
    INSERT INTO recgroup VALUES ('c', 3, 'DD1368');
    INSERT INTO recgroup VALUES ('d', 1, 'DD1368');
    INSERT INTO recgroup VALUES ('d', 2, 'DD1368');
    INSERT INTO recgroup VALUES ('d', 3, 'DD1368');

    INSERT INTO recgroup VALUES ('a', 1, 'IS1500');
    INSERT INTO recgroup VALUES ('a', 2, 'IS1500');
    INSERT INTO recgroup VALUES ('a', 3, 'IS1500');
    INSERT INTO recgroup VALUES ('b', 1, 'IS1500');
    INSERT INTO recgroup VALUES ('b', 2, 'IS1500');
    INSERT INTO recgroup VALUES ('b', 3, 'IS1500');
    INSERT INTO recgroup VALUES ('c', 1, 'IS1500');
    INSERT INTO recgroup VALUES ('c', 2, 'IS1500');
    INSERT INTO recgroup VALUES ('c', 3, 'IS1500');
    INSERT INTO recgroup VALUES ('d', 1, 'IS1500');
    INSERT INTO recgroup VALUES ('d', 2, 'IS1500');
    INSERT INTO recgroup VALUES ('d', 3, 'IS1500');
COMMIT;

-- Teacher assistants
BEGIN;
    INSERT into ta VALUES (1, 'Roastmaster');
    INSERT into ta VALUES (2, 'Snipergubbe');
COMMIT;

-- Students taking courses
BEGIN;
    INSERT INTO takes VALUES (1, 'DD1339');
    INSERT INTO takes VALUES (1, 'DD1368');

    INSERT INTO takes VALUES (2, 'DD1339');
    INSERT INTO takes VALUES (2, 'IS1500');

    INSERT INTO takes VALUES (3, 'IS1500');
    INSERT INTO takes VALUES (3, 'DD1368');

    INSERT INTO takes VALUES (4, 'DD1339');
COMMIT;

-- Teacher assistants teaching
BEGIN;
    INSERT INTO teaches VALUES (2, 1, 'DD1339');
    INSERT INTO teaches VALUES (2, 2, 'DD1339');
    INSERT INTO teaches VALUES (1, 3, 'DD1339');

    INSERT INTO teaches VALUES (2, 1, 'DD1368');
    INSERT INTO teaches VALUES (1, 2, 'DD1368');
    INSERT INTO teaches VALUES (2, 3, 'DD1368');

    INSERT INTO teaches VALUES (1, 1, 'IS1500');
    INSERT INTO teaches VALUES (1, 2, 'IS1500');
    INSERT INTO teaches VALUES (2, 3, 'IS1500');
COMMIT;
