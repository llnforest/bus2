#-*- coding:utf-8 -*-  
from stat_mgr import *
# import db_backup
import time,datetime
import ConfigParser
import os, sys

def print_section(level, msg):
    if(level == 1):
        print "=======%s=======\n\r" % (msg)

#prepare dir

def do_stat(statMgr, cur_date, when):
    date = cur_date - datetime.timedelta(days=when)
    end_date = cur_date - datetime.timedelta(days=(when-1))
    statMgr.set_date(date,end_date,when)
    return statMgr.do_stat()
    
if __name__ == "__main__":
    when = 1;   #by default, we stat yersterday
    all = '';
    argv = sys.argv
    if(len(argv)>1):
        when = int(argv[1])
    #if (when < 0):
    #    return
    if(len(argv)>2):
        all = argv[2]
    cf = ConfigParser.ConfigParser()
    cf.read("./shijia.conf")
    #if(False == os.path.exists(cf.get("backup","dest_dir"))):
    #    os.mkdir(cf.get("backup","dest_dir"))
        
    print_section(1, "statistic data begin ...") 
    stat_manager = CStatManager()
    cur_date = datetime.date.today()
    print all
    if (all == 'A'):
        print "######Multiple stat######, from 1 to ", when
        for i in range(1, when):
            ret = do_stat(stat_manager, cur_date, i)
    else:
        ret = do_stat(stat_manager, cur_date, when)

    stat_manager.destory_conn()
    print_section(1, "statistic data End") 

    #print_section(1, "Data backup begin") 
    #backup_mgr = db_backup.CDataBackup()
    #backup_mgr.do_backup()
    #backup_mgr.do_cleanup()   
    #print_section(1, "Data backup end") 

