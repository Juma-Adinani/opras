<nav id="sidebar">
    <div class="sidebar_blog_2">
        <h4>Dashboard</h4>
        <ul class="list-unstyled components">
            <?php
            if ($_SESSION['role'] == 'supervisor') {
            ?>
                <li class="active">
                    <a href="./supervisor-page.php" class=""><i class="fa fa-home text-danger"></i> <span>Home</span></a>
                </li>
                <li>
                    <a href="./annual-review.php">
                        <i class="fa fa-paper-plane red_color"></i>
                        <span>Annual review</span></a>
                </li>
                <li>
                    <a href="./attribute-performance.php">
                        <i class="fa fa-bar-chart red_color"></i>
                        <span>Attribute performance</span></a>
                </li>
                <li>
                    <a href="./comment-section.php">
                        <i class="fa fa-edit purple_color"></i>
                        <span>Comments</span></a>
                </li>
                <li>
                    <a href="./reports.php"><i class="fa fa-cog yellow_color"></i>
                        <span>Reports</span></a>
                </li>
            <?php
            } else {
            ?>
                <li class="active">
                    <a href="./homepage.php" class=""><i class="fa fa-home text-danger"></i> <span>Home</span></a>
                </li>
                <li>
                    <a href="./agreement.php" class=""><i class="fa fa-diamond purple_color"></i>
                        <span>Agreement</span></a>
                </li>
                <li>
                    <a href="./mid-review.php">
                        <i class="fa fa-table purple_color2"></i>
                        <span>Mid review</span></a>
                </li>
                <li>
                    <a href="./revised-objective.php">
                        <i class="fa fa-paper-plane red_color"></i>
                        <span>Revised Objectives</span></a>
                </li>
                <li>
                    <a href="./annual-review.php">
                        <i class="fa fa-paper-plane red_color"></i>
                        <span>Annual review</span></a>
                </li>
                <li>
                    <a href="./attribute-performance.php">
                        <i class="fa fa-bar-chart red_color"></i>
                        <span>Attribute performance</span></a>
                </li>
                <li>
                    <a href="./reports.php"><i class="fa fa-cog yellow_color"></i>
                        <span>Reports</span></a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>