## Deployment

### Building an artifact

To build a new artifact (ZIP file), for deployment, run:

``` bash
$ ant build
```

The new artifact is created in the `build` directory: `build/my_app_*.zip`

To deploy the artifact to test/staging or production, just upload
the zip file with a SFTP client onto your server (`/var/www/example.com`).
Then extract the artifact into a `htdocs/` sub-directory and run the migrations. 
It's recommended to use `deploy.php` script for this task.

#### Server setup

* Create a directory: `/var/www/example.com`
* Create a directory: `/var/www/example.com/htdocs`
* Upload, rename and customize: `config/env.example.php` to `/var/www/example.com/env.php`
* Upload `config/deploy.php` to `/var/www/example.com/deploy.php`
* Make sure the apache [DocumentRoot](https://httpd.apache.org/docs/2.4/en/mod/core.html#documentroot) points to the `public` path: `/var/www/example.com/htdocs/public`

#### Deploying a new artifact

* Upload the new artifact file `my_app_*.zip` to `/var/www/example.com/`
* Then run `sudo php deploy.php my_app_*.zip`

Example:

```bash
$ cd /var/www/example.com
$ sudo php deploy.php my_app_2019-01-29_235044.zip
```

<hr>

Navigation: [Index](readme.md)