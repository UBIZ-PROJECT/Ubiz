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
            $qpModel = new Quoteprice();
            $qpData = $qpModel->getQuoteprices();
            $pagingData = $qpModel->getPagingInfo();
            $pagingData['page'] = 0;
            return view('quoteprice', ['quoteprices' => $qpData, 'paging' => $pagingData]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function detail(Request $request, $qp_id)
    {
        try {
            $qpModel = new Quoteprice();
            $qpData = $qpModel->getQuoteprice($qp_id);

            if ($qpData == null) {
                return response()->view('errors.404', [], 404);
            }
            $qpDetail = new QuotepriceDetail();
            $qpDetailData = $qpDetail->getQuotepriceDetailsByQpId($qp_id);

            $prdStatus = new ProductStatus();
            $prdStatusData = $prdStatus->getAllStatus();

            $cusAddress = new CustomerAddress();
            $cusAddressData = $cusAddress->getAddressByCusId($qpData->cus_id);

            $cusModel = new Customer();
            $contactData = $cusModel->getCustomerContact($qpData->cus_id);

            $comModel = new Company();
            $comData = $comModel->getAllCompany();

            $languages = [
                'en' => 'Tiếng Anh',
                'vn' => 'Tiếng Việt',
            ];

            return view('quoteprice_detail', [
                'quoteprice' => $qpData,
                'quotepriceDetail' => $qpDetailData,
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
            $cus = new Customer();
            $cusData = $cus->getCustomerById($cus_id);
            if ($cusData == null) {
                return response()->view('errors.404', [], 404);
            }

            $user = new User();
            $userData = $user->getCurrentUser();

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
                'customer' => $cusData,
                'contacts' => $contactData,
                'prdStatus' => convertDataToDropdownOptions($prdStatusData, 'id', 'title'),
                'cusAddress' => convertDataToDropdownOptions($cusAddressData, 'cad_id', 'cad_address'),
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function pdf(Request $request, $qp_id, $uniqid)
    {
        try {
            $qpModel = new Quoteprice();
            $qpData = $qpModel->getQuoteprice($qp_id);
            if ($qpData == null) {
                return response()->view('errors.404', [], 404);
            }

            $file = $qpModel->getPdfFile($qp_id, $uniqid);
            if ($file == null) {
                return response()->view('errors.404', [], 404);
            }

            return response()->file($file['path'], ['Content-Disposition' => 'filename="' . $file['name'] . '.pdf"']);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function download(Request $request, $qp_id, $uniqid, $file_name)
    {
        try {
            $qpModel = new Quoteprice();
            $qpData = $qpModel->getQuoteprice($qp_id);
            if ($qpData == null) {
                return response()->view('errors.404', [], 404);
            }

            $is_exists = Storage::disk('quoteprices')->exists("$uniqid.pdf");
            if ($is_exists == false) {
                return response()->view('errors.404', [], 404);
            }

            $file_path = Storage::disk('quoteprices')->path("$uniqid.pdf");

            $headers = [
                'Content-Type' => 'application/pdf',
            ];

            return response()->download($file_path, "$file_name.pdf", $headers);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
