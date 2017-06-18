import cymysql
 
DB_HOST = 'localhost' 
DB_USER = 'root' 
DB_PASS = 'root' 
DB_NAME_A = 'lebouquet_es'
BD_NAME_B = 'bd_le_bouquet'

#conn = cymysql.connect(host='127.0.0.1', unix_socket='/tmp/mysql.sock', user='root', passwd=None, db='mysql')

conn = cymysql.connect(host=DB_HOST, port=3306, user=DB_USER, passwd=DB_PASS, db=DB_NAME_A)  

cur = conn.cursor()

cur.execute("SELECT * FROM usuarios")

# print cur.description

# r = cur.fetchall()
# print r
# ...or...
for r in cur.fetchall():
   print(r)

cur.close()
conn.close()