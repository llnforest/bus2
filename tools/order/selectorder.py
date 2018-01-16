import os  
import time 
import ConfigParser
import redis
import json
import MySQLdb

#Regular access to orders within 10 days

class SelectOrder:
    _now = int(round(time.time()));
    _startTime = int(round(time.time())) - (15*24*3600);
    _orderList = {};

    def __init__(self):
        cf = ConfigParser.ConfigParser()
        cf.read("shijia.conf")
        self._conn_order = MySQLdb.connect(host=cf.get("db","db_host"),
                                     port=int(cf.get("db","db_port")),
                                     user=cf.get("db","db_user"),
                                     passwd=cf.get("db","db_pass"),
                                     db=cf.get("db","db_database"))
        if(self._conn_order != None):
            print "Connect to log DB is ok!\n\r"
        else:
            print "Connect to log DB failed!\n\r"
        self._redis_conn = redis.Redis(host=cf.get("redis","db_host"), 
                                    port=int(cf.get("redis","db_port")),
                                    password=cf.get("redis","db_pass"))
        self._redis_key = cf.get("redis","db_key")


    def get_data(self):
        print self._startTime
        start_time = time.strftime('%Y-%m-%d %H:%M:%S',time.localtime(self._startTime));
        sql = "select id,create_time from tp_user_order where status =0 and create_time >= '%s' order by create_time asc"  % (start_time)
        print sql;
        cursor = self._conn_order.cursor()
        cursor.execute(sql)
        cds = cursor.fetchall()
        for i in range(len(cds)):
            self._orderList[cds[i][0]] = cds[i][1].strftime('%Y-%m-%d %H:%M:%S')

        order_json = json.dumps(self._orderList)
        self._redis_conn.set(self._redis_key,order_json)
        print 'end'
    #to mysql find data and check
        #todo

if __name__ == "__main__":
    mgr = SelectOrder()
    mgr.get_data()  