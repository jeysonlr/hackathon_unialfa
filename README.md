git clone https://github.com/jeysonlr/laminas-mezzio-api.git

```
cd laminas-mezzio-api
```

### run project
```
docker-compose up -d --build
```

### enter container for install dependencies
```
docker exec -it teste-mezzio_laminas_1 bash

composer install
```


### Do NOT run development mode on your production server!

```bash
$ composer development-enable
```

### To disable development mode

```bash
$ composer development-disable
```

### Development mode status

```bash
$ composer development-status
```

```
project run port 8082
```
### documentation routes 

https://documenter.getpostman.com/view/7013209/TVRrUjEF

or archive in raiz project  
```
GeoNames.postman_collection.json
```

### email
``
jeysonlr@gmail.com
``
