<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Model\Company;
use App\Model\Customer;
use App\Model\Quoteprice;
use App\Model\QuotepriceDetail;
use App\Model\ProductStatus;
use App\Model\CustomerAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class QuotepriceController extends Controller
{
    public function index(Request $request)
    {
        try {

            checkUserRight(11, 1);

            $qpModel = new Quoteprice();
            $qpData = $qpModel->search();
            $pagingData = $qpModel->getPagingInfo();
            $pagingData['page'] = 0;

            $userData = [];
            $userModel = new User();
            $curUser = $userModel->getCurrentUser();
            if ($curUser->role == '1' || $curUser->role == '2') {
                $userData = $userModel->getAllUsers();
            }

            $cusModel = new Customer();
            $cusData = $cusModel->getAllCustomers();

            return view('quoteprice', [
                'quoteprices' => $qpData,
                'customers' => $cusData,
                'users' => $userData,
                'paging' => $pagingData
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function detail(Request $request, $qp_id)
    {
        try {

            checkUserRight(11, 1);

            $qpModel = new Quoteprice();
            $qpData = $qpModel->getQuoteprice($qp_id);

            if ($qpData == null) {
                return response()->view('errors.404', [], 404);
            }
            $qpDetail = new QuotepriceDetail();
            $qpDetailData = $qpDetail->getQuotepriceDetailsByQpId($qp_id);

            $user = new User();
            $userData = $user->getCurrentUser();
            $saleData = $user->getAllUserByDepId('3');

            $prdStatus = new ProductStatus();
            $prdStatusData = $prdStatus->getAllStatus();

            $cusAddress = new CustomerAddress();
            $cusAddressData = $cusAddress->getAddressByCusId($qpData->cus_id);

            $cusModel = new Customer();
            $contactData = $cusModel->getCustomerContact($qpData->cus_id);

            $comModel = new Company();
            $comData = $comModel->findAll();

            $languages = [
                'en' => 'Tiếng Anh',
                'vn' => 'Tiếng Việt',
            ];

            return view('quoteprice_detail', [
                'quoteprice' => $qpData,
                'quotepriceDetail' => $qpDetailData,
                'user' => $userData,
                'sales' => $saleData,
                'contacts' => $contactData,
                'languages' => $languages,
                'company' => convertDataToDropdownOptions($comData, 'com_id', 'com_nm_shot'),
                'prdStatus' => convertDataToDropdownOptions($prdStatusData, 'id', 'title'),
                'cusAddress' => convertDataToDropdownOptions($cusAddressData, 'cad_id', 'cad_address'),
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function create(Request $request, $cus_id)
    {
        try {

            checkUserRight(5, 5);

            $cus = new Customer();
            $cusData = $cus->getCustomerById($cus_id);
            if ($cusData == null) {
                return response()->view('errors.404', [], 404);
            }

            $user = new User();
            $userData = $user->getCurrentUser();
            $saleData = $user->getAllUserByDepId('3');

            $qpModel = new Quoteprice();
            $qp_no = $qpModel->generateQpNo();

            $prdStatus = new ProductStatus();
            $prdStatusData = $prdStatus->getAllStatus();

            $cusAddress = new CustomerAddress();
            $cusAddressData = $cusAddress->getAddressByCusId($cus_id);

            $cusModel = new Customer();
            $contactData = $cusModel->getCustomerContact($cus_id);

            return view('quoteprice_create', [
                'qp_no' => $qp_no,
                'user' => $userData,
                'sales' => $saleData,
                'customer' => $cusData,
                'contacts' => $contactData,
                'prdStatus' => convertDataToDropdownOptions($prdStatusData, 'id', 'title'),
                'cusAddress' => convertDataToDropdownOptions($cusAddressData, 'cad_id', 'cad_address'),
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function preview(Request $request, $qp_id)
    {
        try {
            checkUserRight(11, 1);
            $extra_data = $request->get('params', null);

            $qpModel = new Quoteprice();
            $qpData = $qpModel->getQuoteprice($qp_id);
            if (empty($qpData) == true || $qpData == null) {
                return response()->json(['success' => false, 'message' => __('Data is wrong.!')], 200);
            }

            $qpDetailModel = new QuotepriceDetail();
            $qpDetailData = $qpDetailModel->getQuotepriceDetailsByQpId($qp_id);

            $user = new User();
            $userData = $user->getCurrentUser();

            $tmp_quoteprices_detail = [];
            foreach ($qpDetailData as $idx => $item) {

                if (array_key_exists($item->type, $tmp_quoteprices_detail) == false) {
                    $tmp_quoteprices_detail[$item->type] = [];
                }
                $tmp_quoteprices_detail[$item->type][] = $item;
            }

            $company = presentValidator($extra_data['md_company']) == true ? ($extra_data['md_company'] == '1' ? 'tk' : 'ht') : 'tk';
            $language = presentValidator($extra_data['md_language']) == true ? $extra_data['md_language'] : 'vn';

            $view_name = "quoteprice_preview_{$company}_{$language}";

            return view($view_name, [
                'user' => $userData,
                'extra_data' => $extra_data,
                'quoteprice' => $qpData,
                'quoteprices_detail' => $tmp_quoteprices_detail
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function download(Request $request, $qp_id, $uniqid, $file_name)
    {
        try {
            checkUserRight(11, 1);
            $qpModel = new Quoteprice();
            $qpData = $qpModel->getQuoteprice($qp_id);
            if ($qpData == null) {
                return response()->view('errors.404', [], 404);
            }

            $is_exists = Storage::disk('quoteprices')->exists("$uniqid.xlsx");
            if ($is_exists == false) {
                return response()->view('errors.404', [], 404);
            }

            $file_path = Storage::disk('quoteprices')->path("$uniqid.xlsx");

            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ];

            return response()->download($file_path, "$file_name.xlsx", $headers);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
