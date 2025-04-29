<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function index()
    {
        $data = [
            "page_title" => "স্বাগতম",
            "page_heading" => "মুলগ্রাম মাধ্যমিক বিদ্যালয়",
            "menu" => [
                ["name" => "Home", "link" => base_url('/')],
                ["name" => "About", "link" => base_url('/about')],
                ["name" => "Exam", "link" => base_url('/exam')],
                ["name" => "Result", "link" => base_url('/result')],
                ["name" => "Courses", "link" => base_url('/courses')],
                ["name" => "Chinmoy Mondal", "link" => base_url('/contact')],
            ],
            "special_link" => [
                ["name" => "Notice", "link" => base_url('/applyNow')] // Apply Now button link,
            ],
            "courses" => [
                [
                    "title" => "Course Title 1",
                    "image" => base_url("public/assets/img/ima1.jpg"),
                    "description" => "Short description of the course content.",
                    "link" => base_url("/course-details/1")
                ],
                [
                    "title" => "Course Title 2",
                    "image" => base_url("public/assets/img/ima1.jpg"),
                    "description" => "Short description of the course content.",
                    "link" => base_url("/course-details/2")
                ],
                [
                    "title" => "Course Title 3",
                    "image" => base_url("public/assets/img/ima1.jpg"),
                    "description" => "Short description of the course content.",
                    "link" => base_url("/course-details/3")
                ],
            ],
            "activities" => [
                [
                    "title" => "Activity 1",
                    "image" => base_url("public/assets/img/ima1.jpg"),
                    "description" => "Short description of the activity.",
                    "link" => base_url("/activity-details/1")
                ],
                [
                    "title" => "Activity 2",
                    "image" => base_url("public/assets/img/ima1.jpg"),
                    "description" => "Short description of the activity.",
                    "link" => base_url("/activity-details/2")
                ],
                [
                    "title" => "Activity 3",
                    "image" => base_url("public/assets/img/ima1.jpg"),
                    "description" => "Short description of the activity.",
                    "link" => base_url("/activity-details/3")
                ],
            ]
        ];
        return view('page', $data);
    }
}