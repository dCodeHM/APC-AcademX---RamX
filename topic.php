    <?php
    session_start();
    include("config/db.php");
    include("config/functions.php");
    
    if (!isset($_SESSION['account_id'])) {
        // Redirect to the login page if the user is not logged in
        echo '<script>alert("User is not logged in, directing to login page.")</script>';
        echo "<script> window.location.assign('login.php'); </script>";
        exit();
    }


    $account_id = $_SESSION['account_id'];


    // Display the user-specific information
    $sql = "SELECT * FROM account WHERE account_id = $account_id";
    $result = mysqli_query($conn, $sql); // Replace with data from the database
    if ($result) {
        $row = mysqli_fetch_array($result);
        $user_email = $row['user_email'];
        $pwd = $row['pwd'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $role = $row['role'];
    }

    require('topicfolder.php');
    ?>

    <?php
    // Retrieve the course code from the URL parameter
    $courseCode = isset($_GET['course_code']) ? $_GET['course_code'] : '';

    // Optionally, you may sanitize and validate the course code here

    // Set the course code as the header text
    $courseFolderName = $courseCode;
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <meta name="author" content="APC AcademX">
        <title>APC AcademX | Exam Maker</title>
        <link rel="stylesheet" href="./css/topicstyle.css">
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/adminstyle.css">
        <link rel="stylesheet" href="./css/emstyle.css">
        <link rel="stylesheet" href="./css/myexamstyle.css">
        <link rel="stylesheet" href="./css/topicrectangledesign.css">
        <link rel="stylesheet" href="./css/sidebar.css">
        <link rel="stylesheet" href="./css/header.css">
        <link rel="stylesheet" href="./css/homepage.css">
        <script src="https://kit.fontawesome.com/e85940e9f2.js" crossorigin="anonymous"></script>
    </head>

    <body>
<!--OTHER CODE -->
<navigation class = "navbar">
                                        
                                        <ul class="right-header">
                                    <li class="logo">
                                        <a href="index.php"><img id="logo" src="img/logo.png"></a>
                                    </li>
                                    </ul>
                                
                                            <ul class = "left-header">
                                            <?php
                                    // Check if the session variable exists
                                    if(isset($_SESSION['user'])) {
                                        // Retrieve data from the session variable
                                        $userData = $_SESSION['user'];
                                        
                                        // // Access specific data from the session variable
                                        // $username = $userData['username'];
                                        // $email = $userData['email'];
                                        
                                        // Output the retrieved data in HTML text
                                        echo "<li class='username'><h3>$userData</h3></li>";
                                    } else {
                                        // Session variable does not exist or user is not logged in
                                        echo "<li class='username'><h3>$row[first_name] $row[last_name]</h3></li>";
                                    }
                                    ?>
                                
                                
                                    <li class="notification">
                                        <a href="#" id="toggleNotif"><img id="notification" src="img/notification.png"></a>
                                        <ul class="notif-drop dropdown" id="notif-drop" style="display: none;">
                                            <h3>Notifications</h3>
                                            <hr>
                                            <div class="notif-list">
                                                <div class="notif">
                                                    <label id="notifname">
                                                        <p class="notifname">Sergio Peruda</p>
                                                        <p class="notifdate">5/22/24</p>
                                                    </label>
                                                    <label id="notifname">
                                                        <p class="notifdetails">A program director assigned a course<br> [GRAPHYS] to you.</p>
                                                    </label>
                                                </div>;
                                                <div class="notif">
                                                    <label id="notifname">
                                                        <p class="notifname">Sergio Peruda</p>
                                                        <p class="notifdate">5/22/24</p>
                                                    </label>
                                                    <label id="notifname">
                                                        <p class="notifdetails">A program director assigned a course<br> [GRAPHYS] to you.</p>
                                                    </label>
                                                </div>;
                                                <div class="notif">
                                                    <label id="notifname">
                                                        <p class="notifname">Sergio Peruda</p>
                                                        <p class="notifdate">5/22/24</p>
                                                    </label>
                                                    <label id="notifname">
                                                        <p class="notifdetails">A program director assigned a course<br> [GRAPHYS] to you.</p>
                                                    </label>
                                                </div>;
                                                <div class="notif">
                                                    <label id="notifname">
                                                        <p class="notifname">Sergio Peruda</p>
                                                        <p class="notifdate">5/22/24</p>
                                                    </label>
                                                    <label id="notifname">
                                                        <p class="notifdetails">A program director assigned a course<br> [GRAPHYS] to you.</p>
                                                    </label>
                                                </div>;
                                                <div class="notif">
                                                    <label id="notifname">
                                                        <p class="notifname">Sergio Peruda</p>
                                                        <p class="notifdate">5/22/24</p>
                                                    </label>
                                                    <label id="notifname">
                                                        <p class="notifdetails">A program director assigned a course<br> [GRAPHYS] to you.</p>
                                                    </label>
                                                </div>;
                                                <div class="notif">
                                                    <label id="notifname">
                                                        <p class="notifname">Sergio Peruda</p>
                                                        <p class="notifdate">5/22/24</p>
                                                    </label>
                                                    <label id="notifname">
                                                        <p class="notifdetails">A program director assigned a course<br> [GRAPHYS] to you.</p>
                                                    </label>
                                                </div>;
                                            </div>
                                        </ul>
                                    </li>
                                
                                    <li class="user">
                                        <a href="#" id="toggleUser"><img id="profile" src="img/profile.png"></a>
                                        <ul class="user-d   rop dropdown" id="user-drop" style="display: none;">
                                            <h3>Admin</h3>
                                            <p>School Role</p>
                                            <a href="adminusersettings.php" class="settings"><span>Settings</span></a>
                                            <a href="logout.php" class="logout"><span>Logout</span></a>
                                        </ul>
                                    </li>
                                </ul>
                                
                                <div class="sidebar">
                                    <div class="back_button">
                                        <a href="em.php">
                                        <img src="img/back.png">
                                        </a>
                                    </div>
                                    <div class="help_button">
                                        <img src="img/help.png">
                                    </div>
                                </div>
                                </navigation>


        <div class="column">

            <!--header-->
            <div class="containerem" style="margin-left: 70px;">

                <div class="rightemhead" style="margin-bottom: 50px">
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <?php $courseFolderName = $row['courseFolderName']; ?>
                    <?php endwhile; ?>
                    <div class="adminmehead" style="margin-top: 100px">
                        <p><?php echo $courseFolderName; ?></p>
                    </div>

                    <?php if (!$update) : ?>
                        <button class="addbutt" onclick="showPopup()" style="margin-top: 100px">
                            <i class="fa-solid fa-circle-plus"></i>
                        </button>
                    <?php endif; ?>
                    <script src="./myexams.js"></script>
                    <div class="searchicon " style="position:relative; left: 45%">
                        <input type="text" class="searchbar">
                    </div>
                </div>
                <div class="popup-hidden">
                    <div class="popup_bg"></div>
                    <div class="Add_popup">
                        <form action="topicfolder.php" method="post">
                            <!-- Add a hidden input field to indicate action -->
                            <input type="hidden" name="action" id="action" value="add">

                            <?php if ($update == true) : ?>
                                <p class="heading">Update Course Topic Information<img src="img/Exam.png" style="margin: 5px; width: 4rem;"></p>
                            <?php else : ?>
                                <p class="heading">Create an Exam<img src="img/Exam.png" style="margin: 5px; width: 4rem;"></p>
                            <?php endif; ?>

                            <input type="hidden" name="course_subject_id" value="<?php echo $course_subject_id ?>" readonly><br />

                            <input type="hidden" name="account_id" value="<?php echo $account_id ?>" readonly><br />

                            <div class="inputcolumn">
                                <label class="label" for="course_topics">Course Topic</label>
                                <input class="input" type="text" name="course_topics" placeholder="Your Course Topics" value="<?php echo $course_topics ?>" required><br />
                            </div>
                            <div class="inputcolumn">
                                <label class="label" for="difficulty">Easy</label>
                                <input class="input" type="number" name="difficulty" placeholder="How many Easy question/s?" value="<?php echo $difficulty ?>" required><br />
                            </div>
                            <div class="inputcolumn">
                                <label class="label" for="difficulty">Normal</label>
                                <input class="input" type="number" name="difficulty" placeholder="How many Normal question/s?" value="<?php echo $difficulty ?>" required><br />
                            </div>
                            <div class="inputcolumn">
                                <label class="label" for="difficulty">Hard</label>
                                <input class="input" type="number" name="difficulty" placeholder="How many Hard question/s?" value="<?php echo $difficulty ?>" required><br />
                            </div>
                            <div class="inputcolumn">
                                <label class="label" for="course_code">How many questions would you like to add?</label>
                                <input class="input" type="number" name="course_code" placeholder="Your difficulty" value="<?php echo $course_code ?>" required><br />
                            </div>

                            <input type="hidden" name="course_syllabus_id" value="<?php echo $course_subject_id ?>" readonly><br />
                            <input type="hidden" name="course_topic_id" value="<?php echo $course_subject_id ?>" readonly><br />

                            <?php if ($update == true) : ?>
                                <button class="update" type="submit" name="update">Update</button>
                            <?php else : ?>
                                <button class="save" type="submit" name="save">Create</button>
                            <?php endif; ?>
                            <div class="cancelbutton">
                                <a class="cancel" href="topic.php?course_code=<?php echo urlencode($courseFolderName); ?>">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!--line-->
                <div class="adminemline">
                </div>


                <!--boxes-->

                <?php $result = $mysqli->query("SELECT * from prof_course_topic WHERE account_id = $account_id AND course_subject_id = $course_subject_id") or die(mysqli_error($mysqli));
                if ($result->num_rows === 0) { ?>

                    <p class="header">You have no topic folders.</p>

                <?php } else { ?>
                    <div style="display:block;">
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <section id="container2">
                                <div class="emservices">
                                    <div class="mebox">
                                        <div class="boxt">
                                            <select onchange="handleAction(this)">
                                                <option value="">Select Action</option>
                                                <option value="topic.php?edit=<?php echo $row['course_topic_id']; ?>&update=true">Edit</option>
                                                <option value="topicfolder.php?delete=<?php echo $row['course_topic_id']; ?>">Delete</option>
                                            </select>
                                            <a href="topic.php?course_topics=<?php echo urlencode($row['course_topics']); ?>" class="fill-div">
                                                <p class="mahabangbox">
                                                    <?php echo $row['course_topics']; ?>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                    <?php endwhile;
                    }
                    ?>
                    </div>
            </div>
        </div>
    </body>
    <script>
        function showPopup() {
            // Select the popup element
            const popup = document.querySelector(".popup-hidden");
            // Remove the "hidden" class to display the popup
            popup.classList.remove("popup-hidden");
            // Prevent default link behavior
            return false;
        }

        function showEditPopup(course_topic_id, update) {
            const popup = document.querySelector(".popup-hidden");
            popup.classList.remove("popup-hidden");
            document.getElementById("action").value = "edit";
            document.querySelector("form").action = `topicfolder.php?edit=${course_topic_id}`;
            // Optionally, you can pre-fill form fields here
            // Set the value of the $update PHP variable based on the update parameter
            $update = update;
        }

        function handleAction(select) {
            if (select.value.startsWith('topicfolder.php?delete=')) {
                if (confirm('Are you sure you want to delete this topic folder?')) {
                    window.location = select.value;
                }
            } else if (select.value.startsWith('topic.php?edit=')) {
                const editUrl = select.value;
                const urlParams = new URLSearchParams(editUrl);
                const courseTopicId = urlParams.get('edit');
                const updateParam = urlParams.get('update');
                // Set $update variable based on the updateParam
                const update = updateParam === 'true';
                showEditPopup(courseTopicId, update);
            }
        }
    </script>

    </html>