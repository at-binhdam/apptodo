## APP TODO
[![Build Status](https://travis-ci.org/at-binhdam/apptodo.svg?branch=master)](https://travis-ci.org/at-binhdam/apptodo)

This is a web system to manage your work and show on the calendar.

[![Screenshot](https://raw.githubusercontent.com/at-binhdam/apptodo/master/public/images/app.png)]()

### Server Requirements
- PHP >= 7.0
- Sqlite PHP Extension

### Installing
- Get source `git clone https://github.com/at-binhdam/apptodo`
- Run command `composer install`

### Directory Permissions
After installing app, you may need to configure some permissions. Directories within the `databases` directory should be writable by your web server or app will not run.

### Run app via PHP Development Server
- Go to folder public `cd public`
- Run command `php -S 0.0.0.0:8080`
- Access the URL `http://0.0.0.0:8080`

