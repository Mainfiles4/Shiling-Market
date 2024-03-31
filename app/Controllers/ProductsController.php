<?php

namespace App\Controllers;

use App\Models\ProductsModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class ProductsController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        // Fetch products from the database
        $productModel = new ProductsModel();
        $products = $productModel->findAll();

        return $this->respond($products);
    }

    public function create()
{
    try {
        // Debugging: Log request data
        $productData = $this->request->getJSON();
        
        $productModel = new ProductsModel();
        // Placeholder response for testing
        if ($productModel->insert($productData)) {
            return $this->respondCreated(['message' => 'Product created successfully.', 'data' => $productData]);
        } else {
            return $this->failServerError(['message' => 'Failed to create product.', 'errors' => $productModel->errors()]);
        }

    } catch (\Exception $e) {
        // Debugging: Log any exceptions
        log_message('error', 'Error in create method: ' . $e->getMessage());
        return $this->failServerError('An unexpected error occurred.');
    }
}

public function edit($id)
{
    
}

public function delete($id)
{
    
}
}
