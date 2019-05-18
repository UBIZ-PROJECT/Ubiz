<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Helper;
use App\Model\Customer;
use App\Model\Quoteprice;
use App\Model\QuotepriceDetail;
use App\Model\ProductStatus;
use App\Model\CustomerAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        return view('quoteprice_detail', [
            'quoteprice' => $qpData,
            'quotepriceDetail' => $qpDetailData,
            'prdStatus' => Helper::convertDataToDropdownOptions($prdStatusData, 'id', 'title'),
            'cusAddress' => Helper::convertDataToDropdownOptions($cusAddressData, 'cad_id', 'cad_address'),
        ]);
    }

    public function create(Request $request, $cus_id)
    {
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
        return view('quoteprice_create', [
            'qp_no' => $qp_no,
            'user' => $userData,
            'customer' => $cusData,
            'prdStatus' => Helper::convertDataToDropdownOptions($prdStatusData, 'id', 'title'),
            'cusAddress' => Helper::convertDataToDropdownOptions($cusAddressData, 'cad_id', 'cad_address'),
        ]);
    }

    public function pdf(Request $request, $qp_id, $uniqid)
    {
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
    }
}
