<?php


@include 'database.php';
// prevent campus not chosen brick the html
if (isset($_POST['campus'])) {
    $selectedCampus = $_POST['campus'];
} else {
    $selectedCampus = null;
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./globalManagePrinter.css" />
    <link rel="stylesheet" href="./managePrinter.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" />

    <!-- swiper css link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <!-- header section starts -->

    <section class="header">
        <div class="logo">
            <a href="#">
                <img src="/image/logo.png" alt="logo" />
                <p>ĐẠI HỌC QUỐC GIA TP.HCM<br>TRƯỜNG ĐẠI HỌC BÁCH KHOA</p>
            </a>
        </div>

        <a href="login.php" class="login">Đăng nhập</a>
    </section>

    <!-- header section ends -->

    <section class="main">
        <div class="container">
            <div class="main-text">
                <p>QUẢN LÝ MÁY IN</p>
            </div>
            <div class="campus">
                <label class="choose-campus" name="campus">Chọn cơ sở</label>
                <button class="campus-button campus-container" id="campus1">Cơ sở 1</button>
                <button class="campus-button campus-container" id="campus2">Cơ sở 2</button>
            </div>
            <div class="flex">
                <div class="building">
                    <label class="choose-building">Chọn toà:</label>
                    <div>
                        <select class="dropdown-menu" name="building">
                            <option class="embed" value="toa1">choose-building</option>
                            <?php
                            $selectedCampus = $_POST['campus'];

                            if ($selectedCampus != null) {
                                $query = "SELECT * FROM PRINTERS_LIST WHERE PRINTERS_CAMPUSLOC = '$selectedCampus'";
                                $result = $conn->query($query);
                            }
                            if ($result) {
                                // Process the query result
                                while ($row = $result->fetch_assoc()) {
                                    // Access the data from the row
                                    $columnValue = $row['PRINTERS_BUILDINGLOC'];
                                    // Generate the HTML code for each building option
                                    echo '<option class="embed" value="' . $columnValue . '">' . $columnValue . '</option>';
                                }
                            } else {
                                // Handle the case when the query fails
                                echo "Error executing the query: " . $conn->error;
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="printer">
                    <label class="choose-printer">Chọn máy in:</label>
                    <div>
                        <select class="dropdown-menu" name="printer">
                            <option class="embed" value="id1">Choose Printers</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="printer-state-text">
                <p>Tình trạng máy in</p>
            </div>
            <div class="printer-state">
                <div class="printer-state-box">
                    <div class="printer-short-desc">
                        <img class="print-icon" alt="" src="/image/printer-icon.svg" />
                        <p>Máy in số 1 - H6 - 101</p>
                    </div>
                    <div class="printer-desc">
                        <div class="printer-id">
                            <span>
                                <span>ID: </span>
                                <span class="printer-info-text">1H11011</span>
                            </span>
                        </div>
                        <div class="printer-id">
                            <span>
                                <span>Mã: </span>
                                <span class="printer-info-text">Canon 1</span>
                            </span>
                        </div>
                        <div class="">
                            <span>Trạng thái hoạt động: </span>
                            <span class="printer-info-text"></span>
                            <button class="update-state-button" onclick="openUpdatePrinterState()">
                                <p>(Thay đổi)</p>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

    </section>

    <!-- footer section starts -->
    <div class="footer-container">
        <section class="footer">
            <div class="box-container">
                <div class="box">
                    <h3>student smart printing service</h3>
                    <img src="/image/logo.png" alt="logo" />
                </div>

                <div class="box">
                    <h3>website</h3>
                    <a href="https://hcmut.edu.vn/" class="hcmut">HCMUT</a>
                    <a href="https://mybk.hcmut.edu.vn/my/index.action" class="mybk">MyBK</a>
                    <a href="https://mybk.hcmut.edu.vn/bksi/public/vi/" class="bksi">BKSI</a>
                </div>

                <div class="box">
                    <h3>liên hệ</h3>
                    <a href="#">
                        <div class="location-icon"></div>268 Ly Thuong Kiet Street Ward 14, District 10, Ho Chi Minh
                        City, Vietnam
                    </a>
                    <a href="#">
                        <div class="phone-icon"></div>(028) 38 651 670 - (028) 38 647 256 (Ext: 5258, 5234)
                    </a>
                    <a href="mailto:elearning@hcmut.edu.vn" class="email">
                        <div class="email-icon"></div>elearning@hcmut.edu.vn
                    </a>
                </div>
            </div>
        </section>
        <div class="copyright">
            <p>Copyright 2007-2022 BKEL - Phát triển dựa trên Moodle</p>
        </div>
    </div>

    <script>
        // For saving campus
        $(document).ready(function () {
            $('.campus-button').click(function () {
                var selectedCampus = $(this).attr('id'); // Get the id of the selected campus button

                localStorage.setItem('selectedCampus', selectedCampus);
                $.post('updateCampus.php', { campus: selectedCampus }, function (response) {
                    // You can use the response from the server here if needed
                });
            });


            //for filtering building in campus, idk but do not touch 
            $(document).ready(function () {
                $('.campus-button').click(function () {
                    var selectedCampus = $(this).attr('id').replace('campus', ''); // Get the id of the selected campus button

                    // Send an AJAX request to getBuildings.php
                    $.post('updateBuilding.php', { campus: selectedCampus }, function (response) {
                        // Parse the JSON response from the server
                        var buildings = JSON.parse(response);

                        // Clear the building dropdown list
                        $('select[name="building"]').empty();

                        // Add each building to the dropdown list
                        $.each(buildings, function (index, building) {
                            $('select[name="building"]').append('<option class="embed" value="' + building + '">' + building + '</option>');
                        });
                    });
                });
            });
        });
        $(document).ready(function () {
            $('select[name="building"]').change(function () {
                var selectedBuilding = $(this).val(); // Get the value of the selected building

                // Clear the printer dropdown list
                $('select[name="printer"]').empty();

                // Send an AJAX request to getPrinters.php
                $.post('updatePrinters.php', { building: selectedBuilding }, function (response) {
                    // Parse the JSON response from the server
                    var printers = JSON.parse(response);

                    // Add each printer to the dropdown list
                    $.each(printers, function (index, printer) {
                        $('select[name="printer"]').append('<option class="embed" value="' + printer + '">' + printer + '</option>');
                    });
                });
            });
        });
        $(document).ready(function () {
            $('select[name="printer"]').change(function () {
                var selectedPrinter = $(this).val();
                $.post('getPrinterDetails.php', { printerId: selectedPrinter }, function (response) {
                    var printer = JSON.parse(response);
                    $('.printer-info-text').eq(0).text(printer.PRINTERS_ID);
                    $('.printer-info-text').eq(1).text(printer.PRINTERS_NAME);
                    $('.printer-info-text').eq(2).text(printer.PRINTERS_AVAI == 'Y' ? 'Đang hoạt động' : 'Không hoạt động');
                });
            });
        });

        function openUpdatePrinterState() {
            window.open("updatePrinterState.php", "_blank", "width=500,height=500");
        }
    </script>
</body>

</html>