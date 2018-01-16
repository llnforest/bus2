#-*- coding:utf-8 -*-  
  
import os  
import time  
import tarfile  
import zipfile
import ConfigParser
import MySQLdb

class CDataBackup:
    _cf = None
    _backup_days_ago = 0
    _dump_file = None

    def __init__(self):
        self._cf = ConfigParser.ConfigParser()
        self._cf.read("shijia.conf")
        # self._backup_days_ago = self._cf.get("backup","backup_days_ago")
        self._dump_file=r"%s/shijia_backup_%s.sql" %(self._cf.get("backup","dest_dir"), time.strftime("%Y%m%d%H")) 
                           
    def do_backup(self):
        self.mysql_dump()
        # self.zip_files()
                           
    def mysql_dump(self):
        print "-----mysql_dump--------"
        # where_clause = ("-w \"to_days(now()) - to_days(action_time) > %s\"") % self._backup_days_ago
        # print "Mysql dump: [tables: %s][condition: %s]" % (self._cf.get("backup","tables"), where_clause)
        os.system("mysqldump -h%s -u%s -p%s %s --default-character-set=%s > %s" %(self._cf.get("db","db_host"), self._cf.get("db","db_user"), self._cf.get("db","db_pass"), self._cf.get("db","db_database"),  self._cf.get("db","db_charset"), self._dump_file))

    def zip_files(self):
        print "-----zip_files--------"
        zip_src = self._dump_file  
        zip_dest = zip_src + ".zip"  
        f = zipfile.ZipFile(zip_dest, 'w')   
        f.write(zip_src)  
        f.close()
        os.remove(zip_src) 
        
    def do_cleanup(self):
        print "-----do_cleanup--------"
        conn = MySQLdb.connect(host=self._cf.get("db","db_host"),port=int(self._cf.get("db","db_port")),user=self._cf.get("db","db_user"),passwd=self._cf.get("db","db_pass"),db=self._cf.get("db","db_database"))
        cursor = conn.cursor()
        table_list = self._cf.get('backup',"tables").split(' ')
        for tbl_name in table_list:
            where_clause = ("where to_days(now()) - to_days(action_time) > %s") % self._backup_days_ago
            sql = "delete from %s %s" % (tbl_name, where_clause)
            print sql
            cursor.execute(sql)
        conn.close()

if __name__ == "__main__":
    backup_mgr = CDataBackup()
    backup_mgr.do_backup()                      
