import os  
import time 
import ConfigParser
import redis
import json
import MySQLdb

#Order timeout closing script

class OutTime:
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
                                     db=cf.get("db","db_database"))
        if(self._conn_order != None):
            print "Connect to log DB is ok!\n\r"
        else:
            print "Connect to log DB failed!\n\r"
        self._redis_conn = redis.Redis(host=cf.get("redis","db_host"), 
                                    port=int(cf.get("redis","db_port")),
                                    password=cf.get("redis","db_pass"))
        self._redis_key = cf.get("redis","db_key")

    def json_class(self):
        cache = self._redis_conn.get(self._redis_key);
        print cache;
        self._orderList = json.loads(cache)
        print 'all id'
        for (k, v) in self._orderList.items():
            print k
            OrderTime = self.time_long(time.mktime(time.strptime(v,'%Y-%m-%d %H:%M:%S')));
            if((self._now - OrderTime) >= self._effective):
                # print (self._now - OrderTime)
                # print i
                self._removeKey.append(k)

        self.del_list()

        print json.dumps(self._orderList)
        # list to json

    # #to mysql find data and check
    # def mysql_check(self):
    #     #todo

    #del list value
    def del_list(self):
        print 'del id'
        cursor = self._conn_order.cursor()
        for v in self._removeKey:
            print v
            sql = "update tp_user_order set status = 5 where id = '%s'" % (v)
            print sql;
            cursor.execute(sql)
            del self._orderList[v]
        print 'end id'
        for (k, v) in self._orderList.items():
           print k

    def time_long(self,str):
        return int(round(str));


if __name__ == "__main__":
    mgr = OutTime()
    mgr.json_class()  