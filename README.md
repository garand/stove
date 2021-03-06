<img width="450" src="https://cloud.githubusercontent.com/assets/82437/4970014/f952eba4-6875-11e4-8930-27d94be9feee.png">
<br><br>
<a href="https://heroku.com/deploy"><img src="http://f.cl.ly/items/2S043d073M1O1K423035/deploy-to-heroku.svg"></a>

Stove is an app for tracking stove temperature and wood levels.

## Requirements
- [Node](http://nodejs.org/download/)
- [MySQL](http://blog.joefallon.net/2013/10/install-mysql-on-mac-osx-using-homebrew/) (I recommend installing via Homebrew)

## Local Setup
Clone this repository and run the following command.

```
script/setup
```

### Configuration
In order to configure a local copy, create a MySQL database and configure the connection information for the database in the [`config.local.sample.php`](https://github.com/garand/stove/blob/master/config.local.sample.php) file, and rename it to `config.local.php`. When the app loads, it will create the necessary table structure.

To enable SMS notifications, enter your Twilio SID, token, to number, and from number, in the `config.local.php` file as well. Make sure to format the to and from number with the international code and a leading +, for example: `+18005551234`.

To configure the location for the outside temperature, set the environment variables for latitude and longitude coordinates of your stove in the `config.local.php` file.

### Start Server
This is built to be run with PHP's built in server, in conjunction with [gulp](http://gulpjs.com) for building the project. After running `npm install`, startup gulp:

```
gulp
```

That will start up the PHP server (on port 5703), begin watching the project, and launch your browser to the proxied version of the page, because this uses [BrowserSync](http://www.browsersync.io) for automatic reloading and style injection.

Be sure to view your site on the proxy created by BrowserSync. The port number will be in the gulp log. It should be [localhost:3000](http://localhost:3000) by default.

## Environment Variables
These are the environment variables required for deploying the app.

- outside_temp_lat
- outside_temp_long
- twilio_sid
- twilio_token
- twilio_to
- twilio_from
