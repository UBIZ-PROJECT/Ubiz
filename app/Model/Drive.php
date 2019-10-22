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
            $data['breadcrum'] = $this->generateBreadCrum($f_data->dri_path_uniq, $f_data->dri_path_name);

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

    private function generateBreadCrum($dri_path_uniq, $dri_path_name)
    {
        try {

            $breadcrum = [];
            $path_uniq = explode("/", $dri_path_uniq);
            $path_name = explode("/", $dri_path_name);

            $is_root = true;
            $is_last = false;
            for ($i = 0; $i < sizeof($path_uniq); $i++) {

                $dri_uniq = $path_uniq[$i];
                $dri_name = "Nout found";
                if (requiredValidator($path_name[$i]) == true) {
                    $dri_name = $path_name[$i];
                }

                if ($i == sizeof($path_uniq) - 1)
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
