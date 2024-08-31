<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "office") {
        http_response_code(403);
        exit();
    }
} else {
    http_response_code(403);
    header('Location: https://gpphostels.rf.gd');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .hidden {
            display: none;
        }

        table {
            width: 100%;
            border: none;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        .search {
            display: flex;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.1);
            /* Transparency */
            padding: 10px;
            border-radius: 5px;
        }

        .search input[type="text"],
        .search select {
            padding: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            background-color: rgba(33, 39, 82, 0.8);
            height: 120%;
            /* Optional: Add a shadow */
            border: none;
        }

        .search select {
            border-radius: 0px 12px 12px 0px;
            /* Optional: Add a shadow */
        }

        .search input {
            width: 100%;
            border-radius: 12px;
            /* Optional: Add a shadow */
        }

        .search input,
        .search select {
            color: wheat;
            /* Adjust placeholder color */
        }
    </style>
    <style>
        #nav-icon1,
        #nav-icon2,
        #nav-icon3,
        #nav-icon4 {
            width: 60px;
            height: 45px;
            position: relative;
            margin: 50px auto;
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
            -webkit-transition: .5s ease-in-out;
            -moz-transition: .5s ease-in-out;
            -o-transition: .5s ease-in-out;
            transition: .5s ease-in-out;
            cursor: pointer;
        }

        #nav-icon1 span,
        #nav-icon3 span,
        #nav-icon4 span {
            display: block;
            position: absolute;
            height: 9px;
            width: 100%;
            background: #d3531a;
            border-radius: 9px;
            opacity: 1;
            left: 0;
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
            -webkit-transition: .25s ease-in-out;
            -moz-transition: .25s ease-in-out;
            -o-transition: .25s ease-in-out;
            transition: .25s ease-in-out;
        }


        /* Icon 2 */

        #nav-icon2 {
            position: fixed;
            left: 10px;
        }

        #nav-icon2 span {
            display: block;
            position: absolute;
            height: 7px;
            width: 50%;
            background: #c7c7c7;
            opacity: 1;
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
            -webkit-transition: .25s ease-in-out;
            -moz-transition: .25s ease-in-out;
            -o-transition: .25s ease-in-out;
            transition: .25s ease-in-out;

        }

        #nav-icon2 span:nth-child(even) {
            left: 50%;
            border-radius: 0 9px 9px 0;
        }

        #nav-icon2 span:nth-child(odd) {
            left: 0px;
            border-radius: 9px 0 0 9px;
        }
</style>
</head>
</html>
