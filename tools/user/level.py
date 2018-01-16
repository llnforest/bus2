import os  
import time 
import ConfigParser
# import redis
# import json
import MySQLdb

#Order timeout closing script

class user:
    # now time
    _now = int(round(time.time()));
    _effective = 15*24*3600 # 1 DAY;
    _removeKey = []; #list del key
    _orderList = {};

    def __init__(self):
        cf = ConfigParser.ConfigParser()
        cf.read("shijia.conf")
        self._conn_order = MySQLdb.connect(host=cf.get("db","db_host"),
                                     port=int(cf.get("db","db_port")),
                                     user=cf.get("db","db_user"),
                                     passwd=cf.get("db","db_pass"),
                                     db=cf.get("db","db_database"),
                                     unix_socket=cf.get("db","db_unix_socket"))
        if(self._conn_order != None):
            print "Connect to log DB is ok!\n\r"
        else:
            print "Connect to log DB failed!\n\r"
        # self._redis_conn = redis.Redis(host=cf.get("redis","db_host"), 
        #                             port=int(cf.get("redis","db_port")),
        #                             password=cf.get("redis","db_pass"))
        # self._redis_key = cf.get("redis","db_key")

    def level(self):
        all_user_sql = "select id from tp_user where level != 'S'";
        cursor = self._conn_order.cursor()
        cursor.execute(all_user_sql)
        cds = cursor.fetchall()
        level = 'D';
        for i in range(len(cds)):
            level = 'D';
            uid = cds[i][0];
            order_sql = "select sum(1) from tp_user_order where status = 4 and user_id = %s group by user_id" % uid
            order_num = self.selectSql(order_sql);
            assessment_sql = "select sum(1) from tp_user_assessment where user_id = %s group by user_id" % uid
            assessment_num = self.selectSql(assessment_sql);
            if(order_num > 1):
                level = 'A'
            elif(order_num == 1):
                level = 'B'
            elif(assessment_num >0):
                level = 'C'
            if(level != 'D'):
                updatasql = "update tp_user set level = '%s' where id = %s " % (level , uid)
                print updatasql;
                cursor.execute(updatasql)
        # list to json

    # #to mysql find data and check
    # def mysql_check(self):
    #     #todo
    def selectSql(self,sql):
        print sql;
        cursor = self._conn_order.cursor()
        cursor.execute(sql)
        cds = cursor.fetchone()
        if(cds == None):
            return 0
        else:
            return cds[0];
    #del list value


if __name__ == "__main__":
    mgr = user()
    mgr.level()  