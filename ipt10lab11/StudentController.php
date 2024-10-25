<?php

namespace App\Controllers;

use App\Models\Student;
use App\Controllers\BaseController;

class StudentController extends BaseController
{
    public function list()
    {
        $studentModel = new Student();
        $students = $studentModel->all();

        
        $template = 'students';
        $data = [
            'students' => $students
        ];

        
        $output = $this->render($template, $data);

        return $output;
    }
}
