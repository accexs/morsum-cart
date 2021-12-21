
## Morsum shopping cart.

Small demo application with laravel + react. To handle the shopping cart [LaravelShoppingCart](https://github.com/hardevine/LaravelShoppingcart) package was used, it handles the cart state by keeping a session and is possible to save/restore the cart from the DB. On Frontend side there is a mix of Context and Hooks to handle the Cart state. Material UI was chosen as component library. Users can browse a series of products, add them to a shopping cart, add more or reduce quantity, and do a checkout.

## Installation

The easiest way to set up the project is by using laravel valet. After installing composer dependencies is important to set `.env` file variables. Mails are handled on queues, default sync queue driver should be enough however everything was developed/tested using laravel horizon.

In order to run migrations remember to set DB variables. There is a seed class for products with a list of 100 products paginated by stacks on 20, rapidapi endpoints were used to get the json to feed the products table.

Is recommended to use mailtrap to test the app, `MAIL_ORDER_RECIPIENT` variable is used as target for the generated order.

Tests were created for all the features of the app. To execute them all just run `php artisan test`

## Usage

Cart state is orchestrated by the BE. Every action updates the cart context and is saved on local storage with data incoming form the `cart` and `orders` endpoints.

The library used to handle cart state uses a combination of session and db storage to keep data, it is not the best approach for an API however using the DB storage feature makes it ok to pursue this approach, and it was a time saver. It will be better for this APP to refactor this in favor of a more traditional `Cart` model.

To check OpenApi 3 spec, go to `/api/documentation` on the browser. An  `api-docs.json` is provided and should work however if needed execute `php artisan l5-swagger:generate` 

Several endpoints compose the service:

`GET /products`

Returns a list of products

`POST /orders`

This endpoint creates an order based on the cart items and sends it to the config email. Orders are stored and have a many-to-many relationship with products.

`GET /cart`

Returns cart state: items, total, subtotal, etc.

`PATCH /cart/addItem  PAYLOAD: {id: someProductId(required), quantity: someInt(optional)}`

Adds an existing product to the cart or increases the quantity of an already existing item. It supports the possibility to increment/add more than one product at once using the `quantity` param.

`PATCH /cart/removeItem PAYLOAD: {rowId: someCartItemId(required)}`

Removes an item from the cart reducing its quantity 1 by 1. Is possible to implement a remove the product completely from the cart doing a small refactor and using quantity 0.

`DELETE /cart`

Removes all products from the cart.

## License

[MIT license](https://opensource.org/licenses/MIT).
