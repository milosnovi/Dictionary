app/console doctrine:database:drop --force
app/console doctrine:database:create

app/console doctrine:migration:migrate -n

mysql -u milos -pmilos dictionary < app/DataFixtures/SQL/users.sql
mysql -u milos -pmilos dictionary < app/DataFixtures/SQL/word.sql
mysql -u milos -pmilos dictionary < app/DataFixtures/SQL/dictionary_data.sql