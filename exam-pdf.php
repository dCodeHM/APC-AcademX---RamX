<?php
include("exam-pdf-server.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$combined_result = array();

while ($question = $questions_result->fetch_assoc()) {
    $combined_result[] = array(
        'type' => 'question',
        'data' => $question
    );
}

usort($combined_result, function ($a, $b) {
    return strtotime($a['data']['date_created']) - strtotime($b['data']['date_created']);
});

$totalQuestions = count($combined_result);
$questionsPerPage = 30;
$totalPages = ceil($totalQuestions / $questionsPerPage);

$totalQuestionsWithChoices = count($combined_result);
$questionsPerPageWithChoices = 30;
$totalPagesWithChoices = ceil($totalQuestionsWithChoices / $questionsPerPageWithChoices);

$totalAnswerKeys = count($combined_result);
$answerKeysPerPage = 30;
$totalAnswerKeyPages = ceil($totalAnswerKeys / $answerKeysPerPage);

function displayImage($imageData, $alt, $maxWidth = 200, $maxHeight = 150) {
    $imgData = base64_encode($imageData);
    $src = 'data:image/jpeg;base64,' . $imgData;
    return "<img src='{$src}' alt='{$alt}' style='max-width:{$maxWidth}px; max-height:{$maxHeight}px; width:auto; height:auto; object-fit:contain; display:inline-block; vertical-align:middle;'>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="author" content="APC AcademX">

    <title>APC AcademX | Welcome</title>
    <link rel="shortcut icon" type="x-icon" href="./img/icon.png">
    <link rel="stylesheet" href="./css/header.css?v=<?php echo time(); ?>">

    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/css" media="print">
        @page {
            size: auto;
            /* auto is the initial value */
            margin: 0mm;
            /* this affects the margin in the printer settings */
        }

        @media print {
            .pagebreak {
                page-break-before: always;
            }

            /* page-break-after works, as well */

            /* Always add a margin top */
        }
    </style>

    <script>
        // Print as PDF
        window.onload = function() {
            window.print();
        }
    </script>

</head>

<body>

    <!-- Exam Preview -->
    <div id="exam-preview" class="text-white w-full flex flex-col bg-zinc-400 gap-10">
        <!-- Answer Sheet -->
        <?php
        // old
        // $totalQuestions = count($combined_result);
        // $questionsPerPage = 50;
        // $totalPages = ceil($totalQuestions / $questionsPerPage);

        // for ($page = 1; $page <= $totalPages; $page++) {
        //     $startIndex = ($page - 1) * $questionsPerPage;
        //     $endIndex = min($startIndex + $questionsPerPage, $totalQuestions);

        $questionsPerPage = 50;
        $questionsPerColumn = 30;
        $columnsPerPage = 2;

        for ($page = 1; $page <= $totalPages; $page++) {
            $startIndex = ($page - 1) * $questionsPerPage;
            $endIndex = min($startIndex + $questionsPerPage, $totalQuestions);
        ?>

            <div class="page py-8 px-20 bg-white text-2xl text-zinc-800 w-[210mm]">
                <div class="w-full flex items-center justify-between gap-4 text-xl font-normal text-zinc-800">
                    <!-- Get the params course_code in the URL -->
                    <p>
                        <?php
                        $course_code = isset($_GET['course_code']) ? $_GET['course_code'] : '';
                        echo $course_code;
                        ?>
                    </p>

                    <img src="img/APC AcademX Logo.png" alt="APC AcademX Logo" class="max-w-[100px]">

                    <h4 class="text-zinc-800">
                        <?php echo htmlspecialchars($exam['exam_name']); ?>
                    </h4>
                </div>
                <hr class="my-8" />

                <?php if ($page === 1) { ?>
                    <div class="w-full flex items-center h-[100px] border-black border-1 mb-6">
                        <div class="w-[80%] flex flex-col h-full">
                            <div class="h-full p-4 border-[1px] border-black">Name:</div>
                            <div class="flex h-full">
                                <div class="w-full h-full p-4 border-[1px] border-black">Section:</div>
                                <div class="w-full h-full p-4 border-[1px] border-black">Date:</div>
                            </div>
                        </div>
                        <div class="w-[20%] h-full p-4 border-[1px] border-black">
                            Score:
                        </div>
                    </div>
                    <p class="mb-6">
                        <!-- findme -->
                        <!-- current fixing the space of first page -->
                        <!-- Exam Instructions -->
                        <?php echo htmlspecialchars($exam['exam_instruction']); ?>
                    </p>
                <?php } ?>

                <!-- Answer Sheet -->
                <div id="answer-sheet">
                    <div class="flex justify-between">
<?php
                        for ($column = 1; $column <= $columnsPerPage; $column++) {
                            $columnStartIndex = $startIndex + ($column - 1) * $questionsPerColumn;
                            $columnEndIndex = min($columnStartIndex + $questionsPerColumn, $endIndex);
                        ?>
                            <div class="column w-1/2 pr-4">
                                <?php for ($i = $columnStartIndex; $i < $columnEndIndex; $i++) {
                                    $item = $combined_result[$i];
                                    if ($item['type'] === 'question') {
                                        $question = $item['data'];
                                ?>
<div class="question flex gap-4 items-center mb-2">
                                            <p class="font-semibold"><?php echo $i + 1; ?>.</p>
                                            <div class="choices-container flex gap-4">
                                            <?php
                                                $sql = "SELECT * FROM question_choices WHERE answer_id = ?";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->bind_param("i", $question['answer_id']);
                                                $stmt->execute();
                                                $choices_result = $stmt->get_result();
                                                $choiceIndex = 0;

                                                while ($choice = $choices_result->fetch_assoc()) {
                                                    $choiceLetter = chr(65 + $choiceIndex);
                                                ?>
                                                    <<div class="choice flex items-center">
                                                        <div class="w-6 h-6 rounded-full border-[1px] border-black flex items-center justify-center">
                                                            <span class="text-base font-semibold"><?php echo $choiceLetter; ?></span>
                                                        </div>
                                                    </div>
                                                <?php
                                                    $choiceIndex++;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Footer -->
                <hr class="mt-8" />
                <div class="w-full flex justify-center mt-4 text-lg">
                    <p>Page <?php echo $page; ?> of <?php echo $totalPages; ?></p>
                </div>
            </div>

            <?php if ($page < $totalPages) { ?>
                <div class="pagebreak"> </div>
            <?php } ?>
        <?php } ?>
        <div class="pagebreak"> </div>
        <!-- below is not done -->
        <!-- Questions and Choices -->
        <?php
        $questionsPerPageWithChoices = 30;
        $totalPagesWithChoices = ceil($totalQuestions / $questionsPerPageWithChoices);

        $page = 1;
        $questionIndex = 0;

        for ($page = 1; $page <= $totalPagesWithChoices; $page++) {
            $startIndex = ($page - 1) * $questionsPerPageWithChoices;
            $endIndex = min($startIndex + $questionsPerPageWithChoices, $totalQuestions);
        ?>
            <div class="page py-8 px-20 bg-white text-2xl text-zinc-800 w-[210mm]">
                <div class="w-full flex items-center justify-between gap-4 text-xl font-normal text-zinc-800">
                    <!-- Get the params course_code in the URL -->
                    <p>
                        <?php
                        $course_code = isset($_GET['course_code']) ? $_GET['course_code'] : '';
                        echo $course_code;
                        ?>
                    </p>

                    <img src="img/APC AcademX Logo.png" alt="APC AcademX Logo" class="max-w-[100px]">

                    <h4 class="text-zinc-800">
                        <?php echo htmlspecialchars($exam['exam_name']); ?>
                    </h4>
                </div>
                <hr class="my-8" />

                <div class="flex justify-between">
                    <?php
                    $questionsPerColumnWithChoices = 15;
                    $columnsPerPageWithChoices = 2;

                    for ($column = 1; $column <= $columnsPerPageWithChoices; $column++) {
                        $columnStartIndex = $startIndex + ($column - 1) * $questionsPerColumnWithChoices;
                        $columnEndIndex = min($columnStartIndex + $questionsPerColumnWithChoices, $endIndex);
                    ?>
            <div class="column w-1/2 pr-4">
                            <?php
                            for ($i = $columnStartIndex; $i < $columnEndIndex; $i++) {
                                $item = $combined_result[$i];
                                if ($item['type'] === 'question') {
                                    $question = $item['data'];
                                    $hasQuestionImage = !empty($question['question_image']);
                            ?>
                                <div class="question mb-6">
                                <div class="flex items-start mb-2">
                                        <span class="font-semibold mr-2"><?php echo $i + 1; ?>.</span>
                                        <div>
                                            <?php if ($hasQuestionImage) : ?>
                                                <?php echo displayImage($question['question_image'], 'Question Image', 200, 150); ?>
                                            <?php endif; ?>
                                            <p class="font-semibold mt-2"><?php echo $question['question_text']; ?></p>
                            </div>
                        </div>
                        <div class="choices-container pl-6">
                        <?php
                                        $sql = "SELECT * FROM question_choices WHERE answer_id = ?";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("i", $question['answer_id']);
                                        $stmt->execute();
                                        $choices_result = $stmt->get_result();
                                        $choiceIndex = 0;

                                        while ($choice = $choices_result->fetch_assoc()) {
                                            $choiceLetter = chr(65 + $choiceIndex);
                                        ?>

                                <div class="choice flex items-center mb-2">
                                                <span class="mr-2"><?php echo $choiceLetter; ?>.</span>
                                                <div class="flex items-center">
                                                    <?php if (!empty($choice['answer_image'])) : ?>
                                                        <?php echo displayImage($choice['answer_image'], 'Answer Image', 100, 75); ?>
                                                    <?php endif; ?>
                                                    <p class="ml-2"><?php echo $choice['answer_text']; ?></p>
                                                </div>
                                            </div>
                                        <?php
                                            $choiceIndex++;
                                        }
                                        ?>
                        </div>
                    </div>
                <?php
                        $questionIndex++;
                    }
                
                }}
                ?>
                
                
            </div>
        
    </div>

                <!-- Footer -->
                <hr class="mt-8" />
                <div class="w-full flex justify-center mt-4 text-lg">
                    <p>Page <?php echo $page; ?> of <?php echo $totalPagesWithChoices; ?></p>
                </div>
            </div>

            <?php if ($page < $totalPagesWithChoices) : ?>
                <div class="pagebreak"></div>
            <?php endif; ?>
        <?php } ?>

        <div class="pagebreak"> </div>

        <!-- Answer Keys -->
        <?php
        $questionsPerColumn = 25;
        $columnsPerAnswerKeyPage = 2;
        $questionsPerPage = $questionsPerColumn * $columnsPerAnswerKeyPage;
        $totalAnswerKeyPages = ceil($totalQuestions / $questionsPerPage);

        for ($page = 1; $page <= $totalAnswerKeyPages; $page++) {
            $startIndex = ($page - 1) * $questionsPerPage;
            $endIndex = min($startIndex + $questionsPerPage, $totalQuestions);
        ?>
            <div class="page py-8 px-20 bg-white text-2xl text-zinc-800 w-[210mm]">
                <!-- Header content remains the same -->

                <div class="flex justify-between">
                    <?php
                    for ($column = 1; $column <= $columnsPerAnswerKeyPage; $column++) {
                        $columnStartIndex = $startIndex + ($column - 1) * $questionsPerColumn;
                        $columnEndIndex = min($columnStartIndex + $questionsPerColumn, $endIndex);
                    ?>
                        <div class="column w-1/2 pr-4">
                            <?php
                            for ($i = $columnStartIndex; $i < $columnEndIndex; $i++) {
                                $item = $combined_result[$i];
                                if ($item['type'] === 'question') {
                                    $question = $item['data'];
                            ?>
                                <div class="question mb-2">
                                    <span class="font-semibold"><?php echo $i + 1; ?>.</span>
                                    <?php
                                    $sql = "SELECT * FROM question_choices WHERE answer_id = ? AND is_correct = 1";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $question['answer_id']);
                                    $stmt->execute();
                                    $choices_result = $stmt->get_result();
                                    $choiceIndex = 0;

                                    while ($choice = $choices_result->fetch_assoc()) {
                                        $choiceLetter = chr(65 + $choiceIndex);
                                        echo ' ' . $choiceLetter;
                                        $choiceIndex++;
                                    }
                                    ?>
                                </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    <?php } ?>
                </div>

                <!-- Footer -->
                <hr class="mt-8" />
                <div class="w-full flex justify-center mt-4 text-lg">
                    <p>Answer Keys - Page <?php echo $page; ?> of <?php echo $totalAnswerKeyPages; ?></p>
                </div>
            </div>

            <?php if ($page < $totalAnswerKeyPages) : ?>
                <div class="pagebreak"></div>
            <?php endif; ?>
        <?php } ?>
    </div>
</body>


</html>