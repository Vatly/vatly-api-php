# One-Off Products

One-off products are single-purchase items (not recurring subscriptions).

## Retrieve a Product

```php
$product = $vatly->oneOffProducts->get('prod_abc123');

echo $product->name;
echo $product->price->forHumans(); // €49.00
```

## List Products

```php
$products = $vatly->oneOffProducts->list();

foreach ($products as $product) {
    echo $product->name . ': ' . $product->price->forHumans();
}
```

## One-Off Product Object

| Property | Type | Description |
|----------|------|-------------|
| `id` | string | Unique identifier (`prod_...`) |
| `name` | string | Product display name |
| `description` | string\|null | Product description |
| `price` | Money | Product price |
| `testmode` | bool | Test mode flag |
| `createdAt` | string | Creation timestamp |

## Using Products in Checkouts

```php
$checkout = $vatly->checkouts->create([
    'products' => [
        [
            'id' => 'prod_abc123',
            'quantity' => 2,
        ],
        [
            'id' => 'prod_xyz789',
            'quantity' => 1,
        ]
    ],
    'redirectUrlSuccess' => 'https://yourapp.com/success',
    'redirectUrlCanceled' => 'https://yourapp.com/canceled',
]);
```
