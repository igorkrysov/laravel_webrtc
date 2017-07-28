Setting virtualhost


<VirtualHost *:443>
SSLEngine on
SSLProtocol all -SSLv2
SSLCertificateFile /etc/ssl/certs/server.pem
SSLCertificateKeyFile /etc/ssl/private/server.key
#ProxyPass "/wss2/" "ws://127.0.0.1:8080/"
#ProxyPass "/ws2/"  "ws://127.0.0.1:8080/"
#ProxyPass /wss2/ http://google.com/

#<----->ServerAdmin webmaster@localhost
        ServerName webrtc.local
        ServerAlias webrtc.local
        DocumentRoot /var/www/webrtc/laravel/public

        <Directory "/var/www/webrtc/laravel/public">

            AllowOverride All

        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

        ProxyPass /wss2/ ws://127.0.0.1:8080/

</VirtualHost>
