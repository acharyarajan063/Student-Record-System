<?php
/**
 * Component: Attendance Management
 * Tier: Presentation Layer
 * Goal: Professional bulk-marking interface with user feedback.
 */

require_once '../controllers/AttendanceController.php';
$controller = new AttendanceController();

// Configuration
$courseId = 9; 
$currentDate = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance - EduCare SRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light">

    <div class="container mt-5">
        
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Success!</strong> Attendance records have been committed to the database.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white p-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-user-check me-2"></i> 
                    Daily Attendance: CS101
                </h5>
                <span class="badge bg-light text-dark px-3 py-2">
                    <i class="fas fa-calendar-alt me-1"></i> <?= $currentDate ?>
                </span>
            </div>
            
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" id="studentSearch" class="form-control" placeholder="Filter student by name or ID...">
                        </div>
                    </div>
                </div>

                <form action="process_attendance.php" method="POST">
                    <input type="hidden" name="course_id" value="<?= $courseId ?>">
                    <input type="hidden" name="attendance_date" value="<?= $currentDate ?>">
                    <input type="hidden" name="recorded_by" value="Samuel Agbesi">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="attendanceTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Excused?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($id = 1; $id <= 10; $id++): ?>
                                <tr>
                                    <td class="fw-bold text-primary">STU-00<?= $id ?></td>
                                    <td>Student Name #<?= $id ?></td>
                                    <td>
                                        <select name="attendance[<?= $id ?>][status]" class="form-select border-primary status-select">
                                            <option value="Present" selected>Present</option>
                                            <option value="Absent">Absent</option>
                                            <option value="Late">Late</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check d-inline-block">
                                            <input type="checkbox" name="attendance[<?= $id ?>][is_excused]" value="1" class="form-check-input border-secondary">
                                        </div>
                                    </td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm">
                            <i class="fas fa-save me-2"></i> Finalize Attendance Sheet
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="card-footer text-center bg-white py-3">
                <a href="../index.php" class="text-decoration-none text-muted small">
                    <i class="fas fa-chevron-left me-1"></i> Return to System Menu
                </a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('studentSearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#attendanceTable tbody tr');
            
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>