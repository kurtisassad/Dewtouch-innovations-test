<?php require('SimpleXLSX.php');
	class MigrationController extends AppController{

		public function q1(){

			//load relevent tables
			$models = array('Member','Transaction','TransactionItem');
			foreach($models as $model){
				$this->loadModel($model);
				 //stop cakephp from automatically updating 'created' field because we want it to be custom
				$this->request->data[$model]['created'] = false;
			}

			if ($this->request->is('post')) {

				$file = $this->request->data['FileUpload']['file']['tmp_name'];
				// if(False){
				if ( $xlsx = SimpleXLSX::parse($file) ) {
					$data = $xlsx->rows();


					//vtc = variable to column maps column variable to column number
					//makes it robust so that the columns in xlsx file don't need to be in order.
					$vtc = array_flip($data[0]);

					$memberData = array();
					$transactionData = array();
					$transactionItemData = array();
					// debug($vtc);exit;
					//start at 1 to ignore column variables
					for($i = 1; $i < sizeof($data); $i++){

						$name = $data[$i][$vtc['Member Name']];
						$company = $data[$i][$vtc['Member Company']];
						$date = $data[$i][$vtc['Date']];
						$refNo = $data[$i][$vtc['Ref No.']];
						$payType = $data[$i][$vtc['Member Pay Type']];
						$payBy = $data[$i][$vtc['Payment By']];
						$batchNo = $data[$i][$vtc['Batch No']];
						$receiptNo = $data[$i][$vtc['Receipt No']];
						$checkNo = $data[$i][$vtc['Cheque No']];
						$payDesc = $data[$i][$vtc['Payment Description']];
						$renewalYear = $data[$i][$vtc['Renewal Year']];
						$subtotal = $data[$i][$vtc['subtotal']];
						$totaltax = $data[$i][$vtc['totaltax']];
						$total = $data[$i][$vtc['total']];

						//preg_match uses regex, \w+ dentoes 1 or more character \d+ denotes 1 or more digit
						$memberNo = array();
						preg_match('/(\w+) (\d+)/',$data[$i][$vtc['Member No']],$memberNo);

						$type = $memberNo[1];
						$no = $memberNo[2];

						$brokenDate = array();
						preg_match('/(\d+)-(\d+)-(\d+)/',$date,$brokenDate);
						$year = $brokenDate[1];
						$month = $brokenDate[2];
						$day = $brokenDate[3];

						//modify members table
						$memberRowData = array('type' => $type, 'no' => $no, 'name' => $name ,'company' => $company);
						array_push($memberData,$memberRowData);

						//modify transactions table
						//Im not sure how to get the 'remarks' field
						$transactionRowData = array('member_id' => $no, 'member_name' => $name, 'member_paytype' => $payType,
					  'member_company' => $company,'date' => $date, 'year' => $year,'month' => $month,'ref_no' => $refNo,'receipt_no' =>$receiptNo,
						'payment_method'=>$payBy,'batch_no'=>$batchNo,'cheque_no'=>$checkNo,'payment_type'=>$payType,'renewal_year'=>$renewalYear,
					 	'subtotal'=>$subtotal,'tax'=>$totaltax,'total'=>$total);
						array_push($transactionData,$transactionRowData);

						//modify transaction items table

						$transactionRowData = array('member_id' => $no, 'member_name' => $name, 'member_paytype' => $payType,
					  'member_company' => $company,'date' => $date, 'year' => $year,'month' => $month,'ref_no' => $refNo,'receipt_no' =>$receiptNo,
						'payment_method'=>$payBy,'batch_no'=>$batchNo,'cheque_no'=>$checkNo,'payment_type'=>$payType,'renewal_year'=>$renewalYear,
					 	'subtotal'=>$subtotal,'tax'=>$totaltax,'total'=>$total);
						array_push($transactionData,$transactionRowData);


						//not sure how to do the transaction items
						// $transactionItemData = array('transaction_id' => $i-1, 'quantity'=>);
						// array_push($transactionData,$transactionRowData);

					}
					debug($transactionData);
					$this->Member->saveMany($memberData);
					$this->Member->saveMany($transactionData);
					// $this->Member->saveMany($transactionItemData);
					$this->setFlash("The data was successfully uploaded.");
				} else {
					$this->setFlash('The file you tried to upload was not a xlsx file.');
				}

				return $this->redirect([]);//redirect to same page to remove post data
			//
			}
		}

		public function q1_instruction(){

			$this->setFlash('Question: Migration of data to multiple DB table');



// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}

	}
