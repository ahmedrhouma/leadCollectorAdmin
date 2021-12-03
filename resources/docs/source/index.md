---
title: API Reference

language_tabs:
- bash
- javascript
- php
- python

includes:

search: true

toc_footers:


---
<!-- START_INFO -->
# Introduction

Leads collector is An application that automates the collection, centralization and consolidation of contacts from different channels. Our solution put at your disposal3 sources of prospecting :
-   Social media
-   Landing pages
-   Live chat (Bots)

[Get Postman Collection](http://127.0.0.1:8000/docs/collection.json)

#Requests

Communicate with the API by making an HTTP request at the correct endpoint. The chosen method determines the action taken.

Method | Usage |
--------- | ------- |
DELETE | Use the DELETE method to destroy a resource in your account. If it is not found, the operation will return a 4xx error and an appropriate message.|
GET | To retrieve information about a resource, use the GET method. The data is returned as a JSON object. GET methods are read-only and do not affect any resources. |
POST | Issue a POST method to create a new object. Include all needed attributes in the request body encoded as JSON.|
PUT | Use the PUT method to update information about a resource. PUT will set new values on the item without regard to their current values. |

#Error Codes

We use standard HTTP response codes to show the success or failure of requests.
Response codes in the 2xx range indicate success, while codes in the 4xx range indicate an error, such as an authorization failure or a malformed request.
All 4xx errors will return a JSON response object with an error attribute explaining the error.
Codes in the 5xx range indicate a server-side problem preventing Vultr from fulfilling your request.

Response | Description |
--------- | ------- |
200 OK | The response contains your requested information.|
201 Created | Your request was accepted. The resource was created. |
202 Accepted | Your request was accepted. The resource was created or updated.|
204 No Content |Your request succeeded, there is no additional information returned. |
400 Bad Request | Your request was malformed. |
401 Unauthorized | You did not supply valid authentication credentials. |
403 Forbidden | You are not allowed to perform that action. |
404 Not Found | No results were found for your request. |
429 Too Many Requests | Your request exceeded the API rate limit. |
500 Internal Server Error | We were unable to perform the request due to server-side problems. |


<!-- END_INFO -->

#Access Keys management


APIs for managing access Keys
<!-- START_2b47a68ac15cc12ea0638ce491393dba -->
## Display a list of scopes.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/scopes" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/scopes"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/scopes',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/scopes'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "data": [
        "scope1.action",
        "scope1.action2",
        "scope2.action"
    ]
}
```

### HTTP Request
`GET api/scopes`


<!-- END_2b47a68ac15cc12ea0638ce491393dba -->

<!-- START_ea0c64c7e66e2605f75120243421c139 -->
## Display a list of access Keys.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/accessKeys?id=eos&account_id=9&role=aliquid&status=sint&from=6&to=8&orderBy=facilis&sortBy=et&limit=17" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/accessKeys"
);

let params = {
    "id": "eos",
    "account_id": "9",
    "role": "aliquid",
    "status": "sint",
    "from": "6",
    "to": "8",
    "orderBy": "facilis",
    "sortBy": "et",
    "limit": "17",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/accessKeys',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'query' => [
            'id'=> 'eos',
            'account_id'=> '9',
            'role'=> 'aliquid',
            'status'=> 'sint',
            'from'=> '6',
            'to'=> '8',
            'orderBy'=> 'facilis',
            'sortBy'=> 'et',
            'limit'=> '17',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/accessKeys'
params = {
  'id': 'eos',
  'account_id': '9',
  'role': 'aliquid',
  'status': 'sint',
  'from': '6',
  'to': '8',
  'orderBy': 'facilis',
  'sortBy': 'et',
  'limit': '17',
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "data": [
        {
            "id": 1,
            "name": "ADMIN",
            "token": "token",
            "scopes": "[\"contacts.store\",\"contacts.update\"]",
            "status": 1,
            "end_at": null,
            "account_id": 1,
            "created_at": "2021-09-10T14:24:20.000000Z",
            "updated_at": "2021-09-16T14:08:32.000000Z"
        },
        {
            "id": 2,
            "name": "secrétaire",
            "token": "token",
            "scopes": "[\"contacts.addToSegment\"]",
            "status": 1,
            "end_at": null,
            "account_id": 1,
            "created_at": "2021-09-16T12:39:19.000000Z",
            "updated_at": "2021-09-16T14:08:40.000000Z"
        }
    ],
    "meta": {
        "total": 2,
        "links": "",
        "filters": []
    }
}
```
> Example response (404):

```json
{
    "code": "error",
    "message": "No access keys yet."
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/accessKeys`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  optional  | Int The id of access key.
    `account_id` |  optional  | Int The id of account.
    `role` |  optional  | String The role of access key.
    `status` |  optional  | Int Status of access key.
    `from` |  optional  | Date Date of account creation.
    `to` |  optional  | Date Date of account cancellationy.
    `orderBy` |  optional  | String Field name.
    `sortBy` |  optional  | The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
    `limit` |  optional  | Int The number of items returned in the response.

<!-- END_ea0c64c7e66e2605f75120243421c139 -->

<!-- START_016df260fcdfe9ea6d154b75b3da1a1b -->
## Add new access key.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/accessKeys/add" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"name":"et","scopes":"molestiae"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/accessKeys/add"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "name": "et",
    "scopes": "molestiae"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://127.0.0.1:8000/api/accessKeys/add',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'name' => 'et',
            'scopes' => 'molestiae',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/accessKeys/add'
payload = {
    "name": "et",
    "scopes": "molestiae"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Access key created successfully",
    "data": {
        "id": 1,
        "account_id": 1,
        "token": "Klskdfhl357MLKJHLKJsdfg2dfg65s4dgsd4g5",
        "role": "user",
        "scopes": "",
        "status": 1,
        "date_start": "2020-05-18",
        "date_end": null
    }
}
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Required fields not filled or formats not recognized !"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`POST api/accessKeys/add`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | required |  optional  | String The name of access key.
        `scopes` | required |  optional  | JSON The scopes of access key.
    
<!-- END_016df260fcdfe9ea6d154b75b3da1a1b -->

<!-- START_8913c7e486a52a0979248ddb2c73dc1c -->
## Remove access key.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1:8000/api/accessKeys/quasi/delete" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/accessKeys/quasi/delete"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://127.0.0.1:8000/api/accessKeys/quasi/delete',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/accessKeys/quasi/delete'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Access key deleted successfully"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, the access key has not been deleted"
}
```

### HTTP Request
`DELETE api/accessKeys/{accessKey}/delete`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `accessKey` |  required  | Int The id of access key.


<!-- END_8913c7e486a52a0979248ddb2c73dc1c -->

<!-- START_fe8d5d26132c6bdffac4e7faefaaee8a -->
## Update access key.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1:8000/api/accessKeys/veritatis/update" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/accessKeys/veritatis/update"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://127.0.0.1:8000/api/accessKeys/veritatis/update',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/accessKeys/veritatis/update'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Access key updated successfully",
    "data": {
        "id": 1,
        "account_id": 1,
        "token": "Klskdfhl357MLKJHLKJsdfg2dfg65s4dgsd4g5",
        "role": "user",
        "scopes": "",
        "status": 1,
        "date_start": "2020-05-18",
        "date_end": null
    }
}
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Unauthorized operation"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, the access key has not been updated."
}
```

### HTTP Request
`PUT api/accessKeys/{accessKey}/update`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `accessKey` |  required  | Int The id of access key.


<!-- END_fe8d5d26132c6bdffac4e7faefaaee8a -->

#Channels management


APIs for managing Channels
<!-- START_49dde38880772c46db114f63233b9c8d -->
## Display a list of channels.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/channels?media=13&account_id=3&status=veritatis&from=a&to=nisi&orderBy=blanditiis&sortBy=repellat&limit=10" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/channels"
);

let params = {
    "media": "13",
    "account_id": "3",
    "status": "veritatis",
    "from": "a",
    "to": "nisi",
    "orderBy": "blanditiis",
    "sortBy": "repellat",
    "limit": "10",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/channels',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'query' => [
            'media'=> '13',
            'account_id'=> '3',
            'status'=> 'veritatis',
            'from'=> 'a',
            'to'=> 'nisi',
            'orderBy'=> 'blanditiis',
            'sortBy'=> 'repellat',
            'limit'=> '10',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/channels'
params = {
  'media': '13',
  'account_id': '3',
  'status': 'veritatis',
  'from': 'a',
  'to': 'nisi',
  'orderBy': 'blanditiis',
  'sortBy': 'repellat',
  'limit': '10',
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "data": [
        {
            "id": 1,
            "account_id": 1,
            "media_id": 1,
            "identifier": "1568941346779",
            "name": "Facebook page name",
            "picture": "",
            "status": 1,
            "date_start": "2021-02-10",
            "date_end": null
        },
        {
            "id": 2,
            "account_id": 1,
            "media_id": 2,
            "identifier": "979875434333",
            "name": "Instagram profile",
            "picture": "",
            "status": 1,
            "date_start": "2021-01-21",
            "date_end": null
        }
    ],
    "meta": {
        "total": 10,
        "links": "",
        "filters": []
    }
}
```
> Example response (404):

```json
{
    "code": "error",
    "message": "No channels yet."
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/channels`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `media` |  optional  | String The name of channel [social media name, landing page].
    `account_id` |  optional  | Int The id of account.
    `status` |  optional  | Int Status of channel.
    `from` |  optional  | Date Date of channel creation.
    `to` |  optional  | Date Date of channel cancellation.
    `orderBy` |  optional  | String Field name.
    `sortBy` |  optional  | The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
    `limit` |  optional  | Int The number of items returned in the response.

<!-- END_49dde38880772c46db114f63233b9c8d -->

<!-- START_0779c6dd057d85b1ecc8600867607a5a -->
## View channel details.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/channels/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"media_id":"ut","name":"laboriosam"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/channels/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "media_id": "ut",
    "name": "laboriosam"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/channels/1',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'media_id' => 'ut',
            'name' => 'laboriosam',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/channels/1'
payload = {
    "media_id": "ut",
    "name": "laboriosam"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "data": {
        "id": 1,
        "account_id": 1,
        "media_id": 1,
        "identifier": "1568941346779",
        "name": "Facebook page name",
        "picture": "",
        "status": 1,
        "date_start": "2021-02-10",
        "date_end": null
    }
}
```
> Example response (404):

```json
{
    "code": "error",
    "message": "Channel not found"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/channels/{channel}`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `media_id` | Int |  required  | The id of media.
        `name` | String |  required  | The name of channel.
    
<!-- END_0779c6dd057d85b1ecc8600867607a5a -->

<!-- START_e52ac04e10a3f587ddfb0a753f36d83e -->
## Add new channel.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/channels/add" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"media_id":"quas","name":"dolore"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/channels/add"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "media_id": "quas",
    "name": "dolore"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://127.0.0.1:8000/api/channels/add',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'media_id' => 'quas',
            'name' => 'dolore',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/channels/add'
payload = {
    "media_id": "quas",
    "name": "dolore"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Channel created successfully",
    "data": {
        "id": 1,
        "account_id": 1,
        "media_id": 1,
        "identifier": "1568941346779",
        "name": "Facebook page name",
        "picture": "",
        "status": 1,
        "date_start": "2021-02-10",
        "date_end": null
    }
}
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Required fields not filled or formats not recognized !"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`POST api/channels/add`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `media_id` | Int |  required  | The id of media.
        `name` | String |  required  | The name of channel.
    
<!-- END_e52ac04e10a3f587ddfb0a753f36d83e -->

<!-- START_6b20dd2692b2bf8573490d41e6c86324 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1:8000/api/channels/eius/delete" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/channels/eius/delete"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://127.0.0.1:8000/api/channels/eius/delete',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/channels/eius/delete'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Channel deleted successfully"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`DELETE api/channels/{channel}/delete`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `channel` |  required  | Int The id of channel.


<!-- END_6b20dd2692b2bf8573490d41e6c86324 -->

<!-- START_940cede7ced36ec8aceddf69ed6e82e6 -->
## Update Channel.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1:8000/api/channels/mollitia/update" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"status":"sint","name":"ut","date_end":"et"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/channels/mollitia/update"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "status": "sint",
    "name": "ut",
    "date_end": "et"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://127.0.0.1:8000/api/channels/mollitia/update',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'status' => 'sint',
            'name' => 'ut',
            'date_end' => 'et',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/channels/mollitia/update'
payload = {
    "status": "sint",
    "name": "ut",
    "date_end": "et"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('PUT', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Channel updated successfully",
    "data": {
        "id": 1,
        "account_id": 1,
        "media_id": 1,
        "identifier": "1568941346779",
        "name": "Facebook page name",
        "picture": "",
        "status": 1,
        "date_start": "2021-02-10",
        "date_end": null
    }
}
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Unauthorized operation"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`PUT api/channels/{channel}/update`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `channel` |  optional  | Int required  The id of channel.

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `status` | Int |  required  | The status of channel.
        `name` | String |  required  | The name of channel.
        `date_end` | Date |  optional  | The end date of channel.
    
<!-- END_940cede7ced36ec8aceddf69ed6e82e6 -->

#Contacts management


APIs for managing Contacts
<!-- START_d059abd2fd592130bb0db9d9d1a43873 -->
## add contact to segment.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/contact/segment/add" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"contact":"nihil","segment":"consequuntur"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/contact/segment/add"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "contact": "nihil",
    "segment": "consequuntur"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://127.0.0.1:8000/api/contact/segment/add',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'contact' => 'nihil',
            'segment' => 'consequuntur',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/contact/segment/add'
payload = {
    "contact": "nihil",
    "segment": "consequuntur"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "contact added to segment successfully"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`POST api/contact/segment/add`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `contact` | Int |  required  | The id of contact.
        `segment` | Int |  required  | The id of segment.
    
<!-- END_d059abd2fd592130bb0db9d9d1a43873 -->

<!-- START_8bd3de5bafc12ad4fafd92e4255108fa -->
## delete contact from segment.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1:8000/api/contact/segment/delete" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"contact":"beatae","segment":"fugit"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/contact/segment/delete"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "contact": "beatae",
    "segment": "fugit"
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://127.0.0.1:8000/api/contact/segment/delete',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'contact' => 'beatae',
            'segment' => 'fugit',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/contact/segment/delete'
payload = {
    "contact": "beatae",
    "segment": "fugit"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('DELETE', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "contact deleted from segment successfully"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`DELETE api/contact/segment/delete`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `contact` | Int |  required  | The id of contact.
        `segment` | Int |  required  | The id of segment.
    
<!-- END_8bd3de5bafc12ad4fafd92e4255108fa -->

<!-- START_543b0b80e8dc51d2d3ad7e2a327eed26 -->
## Display a list of contacts.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/contacts?gender=eveniet&country=18&status=cumque&from=necessitatibus&to=architecto&orderBy=et&sortBy=sed&limit=9" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/contacts"
);

let params = {
    "gender": "eveniet",
    "country": "18",
    "status": "cumque",
    "from": "necessitatibus",
    "to": "architecto",
    "orderBy": "et",
    "sortBy": "sed",
    "limit": "9",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/contacts',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'query' => [
            'gender'=> 'eveniet',
            'country'=> '18',
            'status'=> 'cumque',
            'from'=> 'necessitatibus',
            'to'=> 'architecto',
            'orderBy'=> 'et',
            'sortBy'=> 'sed',
            'limit'=> '9',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/contacts'
params = {
  'gender': 'eveniet',
  'country': '18',
  'status': 'cumque',
  'from': 'necessitatibus',
  'to': 'architecto',
  'orderBy': 'et',
  'sortBy': 'sed',
  'limit': '9',
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
null
```
> Example response (404):

```json
{
    "code": "error",
    "message": "No contacts yet."
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/contacts`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `gender` |  optional  | String The gender of contact. Example : male/female
    `country` |  optional  | String The ISO country code.
    `status` |  optional  | Int Status of contact.
    `from` |  optional  | Date Date of contact creation.
    `to` |  optional  | Date Date of contact cancellation.
    `orderBy` |  optional  | String Field name.
    `sortBy` |  optional  | The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
    `limit` |  optional  | Int The number of items returned in the response.

<!-- END_543b0b80e8dc51d2d3ad7e2a327eed26 -->

<!-- START_a44483465b9aa8cdb47a73e922b4dd91 -->
## View contact details.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/contacts/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/contacts/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/contacts/1',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/contacts/1'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (404):

```json
{
    "message": "No query results for model [App\\Models\\Contacts] 1"
}
```

### HTTP Request
`GET api/contacts/{contact}`


<!-- END_a44483465b9aa8cdb47a73e922b4dd91 -->

<!-- START_61bc3dc342ed7a76a3c3e062d8e4f97f -->
## Remove contact

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1:8000/api/contacts/perspiciatis/delete" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/contacts/perspiciatis/delete"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://127.0.0.1:8000/api/contacts/perspiciatis/delete',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/contacts/perspiciatis/delete'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "contact deleted successfully"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`DELETE api/contacts/{contact}/delete`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `contact` |  required  | Int The id of contact.


<!-- END_61bc3dc342ed7a76a3c3e062d8e4f97f -->

<!-- START_00f8c883848bafe3a77f13fb1337451c -->
## Update contact.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1:8000/api/contacts/1/update" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"status":"est","name":"aspernatur","date_end":"est"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/contacts/1/update"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "status": "est",
    "name": "aspernatur",
    "date_end": "est"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://127.0.0.1:8000/api/contacts/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'status' => 'est',
            'name' => 'aspernatur',
            'date_end' => 'est',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/contacts/1/update'
payload = {
    "status": "est",
    "name": "aspernatur",
    "date_end": "est"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('PUT', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Channel updated successfully",
    "data": {
        "id": 1,
        "account_id": 1,
        "media_id": 1,
        "identifier": "1568941346779",
        "name": "Facebook page name",
        "picture": "",
        "status": 1,
        "date_start": "2021-02-10",
        "date_end": null
    }
}
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Unauthorized operation"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`PUT api/contacts/{contact}/update`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `channel` |  optional  | Int required  The id of channel.

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `status` | Int |  required  | The status of channel.
        `name` | String |  required  | The name of channel.
        `date_end` | Date |  optional  | The end date of channel.
    
<!-- END_00f8c883848bafe3a77f13fb1337451c -->

#Fields management


APIs for managing Fields
<!-- START_5ad229a3f4ddbaf4f3333b1eb7f7e890 -->
## Display a list of fields.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/fields?status=quia&limit=6" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/fields"
);

let params = {
    "status": "quia",
    "limit": "6",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/fields',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'query' => [
            'status'=> 'quia',
            'limit'=> '6',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/fields'
params = {
  'status': 'quia',
  'limit': '6',
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "data": [
        {
            "id": 1,
            "account_id": 1,
            "name": "Hobbies",
            "tag": "hobby",
            "format": "text",
            "status": 1
        },
        {
            "id": 2,
            "account_id": 1,
            "name": "Birthday",
            "tag": "birthday",
            "format": "date",
            "status": 1
        }
    ],
    "meta": {
        "total": 10,
        "links": "",
        "filters": []
    }
}
```
> Example response (404):

```json
{
    "code": "error",
    "message": "No fields yet."
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/fields`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `status` |  optional  | Int Status of field.
    `limit` |  optional  | Int The number of items returned in the response.

<!-- END_5ad229a3f4ddbaf4f3333b1eb7f7e890 -->

<!-- START_ae8a8fac20391b973ecfbf8c9c92729b -->
## View field details.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/fields/nulla" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/fields/nulla"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/fields/nulla',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/fields/nulla'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "data": {
        "id": 1,
        "account_id": 1,
        "name": "Hobbies",
        "tag": "hobby",
        "format": "text",
        "status": 1
    }
}
```
> Example response (404):

```json
{
    "code": "error",
    "message": "Field not found"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/fields/{field}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `field` |  optional  | Int required  The id of field .


<!-- END_ae8a8fac20391b973ecfbf8c9c92729b -->

<!-- START_e2f625c01208b97c2982caa8531beeb9 -->
## Add new custom field.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/fields/add" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"name":"ducimus","format":"iusto"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/fields/add"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "name": "ducimus",
    "format": "iusto"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://127.0.0.1:8000/api/fields/add',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'name' => 'ducimus',
            'format' => 'iusto',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/fields/add'
payload = {
    "name": "ducimus",
    "format": "iusto"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Field created successfully",
    "data": {
        "id": 1,
        "account_id": 1,
        "name": "Hobbies",
        "tag": "hobby",
        "format": "text",
        "status": 1
    }
}
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Required fields not filled or formats not recognized !"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`POST api/fields/add`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | String |  required  | The type of contact. Example : client / lead / competitor
        `format` | String |  required  | The type of field.
    
<!-- END_e2f625c01208b97c2982caa8531beeb9 -->

<!-- START_58c5fee616deb9570bab69daa0aec5e3 -->
## Remove field

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1:8000/api/fields/sit/delete" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/fields/sit/delete"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://127.0.0.1:8000/api/fields/sit/delete',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/fields/sit/delete'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "field deleted successfully"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`DELETE api/fields/{field}/delete`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `field` |  required  | Int The id of field.


<!-- END_58c5fee616deb9570bab69daa0aec5e3 -->

<!-- START_dbd9f42ce9af06c1816789ad0d092c73 -->
## Update field.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1:8000/api/fields/provident/update" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"name":"rerum","format":"enim"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/fields/provident/update"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "name": "rerum",
    "format": "enim"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://127.0.0.1:8000/api/fields/provident/update',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'name' => 'rerum',
            'format' => 'enim',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/fields/provident/update'
payload = {
    "name": "rerum",
    "format": "enim"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('PUT', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Field updated successfully",
    "data": {
        "id": 1,
        "account_id": 1,
        "name": "Hobbies",
        "tag": "hobby",
        "format": "text",
        "status": 1
    }
}
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Unauthorized operation"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`PUT api/fields/{field}/update`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `field` |  optional  | Int required  The id of field.

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | String |  required  | The type of contact. Example : client / lead / competitor
        `format` | String |  required  | The type of field.
    
<!-- END_dbd9f42ce9af06c1816789ad0d092c73 -->

#Forms management


APIs for managing Forms
<!-- START_85be5bd8d022a09f1ca4bec4897d4daf -->
## Display a list of forms.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/forms?status=necessitatibus&limit=16" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/forms"
);

let params = {
    "status": "necessitatibus",
    "limit": "16",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/forms',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'query' => [
            'status'=> 'necessitatibus',
            'limit'=> '16',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/forms'
params = {
  'status': 'necessitatibus',
  'limit': '16',
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "data": [
        {
            "id": 1,
            "account_id": 1,
            "name": "First collection bot",
            "content": "",
            "url": "https:\/\/collector.pro\/forms\/form1\/",
            "status": 1,
            "date_start": "2021-02-10",
            "date_end": null
        },
        {
            "id": 2,
            "account_id": 1,
            "name": "Landing page collector",
            "content": "",
            "url": "https:\/\/collector.pro\/forms\/form2\/",
            "status": 1,
            "date_start": "2021-01-21",
            "date_end": null
        }
    ],
    "meta": {
        "total": 10,
        "links": "",
        "filters": []
    }
}
```
> Example response (404):

```json
{
    "code": "error",
    "message": "No forms yet."
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/forms`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `status` |  optional  | Int Status of field.
    `limit` |  optional  | Int The number of items returned in the response.

<!-- END_85be5bd8d022a09f1ca4bec4897d4daf -->

<!-- START_e60b3416bd74d10c3a27d643b781f86f -->
## View form details.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/forms/similique" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/forms/similique"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/forms/similique',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/forms/similique'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
null
```
> Example response (404):

```json
{
    "code": "error",
    "message": "form not found"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/forms/{form}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `form` |  optional  | Int required  The id of form .


<!-- END_e60b3416bd74d10c3a27d643b781f86f -->

<!-- START_1098d12fc247ca1e947ea1546065f34b -->
## Add new form.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/forms/add" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"content":"ullam","name":"ea"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/forms/add"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "content": "ullam",
    "name": "ea"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://127.0.0.1:8000/api/forms/add',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'content' => 'ullam',
            'name' => 'ea',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/forms/add'
payload = {
    "content": "ullam",
    "name": "ea"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Form created successfully",
    "data": {
        "id": 1,
        "account_id": 1,
        "name": "First collection bot",
        "content": "",
        "url": "https:\/\/collector.pro\/forms\/form1\/",
        "status": 1,
        "date_start": "2021-02-10",
        "date_end": null
    }
}
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Required fields not filled or formats not recognized !"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`POST api/forms/add`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `content` | JSON |  required  | Array of fields id.
        `name` | String |  required  | The name of form.
    
<!-- END_1098d12fc247ca1e947ea1546065f34b -->

<!-- START_cca0c9925d2196d9d32a8ee5533bf91f -->
## Remove form.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1:8000/api/forms/est/delete" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/forms/est/delete"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://127.0.0.1:8000/api/forms/est/delete',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/forms/est/delete'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "form deleted successfully"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`DELETE api/forms/{form}/delete`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `form` |  required  | Int The id of form.


<!-- END_cca0c9925d2196d9d32a8ee5533bf91f -->

<!-- START_615ee271fbeb47373c0f11307a01e7dc -->
## Update form.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1:8000/api/forms/a/update" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"content":"modi","name":"natus"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/forms/a/update"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "content": "modi",
    "name": "natus"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://127.0.0.1:8000/api/forms/a/update',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'content' => 'modi',
            'name' => 'natus',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/forms/a/update'
payload = {
    "content": "modi",
    "name": "natus"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('PUT', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Form updated successfully",
    "data": {
        "id": 1,
        "account_id": 1,
        "name": "First collection bot",
        "content": "['1','2','3']",
        "url": "https:\/\/collector.pro\/forms\/form1\/",
        "status": 1,
        "date_start": "2021-02-10",
        "date_end": null
    }
}
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Unauthorized operation"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`PUT api/forms/{form}/update`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `form` |  optional  | Int required  The id of form.

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `content` | JSON |  required  | Array of fields id.
        `name` | String |  required  | The name of form.
    
<!-- END_615ee271fbeb47373c0f11307a01e7dc -->

#Logs management


APIs for managing Logs
<!-- START_54cb226e1c806f816f425980068f574f -->
## Display a list of the logs.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/logs?access_id=est&action=est&from=rerum&to=blanditiis&orderBy=deleniti&sortBy=impedit&limit=15" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/logs"
);

let params = {
    "access_id": "est",
    "action": "est",
    "from": "rerum",
    "to": "blanditiis",
    "orderBy": "deleniti",
    "sortBy": "impedit",
    "limit": "15",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/logs',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'query' => [
            'access_id'=> 'est',
            'action'=> 'est',
            'from'=> 'rerum',
            'to'=> 'blanditiis',
            'orderBy'=> 'deleniti',
            'sortBy'=> 'impedit',
            'limit'=> '15',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/logs'
params = {
  'access_id': 'est',
  'action': 'est',
  'from': 'rerum',
  'to': 'blanditiis',
  'orderBy': 'deleniti',
  'sortBy': 'impedit',
  'limit': '15',
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "data": [
        {
            "id": 1,
            "access_id": "42",
            "action": "create",
            "element": "responder",
            "element_id": 20,
            "date": "2020-05-18"
        },
        {
            "id": 1,
            "access_id": "42",
            "action": "delete",
            "element": "field",
            "element_id": 432,
            "date": "2019-12-10"
        }
    ],
    "meta": {
        "total": 10,
        "links": "",
        "filters": []
    }
}
```
> Example response (404):

```json
{
    "code": "error",
    "message": "No logs yet."
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/logs`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `access_id` |  optional  | Int ID of access key.
    `action` |  optional  | Int The name of the action.
    `from` |  optional  | Date Date of contact creation.
    `to` |  optional  | Date Date of contact cancellation.
    `orderBy` |  optional  | String Field name.
    `sortBy` |  optional  | The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
    `limit` |  optional  | Int The number of items returned in the response.

<!-- END_54cb226e1c806f816f425980068f574f -->

#Medias management


APIs for managing Medias
<!-- START_00f5ebe26d85a2ea26759b6dea95b28f -->
## Display a list of medias.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/medias?id=est&contact_id=ducimus&channel_id=non&responder_id=et&status=eos&from=quas&to=dicta&orderBy=dolores&sortBy=soluta&limit=14" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/medias"
);

let params = {
    "id": "est",
    "contact_id": "ducimus",
    "channel_id": "non",
    "responder_id": "et",
    "status": "eos",
    "from": "quas",
    "to": "dicta",
    "orderBy": "dolores",
    "sortBy": "soluta",
    "limit": "14",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/medias',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'query' => [
            'id'=> 'est',
            'contact_id'=> 'ducimus',
            'channel_id'=> 'non',
            'responder_id'=> 'et',
            'status'=> 'eos',
            'from'=> 'quas',
            'to'=> 'dicta',
            'orderBy'=> 'dolores',
            'sortBy'=> 'soluta',
            'limit'=> '14',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/medias'
params = {
  'id': 'est',
  'contact_id': 'ducimus',
  'channel_id': 'non',
  'responder_id': 'et',
  'status': 'eos',
  'from': 'quas',
  'to': 'dicta',
  'orderBy': 'dolores',
  'sortBy': 'soluta',
  'limit': '14',
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "data": [
        {
            "id": 1,
            "contact_id": 1,
            "channel_id": 1,
            "responder_id": 1,
            "type": "form",
            "content": "",
            "status": 1,
            "date_send": "2021-02-10"
        },
        {
            "id": 2,
            "contact_id": 3,
            "channel_id": 1,
            "responder_id": 4,
            "type": "message",
            "content": "name",
            "status": 1,
            "date_send": "2020-11-18"
        }
    ],
    "meta": {
        "total": 10,
        "links": "",
        "filters": []
    }
}
```
> Example response (404):

```json
{
    "code": "error",
    "message": "No requests  yet."
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/medias`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  optional  | Int The ID of request.
    `contact_id` |  optional  | Int The ID of contact.
    `channel_id` |  optional  | Int The ID of channel.
    `responder_id` |  optional  | Int The ID of responder.
    `status` |  optional  | Int Status of request.
    `from` |  optional  | Date Date of request creation.
    `to` |  optional  | Date Date of request cancellation.
    `orderBy` |  optional  | String Field name.
    `sortBy` |  optional  | The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
    `limit` |  optional  | Int The number of items returned in the response.

<!-- END_00f5ebe26d85a2ea26759b6dea95b28f -->

#Messages management


APIs for managing Messages
<!-- START_c61e9c2b3fdeea56ee207c8db3d88546 -->
## Display a list of messages.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/messages?id=saepe&request_id=praesentium&from=commodi&to=iste&orderBy=a&sortBy=porro&limit=13" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/messages"
);

let params = {
    "id": "saepe",
    "request_id": "praesentium",
    "from": "commodi",
    "to": "iste",
    "orderBy": "a",
    "sortBy": "porro",
    "limit": "13",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/messages',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'query' => [
            'id'=> 'saepe',
            'request_id'=> 'praesentium',
            'from'=> 'commodi',
            'to'=> 'iste',
            'orderBy'=> 'a',
            'sortBy'=> 'porro',
            'limit'=> '13',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/messages'
params = {
  'id': 'saepe',
  'request_id': 'praesentium',
  'from': 'commodi',
  'to': 'iste',
  'orderBy': 'a',
  'sortBy': 'porro',
  'limit': '13',
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
null
```
> Example response (404):

```json
{
    "code": "error",
    "message": "No messages yet."
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/messages`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `id` |  optional  | int The id of message
    `request_id` |  optional  | int The ID of request.
    `from` |  optional  | Date Date of message creation.
    `to` |  optional  | Date Date of message cancellation.
    `orderBy` |  optional  | String Field name.
    `sortBy` |  optional  | The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
    `limit` |  optional  | Int The number of items returned in the response.

<!-- END_c61e9c2b3fdeea56ee207c8db3d88546 -->

#Profiles management


APIs for managing Profiles
<!-- START_f87d568af345c2e37049ca0b695ccfc4 -->
## Display list of profiles.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/profiles" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/profiles"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/profiles',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/profiles'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/profiles`


<!-- END_f87d568af345c2e37049ca0b695ccfc4 -->

#Questions management


APIs for managing Questions
<!-- START_de9212b4bd813e07f73b53cc3bd13088 -->
## Display a list of questions.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/questions?responder_id=saepe&field_id=iure&status=expedita&order=quia&from=rerum&to=nostrum&orderBy=quod&sortBy=enim&limit=19" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/questions"
);

let params = {
    "responder_id": "saepe",
    "field_id": "iure",
    "status": "expedita",
    "order": "quia",
    "from": "rerum",
    "to": "nostrum",
    "orderBy": "quod",
    "sortBy": "enim",
    "limit": "19",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/questions',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'query' => [
            'responder_id'=> 'saepe',
            'field_id'=> 'iure',
            'status'=> 'expedita',
            'order'=> 'quia',
            'from'=> 'rerum',
            'to'=> 'nostrum',
            'orderBy'=> 'quod',
            'sortBy'=> 'enim',
            'limit'=> '19',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/questions'
params = {
  'responder_id': 'saepe',
  'field_id': 'iure',
  'status': 'expedita',
  'order': 'quia',
  'from': 'rerum',
  'to': 'nostrum',
  'orderBy': 'quod',
  'sortBy': 'enim',
  'limit': '19',
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
null
```
> Example response (404):

```json
{
    "code": "error",
    "message": "No questions yet."
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/questions`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `responder_id` |  optional  | int The id of question.
    `field_id` |  optional  | int The id of field.
    `status` |  optional  | Int Status of question.
    `order` |  optional  | Int order of question.
    `from` |  optional  | Date Date of question creation.
    `to` |  optional  | Date Date of question cancellation.
    `orderBy` |  optional  | String Field name.
    `sortBy` |  optional  | The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
    `limit` |  optional  | Int The number of items returned in the response.

<!-- END_de9212b4bd813e07f73b53cc3bd13088 -->

<!-- START_f605dcf2ca92a58323db87f649ac1dae -->
## View Question details .

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/questions/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/questions/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/questions/1',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/questions/1'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/questions/{question}`


<!-- END_f605dcf2ca92a58323db87f649ac1dae -->

<!-- START_d38bad57161d95af1da578161ebd88e4 -->
## Add new question.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/questions/add" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"responder_id":"dolorem","field_id":"sequi","message":"suscipit","response":"voluptatibus","order":16}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/questions/add"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "responder_id": "dolorem",
    "field_id": "sequi",
    "message": "suscipit",
    "response": "voluptatibus",
    "order": 16
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://127.0.0.1:8000/api/questions/add',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'responder_id' => 'dolorem',
            'field_id' => 'sequi',
            'message' => 'suscipit',
            'response' => 'voluptatibus',
            'order' => 16,
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/questions/add'
payload = {
    "responder_id": "dolorem",
    "field_id": "sequi",
    "message": "suscipit",
    "response": "voluptatibus",
    "order": 16
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
null
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Required fields not filled or formats not recognized !"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`POST api/questions/add`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `responder_id` | Int |  required  | The id of responder.
        `field_id` | Int |  required  | The id of field.
        `message` | String |  optional  | The question content.
        `response` | Boolean |  optional  | The question have response or not.
        `order` | integer |  optional  | The order of the question.
    
<!-- END_d38bad57161d95af1da578161ebd88e4 -->

<!-- START_b77e60150e0bc71e62f3bca8143d40ed -->
## Remove question.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1:8000/api/questions/ex/delete" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/questions/ex/delete"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://127.0.0.1:8000/api/questions/ex/delete',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/questions/ex/delete'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "question deleted successfully"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`DELETE api/questions/{question}/delete`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `question` |  required  | Int The id of question.


<!-- END_b77e60150e0bc71e62f3bca8143d40ed -->

<!-- START_26701bc6f96ba6871d26e795e1607a5b -->
## Update Question.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1:8000/api/questions/porro/update" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"responder_id":"autem","field_id":"dolorem","message":"in","response":"quibusdam","order":12}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/questions/porro/update"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "responder_id": "autem",
    "field_id": "dolorem",
    "message": "in",
    "response": "quibusdam",
    "order": 12
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://127.0.0.1:8000/api/questions/porro/update',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'responder_id' => 'autem',
            'field_id' => 'dolorem',
            'message' => 'in',
            'response' => 'quibusdam',
            'order' => 12,
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/questions/porro/update'
payload = {
    "responder_id": "autem",
    "field_id": "dolorem",
    "message": "in",
    "response": "quibusdam",
    "order": 12
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('PUT', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
null
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Unauthorized operation"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`PUT api/questions/{question}/update`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `question` |  optional  | Int required the question id.

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `responder_id` | Int |  optional  | The id of responder.
        `field_id` | Int |  optional  | The id of field.
        `message` | String |  optional  | The question content.
        `response` | Boolean |  optional  | The question have response or not.
        `order` | integer |  optional  | The order of the question.
    
<!-- END_26701bc6f96ba6871d26e795e1607a5b -->

#Requests management


APIs for managing Requests
<!-- START_8f3e0849f59d202e000098a13fc95f23 -->
## Display a list of requests.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/requests?contact_id=esse&channel_id=aut&responder_id=facere&status=ea&from=eius&to=ipsa&orderBy=quia&sortBy=et&limit=15" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/requests"
);

let params = {
    "contact_id": "esse",
    "channel_id": "aut",
    "responder_id": "facere",
    "status": "ea",
    "from": "eius",
    "to": "ipsa",
    "orderBy": "quia",
    "sortBy": "et",
    "limit": "15",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/requests',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'query' => [
            'contact_id'=> 'esse',
            'channel_id'=> 'aut',
            'responder_id'=> 'facere',
            'status'=> 'ea',
            'from'=> 'eius',
            'to'=> 'ipsa',
            'orderBy'=> 'quia',
            'sortBy'=> 'et',
            'limit'=> '15',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/requests'
params = {
  'contact_id': 'esse',
  'channel_id': 'aut',
  'responder_id': 'facere',
  'status': 'ea',
  'from': 'eius',
  'to': 'ipsa',
  'orderBy': 'quia',
  'sortBy': 'et',
  'limit': '15',
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "data": [
        {
            "id": 1,
            "contact_id": 1,
            "channel_id": 1,
            "responder_id": 1,
            "type": "form",
            "content": "",
            "status": 1,
            "date_send": "2021-02-10"
        },
        {
            "id": 2,
            "contact_id": 3,
            "channel_id": 1,
            "responder_id": 4,
            "type": "message",
            "content": "name",
            "status": 1,
            "date_send": "2020-11-18"
        }
    ],
    "meta": {
        "total": 10,
        "links": "",
        "filters": []
    }
}
```
> Example response (404):

```json
{
    "code": "error",
    "message": "No requests yet."
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/requests`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `contact_id` |  optional  | int The id of contact.
    `channel_id` |  optional  | int The id of channel.
    `responder_id` |  optional  | int The id of responder
    `status` |  optional  | Int Status of request.
    `from` |  optional  | Date Date of request creation.
    `to` |  optional  | Date Date of request cancellation.
    `orderBy` |  optional  | String Field name.
    `sortBy` |  optional  | The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
    `limit` |  optional  | Int The number of items returned in the response.

<!-- END_8f3e0849f59d202e000098a13fc95f23 -->

#Responders management


APIs for managing Responders
<!-- START_8fe2b08f9e2b01a2fd204ff0cd679dc1 -->
## Display a list of responders.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/responders?status=vitae&from=sunt&to=voluptatum&orderBy=quia&sortBy=impedit&limit=18" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/responders"
);

let params = {
    "status": "vitae",
    "from": "sunt",
    "to": "voluptatum",
    "orderBy": "quia",
    "sortBy": "impedit",
    "limit": "18",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/responders',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'query' => [
            'status'=> 'vitae',
            'from'=> 'sunt',
            'to'=> 'voluptatum',
            'orderBy'=> 'quia',
            'sortBy'=> 'impedit',
            'limit'=> '18',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/responders'
params = {
  'status': 'vitae',
  'from': 'sunt',
  'to': 'voluptatum',
  'orderBy': 'quia',
  'sortBy': 'impedit',
  'limit': '18',
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "data": [
        {
            "id": 1,
            "account_id": 1,
            "name": "First collection bot",
            "content": "",
            "status": 1,
            "date_start": "2021-02-10",
            "date_end": null
        },
        {
            "id": 2,
            "account_id": 1,
            "name": "Landing page collector",
            "content": "",
            "status": 1,
            "date_start": "2021-01-21",
            "date_end": null
        }
    ],
    "meta": {
        "total": 10,
        "links": "",
        "filters": []
    }
}
```
> Example response (404):

```json
{
    "code": "error",
    "message": "No responders yet."
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/responders`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `status` |  optional  | Int Status of request.
    `from` |  optional  | Date Date of request creation.
    `to` |  optional  | Date Date of request cancellation.
    `orderBy` |  optional  | String Field name.
    `sortBy` |  optional  | The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
    `limit` |  optional  | Int The number of items returned in the response.

<!-- END_8fe2b08f9e2b01a2fd204ff0cd679dc1 -->

<!-- START_9eb3fdff0a1aa133974484faa217a069 -->
## View responder details.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/responders/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/responders/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/responders/1',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/responders/1'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (404):

```json
{
    "message": "No query results for model [App\\Models\\Responders] 1"
}
```

### HTTP Request
`GET api/responders/{responder}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `responders` |  required  | the id of responder


<!-- END_9eb3fdff0a1aa133974484faa217a069 -->

<!-- START_5b8ce3c88f5163de39e38115d695a2bc -->
## Add new responder.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/responders/add" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"name":"voluptatem","type":"doloremque"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/responders/add"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "name": "voluptatem",
    "type": "doloremque"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://127.0.0.1:8000/api/responders/add',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'name' => 'voluptatem',
            'type' => 'doloremque',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/responders/add'
payload = {
    "name": "voluptatem",
    "type": "doloremque"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Responder created successfully",
    "data": {
        "id": 1,
        "account_id": 1,
        "name": "First collection bot",
        "type": "1",
        "status": 1,
        "date_start": "2021-02-10",
        "date_end": null
    }
}
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Required fields not filled or formats not recognized !"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`POST api/responders/add`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | String |  required  | The name of responder.
        `type` | Int |  required  | The type of responder. Example : 1 (questions)/2 (form)
    
<!-- END_5b8ce3c88f5163de39e38115d695a2bc -->

<!-- START_a6904635f8332baac462c3395d856818 -->
## Remove responder.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1:8000/api/responders/autem/delete" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/responders/autem/delete"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://127.0.0.1:8000/api/responders/autem/delete',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/responders/autem/delete'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "responder deleted successfully"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`DELETE api/responders/{responder}/delete`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `responder` |  required  | Int The id of responder.


<!-- END_a6904635f8332baac462c3395d856818 -->

<!-- START_e1a63b8aabba7629c60c1d08db864665 -->
## Update responder.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1:8000/api/responders/1/update" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"name":"at","type":"reprehenderit","status":"nulla"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/responders/1/update"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "name": "at",
    "type": "reprehenderit",
    "status": "nulla"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://127.0.0.1:8000/api/responders/1/update',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'name' => 'at',
            'type' => 'reprehenderit',
            'status' => 'nulla',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/responders/1/update'
payload = {
    "name": "at",
    "type": "reprehenderit",
    "status": "nulla"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('PUT', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Responder updated successfully",
    "data": {
        "id": 1,
        "account_id": 1,
        "name": "First collection bot",
        "status": 1,
        "date_start": "2021-02-10",
        "date_end": null
    }
}
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Unauthorized operation"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`PUT api/responders/{responder}/update`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `responders` |  required  | the id of responder

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | String |  required  | The name of responder.
        `type` | Int |  required  | The type of responder. Example : 1 (questions)/2 (form)
        `status` | Int |  required  | The status of responder. Example : 0/1
    
<!-- END_e1a63b8aabba7629c60c1d08db864665 -->

#Segments management


APIs for managing Segments
<!-- START_13a4c66fec8f4e3a84478d8c298d4e2c -->
## Display a list of segments.

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/segments?name=quia" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/segments"
);

let params = {
    "name": "quia",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://127.0.0.1:8000/api/segments',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'query' => [
            'name'=> 'quia',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/segments'
params = {
  'name': 'quia',
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "data": [
        {
            "id": 1,
            "account_id": 1,
            "name": "Customers"
        },
        {
            "id": 1,
            "account_id": 1,
            "name": "Super customers"
        }
    ],
    "meta": {
        "total": 10,
        "links": "",
        "filters": []
    }
}
```
> Example response (404):

```json
{
    "code": "error",
    "message": "No responders yet."
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`GET api/segments`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `name` |  optional  | String required The name of segment.

<!-- END_13a4c66fec8f4e3a84478d8c298d4e2c -->

<!-- START_ff49c98664f2014bb9e44427db06eeb1 -->
## Add new segment.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/segments/add" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"name":"et"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/segments/add"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "name": "et"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://127.0.0.1:8000/api/segments/add',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'name' => 'et',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/segments/add'
payload = {
    "name": "et"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Segment created successfully",
    "data": {
        "id": 1,
        "account_id": 1,
        "name": "Customers"
    }
}
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Required fields not filled or formats not recognized !"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`POST api/segments/add`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | String |  required  | The name of segment.
    
<!-- END_ff49c98664f2014bb9e44427db06eeb1 -->

<!-- START_6fa3162663dee21c717fba23273433e8 -->
## Remove segment.

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1:8000/api/segments/repellat/delete" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/segments/repellat/delete"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://127.0.0.1:8000/api/segments/repellat/delete',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/segments/repellat/delete'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "segment deleted successfully"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`DELETE api/segments/{segment}/delete`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `segment` |  required  | Int The id of segment.


<!-- END_6fa3162663dee21c717fba23273433e8 -->

<!-- START_fc6c54349db31d52f8535370425ec475 -->
## Update segment.

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1:8000/api/segments/accusamus/update" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: {token}" \
    -d '{"name":"et"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/segments/accusamus/update"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "{token}",
};

let body = {
    "name": "et"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://127.0.0.1:8000/api/segments/accusamus/update',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => '{token}',
        ],
        'json' => [
            'name' => 'et',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://127.0.0.1:8000/api/segments/accusamus/update'
payload = {
    "name": "et"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': '{token}'
}
response = requests.request('PUT', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "code": "success",
    "message": "Segment updated successfully",
    "data": {
        "id": 1,
        "account_id": 1,
        "name": "Customers"
    }
}
```
> Example response (400):

```json
{
    "code": "error",
    "message": "Unauthorized operation"
}
```
> Example response (500):

```json
{
    "code": "error",
    "message": "Unexpected error, please contact technical support."
}
```

### HTTP Request
`PUT api/segments/{segment}/update`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `segment` |  required  | the id of segment

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | String |  required  | The name of segment.
    
<!-- END_fc6c54349db31d52f8535370425ec475 -->


