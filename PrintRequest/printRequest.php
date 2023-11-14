<?php


@include 'database.php';
$maxfilesize = 50000000; //50MB
$allowUpload = true;
function convert_upload_file_array($upload_files)
{
    $converted = array();

    foreach ($upload_files as $attribute => $val_array) {
        foreach ($val_array as $index => $value) {
            $converted[$index][$attribute] = $value;
        }
    }
    return $converted;
}
$success = false;
if (isset($_POST['send'])) {

    $allowTypes = array('.docx', '.docm', '.dotx', '.dotm', '.xlsx', '.pptx', 'jpg', 'png', 'jpeg', 'pdf');
    if (isset($_FILES['fileupload'])) {
        $file_child = convert_upload_file_array($_FILES['fileupload']);

        foreach ($file_child as $key => $child) {
            $targetDir = 'upload/';
            $fileName = basename($child['name']);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            if (!empty($child['name'])) {

                if (
                    (
                        ($child["type"] == "application/pdf")
                        || ($child["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                        || ($child["type"] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
                        || ($child["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
                        || ($child["type"] == "image/gif")
                        || ($child["type"] == "image/jpeg")
                        || ($child["type"] == "image/jpg")
                        || ($child["type"] == "application/msword")
                        || ($child["type"] == "image/pjpeg")
                        || ($child["type"] == "image/x-png")
                        || ($child["type"] == "image/png")
                        && ($child["size"] < 20000000)
                        && in_array($fileType, $allowTypes)
                    )
                ) {
                    if ($child["error"] > 0) {
                        echo "Return Code: " . $child["error"] . "<br>";
                    } else {
                        if (file_exists("upload/" . $child["name"])) {
                            echo $child["name"] . " already exists. ";
                        } else {
                            $totalpage = 0;
                            // Upload file to server
                            if (move_uploaded_file($child['tmp_name'], $targetFilePath)) {
                                if (($child["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")) {
                                    $wdStatisticPages = 2; // Value that corresponds to the Page count in the Statistics
                                    $namefile = "C:\\xampp\htdocs\printing_service\upload\\$fileName";
                                    $word = new COM("word.application") or die("Could not initialise MS Word object.");
                                    print "Loaded Word, version {$word->Version}\n";
                                    $word->Documents->Open($namefile);
                                    $totalpage = $word->ActiveDocument->ComputeStatistics($wdStatisticPages);
                                    /*#$word->ActiveDocument->PrintOut();*/
                                    $word->ActiveDocument->Close();
                                    $word->Quit();
                                } else if (($child["type"] == "application/pdf")) {
                                    $totalpage = count_pdf_pages($targetFilePath);
                                } else if (($child["type"] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")) {
                                    $totalpage = PageCount_PPTX($targetFilePath);
                                } else {
                                    $totalpage = 0;
                                }
                                $insert = $conn->query("INSERT into file (userid,name,createddate,state,totalpage,filepath) VALUES ('1','$fileName',NOW(),'Mới tải lên','" . $totalpage . "','" . $targetFilePath . "')");
                                if ($insert) {
                                    $statusMsg = "The file has been uploaded successfully.";
                                    ?>
                                    <div>
                                        <label>Tên file: <span id="uploadedFileName">
                                                <?php echo $fileName; ?>
                                            </span></label>
                                    </div>
                                    <?php
                                    $success = true;
                                } else
                                    $statusMsg = "File upload failed, please try again.";
                            } else {
                                $statusMsg = "Sorry, there was an error uploading your file.";
                            }
                            # $statusMsg = 'Sorry, only valid type files are allowed to upload.';
                        }
                    }
                } else {
                    echo 'Invalid file';
                }
            }
        }
    }

}

function PageCount_PPTX($file)
{
    $pageCount = 0;

    $zip = new ZipArchive();

    if ($zip->open($file) === true) {
        if (($index = $zip->locateName('docProps/app.xml')) !== false) {
            $data = $zip->getFromIndex($index);
            $zip->close();
            $xml = new SimpleXMLElement($data);
            $pageCount = $xml->Slides;
        }
        #$zip->close();
    }

    return $pageCount;
}
function count_pdf_pages($pdfname)
{
    $pdftext = file_get_contents($pdfname);
    $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);

    return $num;
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./globalPrintRequest.css" />
    <link rel="stylesheet" href="./printRequest.css" />
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
                <p>ĐĂNG KÍ IN TÀI LIỆU</p>
            </div>
            <div class="campus">
                <label class="choose-campus">Chọn cơ sở</label>
                <button class="campus-button campus-container">Cơ sở 1</button>
                <button class="campus-button campus-container">Cơ sở 2</button>
            </div>
            <div class="flex">
                <div class="building">
                    <label class="choose-building">Chọn toà:</label>
                    <div>
                        <select class="dropdown-menu" name="building">
                            <option class="embed" value="toa1">Toà 1</option>
                            <option class="embed" value="toa2">Toà 2</option>
                            <option class="embed" value="toa3">Toà 3</option>
                        </select>
                    </div>
                </div>
                <div class="printer">
                    <label class="choose-printer">Chọn máy in:</label>
                    <div>
                        <select class="dropdown-menu" name="printer">
                            <option class="embed" value="">test1</option>
                            <option class="embed" value="">test2</option>
                            <option class="embed" value="">Test3</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="printer-state-text">
                <p>Tập tin cần in</p>
            </div>
            <div class="printer-state">
                <div class="printer-state-box">
                    <div class="flex">
                        <button class="printer-short-desc" onclick="openFileInput()">
                            <img src=" print-icon" alt="" src="/image/upload.svg" />
                            <p>Chọn tập tin</p>
                            <input type="file" id="fileInput" class="file-input">
                        </button>
                        <button class="printer-short-desc" onclick="openAttributesForm()">
                            <img class="print-icon" alt="" src="/image/printer-icon.svg" />
                            <p>Tùy chọn thuộc tính</p>
                        </button>
                    </div>
                    <div class="upload-frame">
                        <span id="uploadedFileName"></span>
                        </span>
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
        function openFileInput() {
            document.getElementById("fileInput").click();
        }
        document.getElementById("fileInput").addEventListener("change", function () {
            var fileName = this.files[0].name;
            document.getElementById("uploadedFileName").textContent = fileName;
        });
        function openAttributesForm() {
            window.open("printAttributes.php", "_blank", "width=1050,height=800");
        }
        $(document).ready(function () {
            $('.campus-button').click(function () {
                var selectedCampus = $(this).text().trim();
                $('#selectedCampusInput').val(selectedCampus);
                $('.dropdown-menu option').each(function () {
                    if ($(this).text().trim() === selectedCampus) {
                        $(this).addClass('selected');
                    } else {
                        $(this).removeClass('selected');
                    }
                });
                $('#campusForm').submit();
            });
        });
        (document).ready(function () {
            $('.printer-short-desc:nth-child(2)').click(function () {
                $('#popupContainer').fadeIn();
            });

            $('.quay-li').click(function () {
                $('#popupContainer').fadeOut();
            });
        });
    </script>
</body>

</html>