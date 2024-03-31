## Routes
Index Route: Both GET and POST requests to the root URL (/) and /api/v1 will be handled by the ApiControllers::index method. This route is likely used for general API access and functionality.

User Registration and Login Routes:

POST /api/v1/auth-register: Used for user registration.
POST /api/v1/auth-login: Used for user login.
Products Routes:

GET /api/v1/products: Retrieves a list of products.
POST /api/v1/products: Creates a new product.
Buying Products Route:

POST /api/v1/products/buy/{productId}: Allows users to purchase a product by specifying the product ID. Handled by the AuthController::buyProduct method.
Buy Shilling Route:

POST /api/v1/buy-shilling: Likely used for purchasing virtual currency or credits (shillings).
User Transaction History Route:

GET /api/v1/transactions/{userId}: Retrieves the transaction history for a specific user. The {userId} parameter in the URL specifies the user ID.

## Example Bodies 

Here are examples for the various POST methods described:

1. **Adding Products**:
   - **Route**: (POST) http://[::1]/api/v1/product
   - **Use Case**: For adding products
   - **Request Body**:
     ```json
     {
         "user_id": 1,
         "name": "Samsung A20s",
         "description": "kajsdkjh jasdjkasjdb ajsdkjasnd",
         "price": 15000.00,
         "quantity": 2,
         "category": "Electronics",
         "image": "image.jpg"
     }
     ```

2. **User Registration**:
   - **Route**: (POST) http://[::1]/api/v1/auth-register
   - **Use Case**: For user registration
   - **Request Body**:
     ```json
     {
         "username": "admin",
         "email": "admin@example.com",
         "password": "password123",
         "password_confirm": "password123"
     }
     ```

3. **Product Purchase**:
   - **Route**: (POST) http://[::1]/api/v1/products/buy/{productId}
   - **Use Case**: For buying a product (replace {productId} with the actual product ID)
   - **Request Body**:
     ```json
     {
         "buyer_id": "int buyer id or the current logged user",
         "quantity": "amount to buy"
     }
     ```

4. **User Login**:
   - **Route**: (POST) http://[::1]/api/v1/auth-login
   - **Use Case**: For user login
   - **Request Body**:
     ```json
     {
         "email": "admin@example.com",
         "password": "password123"
     }
     ```

5. **Buying Shillings**:
   - **Route**: (POST) http://[::1]/api/v1/buy-shiling
   - **Use Case**: To buy from the central bank
   - **Request Body**:
     ```json
     {
         "buyer_id": "current user id",
         "amount": "the shilling package amount (i.e if there are three packages the package amount)"
     }
     ```

These examples provide the necessary information for frontend developers to make POST requests to the respective endpoints in our API.