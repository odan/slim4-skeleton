## Manual Setup

**Step 1:** Create a new project:

```shell
composer create-project --prefer-dist odan/slim4-skeleton my-app
```

**Step 2:** Set permissions

*(Linux only)*

```bash
cd my-app
```

```bash
sudo chown -R www-data tmp/
sudo chown -R www-data public/cache/
```

*Optional*

NOTE: The app will have ability to create subfolders 
in `tmp/` and `public/cache/` which means it will need 760.

```bash
sudo chmod -R 760 tmp/
sudo chmod -R 760 public/cache/
```

NOTE: Debian/Ubuntu uses `www-data`, while CentOS uses `apache` and OSX `_www`.

**Step 3:** Setup

Run the installer script and follow the instructions:

```shell
sudo php bin/cli.php install
```

**Step 4:** Run it

* Open `http://localhost/my-app`
* Login with username / password: `admin / admin` or `user / user`

<hr>

Navigation: [Index](readme.md)
