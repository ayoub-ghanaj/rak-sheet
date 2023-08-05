<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        $results = DB::select("SELECT s.year,s.class , s.title1   FROM sheets s WHERE s.user_id = ? GROUP BY s.year,s.class,s.title1;", [$id]);
        return $results;
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

    public static function class_data($id , $year , $title , $class)
    {
        $results1 = DB::select("SELECT count(*) as count_sheet   FROM students st INNER JOIN sheets s ON st.id_number = s.id_number WHERE st.user_id = ? AND s.year = ? AND s.title1 = ?  AND s.class = ?;", [$id , $year, $title , $class]);
        $results2 = DB::select("SELECT st.id_number , st.name   FROM students st LEFT JOIN sheets s ON st.id_number = s.id_number WHERE st.user_id = ? AND st.year = ? AND st.class_number = ?;", [$id , $year , $class]);
        $results3 = DB::select("SELECT sheet_id, s.id_number , COUNT(subject) AS subject_count
        FROM subject sub INNER JOIN sheets s ON s.id = sub.sheet_id
        WHERE sheet_id IN (SELECT s.id   FROM students st INNER JOIN sheets s ON st.id_number = s.id_number WHERE st.user_id = ? AND st.year = ? AND st.class_number = ?) 
        GROUP BY sheet_id , s.id_number 
        HAVING SUM(total) / COUNT(subject) >= 50;", [$id , $year , $class]);
        $results4 = DB::select("SELECT sheet_id, s.id_number , COUNT(subject) AS subject_count
        FROM subject sub INNER JOIN sheets s ON s.id = sub.sheet_id
        WHERE sheet_id IN (SELECT s.id   FROM students st INNER JOIN sheets s ON st.id_number = s.id_number WHERE st.user_id = ? AND st.year = ? AND st.class_number = ?) 
        GROUP BY sheet_id , s.id_number 
        HAVING SUM(total) / COUNT(subject) <= 50;", [$id , $year , $class]);
        return array($results1,$results2,$results3,$results4);
    }
}
