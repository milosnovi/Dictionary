#!/bin/sh

rm -rf app/cache/*
rm -rf app/logs/*

#HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
#sudo chmod +a "$HTTPDUSER allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
#sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs


#!/bin/sh
mkdir -p          app/admin/cache     app/api/cache app/main/cache
mkdir -p          app/admin/cache/dev     app/api/cache/dev app/main/cache/dev
mkdir -p          app/admin/logs      app/api/logs      app/main/logs
mkdir -p          web/media/cache
mkdir -p          web/images/uploads
sudo chmod -R +a '_www allow read,write,delete,add_file,add_subdirectory,file_inherit,directory_inherit' app/cache
sudo chmod -R +a '_www allow read,write,delete,add_file,add_subdirectory,file_inherit,directory_inherit' app/logs
sudo chmod -R +a '_www allow read,write,delete,add_file,add_subdirectory,file_inherit,directory_inherit' web/media/cache
sudo chmod -R +a "$USER allow read,write,delete,add_file,add_subdirectory,file_inherit,directory_inherit" app/cache
sudo chmod -R +a "$USER allow read,write,delete,add_file,add_subdirectory,file_inherit,directory_inherit" app/logs
sudo chown -R $USER  *
