<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\students;
use App\Models\sheets;
use App\Models\User;
use App\Models\subject;

class ApiController extends Controller
{
    //

    public function addStudents(Request $request)
    {
        // Get the CSRF token from the session
        // $csrf_token = Session::;
        // return  $csrf_token;
        // Check if the CSRF token is valid
        if (!$request->header('X-CSRF-TOKEN')) {
            return response()->json([
                'error' => 'Invalid CSRF token',
            ], 401);
        }

            // Get the token from the request
            $token = $request->header('X-CSRF-TOKEN');

            // Check if the token is valid (exists in the token_api field of the user)
            $user = User::where('token_api', $token)->first();

            if (!$user) {
                return response()->json([
                    'error' => 'Invalid CSRF token',
                ], 401);
            }


        // Read the request
        $data = $request->all();
        $json_string = $request->input('data');

        // Decode the JSON string
        $students = json_decode($json_string, true);
        $response = [];
        // Loop through the students
        foreach ($students as $student) {
            if(!User::data_sub($user["id"])){
                if(!User::canadd_students($user["id"])){
                    break;
                }
            }
            // Write the student's information to the text file
            if(isset($student['id_number'])){

                $createdStudent = students::create([
                    'user_id' => $user["id"],
                    'id_number' => $student['id_number'],
                    'class_number' => $student['class_number'],
                    'class' => $student['class'],
                    'name' => $student['name'],
                    'phone_number' => $student['phone'],
                ]);

                // Add student ID and ID number to the resp9onse array
                $response[] = [
                    'id' => $createdStudent->id, // Get the ID of the created student
                    'id_number' => $student['id_number'],
                    'phone_number' => $student['phone'],
                ];
        }
        }
        // Return the response as JSON
        return response()->json($response);
    }

    public function addSheets(Request $request)
    {
        // Get the CSRF token from the session
        // $csrf_token = Session::;
        // return  $csrf_token;
        // Check if the CSRF token is valid
        if (!$request->header('X-CSRF-TOKEN')) {
            return response()->json([
                'error' => 'Invalid CSRF token',
            ], 401);
        }

            // Get the token from the request
            $token = $request->header('X-CSRF-TOKEN');

            // Check if the token is valid (exists in the token_api field of the user)
            $user = User::where('token_api', $token)->first();

            if (!$user) {
                return response()->json([
                    'error' => 'Invalid CSRF token',
                ], 401);
            }


        // Read the request 966 53 872 5811
        // $data = $request->all();
        $sheets = $request->input('data');

        //get all low subjects

        $low_subjects = DB::select("select name from low_subjects s;");
        $response = [];
        // Loop through the students
        foreach ($sheets as $sheet) {
            if(!User::data_sub($user["id"])){
                if(!User::canadd_sheets($user["id"])){
                    break;
                }
            }
            // Write the student's information to the text file
            if(isset($sheet['id_number'])){


                $status_loop = 0;
                $table = json_decode($sheet['table'], true);
                foreach ($table as $ligne) {
                    $subjectName = $ligne['subject'];
                    $subjectRank = '1'; // Assuming subject is not found in low_subjects
                    foreach ($low_subjects as $low_subject) {
                        if ($low_subject->name === $subjectName) {
                            $subjectRank = '2'; // Found in low_subjects, set subjectRank to '1'
                            break; // No need to continue searching once found
                        }
                    }
                    // $totale = $ligne['Totale'];
                    // $status = ($subjectRank === '1') ? $this->calculateStatus($totale, 60) : $this->calculateStatus($totale, 100);
                    if($subjectRank == '1'){
                        $percentage = $this->calculatePercentage($ligne['Totale'], 60);
                    }else{
                        $percentage = $ligne['Totale'];
                    }
                    $status_loop += $percentage;
                }
                $status_all =($status_loop / count($table)) ;
                $status_val = $this->calculateStatus($status_all, 100);
                $message = ($status_val === '2') ? $request->input('message_high_data') : (($status_val === '1') ? $request->input('message_mid_data')  : $request->input('message_low_data') );


                $createdSheet = sheets::create([
                    // 'user_id' => $request->input('id'),
                    'user_id' => $user["id"],
                    'id_number' => $sheet['id_number'],
                    'state' => $sheet['state'],
                    'state_ar' => $sheet['state_ar'],
                    'title1' => $sheet['title1'],
                    'title1_ar' => $sheet['title1_ar'],
                    'title2' => $sheet['title2'],
                    'title2_ar' => $sheet['title2_ar'],
                    'title3' => $sheet['title3'],
                    'title3_ar' => $sheet['title3_ar'],
                    'year' => $sheet['year'],
                    'year_ar' => $sheet['year_ar'],
                    'school' => $sheet['school'],
                    'school_ar' => $sheet['school_ar'],
                    'name' => $sheet['name'],
                    'name_ar' => $sheet['name_ar'],
                    'class' => $sheet['class'],
                    'nationality' => $sheet['nationality'],
                    'nationality_ar' => $sheet['nationality_ar'],
                    'birth_day' => $sheet['birth_day'],
                    'birth_day_ar' => $sheet['birth_day_ar'],
                    'sort_by_grade' => $sheet['sort_by_grade'],
                    'sort_by_class' => $sheet['sort_by_class'],
                    'absence' => $sheet['absence'],
                    'latency' => $sheet['latency'],
                    'table' => $sheet['table'],

                    'status' => round($status_all, 3) ,
                    'message'  => $message,
                    'class_drop'  => $request->input('drop_class_data'),
                    'grade_drop' => $request->input('drop_grade_data') ,
                ]);


                foreach ($table as $ligne) {
                    $subjectName = $ligne['subject'];
                    $subjectRank = in_array($subjectName, array_column($low_subjects, 'name')) ? '1' : '2';
                    $totale = $ligne['Totale'];
                    $status = ($subjectRank === '1') ? $this->calculateStatus($totale, 60) : $this->calculateStatus($totale, 100);
                    subject::create([
                        'rank'=> $subjectRank,
                        'status'=> $status,
                        'sheet_id'=> $createdSheet->id,
                        'subject'=> $ligne['subject'],
                        'subject_ar'=> $ligne['subject_ar'],
                        'grade_short'=> $ligne['Short_test'],
                        'total'=> $ligne['Totale'],
                        'grade'=> $ligne['grade'],
                        'Evaluation'=> $ligne['Evaluation'],
                        'end_period'=> $ligne['end_period'],
                    ]);
                }

                // Add student ID and ID number to the response array
                $response[] = [
                    'id' => $createdSheet->id, // Get the ID of the created student
                    'id_number' => $sheet['id_number'],
                ];



        }
        }
        // Return the response as JSON
        return response()->json($response);
    }


    public function getTable(Request $request)
    {
        // Get the CSRF token from the session
        // $csrf_token = Session::;
        // return  $csrf_token;
        // Check if the CSRF token is valid
        if (!$request->header('X-CSRF-TOKEN')) {
            return response()->json([
                'error' => 'Invalid CSRF token',
            ], 401);
        }

        // Get the token from the request
        $token = $request->header('X-CSRF-TOKEN');

        // Check if the token is valid (exists in the token_api field of the user)
        $user = User::where('token_api', $token)->first();

        if (!$user) {
            return response()->json([
                'error' => 'Invalid CSRF token',
            ], 401);
        }


        // Read the request 966 53 872 5811
        // $data = $request->all();
        $id = $request->input('id');
        // dd($id);
        $response = DB::select("select s.table from sheets s where id  =  ?;", [$id]);
        // Loop through the students


        // Return the response as JSON
        return response()->json($response);
    }

    public function getTable_list(Request $request)
    {
        $id = $request->input('id');

        // Check if the sheet with the given id contains "THIRD SEMESTER"
        $hasThirdSemester = DB::select("SELECT COUNT(*) AS count FROM sheets WHERE id = ? AND title1 LIKE '%THIRD SEMESTER%'", [$id]);

        if ($hasThirdSemester[0]->count > 0) {
            $userId = DB::select("SELECT user_id FROM sheets WHERE id = ?", [$id])[0]->user_id;
            $idNumber = DB::select("SELECT id_number FROM sheets WHERE id = ?", [$id])[0]->id_number;
            $classDrop = DB::select("SELECT class_drop FROM sheets WHERE id = ?", [$id])[0]->class_drop;
            $gradeDrop = DB::select("SELECT grade_drop FROM sheets WHERE id = ?", [$id])[0]->grade_drop;
            $state = DB::select("SELECT state FROM sheets WHERE id = ?", [$id])[0]->state;
            $stateAr = DB::select("SELECT state_ar FROM sheets WHERE id = ?", [$id])[0]->state_ar;
            $year = DB::select("SELECT year FROM sheets WHERE id = ?", [$id])[0]->year;
            $yearAr = DB::select("SELECT year_ar FROM sheets WHERE id = ?", [$id])[0]->year_ar;
            $school = DB::select("SELECT school FROM sheets WHERE id = ?", [$id])[0]->school;
            $schoolAr = DB::select("SELECT school_ar FROM sheets WHERE id = ?", [$id])[0]->school_ar;
            $name = DB::select("SELECT name FROM sheets WHERE id = ?", [$id])[0]->name;
            $nameAr = DB::select("SELECT name_ar FROM sheets WHERE id = ?", [$id])[0]->name_ar;

            // Get subjects where conditions match for "THIRD SEMESTER"
            $thirdSemesterSubjects = DB::select("
                SELECT * FROM subject s
                WHERE s.sheet_id IN (
                    SELECT id FROM sheets
                    WHERE user_id = ? AND id_number = ? AND class_drop = ? AND grade_drop = ? AND state = ?
                    AND state_ar = ? AND year = ? AND year_ar = ? AND school = ? AND school_ar = ? AND name = ?
                    AND name_ar = ?
                    AND title1 LIKE '%THIRD SEMESTER%'
                )
            ", [$userId, $idNumber, $classDrop, $gradeDrop, $state, $stateAr, $year, $yearAr, $school, $schoolAr, $name, $nameAr]);


            $hasSecondSemester = DB::select("
            SELECT count(*) AS count  FROM subject s
            WHERE s.sheet_id IN (
                SELECT id FROM sheets
                WHERE user_id = ? AND id_number = ? AND class_drop = ? AND grade_drop = ? AND state = ?
                AND state_ar = ? AND year = ? AND year_ar = ? AND school = ? AND school_ar = ? AND name = ?
                AND name_ar = ?
                AND title1 LIKE '%SECOND SEMESTER%'
            )
            ", [$userId, $idNumber, $classDrop, $gradeDrop, $state, $stateAr, $year, $yearAr, $school, $schoolAr, $name, $nameAr]);

            $hasFirstSemester = DB::select("
            SELECT count(*) AS count  FROM subject s
            WHERE s.sheet_id IN (
                SELECT id FROM sheets
                WHERE user_id = ? AND id_number = ? AND class_drop = ? AND grade_drop = ? AND state = ?
                AND state_ar = ? AND year = ? AND year_ar = ? AND school = ? AND school_ar = ? AND name = ?
                AND name_ar = ?
                AND title1 LIKE '%FIRST SEMESTER%'
            )
            ", [$userId, $idNumber, $classDrop, $gradeDrop, $state, $stateAr, $year, $yearAr, $school, $schoolAr, $name, $nameAr]);



            // Get subjects where conditions match for "SECOND SEMESTER"
            $secondSemesterSubjects = DB::select("
                SELECT * FROM subject s
                WHERE s.sheet_id IN (
                    SELECT id FROM sheets
                    WHERE user_id = ? AND id_number = ? AND class_drop = ? AND grade_drop = ? AND state = ?
                    AND state_ar = ? AND year = ? AND year_ar = ? AND school = ? AND school_ar = ? AND name = ?
                    AND name_ar = ?
                    AND title1 LIKE '%SECOND SEMESTER%'
                )
            ", [$userId, $idNumber, $classDrop, $gradeDrop, $state, $stateAr, $year, $yearAr, $school, $schoolAr, $name, $nameAr]);

            // Get subjects where conditions match for "FIRST SEMESTER"
            $firstSemesterSubjects = DB::select("
                SELECT * FROM subject s
                WHERE s.sheet_id IN (
                    SELECT id FROM sheets
                    WHERE user_id = ? AND id_number = ? AND class_drop = ? AND grade_drop = ? AND state = ?
                    AND state_ar = ? AND year = ? AND year_ar = ? AND school = ? AND school_ar = ? AND name = ?
                    AND name_ar = ?
                    AND title1 LIKE '%FIRST SEMESTER%'
                )
                ", [$userId, $idNumber, $classDrop, $gradeDrop, $state, $stateAr, $year, $yearAr, $school, $schoolAr, $name, $nameAr]);

            $hasJpaInThirdSemester = DB::select("
            SELECT count(*) AS count  FROM subject s
            WHERE s.sheet_id IN (
                SELECT id FROM sheets
                WHERE user_id = ? AND id_number = ? AND class_drop = ? AND grade_drop = ? AND state = ?
                AND state_ar = ? AND year = ? AND year_ar = ? AND school = ? AND school_ar = ? AND name = ?
                AND name_ar = ?
                AND title1 LIKE '%THIRD SEMESTER%'
            ) AND s.subject = 'JPA' ", [$userId, $idNumber, $classDrop, $gradeDrop, $state, $stateAr, $year, $yearAr, $school, $schoolAr, $name, $nameAr]);

            if ($hasJpaInThirdSemester[0]->count > 0) {
                // Calculate value based on your criteria
                // Calculate the new subject's value
                // Insert the new subject with calculated value
                $response = [
                    'semester_subjects' => $thirdSemesterSubjects,
                    'second_semester_subjects' => $secondSemesterSubjects,
                    'first_semester_subjects' => $firstSemesterSubjects
                ];
            }else{
                if($hasThirdSemester[0]->count > 0 && $hasSecondSemester[0]->count > 0 && $hasFirstSemester[0]->count > 0){
                        $calculatedSubjectTotals = [];
                        // Loop over third semester subjects
                        foreach ($thirdSemesterSubjects as $thirdSubject) {
                            $subjectName = $thirdSubject->subject;

                            // Initialize variables to hold the totals
                            $thirdSemesterTotal = $thirdSubject->total;
                            $thirdSemesterRank = $thirdSubject->rank;

                            // Initialize variables to hold the second and first semester totals
                            $secondSemesterTotal = 0;
                            $firstSemesterTotal = 0;

                            // Check if the subject exists in the second semester subjects

                            $matchingSecondSubject = array_filter($secondSemesterSubjects, function ($secondSubject) use ($subjectName) {
                                return $secondSubject->subject === $subjectName;
                            });
                            if($subjectName == "Physical Educaion & Self-Defense" ){
                            }
                            if (!empty($matchingSecondSubject)) {
                                $matchingSubject = reset($matchingSecondSubject); // Get the first element
                                $secondSemesterTotal = $matchingSubject->total;
                            }

                            // Check if the subject exists in the first semester subjects
                            $matchingFirstSubject = array_filter($firstSemesterSubjects, function ($firstSubject) use ($subjectName) {
                                return $firstSubject->subject === $subjectName;
                            });
                            if (!empty($matchingFirstSubject)) {
                                $matchingSubject1 = reset($matchingFirstSubject); // Get the first element
                                $firstSemesterTotal = $matchingSubject1->total;
                            }

                            if($thirdSemesterRank == "2"){
                                $newValue = $this->calculatePercentage((($thirdSemesterTotal + $firstSemesterTotal + $secondSemesterTotal)/3),60);
                            }else{
                                $newValue = (($thirdSemesterTotal + $firstSemesterTotal + $secondSemesterTotal)/3);
                            }
                            // Calculate the new value based on your criteria

                            // Store the calculated value in the array
                            $calculatedSubjectTotals[$subjectName] = $newValue;
                        }
                        // Calculate the average (sum / count) of the calculated values
                            $calculatedSum = array_sum($calculatedSubjectTotals);
                            $calculatedCount = count($calculatedSubjectTotals);
                            $calculatedAverage = ($calculatedCount > 0) ? ($calculatedSum / $calculatedCount) : 0;

                            // Determine the grade based on the calculatedAverage value
                            $calculatedGrade = $this->getCalculatedGrade($calculatedAverage);

                            // Create the new subject entry
                            subject::create([
                                'rank' => "1",
                                'status' => $this->calculateStatus($calculatedAverage, 100),
                                'sheet_id' => $id,
                                'subject' => "JPA",
                                'subject_ar' => "نسبة",
                                'total' => $calculatedAverage,
                                'grade' => $calculatedGrade,
                            ]);

                            $thirdSemesterSubjects = DB::select("
                            SELECT * FROM subject s
                            WHERE s.sheet_id IN (
                                SELECT id FROM sheets
                                WHERE user_id = ? AND id_number = ? AND class_drop = ? AND grade_drop = ? AND state = ?
                                AND state_ar = ? AND year = ? AND year_ar = ? AND school = ? AND school_ar = ? AND name = ?
                                AND name_ar = ?
                                AND title1 LIKE '%THIRD SEMESTER%'
                            )
                            ", [$userId, $idNumber, $classDrop, $gradeDrop, $state, $stateAr, $year, $yearAr, $school, $schoolAr, $name, $nameAr]);


                            $response = [
                                'semester_subjects' => $thirdSemesterSubjects,
                                'second_semester_subjects' => $secondSemesterSubjects,
                                'first_semester_subjects' => $firstSemesterSubjects
                            ];
                }else {
                    $semester_subje = DB::select("select * from subject s where sheet_id  =  ?;", [$id]);
                    $response = [
                        'semester_subjects' => $semester_subje,
                    ];

                }
            }

        }else {
            $semester_subje = DB::select("select * from subject s where sheet_id  =  ?;", [$id]);
            $response = [
                'semester_subjects' => $semester_subje,
            ];

        }
            return response()->json($response);

    }
    // public function updateSheetNames(Request $request)
    // {

    //     // Check if the CSRF token is valid
    //     if (!$request->header('X-CSRF-TOKEN')) {
    //         return response()->json([
    //             'error' => 'Invalid CSRF token',
    //         ], 401);
    //     }

    //         // Get the token from the request
    //         $token = $request->header('X-CSRF-TOKEN');

    //         // Check if the token is valid (exists in the token_api field of the user)
    //         $user = User::where('token_api', $token)->first();

    //         if (!$user) {
    //             return response()->json([
    //                 'error' => 'Invalid CSRF token',
    //             ], 401);
    //         }


    //     $file = $request->file('file');

    //     // Read the Excel file using PhpSpreadsheet
    //     $spreadsheet = IOFactory::load($file);

    //     // Update sheet names
    //     foreach ($spreadsheet->getSheetNames() as $sheetName) {
    //         $sheet = $spreadsheet->getSheetByName($sheetName);
    //         $cellValue = $sheet->getCell('Q30')->getValue();
    //         if ($cellValue) {
    //             $newSheetName = (string) $cellValue;
    //             $sheet->setTitle($newSheetName);
    //         }
    //     }

    //     // Create a StreamedResponse to send the updated file directly to the requester
    //     $response = new StreamedResponse(function () use ($spreadsheet) {
    //         $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    //         $writer->save('php://output');
    //     });

    //     // Set the response headers for downloading the file with the updated sheet names
    //     $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     $response->headers->set('Content-Disposition', 'attachment; filename="updated_file.xlsx"');

    //     return $response;
    // }

    public static function calculatePercentage($number, $maxValue) {
        return ($number / $maxValue) * 100;
    }

    public static function calculateStatus($totale, $maxScore) {
        $percentage = ($totale / $maxScore) * 100;

        if ($percentage < 50) {
            return '0';
        } elseif ($percentage >= 90) {
            return '2';
        } else {
            return '1';
        }
    }
    public static function getCalculatedGrade($average) {
        if ($average >= 90) {
            return "ممتاز";
        } elseif ($average >= 80) {
            return "جيد جدا";
        } elseif ($average >= 65) {
            return "جيد";
        } elseif ($average >= 50) {
            return "مقبول";
        } else {
            return "ضعيف";
        }
    }

}
