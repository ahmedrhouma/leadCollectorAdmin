```php

$client = new \GuzzleHttp\Client();
<?php if($hasRequestOptions): ?>
$response = $client-><?php echo e(strtolower($route['methods'][0])); ?>(
    '<?php echo e(rtrim($baseUrl, '/') . '/' . ltrim($route['boundUri'], '/')); ?>',
    [
<?php if(!empty($route['headers'])): ?>
        'headers' => <?php echo \Mpociot\ApiDoc\Tools\Utils::printPhpValue($route['headers'], 8); ?>,
<?php endif; ?>
<?php if(!empty($route['cleanQueryParameters'])): ?>
        'query' => <?php echo \Mpociot\ApiDoc\Tools\Utils::printQueryParamsAsKeyValue($route['cleanQueryParameters'], "'", "=>", 12, "[]", 8); ?>,
<?php endif; ?>
<?php if(!empty($route['cleanBodyParameters'])): ?>
        'json' => <?php echo \Mpociot\ApiDoc\Tools\Utils::printPhpValue($route['cleanBodyParameters'], 8); ?>,
<?php endif; ?>
    ]
);
<?php else: ?>
$response = $client-><?php echo e(strtolower($route['methods'][0])); ?>('<?php echo e(rtrim($baseUrl, '/') . '/' . ltrim($route['boundUri'], '/')); ?>');
<?php endif; ?>
$body = $response->getBody();
print_r(json_decode((string) $body));
```
<?php /**PATH C:\laragon\www\leadCollector\resources\views/vendor/apidoc/partials/example-requests/php.blade.php ENDPATH**/ ?>