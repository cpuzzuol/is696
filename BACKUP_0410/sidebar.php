<div class="container-fluid">
            <div class="row-fluid">
                <div class="span3">
                    <div class="well sidebar-nav">
                        <ul class="nav nav-list">
                            <li class="nav-header">Quick Links</li>
                            <li>
                                <a href="index.php">Home</a>
                            </li>
                            <li>
                                <a href="about.php">About</a>
                            </li>
                            <li>
                                <a href="contact.php">Contact</a>
                            </li>
                            <?php if(!isset($_SESSION['MM_UserGroup'])): ?>
                            <li>
                              <a href="createreservation.php">Appointments</a>
                            </li>
                            <?php else: ?>
                            <li>
                              <a href="employeestart.php">Employee Options</a>
                            </li>
                            <?php endif; ?>
                            <li class="nav-header">Services</li>
                            <li>
                                <a href="oilchange.php">Oil Changes</a>
                            </li>
                            <li>
                                <a href="brakes.php">Brakes</a>
                            </li>
                            <li>
                                <a href="alignments.php">Alignments</a>
                            </li>
                            <li>
                                <a href="tuneups.php">Tune Ups</a>
                            </li>
                        </ul>
                    </div>
                    <!--/.well -->
                </div>
                <!--/span-->
                <div class="span9">
                  <div class="row-fluid"><!--/span--><!--/span--><!--/span-->
    </div>
                    <!--/row-->
                    <div class="row-fluid"><!--/span--><!--/span-->
                        <div class="span9">
  					<div class="contentBox">
        <span class="nav-collapse in collapse" style="height: auto;"><img src="images/logosmall.png" alt=""></span>
        <div class="innerBox">