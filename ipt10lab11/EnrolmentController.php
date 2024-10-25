<?php

namespace App\Controllers;

use App\Models\Course;
use App\Models\CourseEnrolment;
use App\Models\Student;
use App\Controllers\BaseController;

class EnrolmentController extends BaseController
{
    public function enrollmentForm()
{
    $course_code = $_GET['course_code'] ?? null; // Get course code from query
    $courseObj = new Course();
    $studentObj = new Student();

    $template = 'enrollment-form';
    $data = [
        'courses' => $courseObj->all(),
        'students' => $studentObj->all(),
        'selected_course' => $courseObj->find($course_code) // Fetch the course details
    ];

    $output = $this->render($template, $data);

    return $output;
}


    public function enroll()
    {
        $course_code = $_POST['course_code'];
        $student_code = $_POST['student_code'];
        $enrollment_date = $_POST['enrollment_date'];

        
        $enrollmentModel = new CourseEnrolment();

        
        $enrollmentModel->enroll($course_code, $student_code, $enrollment_date);
        
        header("Location: /courses/{$course_code}");
        exit(); 
    }

}
