<!DOCTYPE html>
<html>
    <head>
        <?php include('html/head.php'); ?>
    </head>
    <body>
        <?php
        if (isset($_SESSION['ativ']))
        {
            include('html/base.php');
        ?>

        <div class="content fanimate rowalign">
            <div class="calendar">
                <div class="header">
                    <div class="month"></div>
                    <div class="btns">
                        <div class="btn today-btn">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="btn prev-btn">
                            <i class="fas fa-chevron-left"></i>
                        </div>
                        <div class="btn next-btn">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </div>
                <div class="weekdays">
                    <div class="day">Dom</div>
                    <div class="day">Seg</div>
                    <div class="day">Ter</div>
                    <div class="day">Qua</div>
                    <div class="day">Qui</div>
                    <div class="day">Sex</div>
                    <div class="day">Sáb</div>
                </div>
                <div class="days">
                </div>
            </div>
        </div>

        <?php 
        }
        else
        {
            header('location:index.php');
        }
        ?>
    </body>
</html>

<script type="text/javascript" src="js/calendario.js"></script>