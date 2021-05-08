# FairRepack

School project.

# Libraries

See /lib/README.md for more details.

## Apache configuration

Here is an example of an Apache configuration for the website.

```apacheconf
<VirtualHost *:80>
    # Replace this with the actual folder path
    DocumentRoot "/some/path/to/folder"

    # Replace this with actual server name
    ServerName fairrepack.lan

    # Set database variables, for security purposes
    # All variables have default values
    SetEnv HTTP_MYSQL_HOST "localhost"
    SetEnv HTTP_MYSQL_USER "root"
    SetEnv HTTP_MYSQL_PASS "root"
    SetEnv HTTP_MYSQL_DB "fairrepack"
    SetEnv HTTP_MYSQL_PORT "3306"
    SetEnv HTTP_MYSQL_DRIVER "mysql"
    
    # Change this with a strong secret, used as a salt
    SetEnv HTTP_SALT "SECRET"

    # Allow folder reading, if necessary
    <Directory "/some/path/to/folder">
        Require all granted
        AllowOverride All
        Options Indexes FollowSymLinks Includes ExecCGI
    </Directory>
</VirtualHost>
```