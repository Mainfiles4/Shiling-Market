<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProductsModel;
use App\Models\Transactions;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    use ResponseTrait;

    public function register()
{
    // Validate the form data (removed from here)
    
    // Hash the password
    $password = $this->request->getVar('password');
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $rules = [
        'username' => 'required|min_length[3]|max_length[30]|is_unique[users.username]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]|max_length[255]',
        'password_confirm' => 'required|matches[password]'
    ];

    if (!$this->validate($rules)) {
        return $this->failValidationErrors($this->validator->getErrors());
    }
    
    // Create a new user
    $userModel = new UserModel();
    $current_time = date('Y-m-d H:i:s');
    $userData = [
        'username' => $this->request->getVar('username'),
        'email' => $this->request->getVar('email'),
        'password' => $hashedPassword,
        'password_confirm' => $hashedPassword,  // Add this line to include password_confirm
        'created_at' => $current_time,
        'updated_at' => $current_time
    ];

    // Save the user data
    if (!$userModel->save($userData)) {
        return $this->failServerError('Failed to save user.');
    }

    return $this->respondCreated(['message' => 'User registered successfully.']);
}


    public function login()
    {
        // Validate the form data
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        // Check if the user exists
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Invalid email or password.');
        }

        return $this->respond(['message' => 'Login successful.', 'user' => $user]);
    }

    public function logout()
    {
        return $this->respond(['message' => 'Logout successful.']);
    }

    public function buyProduct($productId)
{
    try {
        // Retrieve product information from the database
        $productModel = new ProductsModel();
        $product = $productModel->find($productId);

        if (!$product) {
            return $this->failNotFound('Product not found.');
        }

        // Retrieve buyer ID and quantity from the request
        $buyerId = $this->request->getVar('buyer_id');
        $quantity = $this->request->getVar('quantity');

        // Ensure the quantity is valid (greater than 0)
        if ($quantity <= 0) {
            return $this->failValidationError('Invalid quantity. Quantity must be greater than 0.');
        }

        // If buyer ID is not provided or invalid, return an error response
        if (!$buyerId) {
            return $this->failUnauthorized('Buyer ID is missing or invalid.');
        }

        $sellerId = $product['user_id']; // Assuming user_id is the foreign key to the seller in the products table
        $pricePerUnit = $product['price']; // Assuming price is the amount per unit

        // Calculate the total amount
        $totalAmount = $pricePerUnit * $quantity;

        // Load buyer and seller models
        $buyerModel = new UserModel();
        $sellerModel = new UserModel();

        // Retrieve buyer and seller data for update
        $buyer = $buyerModel->find($buyerId);
        $seller = $sellerModel->find($sellerId);

        // If buyer or seller is not found, return an error response
        if (!$buyer || !$seller) {
            return $this->failNotFound('Buyer or seller not found.');
        }

        // Check if buyer's balance is sufficient
        if ($buyer['balance'] < $totalAmount) {
            return $this->fail('Insufficient balance.');
        }

        // Update balances
        $buyer['balance'] -= $totalAmount;
        $seller['balance'] += $totalAmount;

        if ($product['quantity'] >= 0 && !($product['quantity'] - $quantity < 0)){
        // Update user balances and product quantity
        $product['quantity'] -= $quantity;
        
        if (!$buyerModel->updateBalance($buyerId, $buyer['balance']) || 
            !$sellerModel->updateBalance($sellerId, $seller['balance']) ||
            !$productModel->update($productId, ['quantity' => $product['quantity']])) {
            return $this->failServerError('Failed to update user balances or product quantity.');
        }
    }else {
        if ($product['quantity'] <= 0) {
            $productModel->delete($productId);
        }
        return $this->failServerError('Not enough products in store');
    }
        $transactonModel = new Transactions();
        $current_time = date('Y-m-d H:i:s');
        $transactionData = [
            'buyer_id' => $buyerId,
            'seller_id' => $sellerId,
            'amount' => $totalAmount, 
            'currency' => "SHLING", 
            'quantity' => $quantity,
            'created_at' => $current_time,
            'updated_at' => $current_time
        ];
        $transactonModel->save($transactionData);
        return $this->respondCreated(['message' => 'Product bought successfully.', 'transactonModel' => $transactonModel]);
    } catch (\Throwable $th) {
        return $this->failServerError('Failed to buy the product: ' . $th->getMessage());
    }
}

public function  transactionHistory($userId){

    $transactionsModel = new Transactions();
    $transactions = $transactionsModel->where('buyer_id', $userId)->findAll();
    return $this->respond($transactions);
    
}

public function buyShiling(){
    $userModel = new UserModel();
    $curl = curl_init();

    $min = 1000000000000000; // Minimum value
    $max = 9999999999999999; // Maximum value
    $random_number = random_int($min, $max);
    $buyerID = $this->request->getVar('buyer_id');
    $currentUser = $userModel->find($buyerID);
    $amount = $this->request->getVar('amount');
    $email = $currentUser['email'];
    $username = $currentUser['username'];
    $password = $currentUser['password'];

    // Constructing the JSON data separately for better readability
    $jsonData = array(
        "amount" => strval($amount),
        "currency" => "ETB",
        "email" => $email, // Enclosed in double quotes
        "username" => $username, // Enclosed in double quotes
        "tx_ref" => strval($random_number), // Converting to string
        "callback_url" => "https://webhook.site/077164d6-29cb-40df-ba29-8a00e59a7e60",
        "return_url" => "https://www.google.com/success", // Typo: "sucess" to "success"
        "customization" => array(
            "title" => "For Shiling Coin",
            "description" => "For the user " . $username // Variable interpolation
        )
    );

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.chapa.co/v1/transaction/initialize',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($jsonData), // Encode JSON data
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer CHASECK_TEST-xUFqs9sbSj7pU0eqxZSyFrl7Qsj1AuTb',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $this->respond($response);
}


}
