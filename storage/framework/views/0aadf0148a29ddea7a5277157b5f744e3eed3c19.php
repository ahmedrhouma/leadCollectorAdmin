```python
import requests
import json

url = '<?php echo e(rtrim($baseUrl, '/')); ?>/<?php echo e(ltrim($route['boundUri'], '/')); ?>'
<?php if(count($route['cleanBodyParameters'])): ?>
payload = <?php echo json_encode($route['cleanBodyParameters'], JSON_PRETTY_PRINT); ?>

<?php endif; ?>
<?php if(count($route['cleanQueryParameters'])): ?>
params = <?php echo \Mpociot\ApiDoc\Tools\Utils::printQueryParamsAsKeyValue($route['cleanQueryParameters'], "'", ":", 2, "{}"); ?>

<?php endif; ?>
<?php if(!empty($route['headers'])): ?>
headers = {
<?php $__currentLoopData = $route['headers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $header => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  '<?php echo e($header); ?>': '<?php echo e($value); ?>'<?php if(!($loop->last)): ?>,
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

}
<?php endif; ?>
response = requests.request('<?php echo e($route['methods'][0]); ?>', url<?php echo e(count($route['headers']) ?', headers=headers' : ''); ?><?php echo e(count($route['cleanBodyParameters']) ? ', json=payload' : ''); ?><?php echo e(count($route['cleanQueryParameters']) ? ', params=params' : ''); ?>)
response.json()
```
<?php /**PATH C:\laragon\www\leadCollector\resources\views/vendor/apidoc/partials/example-requests/python.blade.php ENDPATH**/ ?>