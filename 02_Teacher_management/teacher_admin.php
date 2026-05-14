<?php
session_start();

if (
    !isset($_SESSION['role']) ||
    ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'teacher')
) {
    header("Location: ../index.php");
    exit();
}

include("../navbar.php");

require_once '../controllers/teachercontroller.php';

$controller = new TeacherController();

$search = $_GET['search'] ?? '';

if(!empty($search)){

    $teachers = $controller->search($search);

}else{

    $teachers = $controller->index();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Teacher Management</title>

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

        .top-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
        }

        h2{
            color:#1e293b;
        }

        .add-btn{
            background:#3b82f6;
            color:white;
            padding:12px 20px;
            border-radius:10px;
            text-decoration:none;
            font-weight:600;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:15px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        form{
            margin-bottom:20px;
            display:flex;
            gap:10px;
        }

        input{
            flex:1;
            padding:12px;
            border:1px solid #cbd5e1;
            border-radius:10px;
        }

        button{
            padding:12px 20px;
            background:#1e293b;
            color:white;
            border:none;
            border-radius:10px;
            cursor:pointer;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#1e293b;
            color:white;
            padding:15px;
            text-align:left;
        }

        td{
            padding:15px;
            border-bottom:1px solid #e2e8f0;
        }

        .badge{
            padding:6px 12px;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
        }

        .active{
            background:#dcfce7;
            color:#166534;
        }

        .inactive{
            background:#fee2e2;
            color:#991b1b;
        }

        .edit-btn{
            background:#3b82f6;
            color:white;
            padding:8px 12px;
            border-radius:8px;
            text-decoration:none;
            margin-right:8px;
        }

        .delete-btn{
            background:#ef4444;
            color:white;
            padding:8px 12px;
            border-radius:8px;
            text-decoration:none;
        }

    </style>

</head>

<body>



<div class="main-content">

    <div class="top-bar">

        <h2>Teacher Management</h2>

        <a
            href="add.php"
            class="add-btn"
        >
            + Add Teacher
        </a>

    </div>

    <div class="card">

        <form method="GET">

            <input
                type="text"
                name="search"
                placeholder="Search teacher..."
                value="<?= htmlspecialchars($search) ?>"
            >

            <button type="submit">

                Search

            </button>

        </form>

        <table>

            <tr>

                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Date Joined</th>
                <th>Status</th>
                <th>Actions</th>

            </tr>

            <?php while($row = $teachers->fetch_assoc()): ?>

            <tr>

                <td><?= $row['TeacherID'] ?></td>

                <td><?= $row['TeacherName'] ?></td>

                <td><?= $row['Email'] ?></td>

                <td><?= $row['Department'] ?></td>

                <td><?= $row['DateJoined'] ?></td>

                <td>

                    <span class="badge <?= $row['IsActive'] ? 'active' : 'inactive' ?>">

                        <?= $row['IsActive'] ? 'Active' : 'Inactive' ?>

                    </span>

                </td>

                <td>

                    <a
                        href="edit.php?id=<?= $row['TeacherID'] ?>"
                        class="edit-btn"
                    >
                        Edit
                    </a>

                    <a
                        href="delete.php?id=<?= $row['TeacherID'] ?>"
                        class="delete-btn"
                    >
                        Delete
                    </a>

                </td>

            </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

</body>
</html>