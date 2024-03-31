### Setting Up CodeIgniter 4 Project

Follow these steps to set up and run a CodeIgniter 4 project after cloning the repository:

1. **Cloning the Repository**: Clone the Git repository containing the CodeIgniter 4 project to your local machine:
    ```bash
    git clone [<repository-url>](https://github.com/Mainfiles4/Shiling-Market.git)
    ```

2. **Installing Composer Dependencies**: Navigate to the project directory and install Composer dependencies:
    ```bash
    cd Shiling-Market
    composer install
    ```

3. **Environment Configuration**: Create a `.env` file in the project root based on the `.env.example` file, and update the values to match your local environment:
    ```bash
    cp env.example .env
    ```

4. **Permissions**: Ensure that necessary directories such as `/writable` have appropriate permissions to allow the application to write to them.

5. **Database Setup**: Set up the database and update the `.env` file with the corresponding database credentials.

6. **Running Migrations (Optional)**: If the project includes database migrations, you can run them to create database tables:
    ```bash
    php spark migrate
    ```

7. **Serving the Application**: Serve the CodeIgniter 4 application using the built-in PHP development server or any other web server environment:
    ```bash
    php spark serve
    ```

    Alternatively, configure the project to run on your local web server environment.

Once these steps are completed, you should be able to access and interact with the CodeIgniter 4 application locally in your web browser.
