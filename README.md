# FairRepack

School project.

## Apache configuration

Here is an example of an Apache configuration for the website.

```apacheconf
<VirtualHost *:80>
    DocumentRoot "/some/path/to/folder" # Replace this with the actual folder path

    ServerName fairrepack.lan # Replace this with actual server name

    # Set database variables, for security purposes
    SetEnv HTTP_MYSQL_HOST "localhost"
    SetEnv HTTP_MYSQL_USER "root"
    SetEnv HTTP_MYSQL_PASS "root"
    SetEnv HTTP_MYSQL_DB "fairrepack"
    SetEnv HTTP_SALT "SECRET" # Change this with a strong secret, used as a salt

    <Directory "/some/path/to/folder"> # Allow folder reading, if necessary
        Require all granted
        AllowOverride All
        Options Indexes FollowSymLinks Includes ExecCGI
    </Directory>
</VirtualHost>
```