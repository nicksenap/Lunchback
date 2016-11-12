
CREATE TABLE Course (
  cID   VARCHAR(10)   PRIMARY KEY,
  name  VARCHAR(50)
);

CREATE TABLE Student (
  ID        VARCHAR(10)   PRIMARY KEY,
  name      VARCHAR(50),
  password  VARCHAR(30)
);

CREATE TABLE Recitation (
  cID   VARCHAR(10)   REFERENCES Course(cID),
  num   INT,
  PRIMARY KEY(cID, num)
);

CREATE TABLE RecitationGroup (
  cID         VARCHAR(10),
  num         INT,
  name        VARCHAR(20),
  dateGiven   date,
  maxLimit    INT,
  FOREIGN KEY (cID, num) REFERENCES Recitation(cID, num),
  PRIMARY KEY(cID, num, name)
);

CREATE TABLE Leader (
  ID    VARCHAR(10)   PRIMARY KEY,
  name  VARCHAR(50)
);

CREATE TABLE Problems (
  problemSet  VARCHAR(30),
  condition   VARCHAR(100),
  PRIMARY KEY(problemSet, condition)
);

CREATE TABLE Takes (
  cID         VARCHAR(10)   REFERENCES Course(cID),
  studentID   VARCHAR(10)   REFERENCES Student(ID),
  PRIMARY KEY(cID, studentID)
);

CREATE TABLE Claims (
  studentID   VARCHAR(10)   REFERENCES Student(ID),
  problemSet  VARCHAR(30),
  condition   VARCHAR(100),
  cID         VARCHAR(10),
  recNum      INT,
  groupName   VARCHAR(20),
  claimedSet  VARCHAR(30),
  called      BOOLEAN,
  FOREIGN KEY (problemSet, condition)   REFERENCES Problems(problemSet, condition),
  FOREIGN KEY (cID, recNum, groupName)  REFERENCES RecitationGroup(cID, num, name),
  PRIMARY KEY(studentID, problemSet, condition, cID, recNum, groupName)
);

CREATE TABLE HasProblems (
  cID         VARCHAR(10),
  recNum      INT,
  problemSet  VARCHAR(30),
  condition   VARCHAR(100),
  FOREIGN KEY (cID, recNum) REFERENCES Recitation(cID, num),
  FOREIGN KEY (problemSet, condition) REFERENCES Problems(problemSet, condition),
  PRIMARY KEY(cID, recNum, problemSet, condition)
);

CREATE TABLE LeadsGroup (
  cID         VARCHAR(10),
  recNum      INT,
  groupName   VARCHAR(20),
  leaderID    VARCHAR(10)   REFERENCES Leader(ID),
  FOREIGN KEY (cID, recNum, groupName) REFERENCES RecitationGroup(cID, num, name),
  PRIMARY KEY (cID, recNum, groupName, leaderID)
);

CREATE TABLE Results (
  cID         VARCHAR(10),
  recNum      INT,
  studentID   VARCHAR(10)   REFERENCES Student(ID),
  points      INT,
  FOREIGN KEY (cID, recNum) REFERENCES Recitation(cID, num),
  PRIMARY KEY(cID, recNum, studentID)
);

--Student(ID, name, password)
BEGIN;

INSERT INTO Student VALUES ('nsong', 'Nick Song', 's82953187');
INSERT INTO Student VALUES ('master', 'Grand Master', 'master');

COMMIT;

--Course(cID, name)
BEGIN;

INSERT INTO Course VALUES ('DD1368', 'Databasteknik för D');
INSERT INTO Course VALUES ('DD1393', 'Mjukvarukonstruktion');
INSERT INTO Course VALUES ('DD1390', 'Programsammahållande kurs i Datateknik');
INSERT INTO Course VALUES ('SF1901', 'Sannoliksteori och statistik');

COMMIT;

--Recitation(cID, number)
BEGIN;

INSERT INTO Recitation VALUES ('DD1368', '1');
INSERT INTO Recitation VALUES ('DD1368', '2');
INSERT INTO Recitation VALUES ('DD1393', '1');
INSERT INTO Recitation VALUES ('DD1393', '2');

COMMIT;

--RecitationGroup(cID, number, group, givenDate, maxLimit)
BEGIN;

INSERT INTO RecitationGroup VALUES ('DD1368', '1', 'A', '2016-02-10', 50);
INSERT INTO RecitationGroup VALUES ('DD1368', '2', 'B', '2016-02-25', 45);
INSERT INTO RecitationGroup VALUES ('DD1393', '1', 'A', '2015-12-15', 100);
INSERT INTO RecitationGroup VALUES ('DD1393', '2', 'B', '2016-02-05', 100);

COMMIT;

--Leader(ID, name)
BEGIN;

INSERT INTO Leader VALUES ('mincock', 'Michael Minock');
INSERT INTO Leader VALUES ('dogmilk', 'Pernilla Ulvengren');

COMMIT;

--Problems(problemSet, condition)
BEGIN;

INSERT INTO Problems VALUES ('1abc2abc3abc', '1ab1ac1bc2ab2ac2bc3abc');
INSERT INTO Problems VALUES ('123', '123');
INSERT INTO Problems VALUES ('1ab23abc', '1a1b23abc');

COMMIT;

--Takes(cID, ID)
BEGIN;

INSERT INTO Takes VALUES ('DD1368', 'nsong');
INSERT INTO Takes VALUES ('DD1393', 'nsong');
INSERT INTO Takes VALUES ('DD1393', 'master');

COMMIT;

--Claims(ID, problemSet, condition, cID, recNum, RecitationGroup, claimedSet, called)
BEGIN;

INSERT INTO Claims VALUES ('nsong', '1abc2abc3abc', '1ab1ac1bc2ab2ac2bc3abc', 'DD1368', '1', 'A', '1ab2ac3abc',FALSE );
INSERT INTO Claims VALUES ('master', '1abc2abc3abc', '1ab1ac1bc2ab2ac2bc3abc', 'DD1368', '1', 'A', '1ac2bc3abc',FALSE );
INSERT INTO Claims VALUES ('nsong', '123', '123', 'DD1393', '1', 'A', '123',TRUE );
INSERT INTO Claims VALUES ('master', '1ab23abc', '1a1b23abc', 'DD1393', '2', 'B', '1a23abc',TRUE );

COMMIT;

--HasProblems(cID, recNum, problemSet, condition)
BEGIN;

INSERT INTO HasProblems VALUES ('DD1368', '1', '1abc2abc3abc', '1ab1ac1bc2ab2ac2bc3abc');
INSERT INTO HasProblems VALUES ('DD1368', '2', '1ab23abc', '1a1b23abc');
INSERT INTO HasProblems VALUES ('DD1393', '1', '123', '123');
INSERT INTO HasProblems VALUES ('DD1393', '2', '1abc2abc3abc', '1ab1ac1bc2ab2ac2bc3abc');

COMMIT;

--LeadsGroup(cID, recNum, RecitationGroup, ID)
BEGIN;

INSERT INTO LeadsGroup VALUES ('DD1368', '1', 'A', 'mincock');
INSERT INTO LeadsGroup VALUES ('DD1368', '2', 'B', 'mincock');
INSERT INTO LeadsGroup VALUES ('DD1393', '1', 'A', 'dogmilk');
INSERT INTO LeadsGroup VALUES ('DD1393', '2', 'B', 'dogmilk');

COMMIT;

--Results(cID, recNum, ID, points)
BEGIN;

INSERT INTO Results VALUES ('DD1368', '1', 'nsong', 22);
INSERT INTO Results VALUES ('DD1368', '1', 'master', 33);
INSERT INTO Results VALUES ('DD1393', '1', 'nsong', 100);
INSERT INTO Results VALUES ('DD1393', '2', 'master', 50);

COMMIT;
