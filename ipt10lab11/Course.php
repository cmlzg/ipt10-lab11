<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Course extends BaseModel
{
    public function all()
    {
        $sql = "
            SELECT 
                c.*, 
                COUNT(ce.student_code) AS enrolled_students 

            FROM 
                courses c 

            LEFT JOIN 

                Course_Enrolments ce ON c.course_code = ce.course_code 

            GROUP BY 
                c.id
        ";

        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Course');
        return $result;
    }

    public function find($code)
    {
        $sql = "SELECT * FROM courses WHERE course_code = ?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$code]);
        $result = $statement->fetchObject('\App\Models\Course');
        return $result;
    }

    public function getEnrolees($course_code)
    {
        $sql = "
            SELECT 
                s.* 
            FROM 

                Course_Enrolments AS ce  

            LEFT JOIN 
                students AS s ON s.student_code = ce.student_code 

            WHERE 
                ce.course_code = :course_code
        ";
        
        $statement = $this->db->prepare($sql);
        $statement->execute(['course_code' => $course_code]);
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
        return $result;
    }

    public function getCourseCode()
    {
        $sql = "SELECT course_code FROM courses";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_COLUMN); 
        return $result;
    }

    public function getCourseName()
    {
        $sql = "SELECT course_name FROM courses";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_COLUMN); 
        return $result;
    }
}