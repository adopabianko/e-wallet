<p align="center">
<a href="https://laravel.com"><img src="https://img.shields.io/badge/made%20with-Laravel-red"></a>
<img src="https://img.shields.io/badge/version-1.0.0-blueviolet" alt="Version 1.0.0">
</p>


# Installation

This project is run using Laravel Sail which is based on docker container.

### Step 1

Clone this project:
```bash
$ git clone https://github.com/adopabianko/e-wallet
```

### Step 2

Copy the file .env.example to .env

```bash
$ cp -R .env.example .env
```

### Step 3

Run laravel sail

```bash
$ ./vendor/bin/sail up -d
```

### Step 4

Run database migration

```bash
$ ./vendor/bin/sail artisan migrate
```

Accessing a Url via web browser http://localhost:8585.



# Testing

Run the following command to run a test scenario:

```bash
./vendor/bin/sail artisan test
```

## Scenario Tests

<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Scenario Tests</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1</td>
      <td>user can access register form</td>
      <td>Passed</td>
    </tr>
    <tr>
      <td>2</td>
      <td>user can register</td>
      <td>Passed</td>
    </tr>
    <tr>
      <td>3</td>
      <td>user can access login form</td>
      <td>Passed</td>
    </tr>
    <tr>
      <td>4</td>
      <td>user can login</td>
      <td>Passed</td>
    </tr>
    <tr>
      <td>5</td>
      <td>user can topup balance</td>
      <td>Passed</td>
    </tr>
    <tr>
      <td>6</td>
      <td>user can access page withdraw</td>
      <td>Passed</td>
    </tr>
    <tr>
      <td>7</td>
      <td>user can withdraw</td>
      <td>Passed</td>
    </tr>
    <tr>
      <td>8</td>
      <td>user can access page transfer</td>
      <td>Passed</td>
    </tr>
    <tr>
      <td>9</td>
      <td>user can transfer</td>
      <td>Passed</td>
    </tr>
  </tbody>
</table>


<p align="center">
  <a href="#"><img alt="flip" src="https://user-images.githubusercontent.com/8348927/103419767-0c305000-4bc7-11eb-88fd-bb2a30267a8f.png" width="500"/></a>
</p>


# Topup API Integration
URL : http://localhost:8585/api/transaction/topup
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Parameter</th>
            <th>Type</th>
            <th>Mandatory</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Phone Number</td>
            <td>String</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Bank Code</td>
            <td>String</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Amount</td>
            <td>Numeric</td>
            <td>Yes</td>
        </tr>
    </tbody>
</table>


Request : 

```bash
curl --location --request POST 'http://localhost:8585/api/transaction/topup' \
--header 'Content-Type: application/json' \
--data-raw '{
    "phone_number": "087874083220",
    "bank_code": "bni",
    "amount": 300000
}'
```

Response : 

```bash
{
    "code": 200,
    "message": "Topup Success"
}
```



# Feature

- Register
- Login
- Topup
- Withdraw
- Transfer
- Report Mutasi