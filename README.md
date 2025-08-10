# Install Git
```
apt install git
```

# Install Docker
```
curl https://get.docker.com | sh -
```

# Run Docker Compose
```
docker compose up -d
```

# Setup Laravel Environment
```
# Enter to docker shell
docker compose exec -it app sh

/var/www/html # cp .env.example .env
/var/www/html # vi .env # Ikuti sesuai instruksi pada gambar, untuk mengganti driver database
/var/www/html # composer update
/var/www/html # php artisan key:generate
/var/www/html # php artisan migrate --seed
/var/www/html # php artisan storage:link
/var/www/html # chown -R nginx /var/www/html/storage/logs /var/www/html/storage/framework
```
