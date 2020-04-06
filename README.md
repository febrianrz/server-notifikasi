# Notifikasi

Microservice untuk notifikasi

## Authentikasi Public Request
- Untuk setiap request yang membutuhkan authentikasi, diharuskan terauthentikasi terlebih dahulu melalui SSO yang terkait.
```php
    app_id: {app_id}
    app_secret: {app_secret}
```
## Authentikasi Private Request

- Untuk endpoint yang bersifat private, menggunakan header :
```php
Authorization: Bearer ${access_token}
```
## Service yang tersedia

### Daftar Channel
* Menampilkan list channel notifikasi yang tersedia, defaultnya hanya *email, wa, web, dan telegram*.
* Method yang tesedia **GET**.
```html
[POST] http://{notification_url}/api/v1/channels
```
|Param|Type  |Null|Description|
|--|--|--|--|
| format |string  |Yes |value berisi *datatable*, *select2*|

#### Response
```json
{
    "data": [
        {
            "id": 4,
            "code": "web",
            "name": "Web",
            "is_active": true,
            "created_at": "2020-04-06 09:06:30",
            "updated_at": "2020-04-06 09:06:30"
        },
        {
            "id": 5,
            "code": "email",
            "name": "Email",
            "is_active": true,
            "created_at": "2020-04-06 09:06:30",
            "updated_at": "2020-04-06 09:06:30"
        },
        {
            "id": 6,
            "code": "tele",
            "name": "Telegram",
            "is_active": false,
            "created_at": "2020-04-06 09:06:30",
            "updated_at": "2020-04-06 09:06:30"
        },
        {
            "id": 7,
            "code": "wa",
            "name": "Whatsapp",
            "is_active": false,
            "created_at": "2020-04-06 09:06:30",
            "updated_at": "2020-04-06 09:06:30"
        }
    ],
    "links": {
        "first": "http://localhost:8000/api/v1/channels?page=1",
        "last": "http://localhost:8000/api/v1/channels?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://localhost:8000/api/v1/channels",
        "per_page": 15,
        "to": 4,
        "total": 4
    }
}
```
### CRUD Templates
* CRUD manipulasi template yang tersedia.
* Method tersedia **GET, POST, PUT, DELETE*.
```php
[POST/GET/PUT/DELETE] 
http://{notification_url}/api/v1/channels/{optional_id}
```
Column untuk POST/PUT
|Param|Type  |Null|Description|
|--|--|--|--|
| channel_id |integer  |No |ID Channelnya|
|name|string|No|Nama template|
|code|string|No|Harus unik untuk setiap templatenya|
|description|string|No|Deskripsi template|
|template|html/markdown|No|Format templatenya, untuk kata/karakter yang akan diubah oleh data, gunakan penanda kurung siku, sebagai contoh ***[name]***|
#### Response POST/PUT
```json
{
    "message": "Template [Berhasil merubah password Update] berhasil dihapus",
    "data": {
        "id": 4,
        "channel_id": 2,
        "code": "success_reset_password",
        "name": "Berhasil merubah password Update",
        "description": "Template password berhasil diubah",
        "template": "<p>Hai [name],</p> <p>Katasandi untuk <strong>[email]</strong> telah berhasil diubah.</p> <p>Terima kasih,</p>",
        "created_at": "2020-04-06 06:29:54",
        "updated_at": "2020-04-06 06:31:39"
    }
}

```
## Riwayat Notifikasi
* Menampilkan seluruh riwayat notifikasi yang tersedia.
* Method tersedia **GET**
```php
http://{notification_url}/api/v1/notifications
```
|Param|Type  |Null|Description|
|--|--|--|--|
| format |string  |Yes |value berisi *datatable*, *select2*|
#### Response
```json
{
    "data": [
        {
            "id": "854b5fa0-780f-11ea-88e9-5b796a171b68",
            "app_id": 1,
            "app": null,
            "channel_id": 5,
            "template_id": 7,
            "from": "from@from.com",
            "description": "catatan",
            "to": "febrianrz@gmail.com",
            "subject": "Title",
            "body": null,
            "data": {
                "name": "Febrian Reza",
                "email": "febrianrz@gmail.com",
                "link": "asdfadsf"
            },
            "attachment_request": [
                "https://homepages.cae.wisc.edu/~ece533/images/baboon.png"
            ],
            "attachment_storage": [
                "/var/www/html/project/rk/api/notifikasi/storage/app/public/attachment/2020-04-06/85488c50-780f-11ea-98cb-2348d816bd69.png"
            ],
            "is_sending": true,
            "is_queue": false,
            "response_text": "Email berhasil dikirim",
            "sent_at": "2020-04-06 14:17:01",
            "trying_send": 2,
            "created_at": "2020-04-06 14:04:24",
            "updated_at": "2020-04-06 14:17:01",
            "deleted_at": null
        }
    ],
    "links": {
        "first": "http://localhost:8000/api/v1/notifications?page=1",
        "last": "http://localhost:8000/api/v1/notifications?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://localhost:8000/api/v1/notifications",
        "per_page": 15,
        "to": 1,
        "total": 1
    }
}
```
## Resend Notifikasi
* Proses pengiriman ulang notifikasi

```php
[POST]
http://{notification_url}/api/v1/resend/{id}
```
|Param|Type  |Null|Description|
|--|--|--|--|
| id |uuid  |No |ID notifikasi yang akan dikirim ulang|
### Response
```json
{
    "message": "Notifikasi telah dikirim",
    "data": {
        "id": "854b5fa0-780f-11ea-88e9-5b796a171b68",
        "app_id": 1,
        "app": null,
        "channel_id": 5,
        "template_id": 7,
        "from": "from@from.com",
        "description": "catatan",
        "to": "febrianrz@gmail.com",
        "subject": "Title",
        "body": null,
        "data": {
            "name": "Febrian Reza",
            "email": "febrianrz@gmail.com",
            "link": "asdfadsf"
        },
        "attachment_request": [
            "https://homepages.cae.wisc.edu/~ece533/images/baboon.png"
        ],
        "attachment_storage": [
            "/var/www/html/project/rk/api/notifikasi/storage/app/public/attachment/2020-04-06/85488c50-780f-11ea-98cb-2348d816bd69.png"
        ],
        "is_sending": true,
        "is_queue": false,
        "response_text": "Email berhasil dikirim",
        "sent_at": "2020-04-06 14:17:01",
        "trying_send": 2,
        "created_at": "2020-04-06 14:04:24",
        "updated_at": "2020-04-06 14:17:01",
        "deleted_at": null,
        "channel": {
            "id": 5,
            "code": "email",
            "name": "Email",
            "is_active": true,
            "created_at": "2020-04-06 09:06:30",
            "updated_at": "2020-04-06 09:06:30"
        },
        "template": {
            "id": 7,
            "channel_id": 5,
            "code": "simple_reset_password",
            "name": "Reset Password",
            "description": "Template untuk merubah katasandi",
            "template": "<p>Hai [name],</p> <p>Sistem kami mendeteksi permintaan perubahan kata sandi untuk email <strong>[email]</strong>.</p> <p>Silahkan klik tombol dibawah ini untuk melanjutkan permintaan Anda. <a href=\"http://login.com\">Login</a> <br><br>Terima kasih,</p>",
            "created_at": "2020-04-06 09:07:10",
            "updated_at": "2020-04-06 09:07:10"
        }
    }
}
```
## Kirim / Buat Notifikasi
* Endpoint ini diakses secara public yang dapat diakses oleh server yang terdaftar untuk melakukan pengiriman notifikasi.
* Request merupakan format **application/json** content.
```php
[POST]
http://{notification_url}/api/v1/send
```
|Param|Type  |Null|Description|
|--|--|--|--|
| user_id |integer  |Yes ||
| to |string  |No |Tujuan pengiriman, dapat berupa email/wa number/telegram number|
| template |string  |No |**code** template|
| queue |boolean  |Yes |default false, Dikirim langsung atau mengikuti jadwal server|
| title |string  |No |Title notifikasi digunakan sebagai subject untuk pengiriman email|
| from |string  |No |from pengiriman|
| notes |string  |No |Catatan tambahan, notes ini tidak akan dikirimkan ke tujuan pengiriman|
| data |object  |No |Template yang akan dimanipulasi|
| attachment |array  |Yes |attachment harus berupa Link file yang akan di attach ke tujuan|
#### Sample Request
```
[
  {
    "user_id":null,
    "to":"febrianrz@gmail.com",
    "template":"simple_reset_password",
    "queue":false,
    "title":"Title",
    "from":"from@from.com",
    "notes":"catatan",
    "data":{
      "name":"Febrian Reza",
      "email":"febrianrz@gmail.com",
      "link":"asdfadsf"
    },
    "attachment":[
      "https://homepages.cae.wisc.edu/~ece533/images/baboon.png"
    ]
  }]
```
#### Response
```json
{
    "message": "Ok"
}
```
## License

Lisensi untuk microservice ini berada pada CV. Alter Indonesia (https://alterindonesia.com) atau email di febrianrz@alterindonesia.com.
