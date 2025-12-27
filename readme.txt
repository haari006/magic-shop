phpMyAdmin sql statement:

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

Stripe checkout:
- Set STRIPE_SECRET_KEY in your environment (use a Stripe test key for local use).
- Open index.php through a PHP server so create_checkout_session.php can run.

Orders table:
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stripe_event_id VARCHAR(255) UNIQUE NOT NULL,
    stripe_session_id VARCHAR(255) NOT NULL,
    client_reference_id VARCHAR(255),
    username VARCHAR(50),
    customer_email VARCHAR(255),
    product_id VARCHAR(50),
    product_name VARCHAR(255),
    amount_total INT NOT NULL,
    currency VARCHAR(10) NOT NULL,
    payment_status VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

Stripe webhook:
- Set STRIPE_WEBHOOK_SECRET in your environment.
- Configure the Stripe webhook endpoint to POST to /stripe_webhook.php.

Dev script (PowerShell):
- Run start-dev.ps1 to start XAMPP, create tables, set Stripe env vars, and launch PHP.

InfinityFree:
- See INFINITYFREE_SETUP.md.


