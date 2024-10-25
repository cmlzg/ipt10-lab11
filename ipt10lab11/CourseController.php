<?php

namespace App\Controllers;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Course;
use App\Controllers\BaseController;

class CourseController extends BaseController
{
    
    public function list()
{
    $courseModel = new Course();
    $courses = $courseModel->all();

    $template = 'courses';
    $data = [
        'items' => $courses
    ];

    $output = $this->render($template, $data);

    return $output;
}

public function enroll($course_code, $student_code, $enrollment_date)
{
    $sql = "INSERT INTO course_enrolments (course_code, student_code, enrollment_date) VALUES (:course_code, :student_code, :enrollment_date)";
    $statement = $this->db->prepare($sql);
    $statement->execute([
        'course_code' => $course_code,
        'student_code' => $student_code,
        'enrollment_date' => $enrollment_date
    ]);
}

public function viewCourse($course_code)
{
    $courseObj = new Course();
    $course = $courseObj->find($course_code);
    $enrollees = $courseObj->getEnrolees($course_code);

    $template = 'single-course';
    $data = [
        'course' => $course,
        'enrollees' => $enrollees
    ];

    $output = $this->render($template, $data);

    return $output;
}

public function exportCourse($course_code)
{
    $courseObj = new Course();
    $course = $courseObj->find($course_code);
    $enrollees = $courseObj->getEnrolees($course_code);

    
    $pdf = new \FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    
    $pdf->Cell(0, 10, 'Course Information', 0, 1, 'C');
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(0, 10, 'Course Code: ' . $course->course_code, 0, 1);
    $pdf->Cell(0, 10, 'Course Name: ' . $course->course_name, 0, 1);
    $pdf->Cell(0, 10, 'Description: ' . $course->description, 0, 1);
    $pdf->Cell(0, 10, 'Credits: ' . $course->credits, 0, 1);

    $pdf->Ln(10); 
 
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Enrolled Students', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    
    foreach ($enrollees as $student) {
        $pdf->Cell(0, 10, $student->first_name . ' ' . $student->last_name . ' (' . $student->email . ')', 0, 1);
    }

    $pdf->Output('D', 'Course_' . $course_code . '.pdf');
    exit;
}
}
