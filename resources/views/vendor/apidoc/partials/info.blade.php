# Introduction

Leads collector is An application that automates the collection, centralization and consolidation of contacts from different channels. Our solution put at your disposal3 sources of prospecting :
-   Social media
-   Landing pages
-   Live chat (Bots)

@if($showPostmanCollectionButton)
[Get Postman Collection]({{url($outputPath.'/collection.json')}})
@endif

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

