<?php

session_start();

if (
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'student'
) {
    header("Location: ../index.php");
    exit();
}

include("../navbar.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Attendance Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#f1f5f9;
}

.dashboard{

    margin-left:250px;

    padding:40px;
}

.page-title{

    font-size:34px;

    font-weight:700;

    color:#1e293b;

    margin-bottom:30px;
}

.card-grid{

    display:grid;

    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));

    gap:25px;
}

.card{

    background:white;

    padding:30px;

    border-radius:20px;

    box-shadow:0 5px 15px rgba(0,0,0,0.05);

    transition:0.3s;
}

.card:hover{

    transform:translateY(-5px);
}

.card h3{

    font-size:20px;

    color:#0f172a;

    margin-bottom:15px;
}

.card p{

    color:#64748b;

    line-height:1.6;
}

.big-number{

    font-size:50px;

    font-weight:700;

    color:#2563eb;

    margin-top:10px;
}

@media(max-width:768px){

    .dashboard{

        margin-left:0;

        padding:20px;
    }
}

</style>

</head>

<body>

<div class="dashboard">

    <h1 class="page-title">

        Attendance Dashboard

    </h1>

    <div class="card-grid">

        <div class="card">

            <h3>Total Attendance</h3>

            <div class="big-number">

                92%

            </div>

        </div>

        <div class="card">

            <h3>Present Days</h3>

            <div class="big-number">

                48

            </div>

        </div>

        <div class="card">

            <h3>Absent Days</h3>

            <div class="big-number">

                4

            </div>

        </div>

        <div class="card">

            <h3>Attendance Status</h3>

            <p>

                Excellent attendance performance this semester.

            </p>

        </div>

    </div>

</div>

</body>

</html>