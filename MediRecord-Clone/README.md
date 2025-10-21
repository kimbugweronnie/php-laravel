# MediRecords API

## Overview
The **MediRecords API** is a secure and efficient RESTful API built with Laravel. It provides healthcare professionals and organizations access to various medical records, enabling seamless data retrieval, patient management, and record updates. The API ensures data security, compliance, and reliability.

## Features
- **Patient Management**: Create, update, and retrieve patient records.
- **Medical History**: Access detailed patient history, including diagnoses and treatments.
- **Doctor & Staff Access**: Secure authentication and role-based access control.
- **Appointments**: Schedule, update, and manage patient appointments.
- **Prescriptions**: Retrieve and manage prescribed medications.
- **Secure Data Handling**: Follows best practices for encryption and data security.

## Installation

1. **Clone the repository**
   ```sh
   git clone https://github.com/your-repo/MediRecords.git
   cd MediRecords
   ```

2. **Install dependencies**
   ```sh
   composer install
   ```

3. **Set up environment variables**
   Copy the `.env.example` file and update the database credentials:
   ```sh
   cp .env.example .env
   ```

4. **Generate application key**
   ```sh
   php artisan key:generate
   ```

5. **Run database migrations**
   ```sh
   php artisan migrate --seed
   ```

6. **Start the server**
   ```sh
   php artisan serve
   ```



## Security & Authentication
This API uses **JWT Authentication** for secure access. Users must authenticate to access protected endpoints.

To obtain a token, send login credentials to `v1/api/login`. Use the returned token in the `Authorization` header for authenticated requests:
```
Authorization: Bearer {token}
```

## License
This project is licensed under the MIT License.

## Contact
For any inquiries or contributions, reach out at [kimbugweronnie@gmail.com].


