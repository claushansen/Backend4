<?php 

class Product{
	private $_name;
	private $_price;
	private $_features;
	static $instances=array();
	public function __construct($name,$price){
		$this->_name = $name;
		$this->_price = $price;
		$this->_features = array();
		Product::$instances[] = $this;
	}
	
	public function setName($name){
		$this->_name = $name;
	}
	
	public function getName(){
		return $this->_name ;
	}
	
	public function setPrice($price){
		$this->_price = $price;
	}
	
	public function getPrice(){
		return $this->_price;
	}	
	
	public function addFeature(Feature $feature){
		array_push($this->_features, $feature);
	}
	
	public function getFeatures(){
		return $this->_features;
	}

	
}

class Feature{
	private $_name;
	private $_value;
	
	public function __construct($name,$value){
		$this->_name = $name;
		$this->_value = $value;
	}
	
	public function getName(){
	return $this->_name;	
	}
	
	public function getValue(){
	return $this->_value;	
	}
	
}

class Order{
	private $_orderid;
	private $_products;
	private $_customer;
	static $instances=array();
	public function __construct($customer){
		$this->_customer = $customer;
		$this->_orderid = rand();
		$this->_products = array();
		Order::$instances[] = $this;	
	}
	public function addProduct(Product $product){
		array_push($this->_products, $product);
	}
	
	public function getProducts(){
		return $this->_products;
	}
	public function getId(){
		return $this->_orderid;
	}
	
	public function getTotal(){
		$total = 0;
		foreach($this->getProducts() as $product){
		$total += $product->getPrice();	
		}
		return $total;
	}
	
	public function getCustomer(){
	return $this->_customer;	
	}
	
}

class User{
	private $_username;
	private $_password;
	public function __construct($username,$password){
		$this->_username = $username;
		$this->_password = $password;
	} 
	public function getUsername(){
		return $this->_username;		
	}
	
	
}

class Customer extends User{
	private $_firstname;
	private $_lastname;
	private $_address;
	private $_zip;
	private $_city;
	
	public function __construct($username,$password,$firstname,$lastname,$address,$zip,$city){
		parent::__construct($username,$password);
		$this->_firstname = $firstname;
		$this->_lastname = $lastname;
		$this->_address = $address;
		$this->_zip = $zip;
		$this->_city = $city;
	}
	
	public function getName(){
	return 	$this->_firstname. ' '.$this->_lastname;
	}
	
	public function getAddress(){
	return 	$this->_address. ' , '.$this->_zip.' , '.$this->_city ;
	}
	
	public function getOrders(){
		$myorders = array();
		foreach(Order::$instances as $order){
			if($order->getCustomer() === $this){
			$myorders[] = $order;	
			}
			
		}
		return $myorders;
	}
}


//testing
//creating products
$prod1 = new Product('computer mouse',199);
$prod1->addFeature(new Feature('color','Silver'));
$prod1->addFeature(new Feature('Powersuply','Battery'));

$prod2 = new Product('socks',7);
$prod2->addFeature(new Feature('color','Green'));
$prod2->addFeature(new Feature('Size','XXL'));

$prod3 = new Product('icecream',22);
$prod3->addFeature(new Feature('Size','Large'));
$prod3->addFeature(new Feature('Flavor','Strawberry'));
$prod3->addFeature(new Feature('Avesomeness','Totally'));

listproducts();

//creating customers
$customer1 = new Customer('clauskludder','1234','Claus', 'Hansen','Stationsvej 31','4261','Dalmose');
$kurt = new Customer('kurtknald','123426','Kurt', 'Knald','Fyrværkerivej 31','4261','Bangstrup');
//output customers
//echo '$customer1 er: '.$customer1->getName().'<br>';
//echo '$customer1s adresser er: '.$customer1->getAddress().'<br>';
//echo '$kurt er: '.$kurt->getName().'<br>';
//echo '$kurts adresser er: '.$kurt->getAddress().'<br>';

//creating new orders
$order1 = new Order($customer1);
$order1->addProduct($prod1);
$order1->addProduct($prod2);
$order1->addProduct($prod3);

$order2 = new Order($kurt);
$order2->addProduct($prod2);
$order2->addProduct($prod2);
$order2->addProduct($prod1);
$order2->addProduct($prod1);
$order2->addProduct($prod1);
//echo '$customer1 now has '.count($customer1->getOrders()).' orders<br>';
//echo 'total on order1 is:'.$order1->getTotal().'<br>';
//echo '$kurt now has '.count($kurt->getOrders()).' orders<br>';
listorders();

//this function lists all orders
function listorders(){
	echo 'Total orders:'. count(Order::$instances);
	
	if(count(Order::$instances)){
	foreach(Order::$instances as $order){
	echo '<h2>Orderid:'.$order->getId().'</h2>';
	echo '<div class="customer-info">';
	echo '<h3>Customer Info</h3>';
	echo '<p>'.$order->getCustomer()->getName().'</p>';
	echo '<p>'.$order->getCustomer()->getAddress().'</p>';
	echo '</div>';
	echo '<table width="600px" class="producttable">';
	echo '<thead><th>Product name</th><th>Features</th><th>price</th></thead>';
	foreach($order->getProducts() as $product){
		
		$featurestring ='';
		foreach($product->getFeatures() as $feature){
			$featurestring .= $feature->getName().':'.$feature->getValue().', ';
			}
		echo '<tr><td align="center"><strong>'.$product->getName().'</strong></td><td align="center">'.$featurestring.'</td><td align="center"> $'.$product->getPrice().'</td></tr>';
		echo '';
		echo '';
		
	}
	echo '</tr><td></td><td align="center"><strong>Total</strong></td><td align="center"><strong>$'.$order->getTotal().'</strong></td></tr>';
	echo '</table>';	
	}//end foreach instances
	}//end if instances
}

//this function lists all products
function listproducts(){
echo 'antal produkter:'. count(Product::$instances);

foreach(Product::$instances as $product){
// output of product
echo '<h2>'.$product->getName().' $'.$product->getPrice().'</h2>';
if($product->getFeatures()){
echo '<h3>Features</h3>';
echo '<ul>';
foreach($product->getFeatures() as $feature){
echo '<li>'.$feature->getName().':'.$feature->getValue().'</li>';	
}//end foreach features
echo '</ul>';
}//endif features
echo '<hr>';
}//end foreach instances
}

?>