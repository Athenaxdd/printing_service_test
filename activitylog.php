<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log</title>

    <!-- swiper css link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <!-- remix icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <!-- custom css file link -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <!-- header section starts -->

    <section class="header">
        <div class="logo">
            <a href="#">
                <img src="image/logo.png" alt="logo" />
                <p>ĐẠI HỌC QUỐC GIA TP.HCM<br>TRƯỜNG ĐẠI HỌC BÁCH KHOA</p>
            </a>
        </div>

        <a href="login.php" class="login">Đăng nhập</a>
    </section>

    <!-- header section ends -->



    <!--POP UP -->
    <!-- Send print request POP UP  -->
    <?php
    @include 'database.php';
    if (isset($_GET['send_id'])) {
        $send_id = $_GET['send_id'];
        // Get request ID
        $filter_requestid = mysqli_query($conn, "select * from request_perform_printer where id ='$send_id'");
        $get_requestid = mysqli_fetch_array($filter_requestid);
        $requestid_ = $get_requestid["requestid"];
        // Get file info
        $popup_dtfile = mysqli_query($conn, "SELECT * FROM file where id in (select fileid from requestprint where id='$requestid_')");
        $get_file_ = mysqli_fetch_array($popup_dtfile);
        // Get request info
        $printerid_ = $get_requestid['printerId'];
        $popup_dtrequest = mysqli_query($conn, "select * from requestprint where id ='$requestid_'");
        $get_request_ = mysqli_fetch_array($popup_dtrequest);
        //Get printer info
        $popup_dtprinter = mysqli_query($conn, "SELECT * FROM printer where id='$printerid_'");
        $get_printer_info_ = mysqli_fetch_array($popup_dtprinter);
        $display_printer_info_ = $get_printer_info_['model'] . ' - Cơ sở ' . $get_printer_info_['Unibranch'] . ' - ' . $get_printer_info_['building'] . ' - ' . $get_printer_info_['room'];
        //Get user info
        $popup_dtuser = mysqli_query($conn, "SELECT * FROM user where id in (select userid from requestprint where id='$requestid_')");
        $get_user = mysqli_fetch_array($popup_dtuser);
        $Now = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));

        //  <!--End get data task -->
        echo '<div class="popup" id="sendprint_popup">
            <img src="image/message.jpg" width="50px" height="50px">
            <div class="popup_text">
                <h3 style="margin-top:5%; color:var(--main-color)">Gửi yêu cầu in</h3>
                <table>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-timer-fill"></i>Thời gian:</th>
                        </td>
                        <td>
                          ' . $Now->format('Y-m-d H:i:s') . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-user-fill"></i>Tên người dùng:</th>
                        </td>
                        <td>
                           ' . $get_user["fullname"] . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-file-fill"></i>Tập tin đã chọn:</th>
                        </td>
                        <td>
                           ' . $get_file_["name"] . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-file-paper-2-fill"></i>Số mặt in:</th>
                        </td>
                        <td>
                            ' . $get_request_["numbersides"] . ' 
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-file-copy-fill"></i>Số bản copy:</th>
                        </td>
                        <td>
                            ' . $get_request_["numbercopies"] . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-file-list-3-fill"></i>Số trang trên một tờ giấy in:</th>
                        </td>
                        <td>
                            ' . $get_request_["paper_per_sheet"] . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-file-paper-fill"></i>Khổ giấy:</th>
                        </td>
                        <td>
                            ' . $get_request_["papersize"] . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <th class="title_"><i class="ri-printer-fill"></i>Máy in:</th>
                        </td>
                        <td>
                           ' . $display_printer_info_ . '
                        </td>
                    </tr>';
        $popup_dtlistpages = mysqli_query($conn, "select page from listpages where performid='$send_id'");
        $list = array();
        while ($list_child = mysqli_fetch_assoc($popup_dtlistpages)) {
            $list[] = $list_child['page'];
        }
        $display = implode(", ", $list);
        echo '<tr>
                        <td>
                        <th class="title_"><i class="ri-list-check"></i>Số trang muốn in:</th>
                        </td>
                        <td>
                           ' . $display . '
                        </td>
                    </tr>
                </table>
        <div class="button-group">
            <button onclick="ClosePopup(\'sendprint_popup\')" class="button" type="button">Thoát</button>
            <a class="button" href="send_activitylog.php?send_confirm_id=' . $send_id . '" type="button">Xác nhận</a>
        </div>
        </div>
    </div>';
    } ?>
    <!-- END Send print request POP UP  -->
    <!-- ---------------------------------------------------------------------------------------------------------- -->
    <!-- Confirm delete request POP UP -->
    <?php
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        echo ' <div class="popup" id="DELETE_popup">
            <img src="image/message.jpg" width="50px" height="50px">
            <div class="popup_text">
                <h2 style="margin-top:5%; color:var(--main-color)">Message:</h2>
                <h4 style="color:var(--text-color)">Bạn có chắc chắn muốn xóa không?</h4>
            </div>
            <div class="button-group">
                <button onclick="ClosePopup(\'DELETE_popup\')" class="button" type="button">Thoát</button>
                <a class="button" href="delete_activitylog.php?id=' . $delete_id . '">Xóa</a>
            </div>
        </div>';
    } ?>
    <!-- END Confirm delete request POP UP  -->
    <!-- END POP UP -->

    <?php
    $result = mysqli_query($conn, "SELECT * FROM request_perform_printer");
    $data = $result->fetch_all(MYSQLI_ASSOC);
    ?>
    <div class="body">
        <h2>NHẬT KÝ SỬ DỤNG DỊCH VỤ IN</h2>
        <section>
            <table border="1">
                <tr>
                    <th>Thời gian<br> bắt đầu in</th>
                    <th>Thời gian<br> kết thúc in</th>
                    <th>Nội dung đăng ký in</th>
                    <th>Tổng<br> số page</th>
                    <th>Số mặt</th>
                    <th>Số<br> bản copy</th>
                    <th>Số<br>trang<br>trên<br>giấy in</th>
                    <th>Khổ<br> giấy</th>
                    <th>Mã máy in</th>
                    <th>Trạng thái</th>
                    <th>Tùy<br> chọn</th>
                </tr>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td>
                            <?php
                            // Get request ID
                            $requestid = $row['requestid'];
                            // Get file info
                            $filter_file = mysqli_query($conn, "SELECT * FROM file where id in (select fileid from requestprint where id='$requestid')");
                            $get_file = mysqli_fetch_array($filter_file);
                            // Get printer ID
                            $printerid = $row['printerId'];
                            // Get request info
                            $filter_request = mysqli_query($conn, "select * from requestprint where id ='$requestid'");
                            $get_request = mysqli_fetch_array($filter_request);
                            // Get printer info
                            $filter_printer = mysqli_query($conn, "SELECT * FROM printer where id='$printerid'");
                            $get_printer_info = mysqli_fetch_array($filter_printer);
                            $display_printer_info = $get_printer_info['model'] . ' - Cơ sở ' . $get_printer_info['Unibranch'] . ' - ' . $get_printer_info['building'] . ' - ' . $get_printer_info['room'];
                            ?>

                            <?= $row['starttime'] ?>
                        </td>
                        <td>
                            <?= $row['endtime'] ?>
                        </td>
                        <td>
                            <?= $get_file['name'] ?>
                        </td>
                        <td>
                            <?= $get_file['totalpage'] ?>
                        </td>
                        <td>
                            <?= $get_request["numbersides"] ?>
                        </td>
                        <td>
                            <?= $get_request["numbercopies"] ?>
                        </td>
                        <td>
                            <?= $get_request["paper_per_sheet"] ?>
                        </td>
                        <td>
                            <?= $get_request["papersize"] ?>
                        </td>
                        <td>
                            <?= $display_printer_info ?>
                        </td>
                        <td>
                            <?php
                            if ($get_request['state'] == '0')
                                $state = '<a  class="payment_link_text">Đã lưu</a>';
                            else if ($get_request['state'] == '1')
                                $state = 'Đã hoàn thành';
                            else
                                $state = 'Đã gửi in';
                            ?>
                            <?= $state ?>
                        </td>
                        <td>
                            <div class="dropdown" style="float:right;">
                                <i style="font-size:25px " class="ri-arrow-down-s-fill dropbtn"></i>
                                <div class="dropdown-content">
                                    <a href="activitylog.php?send_id=<?= $row['id'] ?>">Send</a>
                                    <?php
                                    if ($get_request['state'] == '0' || $get_request['state'] == '1')
                                        echo '<a href="activitylog.php?delete_id=' . $row['id'] . '">Delete</a>';
                                    ?>

                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>

            </table><button class="button" id="delete_multi">Xóa nhiều file</button>
        </section>
    </div>


    <!-- footer section starts -->
    <div class="footer-container">
        <section class="footer">
            <div class="box-container">
                <div class="box">
                    <h3>STUDENT SMART PRINTING SERVICE</h3>
                    <img src="image/logo.png" alt="logo" />
                </div>

                <div class="box">
                    <h3>WEBSITE</h3>
                    <a href="https://hcmut.edu.vn/" class="hcmut">HCMUT</a>
                    <a href="https://mybk.hcmut.edu.vn/my/index.action" class="mybk">MyBK</a>
                    <a href="https://mybk.hcmut.edu.vn/bksi/public/vi/" class="bksi">BKSI</a>
                </div>

                <div class="box">
                    <h3>CONTACT</h3>
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
    <!-- footer section ends -->









    <!-- swiper js link -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- custom js file link -->
    <script src="activitylog_script.js"></script>
</body>

</html>