<?php
include 'formHelper.php';

$inputs = [
    [
        'type' => 'text',
        'name' => 'name',
        'placeholder' => 'Vardas',
    ],
    [
        'type' => 'text',
        'name' => 'last_name',
        'placeholder' => 'Pavarde',
    ],
    [
        'type' => 'email',
        'name' => 'email',
        'placeholder' => 'your@email.com',
    ],
    [
        'type' => 'password',
        'name' => 'password',
        'placeholder' => '********',
    ],
    [
        'type' => 'password',
        'name' => 'password2',
        'placeholder' => '********',
    ],
    [
        'type' => 'select',
        'name' => 'number_of_children',
        'options' => [0,1,2,3,"4+"],
    ],
    [
        'type' => 'submit',
        'value' => 'Register',
        'name' => 'register',
    ],
    [
        'type' => 'textarea',
        'id' => 'user_text',
        'name' => 'text',
        'rows' => '4',
        'cols' => '50',
    ]
];

echo '<form action="registration.php" method="post">';

foreach ($inputs as $input){
    if($input['type'] === 'select'){
        echo generateSelect($input);
    } elseif ($input['type'] === 'textarea'){
        echo generateTextarea($input);
    } else {
        echo generateInput($input);
    }
    echo '<br>';
}

echo '</form>';
