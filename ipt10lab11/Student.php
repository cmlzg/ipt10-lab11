<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Student extends BaseModel
{
    
    public function all()
    {
    $sql = "SELECT * FROM students";
    $statement = $this->db->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
    return $result;
    }

    public function find($id)
    {
        $sql = "SELECT * FROM students WHERE id = :id";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchObject('\App\Models\Student');
        return $result ? $result : null; 
    }

    public function getStudentCode()
    {
        $sql = "SELECT student_code FROM students";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_COLUMN); 
        return $result;
    }

    public function getEmail()
    {
        $sql = "SELECT email FROM students";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_COLUMN); 
        return $result;
    }

    public function getFullName()
    {
        $sql = "SELECT CONCAT(first_name, ' ', last_name) AS full_name FROM students";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_COLUMN); 
        return $result;
    }

}
