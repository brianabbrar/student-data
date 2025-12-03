<?php
session_start();
require('logics/connection.php');
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
        . $_SESSION['success'] .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    unset($_SESSION['success']);
}

// Alert Failed / Error
if (isset($_SESSION['failed'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
        . $_SESSION['failed'] .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    unset($_SESSION['failed']);
} 

if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: index.php");
    exit;
}
?>


<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Student Data | Students</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <!--end::Primary Meta Tags-->
    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="assets/css/adminlte.css" as="style" />
    <!--end::Accessibility Features-->
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
        onload="this.media='all'" />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="assets/css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />
    <!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <?php
        // Memasukkan komponen header
        include 'components/navbar.php';
        ?>
        <!--end::Header-->
        <!--begin::Sidebar-->
        <?php
        // Memasukkan komponen header
        include 'components/sidebar.php';
        ?>
        <!--end::Sidebar-->
        <!--begin::App Main-->
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Students</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Students</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content Header-->
            <!--begin::App Content-->
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title mb-0">All Student Data</h3>
                                    <div class="ms-auto">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                                            <i class="bi bi-plus-lg"></i> Add Student
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Faculty</th>
                                                <th>Department</th>
                                                <th>Major</th>
                                                <th>Class Of</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT students.*, major.major_name, department.dept_name, faculty.fac_name 
                                            FROM students
                                            JOIN major ON students.major_id = major.major_id
                                            JOIN department ON students.dept_id = department.dept_id
                                            JOIN faculty ON students.fac_id = faculty.fac_id
                                            ORDER BY students.student_id DESC");
                                            $no = 1;
                                            while ($row = mysqli_fetch_assoc($query)):
                                            ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $row['student_name']; ?></td>
                                                    <td><?= $row['fac_name']; ?></td>
                                                    <td><?= $row['dept_name']; ?></td>
                                                    <td><?= $row['major_name']; ?></td>
                                                    <td><?= $row['class_of']; ?></td>
                                                    <td><?= $row['status']; ?></td>
                                                    <td>
                                                        <button class="btn btn-warning btn-sm editStudentBtn"
                                                            data-id="<?= $row['student_id']; ?>"
                                                            data-name="<?= $row['student_name']; ?>"
                                                            data-facid="<?= $row['fac_id']; ?>"
                                                            data-deptid="<?= $row['dept_id']; ?>"
                                                            data-majorid="<?= $row['major_id']; ?>"
                                                            data-class="<?= $row['class_of']; ?>"
                                                            data-status="<?= $row['status']; ?>"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editStudentModal">Edit</button>

                                                        <a href="logics/delete_student.php?student_id=<?= $row['student_id']; ?>"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <ul class="pagination pagination-sm m-0 float-end">
                                        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.card -->
                            <!-- /.col -->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::App Content-->

                <div class="modal fade" id="addStudentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="logics/add_student.php" method="POST" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Student</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Faculty</label>
                                    <select name="fac_id" id="facultySelectStudentAdd" class="form-select" required>
                                        <option value="">-- Pilih Fakultas --</option>
                                        <?php
                                        $fac = mysqli_query($conn, "SELECT * FROM faculty");
                                        while ($f = mysqli_fetch_assoc($fac)) {
                                            echo "<option value='{$f['fac_id']}'>{$f['fac_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Department</label>
                                    <select name="dept_id" id="departmentSelectStudentAdd" class="form-select" required>
                                        <option value="">-- Pilih Department --</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Major</label>
                                    <select name="major_id" id="majorSelectStudentAdd" class="form-select" required>
                                        <option value="">-- Pilih Major --</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Student Name</label>
                                    <input type="text" name="student_name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Class Of</label>
                                    <input type="text" name="class_of" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="modal fade" id="editStudentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="logics/edit_student.php" method="POST" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Student</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="student_id" id="edit_student_id">

                                <div class="mb-3">
                                    <label>Faculty</label>
                                    <select name="fac_id" id="facultySelectStudentEdit" class="form-select" required>
                                        <option value="">-- Pilih Fakultas --</option>
                                        <?php
                                        $fac = mysqli_query($conn, "SELECT * FROM faculty");
                                        while ($f = mysqli_fetch_assoc($fac)) {
                                            echo "<option value='{$f['fac_id']}'>{$f['fac_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Department</label>
                                    <select name="dept_id" id="departmentSelectStudentEdit" class="form-select" required>
                                        <option value="">-- Pilih Department --</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Major</label>
                                    <select name="major_id" id="majorSelectStudentEdit" class="form-select" required>
                                        <option value="">-- Pilih Major --</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Student Name</label>
                                    <input type="text" name="student_name" id="edit_student_name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Class Of</label>
                                    <input type="text" name="class_of" id="edit_class_of" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Status</label>
                                    <select name="status" id="edit_status" class="form-select" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

        </main>
        <!--end::App Main-->
        <!--begin::Footer-->
        <?php
        // Memasukkan komponen footer
        include 'components/footer.php';
        ?>
        <!--end::Footer-->



    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="assets/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        document.querySelectorAll('.editStudentBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                const studentId = this.dataset.id;
                const name = this.dataset.name;
                const facId = this.dataset.facid;
                const deptId = this.dataset.deptid;
                const majorId = this.dataset.majorid;
                const classOf = this.dataset.class;
                const status = this.dataset.status;

                document.getElementById('edit_student_id').value = studentId;
                document.getElementById('edit_student_name').value = name;
                document.getElementById('edit_class_of').value = classOf;
                document.getElementById('edit_status').value = status;
                document.getElementById('facultySelectStudentEdit').value = facId;

                // Load departments based on faculty
                fetch('logics/get_departments.php?fac_id=' + facId)
                    .then(res => res.json())
                    .then(data => {
                        const deptSelect = document.getElementById('departmentSelectStudentEdit');
                        deptSelect.innerHTML = '<option value="">-- Pilih Department --</option>';
                        data.forEach(d => {
                            const opt = document.createElement('option');
                            opt.value = d.dept_id;
                            opt.textContent = d.dept_name;
                            deptSelect.appendChild(opt);
                        });
                        deptSelect.value = deptId;

                        // Load majors based on department
                        fetch('logics/get_majors.php?dept_id=' + deptId)
                            .then(res => res.json())
                            .then(data => {
                                const majorSelect = document.getElementById('majorSelectStudentEdit');
                                majorSelect.innerHTML = '<option value="">-- Pilih Major --</option>';
                                data.forEach(m => {
                                    const opt = document.createElement('option');
                                    opt.value = m.major_id;
                                    opt.textContent = m.major_name;
                                    majorSelect.appendChild(opt);
                                });
                                majorSelect.value = majorId;
                            });
                    });
            });
        });

        // Reset dependent dropdowns saat faculty berubah di modal edit
        document.getElementById('facultySelectStudentEdit').addEventListener('change', function() {
            const facId = this.value;
            const deptSelect = document.getElementById('departmentSelectStudentEdit');
            deptSelect.innerHTML = '<option>Memuat...</option>';
            fetch('logics/get_departments.php?fac_id=' + facId)
                .then(res => res.json())
                .then(data => {
                    deptSelect.innerHTML = '<option value="">-- Pilih Department --</option>';
                    data.forEach(d => {
                        const opt = document.createElement('option');
                        opt.value = d.dept_id;
                        opt.textContent = d.dept_name;
                        deptSelect.appendChild(opt);
                    });
                    document.getElementById('majorSelectStudentEdit').innerHTML = '<option value="">-- Pilih Major --</option>';
                });
        });

        document.getElementById('departmentSelectStudentEdit').addEventListener('change', function() {
            const deptId = this.value;
            const majorSelect = document.getElementById('majorSelectStudentEdit');
            majorSelect.innerHTML = '<option>Memuat...</option>';
            fetch('logics/get_majors.php?dept_id=' + deptId)
                .then(res => res.json())
                .then(data => {
                    majorSelect.innerHTML = '<option value="">-- Pilih Major --</option>';
                    data.forEach(m => {
                        const opt = document.createElement('option');
                        opt.value = m.major_id;
                        opt.textContent = m.major_name;
                        majorSelect.appendChild(opt);
                    });
                });
        });

        // Saat faculty berubah di modal Add Student
        document.getElementById('facultySelectStudentAdd').addEventListener('change', function() {
            const facId = this.value;
            const deptSelect = document.getElementById('departmentSelectStudentAdd');
            deptSelect.innerHTML = '<option>Memuat...</option>';

            fetch('logics/get_departments.php?fac_id=' + facId)
                .then(res => res.json())
                .then(data => {
                    deptSelect.innerHTML = '<option value="">-- Pilih Department --</option>';
                    data.forEach(d => {
                        const opt = document.createElement('option');
                        opt.value = d.dept_id;
                        opt.textContent = d.dept_name;
                        deptSelect.appendChild(opt);
                    });

                    // Reset major
                    document.getElementById('majorSelectStudentAdd').innerHTML = '<option value="">-- Pilih Major --</option>';
                });
        });

        // Saat department berubah di modal Add Student
        document.getElementById('departmentSelectStudentAdd').addEventListener('change', function() {
            const deptId = this.value;
            const majorSelect = document.getElementById('majorSelectStudentAdd');
            majorSelect.innerHTML = '<option>Memuat...</option>';

            fetch('logics/get_majors.php?dept_id=' + deptId)
                .then(res => res.json())
                .then(data => {
                    majorSelect.innerHTML = '<option value="">-- Pilih Major --</option>';
                    data.forEach(m => {
                        const opt = document.createElement('option');
                        opt.value = m.major_id;
                        opt.textContent = m.major_name;
                        majorSelect.appendChild(opt);
                    });
                });
        });


        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- sortablejs -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" crossorigin="anonymous"></script>
    <!-- sortablejs -->
    <script>
        new Sortable(document.querySelector('.connectedSortable'), {
            group: 'shared',
            handle: '.card-header',
        });

        const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
        cardHeaders.forEach((cardHeader) => {
            cardHeader.style.cursor = 'move';
        });
    </script>
    <!-- apexcharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
    <!-- ChartJS -->
    <script>
        // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
        // IT'S ALL JUST JUNK FOR DEMO
        // ++++++++++++++++++++++++++++++++++++++++++

        const sales_chart_options = {
            series: [{
                    name: 'Digital Goods',
                    data: [28, 48, 40, 19, 86, 27, 90],
                },
                {
                    name: 'Electronics',
                    data: [65, 59, 80, 81, 56, 55, 40],
                },
            ],
            chart: {
                height: 300,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            legend: {
                show: false,
            },
            colors: ['#0d6efd', '#20c997'],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth',
            },
            xaxis: {
                type: 'datetime',
                categories: [
                    '2023-01-01',
                    '2023-02-01',
                    '2023-03-01',
                    '2023-04-01',
                    '2023-05-01',
                    '2023-06-01',
                    '2023-07-01',
                ],
            },
            tooltip: {
                x: {
                    format: 'MMMM yyyy',
                },
            },
        };

        const sales_chart = new ApexCharts(
            document.querySelector('#revenue-chart'),
            sales_chart_options,
        );
        sales_chart.render();
    </script>
    <!-- jsvectormap -->
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
        integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
        integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY=" crossorigin="anonymous"></script>
    <!-- jsvectormap -->
    <script>
        // World map by jsVectorMap
        new jsVectorMap({
            selector: '#world-map',
            map: 'world',
        });

        // Sparkline charts
        const option_sparkline1 = {
            series: [{
                data: [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021],
            }, ],
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: 'straight',
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ['#DCE6EC'],
        };

        const sparkline1 = new ApexCharts(document.querySelector('#sparkline-1'), option_sparkline1);
        sparkline1.render();

        const option_sparkline2 = {
            series: [{
                data: [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921],
            }, ],
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: 'straight',
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ['#DCE6EC'],
        };

        const sparkline2 = new ApexCharts(document.querySelector('#sparkline-2'), option_sparkline2);
        sparkline2.render();

        const option_sparkline3 = {
            series: [{
                data: [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21],
            }, ],
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: 'straight',
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ['#DCE6EC'],
        };

        const sparkline3 = new ApexCharts(document.querySelector('#sparkline-3'), option_sparkline3);
        sparkline3.render();
    </script>
    <!--end::Script-->
</body>
<!--end::Body-->

</html>