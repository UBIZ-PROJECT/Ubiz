<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/31/2018
 * Time: 8:54 PM
 */

namespace App\Model;
use App\Helper;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Keeper implements JWTSubject
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];
    private $CONST_USER = 1;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getKeeperPaging($acs_id, $page = 0) {
        $rows_per_page = env('ROWS_PER_PAGE', 10);
        $keeper = DB::table('accessory_keeper')
            ->select('acs_keeper_id','acs_id','note','keeper', 'quantity')
            ->where('acs_id', '=', $acs_id)
            ->offset($page * $rows_per_page)
            ->limit($rows_per_page)
            ->get();
        return $keeper;
    }

    /**
     * Insert Keeper JSON Structure
     * {
     *  keeper:
     *      {
     *          prd_id,
     *          serial_id,
     *          keeper,
     *          quantity
     *      }
     * }
     */

    public function insertKeeper($param) {
        DB::beginTransaction();
        try {
//            $seri_no = $this->generateCode();
            $id = DB::table('accessory_keeper')->insertGetId(
                [
                    'acs_id'=> $param['acs_id'],
                    'note'=>$param['note'],
                    'keeper'=>$param['keeper'],
                    'quantity'=>$param['quantity'],
                    'delete_flg'=>'0',
                    'inp_date'=>date('Y-m-d H:i:s'),
                    'upd_date'=>date('Y-m-d H:i:s'),
                    'inp_user'=>$this->CONST_USER,
                    'upd_user'=>$this->CONST_USER
                ]
            );

            DB::commit();
            return $id;
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateKeeper($param) {
        DB::beginTransaction();
        try {
            DB::table('accessory_keeper')->where('acs_keeper_id','=',$param['acs_keeper_id'])
                ->update([
                    'keeper'=>$param['keeper'],
                    'quantity'=>$param['quantity'],
                    'note'=>$param['note'],
                    'upd_date'=>date('Y-m-d H:i:s')
                ]);
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteKeeper($id) {
        DB::beginTransaction();
        try {
            DB::table('accessory_keeper')->where('acs_keeper_id','=',$id)
                ->update([
                    'delete_flg'=>'1',
                    'upd_date'=>date('Y-m-d H:i:s')
                ]);
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getPagingInfo($acs_id) {
        try {
            $rows_per_page = env('ROWS_PER_PAGE', 10);
            $rows_num = $this->countAllSeries($acs_id);
        } catch (\Throwable $e) {
            throw $e;
        }

        return [
            'rows_num' => $rows_num,
            'rows_per_page' => $rows_per_page
        ];
    }

    public function countAllSeries($acs_id)
    {
        try {
            $count = DB::select("
                SELECT count(*) as count
                    FROM accessory_keeper where acs_id = ? 
                ", array($acs_id));
            $count = $count[0]->count;
        } catch (\Throwable $e) {
            throw $e;
        }
        return $count;
    }

}