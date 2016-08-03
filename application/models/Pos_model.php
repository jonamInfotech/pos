<?php

/**
 * Created by IntelliJ IDEA.
 * User: jonam
 * Date: 24/7/16
 * Time: 7:52 AM
 */
class Pos_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function selectQueryList($tablename,$fieldname,$condition){

        $returnValue = array();
	$fieldnames="";

	for($i=0;$i<count($fieldname);$i++)
	{
		$fieldnames.="t.".$fieldname[$i].",";
	}
	$fieldnames=trim($fieldnames,",");
	

        $sql = "SELECT ".$fieldnames." FROM ".$tablename." t WHERE ".$condition;
        $executeQuery = $this->db->query($sql);
	$returnValue = $executeQuery->result_array(); 


        return $returnValue;
    }

    public function productDetails($productId){

        
	$this->db->select('productid,productname,productrate,availablequantity,barcode');
	$this->db->where('productid', $productId);
	$q = $this->db->get('tbl_product');
	$returnValue = $q->result_array();

        return $returnValue;
    }

	public function insertSellDetails($insertValue)
	{
	
		if($insertValue['Customer']!="" || $insertValue['mobile']!="")
		{
			$this->db->select('id');
			$this->db->where('mobileno', $insertValue['mobile']);
			$q = $this->db->get('tbl_customer');
			$returnValue = $q->result_array();
	
			if(count($returnValue)==0)
			{
				$data = array(
				'name'=>$insertValue['Customer'],
				'mobileno'=>$insertValue['mobile']
				);

				$this->db->insert('tbl_customer',$data);
				$customerId = $this->db->insert_id();
			
			}
			else
			{
				$customerId=$returnValue[0]['id'];
			}
		}
		else
		{
			$customerId=0;		
		}

		$data = array(
		'discount'=>$insertValue['totdiscount'],
		'roundoff'=>$insertValue['roundoff'],
		'Total'=>$insertValue['FinalTotal'],
		'customerId'=>$customerId,
		'date'=>date("Y-m-d H:i:s")
		);

		$this->db->insert('tbl_customerreceipt',$data);
		$receiptId = $this->db->insert_id();

		
		for($i=0;$i<count($insertValue['count']);$i++)
		{
			$customerreceiptproduct = array(
			'receiptId'=>$receiptId,
			'productId'=>$insertValue['product'][$i],
			'price'=>$insertValue['price'][$i],
			'qty'=>$insertValue['qty'][$i],
			'discount'=>$insertValue['disc'][$i]
			);
			
			$this->db->insert('tbl_customerreceiptproduct',$customerreceiptproduct);
		}

		
	}

    public function receiptDetails($receiptId){

        
	$this->db->select('*');
	$this->db->where('id', $receiptId);
	$q = $this->db->get('tbl_customerreceipt');
	$returnValue['customerreceipt'] = $q->result_array();


	$this->db->select('*');
	$this->db->where('receiptId', $receiptId);
	$q = $this->db->get('tbl_customerreceiptproduct');
	$returnValue['productDetails'] = $q->result_array();


	if(count($returnValue['customerreceipt'])>0)
	{
		$this->db->select('name,mobileno');
		$this->db->where('id', $returnValue['customerreceipt'][0]['customerId']);
		$q = $this->db->get('tbl_customer');
		$returnValue['customer'] = $q->result_array();
	}

	if(count($returnValue['productDetails'])>0)
	{
		$this->db->select('productname,barcode');
		$this->db->where('`productid` in ', '(select `productId` from `tbl_customerreceiptproduct` where `receiptId` = '.$receiptId.')', false);
		$q = $this->db->get('tbl_product');
		$returnValue['product'] = $q->result_array();
	}

        return $returnValue;
    }
	
}

?>