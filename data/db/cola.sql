###EXPORTAR WINDOWS
mysqldump -u root -B bdprovatudo -p > C:\xampp\htdocs\prova_tudo\data\db\script_inicial.sql

###IMPORTAR WINDOWS
mysql -u root -p < C:\xampp\htdocs\prova_tudo\data\db\script_inicial.sql


###EXPORTAR LINUX
mysqldump -u root -B bdprovatudo -p > /var/www/html/juridico.acthosti.com.br/data/db/script_inicial.sql


###IMPORTAR LINUX
mysql -u root -p < /var/www/html/juridico.acthosti.com.br/data/db/script_inicial.sql





mysqldump -u root -B bdprovatudo -p > /tmp/script_inicial_backup.sql


C:\xampp\htdocs\prova_tudo\data\db\bkp\script_inicial_backup.sql