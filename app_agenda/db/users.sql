CREATE USER  'create'@'%' IDENTIFIED BY 'UYQsjBRIv6dCVfEz';
GRANT INSERT, CREATE, RELOAD, REFERENCES, INDEX, ALTER ON *.* TO 'create'@'%';
CREATE USER  'demo'@'%' IDENTIFIED BY 'YLot6pyQCwgTjolF';
GRANT INSERT, CREATE, DROP, REFERENCES, ALTER ON *.* TO 'demo'@'%';
CREATE USER  'select'@'%' IDENTIFIED BY 'gon3rJGgpCBwksi0';
GRANT SELECT ON *.* TO 'select'@'%';
CREATE USER  'user'@'%' IDENTIFIED WITH mysql_native_password BY '0Z8AHyYDKN0hUYik';
GRANT SELECT, INSERT, UPDATE, DELETE, DROP ON *.* TO 'user'@'%';

CREATE USER  'create'@'localhost' IDENTIFIED BY 'UYQsjBRIv6dCVfEz';
GRANT INSERT, CREATE, RELOAD, REFERENCES, INDEX, ALTER ON *.* TO 'create'@'localhost';
CREATE USER  'demo'@'localhost' IDENTIFIED BY 'YLot6pyQCwgTjolF';
GRANT INSERT, CREATE, DROP, REFERENCES, ALTER ON *.* TO 'demo'@'localhost';
CREATE USER  'select'@'localhost' IDENTIFIED BY 'gon3rJGgpCBwksi0';
GRANT SELECT ON *.* TO 'select'@'localhost';
CREATE USER  'user'@'localhost' IDENTIFIED WITH mysql_native_password BY '0Z8AHyYDKN0hUYik';
GRANT SELECT, INSERT, UPDATE, DELETE, DROP ON *.* TO 'user'@'localhost';
