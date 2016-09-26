<?php

/**
 * Created by IntelliJ IDEA.
 * User: jonam
 * Date: 23/7/16
 * Time: 10:52 AM
 */
class Product extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('users_model');
        $this->load->library('session');
    }

    public function addProductMaster()
    {

        $submit = $this->input->get_post('submit');
        $actionType = $this->input->get_post('actionType');
        $actionId = $this->input->get_post('actionId');

        $dataheader['addProductMasterUrl'] = "addProductMaster";

        $sessionUserTypeIdIsset = $this->session->has_userdata('usertypeid');
        $adminid = "0";
        if ($sessionUserTypeIdIsset == 1) {
            $sessionUserTypeId = $this->session->userdata('usertypeid');
            if ($sessionUserTypeId == 2) {
                $adminid = $this->session->userdata('userid');
            } else if ($sessionUserTypeId == 1) {
                $adminid = $this->input->get_post('adminid');
            } else if ($sessionUserTypeId == 4) {
                $adminid = $this->session->userdata('adminid');
            }
        }

        $updateSuccess = 0;
        $insertSuccess = 0;
        $deletetSuccess = 0;
        if ($submit == 'Product') {
            $output = array('status' => "3", 'message' => "Invalid Request");
            $productname = $this->input->get_post('productname');
            $brandname = $this->input->get_post('brandname');
            $barcode = $this->input->get_post('barcode');
            $size = $this->input->get_post('size');
            $categorytypeid = $this->input->get_post('categorytypeid');
            $price = $this->input->get_post('price');
            $active = 'active';
            $createdAtdate = date("Y-m-d H:i:s");
            $ShowroomId = $this->input->get_post('ShowroomId');
            $mappedprice = $this->input->get_post('mappedprice');
            $mappedqyt = $this->input->get_post('mappedqyt');

            if ($actionType == "Edit" && $actionId != "0" && $actionId != "" && $actionId != null) {
                $ProductDetailsArray = array('productid' => $actionId, 'productname' => $productname, 'price' => $price, 'size' => $size, 'barcode' => $barcode, 'categorytypeid' => $categorytypeid, 'brandname' => $brandname, 'adminid' => $adminid);
                $this->users_model->updateProductMaster($ProductDetailsArray); //For admin
            } else if ($actionType == "Delete" && $actionId != "0" && $actionId != "" && $actionId != null) {
                $ProductDetailsDeleteArray = array('productid' => $actionId, 'adminid' => $adminid);
                $this->users_model->deleteProductMaster($ProductDetailsDeleteArray); //For admin
                $output = array('status' => "1", 'message' => "Successfully deleted");
            } else if ($actionType == "Add" || $actionType == "") {
                $ProductDetailsArray = array('productname' => $productname, 'price' => $price, 'size' => $size, 'barcode' => $barcode, 'categorytypeid' => $categorytypeid, 'brandname' => $brandname, 'adminid' => $adminid, 'createdAtdate' => $createdAtdate, 'active' => $active);
                $productId = $this->users_model->createProductMaster($ProductDetailsArray); //For admin
                for ($i = 0; $i < count($ShowroomId); $i++) {
                    $ProductMappingArray = array('ShowroomId' => $ShowroomId[$i], 'mappedprice' => $mappedprice[$i], 'mappedqyt' => $mappedqyt[$i], 'adminid' => $adminid, 'productId' => $productId, 'createdAtdate' => $createdAtdate);
                    $this->users_model->createProductmappingMaster($ProductMappingArray);
                }
            }
            redirect(base_url() . "Product/ProductMaster");
        }

        if ($submit == "brand") {

            $brandname = $this->input->post('brandname');
            $createdAt = date("Y-m-d H:i:s");
            $BrandDetailsArray = array('brandname' => $brandname, 'brandid' => $actionId, 'adminid' => $adminid, 'createdAt' => $createdAt);

            $output = array('status' => "3", 'message' => "Invalid Request");
            if ($actionType == "Edit" && $actionId != "0" && $actionId != "" && $actionId != null) {
                $insertSuccess = $userTypeArray = $this->users_model->updateBrandMaster($BrandDetailsArray); //For Create Brand
                if ($insertSuccess == 1) {
                    $output = array('status' => "1", 'message' => "Successfully updated");
                } else {
                    $output = array('status' => "2", 'message' => "Invalid update");
                }
            } else if ($actionType == "Delete" && $actionId != "0" && $actionId != "" && $actionId != null) {
                $deletetSuccess = $userTypeArray = $this->users_model->deleteBrandMaster($BrandDetailsArray); //For Update Brand
                if ($deletetSuccess == 1) {
                    $output = array('status' => "1", 'message' => "Successfully deleted");
                } else {
                    $output = array('status' => "2", 'message' => "Please try again later");
                }
            } else if ($actionType == "Add" || $actionType == "") {
                $updateSuccess = $userTypeArray = $this->users_model->createBrandMaster($BrandDetailsArray); //For Update Brand
                if ($updateSuccess == 1) {
                    $output = array('status' => "1", 'message' => "Successfully created");
                } else {
                    $output = array('status' => "2", 'message' => "Please try again later");
                }
            }
            $this->session->set_flashdata('output', $output);

            redirect(base_url() . "Product/BrandMaster");
        }

        if ($submit == "size") {

            $size = $this->input->post('size');
            $createdAt = date("Y-m-d H:i:s");
            $SizeDetailsArray = array('size' => $size, 'sizeid' => $actionId, 'adminid' => $adminid, 'createdAt' => $createdAt);

            $output = array('status' => "3", 'message' => "Invalid Request");
            if ($actionType == "Edit" && $actionId != "0" && $actionId != "" && $actionId != null) {
                $insertSuccess = $userTypeArray = $this->users_model->updateSizeMaster($SizeDetailsArray); //For Create Brand
                if ($insertSuccess == 1) {
                    $output = array('status' => "1", 'message' => "Successfully updated");
                } else {
                    $output = array('status' => "2", 'message' => "Invalid update");
                }
            } else if ($actionType == "Delete" && $actionId != "0" && $actionId != "" && $actionId != null) {
                $deletetSuccess = $userTypeArray = $this->users_model->deleteSizeMaster($SizeDetailsArray); //For Update Brand
                if ($deletetSuccess == 1) {
                    $output = array('status' => "1", 'message' => "Successfully deleted");
                } else {
                    $output = array('status' => "2", 'message' => "Please try again later");
                }
            } else if ($actionType == "Add" || $actionType == "") {
                $updateSuccess = $userTypeArray = $this->users_model->createSizeMaster($SizeDetailsArray); //For Update Brand
                if ($updateSuccess == 1) {
                    $output = array('status' => "1", 'message' => "Successfully created");
                } else {
                    $output = array('status' => "2", 'message' => "Please try again later");
                }
            }
            $this->session->set_flashdata('output', $output);
            redirect(base_url() . "Product/SizeMaster");
        }

        if ($submit == "Category Type") {

            $categoryType = $this->input->post('categoryType');
            $createdAt = date("Y-m-d H:i:s");
            $CategoryTypeDetailsArray = array('categoryType' => $categoryType, 'categorytypeid' => $actionId, 'adminid' => $adminid, 'createdAt' => $createdAt);

            $output = array('status' => "3", 'message' => "Invalid Request");
            if ($actionType == "Edit" && $actionId != "0" && $actionId != "" && $actionId != null) {
                $insertSuccess = $userTypeArray = $this->users_model->updateCategoryTypeMaster($CategoryTypeDetailsArray); //For Create Brand
                if ($insertSuccess == 1) {
                    $output = array('status' => "1", 'message' => "Successfully updated");
                } else {
                    $output = array('status' => "2", 'message' => "Invalid update");
                }
            } else if ($actionType == "Delete" && $actionId != "0" && $actionId != "" && $actionId != null) {
                $deletetSuccess = $userTypeArray = $this->users_model->deleteCategoryTypeMaster($CategoryTypeDetailsArray); //For Update Brand
                if ($deletetSuccess == 1) {
                    $output = array('status' => "1", 'message' => "Successfully deleted");
                } else {
                    $output = array('status' => "2", 'message' => "Please try again later");
                }
            } else if ($actionType == "Add" || $actionType == "") {
                $updateSuccess = $userTypeArray = $this->users_model->createCategoryTypeMaster($CategoryTypeDetailsArray); //For Update Brand
                if ($updateSuccess == 1) {
                    $output = array('status' => "1", 'message' => "Successfully created");
                } else {
                    $output = array('status' => "2", 'message' => "Please try again later");
                }
            }
            $this->session->set_flashdata('output', $output);
            redirect(base_url() . "Product/CategoryTypeMaster");

        }
    }

    public function ViewRetailerCostDetails(){
        $dataheader = array();
        $dataheader['title'] = "Retailer cost";
        $sessionUserTypeIdIsset = $this->session->has_userdata('usertypeid');
        $adminid = "0";
        $sessionUserTypeId = "0";
        $showroomId = $this->input->get_post('showroomId');
        if ($sessionUserTypeIdIsset == 1) {
            $sessionUserTypeId = $this->session->userdata('usertypeid');
            if ($sessionUserTypeId == 2) {
                $adminid = $this->session->userdata('userid');
            } else if ($sessionUserTypeId == 1) {
                $adminid = $this->input->get_post('adminid');
            } else if ($sessionUserTypeId == 4) {
                $adminid = $this->session->userdata('adminid');
                $showroomId = $this->session->userdata('retailerShowRoomId');
            }
        }

        $productId = $this->input->get_post('productId');
        $responseFromSite = $this->input->get_post('responseFromSite');
        $RetailerProductList = $this->users_model->getRetailerProductList($adminid, $productId, $showroomId, null, null, null, null);
        $viewCostUrl = base_url()."Product/ViewRetailerCostDetails";
        $mapRetailerProductCostAndQuantityUrl =   base_url()."Product/mapRetailerProductCostAndQuantityUrl";
        $dataheader['productId']= $productId;
        $dataheader['viewCostUrl']= $viewCostUrl;
        $dataheader['mapRetailerProductCostAndQuantityUrl']= $mapRetailerProductCostAndQuantityUrl;
        $dataheader['RetailerProductList']= $RetailerProductList;
        $successMsg = "";
        if($responseFromSite==1){
            $output = array('status' => "1", 'message' => "Successfully updated");
            $successMsg = $this->users_model->getSuccessMsg($output);
        }
        $dataheader['successMsg']= $successMsg;
        $this->load->view('product/ViewRetailerCostDetails', $dataheader);
    }

    public function mapRetailerProductCostAndQuantityUrl(){
        $dataheader = array();
        $dataheader['title'] = "Retailer cost";
        $sessionUserTypeIdIsset = $this->session->has_userdata('usertypeid');
        $adminid = "0";
        $sessionUserTypeId = "0";
        if ($sessionUserTypeIdIsset == 1) {
            $sessionUserTypeId = $this->session->userdata('usertypeid');
            if ($sessionUserTypeId == 2) {
                $adminid = $this->session->userdata('userid');
            } else if ($sessionUserTypeId == 1) {
                $adminid = $this->input->get_post('adminid');
            } else if ($sessionUserTypeId == 4) {
                $adminid = $this->session->userdata('adminid');
            }
        }

        $retailerIdArray = $this->input->get_post('retailerId');
        $newMrpArray = $this->input->get_post('newMrp');
        $incQtyArray = $this->input->get_post('incQty');

        $productId = $this->input->get_post('productId');
        $viewCostUrl = $this->input->get_post('viewCostUrl');


        for($n=0; $n<count($retailerIdArray) && $n<count($newMrpArray) && $n<count($incQtyArray); $n++){

            $retailerId = $retailerIdArray[$n];
            $newMrp = $newMrpArray[$n];
            $incQty = $incQtyArray[$n];

            $isUpdateprice = "";
            if($newMrp!="" && $newMrp!=null && $newMrp>0){
                $isUpdateprice = "on";
            }

            if($newMrp!="" || $incQty!=""){
                $ProductMappingArray = array('showroomId' => $retailerId, 'newPrice' => $newMrp, 'Incquantity' => $incQty, 'adminid' => $adminid, 'productid' => $productId, 'price'=>$isUpdateprice);
                $this->users_model->assignMapProduct($ProductMappingArray);
            }
        }
    }

    public function AddBrand()
    {
        $dataheader = array();
        $actionType = $this->input->get_post('actionType');
        $actionId = $this->input->get_post('actionId');

        $sessionUserTypeIdIsset = $this->session->has_userdata('usertypeid');
        $adminid = "0";
        $sessionUserTypeId = "0";
        if ($sessionUserTypeIdIsset == 1) {
            $sessionUserTypeId = $this->session->userdata('usertypeid');
            if ($sessionUserTypeId == 2) {
                $adminid = $this->session->userdata('userid');
            } else if ($sessionUserTypeId == 1) {
                $adminid = $this->input->get_post('adminid');
            } else if ($sessionUserTypeId == 4) {
                $adminid = $this->session->userdata('adminid');
            }
        }

        $singleBrandList = array();
        if ($actionType == "Edit") {
            $singleBrandList = $this->users_model->getBrandList($adminid, $actionId);
        }

        $dataheader['adminid'] = $adminid;
        $dataheader['title'] = "Brand";
        $dataheader['actionType'] = $actionType;
        $dataheader['actionId'] = $actionId;
        $dataheader['singleBrandList'] = $singleBrandList;
        $dataheader['addProductMasterUrl'] = "addProductMaster";
        $this->load->view('product/AddBrand', $dataheader);
    }

    public function BrandList()
    {
        //print_r($_REQUEST);
//        $adminid = $this->input->post('adminid');

        $sessionUserTypeIdIsset = $this->session->has_userdata('usertypeid');
        $adminid = "0";
        $showroomId = "0";
        $sessionUserTypeId = "0";
        if ($sessionUserTypeIdIsset == 1) {
            $sessionUserTypeId = $this->session->userdata('usertypeid');
            if ($sessionUserTypeId == 2) {
                $adminid = $this->session->userdata('userid');
                $showroomId = $this->input->get_post('showroomId');
            } else if ($sessionUserTypeId == 1) {
                $adminid = $this->input->get_post('adminid');
                $showroomId = $this->input->get_post('showroomId');
            } else if ($sessionUserTypeId == 4) {
                $showroomId = $this->session->userdata("retailerShowRoomId");
                $adminid = $this->session->userdata('adminid');

            }
        }

        $type = $this->input->get('type');
        $actionId = "0";

        $BrandList = array();
        $SizeList = array();
        $CategoryTypeList = array();

        $ProductList = array();
        if ($type == "brandList") {
            $BrandList = $this->users_model->getBrandList($adminid, $actionId);
        } else if ($type == "sizeList") {
            $SizeList = $this->users_model->getSizeList($adminid, $actionId);
        } else if ($type == "Category Type") {
            $CategoryTypeList = $this->users_model->getCategoryTypeList($adminid, $actionId);
        } else if ($type == "ProductList") {
            $categorytypeid = $this->input->get_post('categorytypeid');
            $brandid = $this->input->get_post('brandid');
            $sizeid = $this->input->get_post('sizeid');
            $barcode = $this->input->get_post('barcode');

            $ProductList = $this->users_model->getProductList($adminid, "0", $showroomId, $categorytypeid, $brandid, $sizeid, $barcode);
        }

        $dataheader['typeList'] = $type;
        $dataheader['SizeList'] = $SizeList;
        $dataheader['BrandList'] = $BrandList;
        $dataheader['CategoryTypeList'] = $CategoryTypeList;
        $dataheader['ProductList'] = $ProductList;
        $dataheader['sessionUserTypeId'] = $sessionUserTypeId;

        $this->load->view('product/BrandList', $dataheader);
    }

    public function productSearch(){

        $sessionUserTypeIdIsset = $this->session->has_userdata('usertypeid');
        $adminid = "0";
        $showroomId = "0";
        $sessionUserTypeId = "0";
        if ($sessionUserTypeIdIsset == 1) {
            $sessionUserTypeId = $this->session->userdata('usertypeid');
            if ($sessionUserTypeId == 2) {
                $adminid = $this->session->userdata('userid');
            } else if ($sessionUserTypeId == 1) {
                $adminid = $this->input->get_post('adminid');
                $showroomId = $this->input->get_post('showroomId');
            } else if ($sessionUserTypeId == 4) {
                $showroomId = $this->session->userdata("retailerShowRoomId");
                $adminid = $this->session->userdata('adminid');
            }
        }

        $dataheader = array();
        $categorytypeid = $this->input->get_post('categorytypeid');
        $brandid = $this->input->get_post('brandid');
        $sizeid = $this->input->get_post('sizeid');
        $barcode = $this->input->get_post('barcode');

        $BrandArray = $this->users_model->getBrandList($adminid, null);
        $SizeList = $this->users_model->getSizeList($adminid, null);
        $CategoryTypeList = $this->users_model->getCategoryTypeList($adminid, null);
        $showroomArray = $this->users_model->getUsersList("3", $adminid, null, null);

        $dataheader['BrandArray'] = $BrandArray;
        $dataheader['SizeList'] = $SizeList;
        $dataheader['CategoryTypeList'] = $CategoryTypeList;
        $dataheader['showroomArray'] = $showroomArray;

        $dataheader['categorytypeid'] = $categorytypeid;
        $dataheader['brandid'] = $brandid;
        $dataheader['sizeid'] = $sizeid;
        $dataheader['barcode'] = $barcode;
        $dataheader['showroomId'] = $showroomId;

        $this->load->view('product/productSearch', $dataheader);
    }

    public function ProductMaster()
    {
        $sessionUserTypeIdIsset = $this->session->has_userdata('usertypeid');
        $adminid = "0";
        if ($sessionUserTypeIdIsset == 1) {
            $sessionUserTypeId = $this->session->userdata('usertypeid');
            if ($sessionUserTypeId == 2) {
                $adminid = $this->session->userdata('userid');
            } else if ($sessionUserTypeId == 1) {
                $adminid = $this->input->get_post('adminid');
            } else if ($sessionUserTypeId == 4) {
                $adminid = $this->session->userdata('adminid');
            }
        } else {
            redirect(base_url() . "Frontend/logout");
        }
//        $adminid = $this->session->userdata('usertypeid');
        $dataheader['title'] = "Product";
        $this->load->view('layout/backend_header', $dataheader);
        $this->load->view('layout/backend_menu');
        $this->load->view('product/ProductMaster');
        $this->load->view('layout/backend_footer');
    }

    public function BrandMaster()
    {
        $dataheader['Brand'] = "Brand";
        $dataheader['title'] = "Brand";
        //$adminid = $this->session->userdata('usertypeid');
        $this->load->view('layout/backend_header', $dataheader);
        $this->load->view('layout/backend_menu');
        $this->load->view('product/BrandMaster', $dataheader);
        $this->load->view('layout/backend_footer');
    }

    public function CategoryTypeMaster()
    {
        $dataheader['CategoryType'] = "CategoryType";
        $dataheader['title'] = "Category Type";
        //$adminid = $this->session->userdata('usertypeid');
        $this->load->view('layout/backend_header', $dataheader);
        $this->load->view('layout/backend_menu');
        $this->load->view('product/CategoryTypeMaster', $dataheader);
        $this->load->view('layout/backend_footer');
    }

    public function AddOrEditMasterContent()
    {
        $dataheader['title'] = "Category Type";
        $actionType = $this->input->get_post('actionType');
        $actionId = $this->input->get_post('actionId');
        $masterName = $this->input->get_post('masterName');

        $showroomArray = array();
        $BrandArray = array();
        $SizeArray = array();
        $CategoryTypeArray = array();

        $sessionUserTypeIdIsset = $this->session->has_userdata('usertypeid');
        $adminid = "0";
        if ($sessionUserTypeIdIsset == 1) {
            $sessionUserTypeId = $this->session->userdata('usertypeid');
            if ($sessionUserTypeId == 2) {
                $adminid = $this->session->userdata('userid');
            } else if ($sessionUserTypeId == 1) {
                $adminid = $this->input->get_post('adminid');
            } else if ($sessionUserTypeId == 4) {
                $adminid = $this->session->userdata('adminid');
            }
        }

        if ($masterName == "Product") {
            $showroomArray = $this->users_model->getUsersList('3', $adminid, "0", null);
            $BrandArray = $this->users_model->getBrandList($adminid, "0");
            $SizeArray = $this->users_model->getSizeList($adminid, "0");
            $CategoryTypeArray = $this->users_model->getCategoryTypeList($adminid, "0");
        } else if ($masterName == "Category Type" && $actionType == "Edit") {
            $CategoryTypeArray = $this->users_model->getCategoryTypeList($adminid, $actionId);
        }

//        echo $masterName;

        $dataheader['showroomArray'] = $showroomArray;
        $dataheader['BrandArray'] = $BrandArray;
        $dataheader['SizeArray'] = $SizeArray;
        $dataheader['CategoryTypeArray'] = $CategoryTypeArray;

        $dataheader['actionType'] = $actionType;
        $dataheader['actionId'] = $actionId;
        $dataheader['masterName'] = $masterName;
        $dataheader['addProductMasterUrl'] = "addProductMaster";

        $this->load->view('product/AddOrEditMasterContent', $dataheader);
    }

    public function SizeMaster()
    {
        $dataheader['Size'] = "Size";
        $dataheader['title'] = "Size";
        //$adminid = $this->session->userdata('usertypeid');
        $this->load->view('layout/backend_header', $dataheader);
        $this->load->view('layout/backend_menu');
        $this->load->view('product/SizeMaster', $dataheader);
        $this->load->view('layout/backend_footer');
    }

    public function AddSize()
    {
        $dataheader = array();
        $actionType = $this->input->get_post('actionType');
        $actionId = $this->input->get_post('actionId');

        $sessionUserTypeIdIsset = $this->session->has_userdata('usertypeid');
        $adminid = "0";
        $sessionUserTypeId = "0";
        if ($sessionUserTypeIdIsset == 1) {
            $sessionUserTypeId = $this->session->userdata('usertypeid');
            if ($sessionUserTypeId == 2) {
                $adminid = $this->session->userdata('userid');
            } else if ($sessionUserTypeId == 1) {
                $adminid = $this->input->get_post('adminid');
            } else if ($sessionUserTypeId == 4) {
                $adminid = $this->session->userdata('adminid');
            }
        }

        $singleSizeList = array();
        if ($actionType == "Edit") {
            $singleSizeList = $this->users_model->getSizeList($adminid, $actionId);
        }

        $dataheader['adminid'] = $adminid;
        $dataheader['title'] = "Size";
        $dataheader['actionType'] = $actionType;
        $dataheader['actionId'] = $actionId;
        $dataheader['singleSizeList'] = $singleSizeList;
        $dataheader['addProductMasterUrl'] = "addProductMaster";
        $this->load->view('product/AddSize', $dataheader);
    }

    public function MapProduct()
    {
        $sessionUserTypeIdIsset = $this->session->has_userdata('usertypeid');
        $adminid = "0";
        $sessionUserTypeId = "0";
        $showroomId = "0";
        if ($sessionUserTypeIdIsset == 1) {
            $sessionUserTypeId = $this->session->userdata('usertypeid');
            if ($sessionUserTypeId == 2) {
                $adminid = $this->session->userdata('userid');
            } else if ($sessionUserTypeId == 1) {
                $adminid = $this->input->get_post('adminid');
            } else if ($sessionUserTypeId == 4) {
                $adminid = $this->session->userdata('adminid');
                $showroomId = $this->session->userdata('retailerShowRoomId');
            }
        }
        $retailerShowRoomId = "3";

        $showroomArray = $this->users_model->getshowroomList($adminid, $retailerShowRoomId);
        $dataheader['showroomArray'] = $showroomArray;
        $dataheader['adminid'] = $adminid;
        $dataheader['showroomId'] = $showroomId;
        $dataheader['title'] = "MapProduct";

        $dataheader['showroomArray'] = $showroomArray;


        $this->load->view('layout/backend_header', $dataheader);
        $this->load->view('layout/backend_menu');
        $this->load->view('product/MapProduct', $dataheader);
        $this->load->view('layout/backend_footer');
    }

    public function assignMapProduct(){
        $sessionUserTypeIdIsset = $this->session->has_userdata('usertypeid');
        $adminid = "0";
        $sessionUserTypeId = "0";
        $showroomId = $this->input->get_post('showroomId');
        if ($sessionUserTypeIdIsset == 1) {
            $sessionUserTypeId = $this->session->userdata('usertypeid');
            if ($sessionUserTypeId == 2) {
                $adminid = $this->session->userdata('userid');
            } else if ($sessionUserTypeId == 1) {
                $adminid = $this->input->get_post('adminid');
            } else if ($sessionUserTypeId == 4) {
                $adminid = $this->session->userdata('adminid');
                $showroomId = $this->session->userdata('retailerShowRoomId');
            }
        }

        $productid = $this->input->get_post('productid');
        $quantity = $this->input->get_post('quantity');
        $Incquantity = $this->input->get_post('Incquantity');
        $price = $this->input->get_post('price');
        $newPrice = $this->input->get_post('newPrice');
        $submit = $this->input->get_post('submit');

        $retrievalArray = array();
        if($submit == "MapProduct"){
            $retrievalArray['productid'] = $productid;
            $retrievalArray['quantity'] = $quantity;
            $retrievalArray['Incquantity'] = $Incquantity;
            $retrievalArray['price'] = $price;
            $retrievalArray['newPrice'] = $newPrice;
            $retrievalArray['showroomId'] = $showroomId;
            $retrievalArray['adminid'] = $adminid;
            $showRoomArray = $this->users_model->assignMapProduct($retrievalArray);
        }
        redirect(base_url()."Product/MapProduct");
        
    }

    public function getContent()
    {
//        $adminid = $this->session->userdata('usertypeid');
        $sessionUserTypeIdIsset = $this->session->has_userdata('usertypeid');
        $adminid = "0";
        $sessionUserTypeId = "0";
        if ($sessionUserTypeIdIsset == 1) {
            $sessionUserTypeId = $this->session->userdata('usertypeid');
            if ($sessionUserTypeId == 2) {
                $adminid = $this->session->userdata('userid');
            } else if ($sessionUserTypeId == 1) {
                $adminid = $this->input->get_post('adminid');
            } else if ($sessionUserTypeId == 4) {
                $adminid = $this->session->userdata('adminid');
            }
        }

        $dataheader['adminid'] = $adminid;
        $type = $this->input->get('type');
        $count = $this->input->get('count');
        if ($type == 'productQyt') {
            $usertypeid = '3';
            $retailerShowRoomId = "";
            $userid = "";
            $showRoomArray = $this->users_model->getUsersList($usertypeid, $adminid, $retailerShowRoomId, $userid);
            $dataheader['showRoomArray'] = $showRoomArray;
        }

        if ($type == 'product') {
            $showroomId = $this->input->get('showroomId');
            $productId = "";
            $productListArray = $this->users_model->mappedProduct($productId, $showroomId, $adminid, $type);

            $dataheader['productListArray'] = $productListArray;
            $dataheader['showroomId'] = $showroomId;
        }
        if ($type == 'productQtyandPrice') {
            $productId = $this->input->get('productId');
            $showroomId = $this->input->get('showroomId');
            $productQytArray = $this->users_model->mappedProduct($productId, $showroomId, $adminid, $type);
            $dataheader['productQytArray'] = $productQytArray;
        }
        $dataheader['type'] = $type;
        $dataheader['count'] = $count;
        $this->load->view('product/getContent', $dataheader);

    }

    public function EditProduct()
    {
        $dataheader['title'] = "Edit Product";
        $dataheader['addProductMasterUrl'] = "addProductMaster";
        $sessionUserTypeIdIsset = $this->session->has_userdata('usertypeid');
        $adminid = "0";
        if ($sessionUserTypeIdIsset == 1) {
            $sessionUserTypeId = $this->session->userdata('usertypeid');
            if ($sessionUserTypeId == 2) {
                $adminid = $this->session->userdata('userid');
            } else if ($sessionUserTypeId == 1) {
                $adminid = $this->input->get_post('adminid');
            } else if ($sessionUserTypeId == 4) {
                $adminid = $this->session->userdata('adminid');
            }
        }

        $retailerShowRoomId = "0";
        $actionId = "0";
        $actionType = $this->input->get_post('actionType');
        $productId = $this->input->get_post('actionId');
        $productArray = $this->users_model->getProductList($adminid, $productId, $retailerShowRoomId , "0", "0", "0", null);
        $BrandArray = $this->users_model->getBrandList($adminid, $actionId);
        $SizeArray = $this->users_model->getSizeList($adminid, $actionId);
        $CategoryTypeArray = $this->users_model->getCategoryTypeList($adminid, $actionId);

        $dataheader['productArray'] = $productArray;
        $dataheader['BrandArray'] = $BrandArray;
        $dataheader['SizeArray'] = $SizeArray;
        $dataheader['CategoryTypeArray'] = $CategoryTypeArray;
        $dataheader['actionType'] = $actionType;
        $dataheader['actionId'] = $productId;
//        $dataheader['showroomArray'] = $showroomArray;
//        $this->load->view('layout/backend_header', $dataheader);
//        $this->load->view('layout/backend_menu');
        $this->load->view('product/EditProduct', $dataheader);
//        $this->load->view('layout/backend_footer');


    }

}

?>
