<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Finder\SplFileInfo;
use Illuminate\Support\Facades\Storage;
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
                ->orderBy('dri_id', 'asc')
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

    public function getDetail($uniqid)
    {
        try {

            $data = DB::table('drives')
                ->select('*')
                ->where([
                    ['dri_uniq', '=', $uniqid],
                    ['delete_flg', '=', '0']
                ])
                ->first();

            return $data;

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function validateDriUniq($uniqid)
    {
        try {

            $count = DB::table('drives')
                ->select('*')
                ->where([
                    ['dri_uniq', '=', $uniqid],
                    ['delete_flg', '=', '0']
                ])
                ->count();

            if ($count > 0)
                return true;
            return false;

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function uploadFiles($uniqid, $upload_data)
    {
        DB::beginTransaction();
        try {

            $user_id = Auth::user()->id;
            $file_ids = $upload_data['file-ids'];
            $upload_files = $upload_data['upload-files'];
            $relative_paths = $upload_data['relative-paths'];

            $perrent = DB::table('drives')
                ->select('*')
                ->where([
                    ['dri_uniq', '=', $uniqid],
                    ['delete_flg', '=', '0']
                ])
                ->first();

            $hierarchical_trees = [];
            $hierarchical_trees_level = [];
            $hierarchical_trees_level[0] = $perrent->dri_level + 1;

            $uploaded_files = [];
            foreach ($upload_files as $key => $file) {

                $hierarchical_trees_name = [];
                $relative_path = $relative_paths[$key];
                $paths = explode('/', $relative_path);
                foreach ($paths as $key => $item) {

                    if (array_key_exists($key, $hierarchical_trees) == false) {
                        $hierarchical_trees[$key] = [];
                    }

                    if (array_key_exists($key, $hierarchical_trees_level) == false) {
                        $hierarchical_trees_level[$key] = $hierarchical_trees_level[$key - 1] + 1;
                    }

                    $item_uniq = md5($key . $item);
                    $hierarchical_trees_name[$key] = $item_uniq;
                    if (array_key_exists($item_uniq, $hierarchical_trees[$key]) == true) {
                        continue;
                    }

                    $node = [];
                    if ($key == 0) {
                        $dri_funiq = $perrent->dri_uniq;
                    } else {
                        $bf_item_uniq = $hierarchical_trees_name[$key - 1];
                        $dri_funiq = $hierarchical_trees[$key - 1][$bf_item_uniq]['dri_uniq'];
                    }

                    $node['dri_funiq'] = $dri_funiq;
                    $node['dri_uniq'] = $this->generateUniqId();
                    $node['dri_name'] = $item;
                    $node['dri_level'] = $hierarchical_trees_level[$key];
                    $node['dri_type'] = '0';
                    $node['dri_owner'] = $user_id;
                    $node['inp_user'] = $user_id;
                    $node['upd_user'] = $user_id;

                    if ($key == sizeof($paths) - 1) {

                        $node['dri_type'] = '1';
                        $node['dri_ext'] = strtolower($file->getClientOriginalExtension());

                        $fileSizeUnits = $this->formatSizeUnits($file->getSize());
                        $node['dri_size'] = $fileSizeUnits['dri-size'];
                        $node['dri_size_type'] = $fileSizeUnits['dri-size-type'];

                        //save file to disk
                        $uploaded_file_path = Storage::disk('drive')->putFileAs('marketing', $file, $node['dri_uniq'] . '.' . $node['dri_ext']);
                        $uploaded_files[] = $uploaded_file_path;
                    }

                    //add node to hierarchical trees
                    $hierarchical_trees[$key][$item_uniq] = $node;

                }
            }

            foreach ($hierarchical_trees as $level) {
                foreach ($level as $data) {
                    DB::table('drives')->insert($data);
                }
            }
            DB::commit();
        } catch (\Throwable $e) {
            $this->rollbackUploadedFiles($uploaded_files);
            DB::rollback();
            throw $e;
        }
    }

    private function rollbackUploadedFiles($uploaded_files)
    {
        try {

            foreach ($uploaded_files as $file_path) {
                Storage::disk('drive')->delete($file_path);
            }

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function addNewFolder($uniqid, $folder_name)
    {
        DB::beginTransaction();
        try {

            $user_id = Auth::user()->id;
            $target = DB::table('drives')
                ->select('*')
                ->where([
                    ['dri_uniq', '=', $uniqid],
                    ['delete_flg', '=', '0']
                ])
                ->first();

            $data = [];
            $data['dri_funiq'] = $uniqid;
            $data['dri_uniq'] = $this->generateUniqId();
            $data['dri_name'] = $folder_name;
            $data['dri_level'] = $target->dri_level + 1;
            $data['dri_type'] = '0';
            $data['dri_owner'] = $user_id;
            $data['inp_user'] = $user_id;
            $data['upd_user'] = $user_id;

            DB::table('drives')->insert($data);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function changeName($uniqid, $new_name)
    {
        DB::beginTransaction();
        try {

            $user_id = Auth::user()->id;

            $data = [];
            $data['dri_name'] = $new_name;
            $data['upd_user'] = $user_id;

            DB::table('drives')
                ->where([
                    ['dri_uniq', '=', $uniqid],
                    ['delete_flg', '=', '0']
                ])
                ->update($data);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function changeColor($uniqid, $color)
    {
        DB::beginTransaction();
        try {

            $user_id = Auth::user()->id;

            $data = [];
            $data['dri_color'] = $color;
            $data['upd_user'] = $user_id;

            DB::table('drives')
                ->where([
                    ['dri_uniq', '=', $uniqid],
                    ['delete_flg', '=', '0']
                ])
                ->update($data);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function doCopy($uniqid)
    {
        DB::beginTransaction();
        try {

            $user_id = Auth::user()->id;

            $source_data = DB::table('drives')
                ->select('*')
                ->where([
                    ['dri_uniq', '=', $uniqid],
                    ['delete_flg', '=', '0']
                ])
                ->first();

            $target_data = (array)$source_data;

            unset($target_data['dri_id']);
            unset($target_data['inp_date']);
            unset($target_data['upd_date']);

            $target_data['dri_uniq'] = $this->generateUniqId();
            $target_data['dri_name'] = "Bản sao của " . $target_data['dri_name'];
            $target_data['dri_owner'] = $user_id;
            $target_data['inp_user'] = $user_id;
            $target_data['upd_user'] = $user_id;

            DB::table('drives')->insert($target_data);

            $target_file = $target_data['dri_uniq'];
            if ($target_data['dri_ext'] != '' && $target_data['dri_ext'] != null) {
                $target_file .= "." . $target_data['dri_ext'];
            }

            $source_file = $source_data->dri_uniq;
            if ($source_data->dri_ext != '' && $source_data->dri_ext != null) {
                $source_file .= "." . $source_data->dri_ext;
            }

            Storage::disk('marketing')->copy($source_file, $target_file);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function moveTo($uniqid, $target_uniqid)
    {
        DB::beginTransaction();
        try {

            $user_id = Auth::user()->id;

            $data = [];
            $data['dri_funiq'] = $target_uniqid;
            $data['upd_user'] = $user_id;

            DB::table('drives')
                ->where([
                    ['dri_uniq', '=', $uniqid],
                    ['delete_flg', '=', '0']
                ])
                ->update($data);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteFiles($uniqid)
    {
        DB::beginTransaction();
        try {

            $user_id = Auth::user()->id;
            $data = $this->getDetail($uniqid);

            //delete data
            DB::table('drives')
                ->where([
                    ['dri_uniq', '=', $uniqid],
                    ['delete_flg', '=', '0']
                ])
                ->update([
                    'delete_flg' => '1',
                    'upd_user' => $user_id
                ]);

            //delete file
            $delete_file = $data->dri_uniq . "." . $data->dri_ext;
            Storage::disk('marketing')->delete($delete_file);


            if ($data->dri_type == '0') {

                $children = $this->getAllChildren($uniqid);

                //delete children
                $this->deleteAllChildren($uniqid);

                //delete file
                foreach ($children as $child) {
                    if ($child->dri_type == '0')
                        continue;

                    $delete_file = $child->dri_uniq . "." . $child->dri_ext;
                    Storage::disk('marketing')->delete($delete_file);
                }
            }

            DB::commit();
            return ($data->dri_funiq == null ? $data->dri_uniq : $data->dri_funiq);
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    private function formatSizeUnits($size)
    {
        try {
            // 1 : 'B', 2 : 'KB', 3 : 'MB', 4 : 'GB', 5 : 'TB', 6 : 'PB', 7 : 'EB', 8 : 'ZB', 9 : 'YB'
            $dri_size_type = $size > 0 ? floor(log($size, 1024)) : 0;
            $dri_size = number_format($size / pow(1024, $dri_size_type), 2, '.', '');
            return [
                'dri-size' => $dri_size,
                'dri-size-type' => $dri_size_type + 1
            ];
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getChildren($uniqid)
    {
        try {
            $data = DB::table('drives')
                ->select('*')
                ->where([
                    ['dri_funiq', '=', $uniqid],
                    ['delete_flg', '=', '0']
                ])
                ->orderBy('dri_type', 'asc')
                ->orderBy('dri_id', 'asc')
                ->get();
            return $data;

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
                    ORDER BY T2.dri_id ASC, T1.lvl DESC;";

            $results = DB::select(DB::raw($sql), array(
                'uniqid' => $uniqid,
            ));
            return $results;

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    private function getAllChildren($uniqid)
    {
        try {
            $sql = "SELECT *
                    FROM `drives`
                    WHERE delete_flg = '0' AND FIND_IN_SET(`dri_uniq`, (
                       SELECT GROUP_CONCAT(Level SEPARATOR ',') FROM (
                          SELECT @dri_uniq := (
                              SELECT GROUP_CONCAT(`dri_uniq` SEPARATOR ',')
                              FROM `drives`
                              WHERE FIND_IN_SET(`dri_funiq`, @dri_uniq)
                          ) Level
                          FROM `drives`
                          JOIN (SELECT @dri_uniq := :uniqid) T1
                       ) T2
                    )
                    ORDER BY dri_id ASC);";

            $results = DB::select(DB::raw($sql), array(
                'uniqid' => $uniqid,
            ));
            return $results;

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    private function deleteAllChildren($uniqid)
    {
        try {

            $user_id = Auth::user()->id;
            $sql = "UPDATE `drives` SET delete_flg = '1', upd_user = :upd_user
                    WHERE delete_flg = '0' AND FIND_IN_SET(`dri_uniq`, (
                       SELECT GROUP_CONCAT(Level SEPARATOR ',') FROM (
                          SELECT @dri_uniq := (
                              SELECT GROUP_CONCAT(`dri_uniq` SEPARATOR ',')
                              FROM `drives`
                              WHERE FIND_IN_SET(`dri_funiq`, @dri_uniq)
                          ) Level
                          FROM `drives`
                          JOIN (SELECT @dri_uniq := :uniqid) T1
                       ) T2
                    ));";

            DB::statement($sql, array(
                'upd_user' => $user_id,
                'uniqid' => $uniqid
            ));
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    private function generateUniqId()
    {
        try {
            return strtoupper(md5(uniqid()));
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
