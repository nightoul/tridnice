
**************** .htaccess files ******************

1. in root dir

RewriteEngine On
RewriteRule ^$ public/ [L]
RewriteRule (.*) public/$1 [L]

2. in public dir

Options -Multiviews
RewriteEngine On
RewriteBase /tridnice/public
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]

3. in app dir

Options -Indexes
