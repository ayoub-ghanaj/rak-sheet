<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\ApiController;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'token_api',
        'password',
        'rank',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public static function data($id){
        $user = DB::table('users')
            ->select('users.*')
            ->where('users.id', '=', "$id")
            ->get();
        return $user[0];
    }

    public static function canadd_students($id){

        $results3 = DB::select("SELECT COUNT(*) AS new_added_count
        FROM students
        WHERE user_id = ? AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE());", [$id]);
        if($results3[0]->new_added_count < 500){
            return true;
        }
        return false;
    }
    public static function canadd_sheets($id){
        $results4 = DB::select("SELECT COUNT(*) AS new_added_count
        FROM sheets
        WHERE user_id = ? AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE());", [$id]);
        if($results4[0]->new_added_count < 200){
            return true;
        }
        return false;

    }
    public static function stats($id)
    {
        $results1 = DB::select("SELECT she.year ,sub.subject, sub.subject_ar  , ROUND(AVG(grade_short), 2) AS avg_grade_short
        FROM subject sub
        INNER JOIN sheets she on sub.sheet_id = she.id
        where she.user_id = ?
        GROUP BY year, subject, subject_ar ;", [$id]);
        $results2 = DB::select("SELECT year, subject, subject_ar, count_below_10
        FROM (
          SELECT she.year, sub.subject, sub.subject_ar,
                 ROUND(AVG(grade_short), 2) AS avg_grade_short,
                 COUNT(CASE WHEN grade_short < 10 THEN 1 END) AS count_below_10
          FROM subject sub
          INNER JOIN sheets she ON sub.sheet_id = she.id
          WHERE she.user_id = ?
          GROUP BY she.year, sub.subject, sub.subject_ar
        ) AS subquery
        WHERE avg_grade_short > 10;", [$id]);
        $results3 = DB::select("SELECT COUNT(*) AS new_added_count
        FROM students
        WHERE user_id = ? AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE());", [$id]);
        $results4 = DB::select("SELECT COUNT(*) AS new_added_count
        FROM sheets
        WHERE user_id = ? AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE());", [$id]);
        return array($results1,$results2,$results3,$results4);
    }
    public static function data_api($id)
    {
        $user = DB::table('wsp')
            ->select('wsp.*')
            ->where('wsp.user_id', '=', $id)
            ->latest('wsp.created_at') // Order by the latest created_at value
            ->first(); // Retrieve only the first record

        return $user;
    }

    public static function data_list($id)
    {
        $results = DB::select("SELECT s.year, s.grade_drop , s.class_drop   , s.title1   FROM sheets s WHERE s.user_id = ? GROUP BY s.year,s.grade_drop , s.class_drop ,s.title1;", [$id]);
        return $results;
    }

    public static function clear($userId)
    {
        DB::transaction(function () use ($userId) {
            // Delete sheets related to the students
            DB::table('sheets')
            ->where('user_id', $userId)
            ->delete();
    
            // Delete students
            DB::table('students')
                ->where('user_id', $userId)
                ->delete();
        });
    }
    public static function data_sub($userId)
    {
        // Get the user using the ID
        $user = User::find($userId);
        $result = DB::table('subs')
        ->select('id')
        ->where('user_id', $userId)
        ->where('end_date', '>', now())
        ->first();

        $isSubscribed = !empty($result);

        if ($isSubscribed) {
            return true;
        }
        return false;
    }

    public static function class_stats_data($id , $year  , $class  , $grade)
    {
        $sheets_list = DB::select("SELECT id  FROM sheets s WHERE s.user_id = ? AND s.year = ? AND class_drop = ? AND grade_drop = ? AND  title1 LIKE '%THIRD SEMESTER%'", [$id , $year  , $class  , $grade]);
        $allnotes = [];
            foreach($sheets_list as $sheet_item){
                $id_sheet = $sheet_item->id;
                // Check if the sheet with the given id contains "THIRD SEMESTER"
                $hasThirdSemester = DB::select("SELECT COUNT(*) AS count FROM sheets s WHERE  s.id = ? AND  s.user_id = ? AND s.title1 LIKE '%THIRD SEMESTER%'", [$id_sheet  , $id]);
                if ($hasThirdSemester[0]->count > 0) {
                    $userId = DB::select("SELECT user_id FROM sheets WHERE id = ?", [$id_sheet])[0]->user_id;
                    $idNumber = DB::select("SELECT id_number FROM sheets WHERE id = ?", [$id_sheet])[0]->id_number;
                    $classDrop = DB::select("SELECT class_drop FROM sheets WHERE id = ?", [$id_sheet])[0]->class_drop;
                    $gradeDrop = DB::select("SELECT grade_drop FROM sheets WHERE id = ?", [$id_sheet])[0]->grade_drop;
                    $state = DB::select("SELECT state FROM sheets WHERE id = ?", [$id_sheet])[0]->state;
                    $stateAr = DB::select("SELECT state_ar FROM sheets WHERE id = ?", [$id_sheet])[0]->state_ar;
                    $year = DB::select("SELECT year FROM sheets WHERE id = ?", [$id_sheet])[0]->year;
                    $yearAr = DB::select("SELECT year_ar FROM sheets WHERE id = ?", [$id_sheet])[0]->year_ar;
                    $school = DB::select("SELECT school FROM sheets WHERE id = ?", [$id_sheet])[0]->school;
                    $schoolAr = DB::select("SELECT school_ar FROM sheets WHERE id = ?", [$id_sheet])[0]->school_ar;
                    $name = DB::select("SELECT name FROM sheets WHERE id = ?", [$id_sheet])[0]->name;
                    $nameAr = DB::select("SELECT name_ar FROM sheets WHERE id = ?", [$id_sheet])[0]->name_ar;

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



                    // Get student
                    $student = DB::select("
                        SELECT s.* FROM students s INNER JOIN sheets sh on sh.id_number = s.id_number
                        WHERE sh.id  = ? ;", [$id_sheet]);
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
                            'student' => $student,
                            'semester_subjects' => $thirdSemesterSubjects,
                            'second_semester_subjects' => $secondSemesterSubjects,
                            'first_semester_subjects' => $firstSemesterSubjects
                        ];
                        $allnotes[$id_sheet] = $response;
                        continue;
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
                                        $newValue = ApiController::calculatePercentage((($thirdSemesterTotal + $firstSemesterTotal + $secondSemesterTotal)/3),60);
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
                                    $calculatedGrade = ApiController::getCalculatedGrade($calculatedAverage);

                                    // Create the new subject entry
                                    subject::create([
                                        'rank' => "1",
                                        'status' => ApiController::calculateStatus($calculatedAverage, 100),
                                        'sheet_id' => $id_sheet,
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
                                        'student' => $student,
                                        'semester_subjects' => $thirdSemesterSubjects,
                                        'second_semester_subjects' => $secondSemesterSubjects,
                                        'first_semester_subjects' => $firstSemesterSubjects
                                    ];
                                    $allnotes[$id_sheet] = $response;
                        }
                    }
                }
            }
        return $allnotes;
    }

    public static function class_data($id , $year , $title , $class , $grade)
    {
        $results1 = DB::select("SELECT count(*) as count_sheet   FROM students st INNER JOIN sheets s ON st.id_number = s.id_number WHERE st.user_id = ? AND s.year = ? AND s.title1 = ?  AND s.class_drop = ? AND s.grade_drop = ?;", [$id , $year, $title , $class, $grade]);
        $results2 = DB::select("SELECT st.id_number , st.name
        FROM students st LEFT JOIN sheets s ON st.id_number = s.id_number
        WHERE st.id_number in (SELECT s.id_number   FROM  sheets s WHERE st.user_id = ? AND s.year = ? AND s.title1 = ?  AND s.class_drop = ? AND s.grade_drop = ? );", [$id , $year, $title , $class, $grade]);
        $results3 = DB::select("SELECT s.id, s.id_number, s.table
        FROM sheets s
        WHERE s.user_id = ?
          AND s.year = ?
          AND s.title1 = ?
          AND s.class_drop = ?
          AND s.grade_drop = ?
		  AND s.status>= 50 ;", [$id , $year, $title , $class, $grade]);
        $results4 = DB::select("SELECT s.id, s.id_number, s.table
        FROM sheets s
        WHERE s.user_id = ?
          AND s.year = ?
          AND s.title1 = ?
          AND s.class_drop = ?
          AND s.grade_drop = ?
		  AND s.status < 50 ;", [$id , $year, $title , $class, $grade]   );
        return array($results1,$results2,$results3,$results4);
    }

    public function calculatePercentage($number, $maxValue) {
        return ($number / $maxValue) * 100;
    }

    public function calculateStatus($totale, $maxScore) {
        $percentage = ($totale / $maxScore) * 100;

        if ($percentage < 50) {
            return '0';
        } elseif ($percentage >= 90) {
            return '2';
        } else {
            return '1';
        }
    }
    public function getCalculatedGrade($average) {
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
