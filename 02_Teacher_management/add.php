<?php

require_once '../controllers/teachercontroller.php';

$controller = new TeacherController();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $controller->store([

        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'department' => $_POST['department'],
        'date_joined' => $_POST['date_joined'],
        'is_active' => $_POST['is_active']

    ]);

    header(
        "Location: teacher_admin.php"
    );

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Add Teacher</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins', sans-serif;
        }

        body{
            background:#f8fafc;
        }

        .main-content{
            padding:40px;
        }

        .card{
            background:white;
            max-width:700px;
            padding:30px;
            border-radius:15px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        h2{
            margin-bottom:25px;
            color:#1e293b;
        }

        .input-group{
            margin-bottom:20px;
        }

        label{
            display:block;
            margin-bottom:8px;
            font-weight:500;
            color:#334155;
        }

        input,
        select{
            width:100%;
            padding:12px;
            border:1px solid #cbd5e1;
            border-radius:10px;
            font-size:15px;
        }

        button{
            background:#3b82f6;
            color:white;
            border:none;
            padding:14px 20px;
            border-radius:10px;
            cursor:pointer;
            font-weight:600;
        }

        button:hover{
            background:#2563eb;
        }

    </style>

</head>

<body>

<?php include '../navbar.php'; ?>

<div class="main-content">

    <div class="card">

        <h2>Add Teacher</h2>

        <form method="POST">

            <div class="input-group">

                <label>Teacher Name</label>

                <input
                    type="text"
                    name="name"
                    required
                >

            </div>

            <div class="input-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    required
                >

            </div>

            <div class="input-group">

                <label>Department</label>

                <input
                    type="text"
                    name="department"
                    required
                >

            </div>

            <div class="input-group">

                <label>Date Joined</label>

                <input
                    type="date"
                    name="date_joined"
                    required
                >

            </div>

            <div class="input-group">

                <label>Status</label>

                <select name="is_active">

                    <option value="1">

                        Active

                    </option>

                    <option value="0">

                        Inactive

                    </option>

                </select>

            </div>

            <button type="submit">

                Add Teacher

            </button>

        </form>

    </div>

</div>

</body>
</html>