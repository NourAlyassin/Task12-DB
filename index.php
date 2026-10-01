<?php

// Students (student_id, first_name, last_name, email, birth_date)

// Instructors (instructor_id, first_name, last_name, email, salary)

// Courses (course_id, course_name, credits, instructor_id of(Instructors))

// Enrollments (enrollment_id, student_id of(Students), course_id of(Courses), enrollment_date, grade)

// =================================================================================

$conn = mysqli_connect("localhost", "root", "", "school_system");
if (!$conn) {
    echo "Connect Error" . mysqli_connect_error();
}



// 1. Insert sample data into Students

$sql = "INSERT INTO Students (first_name, last_name, email, birth_date) VALUES
('Ahmed',  'Hassan',  'ahmed.hassan@example.com',  '2001-04-12'),
('Mona',   'Said',    'mona.said@example.com',     '2002-09-30'),
('Youssef','Ali',     'youssef.ali@example.com',   '2000-01-25'),
('Salma',  'Ibrahim', 'salma.ibrahim@example.com', '2003-06-18'),
('Omar',   'Khaled',  'omar.khaled@example.com',   '2001-11-07')";

$result = mysqli_query($conn, $sql);


// ======================================================================

// 2. Insert sample data into Instructors

$sql = "INSERT INTO Instructors (name, email, salary) VALUES
('Hany',   'hany.mostafa@example.com', 12000.00),
('Laila',   'laila.fouad@example.com',   9500.00),
('Karim',   'karim.adel@example.com',   11000.00)";

$result = mysqli_query($conn, $sql);


// =======================================================================

// 3. Update a student's email

$sql = "UPDATE Students
SET email = 'mona.newmail@example.com'
WHERE id = 2";


// =======================================================================

// 4. Insert sample data into Courses

$resutl= "INSERT INTO Courses (course_name, credits, instructor_id) VALUES
('Introduction to MySQL', 3, 1),
('Database Design',       4, 1),
('Web Development',       3, 2),
('Python Programming',    4, 3)";

$result = mysqli_query($conn, $sql);


// =======================================================================

// 5. Enroll a student in a course

$sql = "INSERT INTO Enrollments (enrollment_date)
VALUES (CURDATE())";

$result = mysqli_query($conn, $sql);


// =======================================================================

// 6. Delete an enrollment record

$sql = "DELETE FROM Enrollments
WHERE student_id = 1 AND course_id = 1";


// ======================================================================

// 7. Get total number of students

$sql = "SELECT COUNT(*) AS total_students
FROM Students";


// ======================================================================

// 8. Show all students enrolled in "Introduction to MySQL"

$sql = "SELECT s.student_id, s.first_name, s.last_name, s.email
FROM Students s
JOIN Enrollments e ON s.student_id = e.student_id
JOIN Courses c     ON e.course_id  = c.course_id
WHERE c.course_name = 'Introduction to MySQL'";


// ======================================================================

// 9. Show all courses with the instructor's name (subquery only)

$sql = "SELECT c.course_id,
       c.course_name,
       (SELECT CONCAT(i.first_name, ' ', i.last_name)
        FROM Instructors i
        WHERE i.instructor_id = c.instructor_id) AS instructor_name
FROM Courses c";


// ======================================================================

// 10. Count students enrolled in each course (GROUP BY)

$sql = "SELECT c.course_id,
       c.course_name,
       COUNT(e.student_id) AS students_count
FROM Courses c
LEFT JOIN Enrollments e ON c.course_id = e.course_id
GROUP BY c.course_id, c.course_name";


// ======================================================================

// 11. List courses a specific student is enrolled in (by name)

$sql = "SELECT c.course_id, c.course_name, c.credits
FROM Courses c
JOIN Enrollments e ON c.course_id = e.course_id
JOIN Students s    ON e.student_id = s.student_id
WHERE s.first_name = 'Ahmad' AND s.last_name = 'Hassan'";


// ======================================================================

// 12. Show instructors teaching more than one course

$sql = "SELECT i.instructor_id,
       CONCAT(i.first_name, ' ', i.last_name) AS instructor_name,
       COUNT(c.course_id) AS courses_count
FROM Instructors i
JOIN Courses c ON i.instructor_id = c.instructor_id
GROUP BY i.instructor_id, i.first_name, i.last_name
HAVING COUNT(c.course_id) > 1";


// ======================================================================

// 13. Show students who are not enrolled in any course

$sql = "SELECT s.student_id, s.first_name, s.last_name, s.email
FROM Students s
LEFT JOIN Enrollments e ON s.student_id = e.student_id
WHERE e.enrollment_id IS NULL";


// ======================================================================

// 14. Count the number of courses each instructor teaches

$sql = "SELECT i.instructor_id,
       CONCAT(i.first_name, ' ', i.last_name) AS instructor_name,
       COUNT(c.course_id) AS courses_count
FROM Instructors i
LEFT JOIN Courses c ON i.instructor_id = c.instructor_id
GROUP BY i.instructor_id, i.first_name, i.last_name";


// =======================================================================

// 15. Average number of students per course

$sql = "SELECT ROUND(AVG(students_count), 2) AS avg_students_per_course
FROM (
    SELECT c.course_id, COUNT(e.student_id) AS students_count
    FROM Courses c
    LEFT JOIN Enrollments e ON c.course_id = e.course_id
    GROUP BY c.course_id
) AS course_counts";

