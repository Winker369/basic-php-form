<?php
    $GLOBALS['db_settings'] = [
        'server_name' => 'mysql_db',
        'username' => 'root',
        'password' => 'root',
        'db_name' => 'propelrr'
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get request data
        $requestData = $_POST;
        // print_r($requestData);
        $statusCode = 500;
        $response = [
            'status' => $statusCode,
            'body' => 'Unexpected error!'
        ];
        $errorMessages = validateForm($requestData);

        if (!$errorMessages) {
            // Save request data
            $saveStatus = saveProfile($requestData);

            if ($saveStatus) {
                $statusCode = 200;
                $response = [
                    'status' => $statusCode,
                    'body' => 'Saved Successfully!'
                ];
            }
        } else {
            $statusCode = 400;
            $response = [
                'status' => $statusCode,
                'body' => $errorMessages
            ];
        }
        // Return response
        http_response_code($statusCode);
        print_r(json_encode($response));
    }

    function saveProfile($requestData) {
        $status = false;
        $dbSettings = $GLOBALS['db_settings'];
        $con = new mysqli(
            $dbSettings['server_name'],
            $dbSettings['username'],
            $dbSettings['password'],
            $dbSettings['db_name'],
        );

        // Check if connection is successful
        if ($con) {
            $currentDatetime = date('Y-m-d h:i:s');
            // sql to create table
            $sql = "INSERT INTO profile (
                    name,
                    age,
                    gender,
                    email,
                    address,
                    birthday,
                    created_at,
                    updated_at,
                    deleted_at
                ) VALUES (
                    '{$requestData['name']}',
                    '{$requestData['age']}',
                    '{$requestData['gender']}',
                    '{$requestData['email']}',
                    NULL,
                    '{$requestData['dob']}',
                    '{$currentDatetime}',
                    '{$currentDatetime}',
                    NULL
                );
            ";

            if ($con->query($sql)) {
                $status = true;
            }
        }

        return $status;
    }

    function validateForm($requestData) {
        $errorMessages = [];

        foreach ($requestData as $field => $value) {
            $errorMessage = validateField($field, $value);

            if ($errorMessage) {
                array_push($errorMessages, $errorMessage);
            }
        }

        return $errorMessages;
    }

    function validateField($field, $value) {
        $errorMessage = '';
        $pattern = '';

        switch ($field) {
            case 'name':
                // For checking comma and period
                $pattern = "/[^a-zA-Z,. ]+/";

                if (!$value) {
                    $errorMessage = 'Name is required.';
                } else if (preg_match($pattern, $value)) {
                    $errorMessage = 'Name has invalid character.';
                }
                break;
            case 'email':
                if (!$value) {
                    $errorMessage = 'Email is required.';
                } else if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errorMessage = 'Email has invalid format.';
                }
                break;
            case 'number':
                // For checking if number is in PH format
                $pattern =  "/^(09|\+639)\d{9}$/";

                if (!$value) {
                    $errorMessage = 'Number is required.';
                } else if (!preg_match($pattern, $value)) {
                    $errorMessage = 'Number has invalid format. Must be in PH mobile number';
                }
                break;
            case 'dob':
                if (!$value) {
                    $errorMessage = 'Date of Birth is required.';
                }
                break;
            case 'age':
                if (!$value) {
                    $errorMessage = 'Age is required.';
                } else if ($value <= 0) {
                    $errorMessage = 'Age must be atleast a 1 year old.';
                }
                break;
            case 'gender':
                if (!$value) {
                    $errorMessage = 'Gender is required.';
                }
                break;
        }

        return $errorMessage;
    }
