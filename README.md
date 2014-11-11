<p align="center">
  <img width="400" src="https://cloud.githubusercontent.com/assets/82437/4970014/f952eba4-6875-11e4-8930-27d94be9feee.png">
  <br/><br/>
  <img src="https://codeship.com/projects/ebc21970-4aa4-0132-eb1f-2eec968ed96f/status">
</p>

Stove is a web app used to track woodstove temperature and wood levels throughout the winter.

### Setup
Clone this repository and run `npm install` in the root directory.

### Configuration
In order to configure a local copy, create a MySQL database with the following table structure. You can download and import [this SQL file](http://cl.ly/YSmF/download/stove.sql) to automatically generate the table as well.

##### Table Name: Log

| Field              | Type     | Length |
|--------------------|----------|--------|
| id _(primary key)_ | INT      | 11     |
| outside_temp       | VARCHAR  | 10     |
| stove_temp         | VARCHAR  | 10     |
| pre_fill_level     | VARCHAR  | 10     |
| post_fill_level    | VARCHAR  | 10     |
| filled_by          | VARCHAR  | 200    |
| datetime           | DATETIME |        |

After the table is setup, configure the connection information for the database in the [`config.local.sample.php`](https://github.com/garand/stove/blob/master/config.local.sample.php) file, and rename it to `config.local.php`.

To enable SMS notifications, enter your Twilio SID, token, to number, and from number, in the `config.local.php` file as well. Make sure to format the to and from number with the international code and a leading +, for example: `+18005551234`.

### Start Server
This is built to be run with PHP's built in server, in conjunction with [gulp](http://gulpjs.com) for building the project. After running `npm install`, startup the PHP server:

```
php -S 0.0.0.0:8000
```

Once that server is running, startup gulp:

```
gulp
```

That will begin watching the project and launch your browser to the proxied version of the page, because this uses [BrowserSync](http://www.browsersync.io) for automatic reloading and style injection.
