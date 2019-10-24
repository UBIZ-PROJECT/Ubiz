<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;

class Drive
{
    public function getData($uniqid)
    {
        try {

            $f_data = DB::table('drives')
                ->select('*')
                ->where([
                    ['dri_uniq', '=', $uniqid],
                    ['delete_flg', '=', '0']
                ])
                ->first();

            if ($f_data == null)
                return null;

            $data = [];

            $parents = $this->getAllParents($uniqid);
            $data['breadcrum'] = $this->generateBreadCrum($parents);

            $c_data = DB::table('drives')
                ->select('*')
                ->where([
                    ['dri_funiq', '=', $uniqid],
                    ['delete_flg', '=', '0']
                ])
                ->orderBy('dri_name', 'asc')
                ->get();

            $data['files'] = [];
            $data['folders'] = [];
            foreach ($c_data as $item) {
                if ($item->dri_type == '0') {
                    $data['folders'][] = $item;
                } else {
                    $data['files'][] = $item;
                }
            }
            return $data;

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function uploadFiles($uniqid, $upload_data)
    {
        try {
            $upload_files = $upload_data['upload-files'];
            $relative_paths = $upload_data['relative-paths'];
            $parents = $this->getAllParents($uniqid);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    private function getAllParents($uniqid)
    {
        try {
            $sql = "SELECT T2.*, T1.lvl
                    FROM (
                        SELECT
                            @r AS _dri_uniq,
                            ( SELECT @r := dri_funiq FROM drives WHERE dri_uniq = _dri_uniq ) AS dri_funiq,
                            @l := @l + 1 AS lvl
                        FROM
                            ( SELECT @r := :uniqid, @l := 0 ) vars, drives d
                        WHERE delete_flg = '0'
                    ) T1
                    JOIN drives T2
                    ON T1._dri_uniq = T2.dri_uniq
                    ORDER BY T1.lvl DESC;";

            $results = DB::select(DB::raw($sql), array(
                'uniqid' => $uniqid,
            ));
            return $results;

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    private function generateUniqId()
    {
        try {
            return md5(uniqid());
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    private function generateBreadCrum($parents)
    {
        try {

            $breadcrum = [];
            $is_root = true;
            $is_last = false;

            foreach ($parents as $key => $item) {

                $dri_uniq = $item->dri_uniq;
                $dri_name = $item->dri_name;

                if ($key == sizeof($parents) - 1)
                    $is_last = true;

                $breadcrum[] = [
                    'is_root' => $is_root,
                    'is_last' => $is_last,
                    'dri_uniq' => $dri_uniq,
                    'dri_name' => $dri_name
                ];

                $is_root = false;
                $is_last = false;
            }

            return $breadcrum;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
