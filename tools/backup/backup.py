# !/usr/bin/env python
# -*- coding:utf-8 -*-

import ConfigParser
import time
import os

class DbBackup:

    def __init__(self):
        self._cf = ConfigParser.ConfigParser()
        self._cf.read("bus.conf")
        self._dump_file = r"{}/bus_backup_{}.sql".format(self._cf.get("backup","dest_dir"),time.strftime("%Y%m%d%H"))

    def do_backup(self):
        self.mysql_dump()

    def mysql_dump(self):
        print '---------mysql_dump------------'
        os.system("mysqldump -h{} -u{} -p{} {} --default-character-set={} > {}".format(self._cf.get("db","db_host"),self._cf.get("db","db_user"),self._cf.get("db","db_pass"),self._cf.get("db","db_database"),self._cf.get("db","db_charset"),self._dump_file))

if __name__ == "__main__":
    db_backup = DbBackup()
    db_backup.do_backup()
        