# Order Processing

---

## Overview

The project has a simple DB schema for ordering process follows a modular architecture for order module with separation of concerns to ensure maintainability and flexibility.

## Requirements
- Docker client
---
### tech stack
- Composer
- PHP 8.3 
- nginx
- MariaDB
- redis
- adminer
---

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/mahmmoudmohammed/OrderProcessing.git
    ```

2. Navigate to the project directory:
    ```bash
    cd EAV
    ```

3. Thanks for `make install` which will install the required environment:
    ```bash
    make install
    ```
4. wait until the container running and make sure DB is up then,
run `make up` to Start configure, seed, DB, and run test cases:
    ```bash
    make up
    ```
5. Access the application at:
    ```
    http://localhost:8090/
    ```

---

## API Documentation
- Open postman and then try to import [orderProcessing.postman_collection.json](orderProcessing.postman_collection.json)
  collection file
