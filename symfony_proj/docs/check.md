
## MySQL
```shell
php -a
```

```php
$server = "172.50.0.101";
$user = "zhangrj";
$pass = "123123";

$conn = new mysqli($server, $user, $pass);
if ($conn->connect_error) {
  die("[MySQL] failed: " . $conn->connect_error);
}
echo "[MySQL] ok";
```

## Redis
```shell
php -a
```

```php
$vm = [
    'host'     => '172.50.0.120',
    'port'     => 6379,
    'timeout'  => 0.8
];

$redis = new Predis\Client($vm);
try {
    $redis->ping();
} catch (Exception $e) {
    die("[Redis] failed: " . $e->getMessage());
}
echo "[MySQL] ok";
```