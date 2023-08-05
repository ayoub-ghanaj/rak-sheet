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

                // Add student ID and ID number to the response array
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
                ]);


                $table = json_decode($sheet['table'], true);
                foreach ($table as $ligne) {
                    subject::create([
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
}
