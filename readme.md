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



setting turnserver
tu
# you can listen ports 3478 and 5349 instead of 80/443
#listening-port=80
#tls-listening-port=443

listening-port=3478
tls-listening-port=5349

listening-ip=192.168.0.102

relay-ip=192.168.0.102
external-ip=192.168.0.102

realm=webrtc-test.ru
server-name=webrtc-test.ru

lt-cred-mech
userdb=/etc/turnuserdb.conf

# use real-valid certificate/privatekey files
#cert=/etc/ssl/certificate.pem
#pkey=/etc/ssl/private.key


user=test:test





START: turnserver


579  a2enmod SSLEngine
580  a2enmod ssl 
618  a2enmod rewrite 
626  a2enmod proxy
634  sudo a2enmod proxy_http
635  sudo a2enmod proxy
637  a2enmod proxy proxy_http proxy_ajp 
638  sudo a2enmod proxy_balancer
639  sudo a2enmod proxy_wstunnel


apt-get install coturn


