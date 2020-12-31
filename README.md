<p align="center">
<a href="https://laravel.com"><img src="https://img.shields.io/badge/made%20with-Laravel-red"></a>
<img src="https://img.shields.io/badge/version-1.0.0-blueviolet" alt="Version 1.0.0">
</p>


# Instalasi

Project ini dijalankan menggunakan <a href="https://laravel.com/docs/8.x/sail">Laravel Sail</a> yang berbasis docker container.

### Proses Instalasi

Jalankan perintah berikut di command line:

```bash
$ ./vendor/bin/sail up -d
```

```bash
$ ./vendor/bin/sail artisan migrate
```

Akses Url http://localhost:8585.

# Testing

Jalankan perintah berikut untuk menjalankan skenario test:

```bash
./vendor/bin/sail artisan test
```

## Skenario Test

<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Scenario Test</th>
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


# Integrasi API Topup
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

Example : 

curl --location --request POST 'http://localhost:8585/api/transaction/topup' \
--header 'Content-Type: application/json' \
--data-raw '{
    "phone_number": "087874083220",
    "bank_code": "bni",
    "amount": 300000
}'

# Fitur
- Register
- Login
- Topup
- Withdraw
- Transfer
- Report Mutasi