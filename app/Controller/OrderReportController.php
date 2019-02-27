<?php
	class OrderReportController extends AppController{

		public function index(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>1));
			// debug($orders);exit;

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>1));

			$this->loadModel('Part');
			$parts = $this->Part->find('all',array('conditions'=>array('Part.valid'=>1),'recursive'=>1,'fields' => array('Part.name','Part.id')));

			//The solution would probably look cleaner using the database to do the heavy lifting with joins,
			//but the scope of the question only specified PHP, so I tried to stick with array manipulations.

			// we can get from order -> ingredient by order -> item -> part -> ingredient
			$orderToItem = array();
			foreach($orders as $order){
				$name = $order['Order']['name'];
				if(!array_key_exists($name,$orderToItem)){
					$orderToItem[$name] = array();
				}
				foreach($order['OrderDetail'] as $detail){
					array_push($orderToItem[$name],array('item_id' => $detail['item_id'], 'quantity' => $detail['quantity']));
				}
			}

			$itemToPart = array();
			foreach($portions as $portion){
				$id = $portion['Portion']['id'];
				if(!array_key_exists($id,$itemToPart)){
					$itemToPart[$id] = array();
				}
				foreach($portion['PortionDetail'] as $detail){
					array_push($itemToPart[$id],array('part_id' => $detail['part_id'], 'value' => $detail['value']));
				}
			}

			$partToIngredient = array();
			foreach($parts as $part){
				$partToIngredient[$part['Part']['id']] = $part['Part']['name'];
			}


			//we now need to perform look ups to get from order to ingredients by order -> item -> part -> ingredient
			$order_reports = array();
			foreach($orderToItem as $key => $order ){
				$order_reports[$key] = array();
				foreach($order as $item){
					foreach($itemToPart[$item['item_id']] as $part){
						$ingredientName = $partToIngredient[$part['part_id']];
						$order_reports[$key][$ingredientName] = $part['value']*$item['quantity'];
					}
				}
			}
			// debug($order_reports);exit;


			// To Do - write your own array in this format
			// $order_reports = array('Order 1' => array(
			// 							'Ingredient A' => 1,
			// 							'Ingredient B' => 12,
			// 							'Ingredient C' => 3,
			// 							'Ingredient G' => 5,
			// 							'Ingredient H' => 24,
			// 							'Ingredient J' => 22,
			// 							'Ingredient F' => 9,
			// 						),
			// 					  'Order 2' => array(
			// 					  		'Ingredient A' => 13,
			// 					  		'Ingredient B' => 2,
			// 					  		'Ingredient G' => 14,
			// 					  		'Ingredient I' => 2,
			// 					  		'Ingredient D' => 6,
			// 					  	),
			// 					);
			//
			// // ...

			$this->set('order_reports',$order_reports);

			$this->set('title',__('Orders Report'));
		}

		public function Question(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			// debug($orders);exit;

			$this->set('orders',$orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));

			// debug($portions);exit;

			$this->set('portions',$portions);

			$this->set('title',__('Question - Orders Report'));
		}

	}
