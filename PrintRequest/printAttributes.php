<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./globalPrintRequest.css" />
    <link rel="stylesheet" href="./printAttributes.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" />

    <!-- swiper css link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="print-attributes-container">
        <div class="chn-thuc-tnh">Chọn thuộc tính in</div>
        <div class="pages-to-print-parent">
            <div class="pages-to-print">
                <div class="group-container">
                    <div class="rectangle-parent4">
                        <div class="input" id="pages-input">input</div>
                    </div>
                    <button class="pages-button choose-option button-unselected" id="button-pages">
                        <div class="pages">Pages</div>
                    </button>
                </div>
                <button class="all-container choose-option button-unselected" id="button-all">
                    <div class="all-button">All</div>
                </button>
            </div>
            <div class="pages-to-print1">Pages to Print</div>
        </div>
        <div class="duplex">
            <div class="duplex-printing">Duplex Printing</div>
            <div class="duplex-yes choose-option">
                <button class="duplex-box button-unselected" id="button-duplex-yes"></button>
                <div class="duplex-text">Yes</div>
            </div>
            <div class="group-div choose-option">
                <button class="duplex-box button-unselected" id="button-duplex-no"></button>
                <div class="duplex-text">No</div>
            </div>
        </div>
        <div class="orientation">
            <div class="orientation-parent">
                <div class="orientation1">Orientation</div>
                <div class="group-parent">
                    <div class="rectangle-parent1 choose-option">
                        <button class="duplex-box button-unselected" id="button-landscape"></button>
                        <div class="duplex-text">Landscape</div>
                    </div>
                    <div class="rectangle-parent2 choose-option">
                        <button class="duplex-box button-unselected" id="button-portrait"></button>
                        <div class="duplex-text">Portrait</div>
                    </div>
                    <div class="rectangle-parent3 choose-option">
                        <button class="duplex-box button-unselected" id="button-all"></button>
                        <div class="duplex-text">All</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rectangle-parent">
            <button class="duplex-box"></button>
            <div class="duplex-text">Quay lại</div>
        </div>
        <div class="rectangle-group">
            <button class="duplex-box"></button>
            <div class="duplex-text">Xác nhận</div>
        </div>
        <div class="page-layout-parent">
            <div class="page-layout">
                <button class="a6 size-unselected">
                    <div class="a61">A6</div>
                </button>
                <button class="a5 size-unselected">
                    <div class="a51">A5</div>
                </button>
                <button class="a4 size-unselected">
                    <div class="a41">A4</div>
                </button>
                <button class="a3 size-unselected">
                    <div class="a31">A3</div>
                </button>
                <button class="a2 size-unselected">
                    <div class="a21">A2</div>
                </button>
                <button class="a1 size-unselected">
                    <div class="a11">A1</div>
                </button>
                <button class="a0 size-unselected">
                    <div class="a01">A0</div>
                </button>
            </div>
            <div class="page-layout1">Page Layout</div>
        </div>


    </div>
    <script>
        $(document).ready(function () {
            $('#button-duplex-yes').click(function () {
                $(this).removeClass('button-unselected').addClass('button-selected');
                $('#button-duplex-no').removeClass('button-selected').addClass('button-unselected');
            });

            $('#button-duplex-no').click(function () {
                $(this).removeClass('button-unselected').addClass('button-selected');
                $('#button-duplex-yes').removeClass('button-selected').addClass('button-unselected');
            });
        });
        $(document).ready(function () {
            $('.choose-option').click(function () {
                $('.choose-option button').removeClass('button-selected').addClass('button-unselected');
                $(this).find('button').removeClass('button-unselected').addClass('button-selected');
            });
        });
        $(document).ready(function () {
            $('#button-landscape, #button-portrait, #button-all').click(function () {
                $('#button-landscape, #button-portrait, #button-all').removeClass('button-selected').addClass('button-unselected');
                $(this).removeClass('button-unselected').addClass('button-selected');
            });
        });
        //for page option
        $(document).ready(function () {
            $('.page-option').click(function () {
                $('.page-option').removeClass('button-selected').addClass('button-unselected');
                $(this).removeClass('button-unselected').addClass('button-selected');
            });
        });
        $(document).ready(function () {
            $('.pages-button').click(function () {
                $('#pages-input').attr('contenteditable', 'true').focus();
            });
        });
        $(document).ready(function () {
            $('#button-pages, #button-all').click(function () {
                $('#button-pages, #button-all').removeClass('button-selected').addClass('button-unselected');
                $(this).removeClass('button-unselected').addClass('button-selected');
            });
        });
        $(document).ready(function () {
            $('.a6, .a5, .a4, .a3, .a2, .a1, .a0').click(function () {
                $('.a6, .a5, .a4, .a3, .a2, .a1, .a0').removeClass('size-selected').addClass('size-unselected');
                $(this).removeClass('size-unselected').addClass('size-selected');
            });
        });
    </script>
</body>

</html>