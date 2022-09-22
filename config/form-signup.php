<?php

return [
    'list-field' => [
        'job_id' => [
            'required' => false,
            'description' => 'If the user is viewing the job and clicks signup, then pass the job along',
            'validate_default' => 'numeric'
        ],
        'email' => [
            'required' => true,
            'description' => 'Email',
            'validate_default' => 'email'
        ],
        'password' => [
            'required' => false,
            'description' => 'Password',
            'validate_default' => ''
        ],
        'name' => [
            'required' => false,
            'description' => 'Name',
            'validate_default' => ''
        ],
        'gender' => [
            'required' => false,
            'description' => 'Gender',
            'validate_default' => ''
        ],
        'birthday' => [
            'required' => false,
            'description' => 'Birthday',
            'validate_default' => 'date'
        ],
        'nationality' => [
            'required' => false,
            'description' => 'Nationality',
            'validate_default' => ''
        ],
        'tel' => [
            'required' => false,
            'description' => 'Phone number',
            'validate_default' => 'numeric|digits_between:8,20'
        ],
        'city' => [
            'required' => false,
            'description' => 'City',
            'validate_default' => 'numeric|digits_between:8,20'
        ],
        'address' => [
            'required' => false,
            'description' => 'Address',
            'validate_default' => ''
        ],
        'language' => [
            'required' => false,
            'description' => 'Languages you can use',
            'validate_default' => 'array'
        ],
        'certification' => [
            'required' => false,
            'description' => 'Languages certification ex: N1,N2,N3,TOEIC',
            'validate_default' => ''
        ],
        'degree' => [
            'required' => false,
            'description' => 'Degree',
            'validate_default' => ''
        ],
        'school' => [
            'required' => false,
            'description' => 'School',
            'validate_default' => ''
        ],
        'japan_intern' => [
            'required' => false,
            'description' => 'Experience of technical intern trainees in Japan',
            'validate_default' => ''
        ],
        'exp_category' => [
            'required' => false,
            'description' => 'Work experience',
            'validate_default' => 'array'
        ],
        'resume_file' => [
            'required' => false,
            'description' => 'Resume file',
            'validate_default' => ''
        ],
        'cv_file' => [
            'required' => false,
            'description' => 'CV file',
            'validate_default' => ''
        ],
        'pref_location' => [
            'required' => false,
            'description' => 'Workplace address',
            'validate_default' => 'array'
        ],
        'pref_salary' => [
            'required' => false,
            'description' => 'Expect salary',
            'validate_default' => 'max:10000'
        ],
        'pref_category' => [
            'required' => false,
            'description' => 'Expect job',
            'validate_default' => 'array'
        ],
        'memo' => [
            'required' => false,
            'description' => 'Comment',
            'validate_default' => ''
        ],
        'status-of-residence' => [
            'required' => false,
            'description' => 'Status of residence',
            'validate_default' => ''
        ],
    ]
];

