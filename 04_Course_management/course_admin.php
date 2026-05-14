<?php
if (!isset($_SESSION['role'])) {
    header("Location: ../index.php");
    exit();
}

include("../navbar.php");

require_once '../controllers/CourseController.php';

$controller = new CourseController();

$search = $_GET['search'] ?? '';

$status = $_GET['status'] ?? '';

/*
|--------------------------------------------------------------------------
| Search + Filter
|--------------------------------------------------------------------------
*/

if (!empty($search) && $status !== '') {

    $courses = $controller->searchAndFilter(
        $search,
        $status
    );

} elseif (!empty($search)) {

    $courses = $controller->search($search);

} elseif ($status !== '') {

    $courses = $controller->filter($status);

} else {

    $courses = $controller->index();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"
>

<title>Course Management</title>

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

.page-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:30px;
}

.page-header h2{
    font-size:30px;
    color:#1e293b;
}

.add-btn{

    background:#10b981;

    color:white;

    text-decoration:none;

    padding:12px 20px;

    border-radius:10px;

    font-weight:600;
}

.add-btn:hover{
    background:#059669;
}

.filter-form{

    display:flex;

    gap:15px;

    margin-bottom:25px;

    flex-wrap:wrap;
}

.filter-form input,
.filter-form select{

    padding:12px 15px;

    border:1px solid #cbd5e1;

    border-radius:10px;

    outline:none;
}

.filter-form button{

    background:#3b82f6;

    color:white;

    border:none;

    padding:12px 20px;

    border-radius:10px;

    cursor:pointer;

    font-weight:600;
}

.table-container{

    background:white;

    border-radius:15px;

    overflow:hidden;

    box-shadow:
    0 5px 20px rgba(0,0,0,0.05);
}

table{
    width:100%;
    border-collapse:collapse;
}

th{

    background:#1e293b;

    color:white;

    padding:16px;

    text-align:left;
}

td{

    padding:16px;

    border-bottom:1px solid #e2e8f0;
}

tr:hover{
    background:#f8fafc;
}

.edit-btn,
.delete-btn{

    text-decoration:none;

    padding:8px 14px;

    border-radius:8px;

    color:white;

    font-size:13px;

    margin-right:8px;
}

.edit-btn{
    background:#3b82f6;
}

.delete-btn{
    background:#ef4444;
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

</style>

</head>

<body>

<?php include '../navbar.php'; ?>

<div class="main-content">

<div class="page-header">

<h2>Course Management</h2>

<a
href="add.php"
class="add-btn"
>

+ Add Course

</a>

</div>

<form method="GET" class="filter-form">

<input
type="text"
name="search"
placeholder="Search course..."
value="<?= htmlspecialchars($search) ?>"
>

<select name="status">

<option value="">

All Status

</option>

<option
value="1"
<?= ($status === '1') ? 'selected' : '' ?>
>

Active

</option>

<option
value="0"
<?= ($status === '0') ? 'selected' : '' ?>
>

Inactive

</option>

</select>

<button type="submit">

Apply

</button>

</form>

<div class="table-container">

<table>

<tr>

<th>ID</th>

<th>Course Name</th>

<th>Course Code</th>

<th>Credit Points</th>

<th>Start Date</th>

<th>Status</th>

<th>Actions</th>

</tr>

<?php if ($courses->num_rows > 0): ?>

<?php while($row = $courses->fetch_assoc()): ?>

<tr>

<td>

<?= $row['CourseID'] ?>

</td>

<td>

<?= htmlspecialchars($row['CourseName']) ?>

</td>

<td>

<?= htmlspecialchars($row['CourseCode']) ?>

</td>

<td>

<?= $row['CreditPoints'] ?>

</td>

<td>

<?= $row['StartDate'] ?>

</td>

<td>

<span class="badge <?= $row['IsActive'] ? 'active' : 'inactive' ?>">

<?= $row['IsActive'] ? 'Active' : 'Inactive' ?>

</span>

</td>

<td>

<a
href="edit.php?id=<?= $row['CourseID'] ?>"
class="edit-btn"
>

Edit

</a>

<a
href="delete.php?id=<?= $row['CourseID'] ?>"
class="delete-btn"
onclick="return confirm('Delete this course?')"
>

Delete

</a>

</td>

</tr>

<?php endwhile; ?>

<?php else: ?>

<tr>

<td colspan="7">

No courses found

</td>

</tr>

<?php endif; ?>

</table>

</div>

</div>

</body>

</html>