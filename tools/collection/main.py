import threading
import urllib2,time,datetime
import sys,os,signal
import MySQLdb
import httplib
import inspect
import ctypes
httplib.HTTPConnection._http_vsn = 10 
httplib.HTTPConnection._http_vsn_str = 'HTTP/1.0'
# def getUrl(url):
# 	print url
# 	response = urllib2.urlopen(url)
# 	html = response.read()
thread = []
page = ['b7','b7-p2','b7-p3','b7-p4','b7-p5','b7-p6','b7-p7','b7-p8','b7-p9','c1-b7-p10','c1-b7-p11','c1-b7-p12','b52','b184','b184-p2','b9','b9-p2','b9-p3','b9-p4','b9-p5','b9-p6','b9-p7','b24','b24-p2','b356','b4','b4-p2','b4-p3','b4-p4','b16','b16-p2','b16-p3','b16-p4','b278','b278-p2','b278-p3','b278-p4','b278-p5','b278-p6','b365','b17','b17-p2','b17-p3','b17-p4','b19','b19-p2','b19-p3','b19-p4','b19-p5','b1','b1-p2','b1-p3','b1-p4','b1-p5','b1-p6','b3','b3-p2','b3-p3','b18','b18-p2','b18-p3','b18-p4','b18-p5','b18-p6','b18-p7','b18-p8','b342','b25','b25-p2','b357','b8','b8-p2','b8-p3','b8-p4','b8-p5','b8-p6','b21','b21-p2','b21-p3','b21-p4','b21-p5','b21-p6','b21-p7','b21-p8','b14','b14-p2','b14-p3','b14-p4','b14-p5','b103','b20','b15','b15-p2','b15-p3','b12','b12-p2','b10','b11','b358','b51','b391','b458','b460','b463','b478']
# page = ['b7','b7-p2','b7-p3','b7-p4','b7-p5','b7-p6','b7-p7','b7-p8','b7-p9','c1-b7-p10','c1-b7-p11','c1-b7-p12','b52','b184','b184-p2','b9','b9-p2','b9-p3','b9-p4','b9-p5','b9-p6','b9-p7','b24','b24-p2','b356','b4','b4-p2','b4-p3','b4-p4','b16','b16-p2','b16-p3','b16-p4','b278','b278-p2','b278-p3','b278-p4','b278-p5']

def get_cur_time():
    return time.strftime('%Y-%m-%d %H:%M:%S',time.localtime(time.time()))

def main():
    for key in page:
        # url = 'http://192.168.1.105/admin/phone/gethttp/getaihuishou/page/'+key+'.html'
        url = 'http://abak.shijiashou.cn/phone/gethttp/getaihuishou/page/'+key+'.html'
        t = VisitPageThread(key,url) 
        thread.append(t)

def startThead():
    for i in thread: 
        i.start()
        time.sleep(1)

def _async_raise(tid, exctype):
    """raises the exception, performs cleanup if needed"""
    print "tid is %s" % tid
    if(tid != None):
        tid = ctypes.c_long(tid)
        if not inspect.isclass(exctype):
            exctype = type(exctype)
        res = ctypes.pythonapi.PyThreadState_SetAsyncExc(tid, ctypes.py_object(exctype))
        if res == 0:
            raise ValueError("invalid thread id")
        elif res != 1:
            # """if it returns a number greater than one, you're in trouble,
            # and you should call it again with exc=NULL to revert the effect"""
            ctypes.pythonapi.PyThreadState_SetAsyncExc(tid, None)
            raise SystemError("PyThreadState_SetAsyncExc failed")

def stopThead():
    for i in thread: 
        _async_raise(i._get_my_tid(), SystemExit)


class collectiondb:
    def __init__(self):
        
        self._conn_order = MySQLdb.connect(host='localhost',port=3306,user='shijia',passwd='shijia.2017',db='shijia',unix_socket="/home/mysql/mysql.sock")
        if(self._conn_order != None):
            print "Connect to log DB is ok!\n\r"
        else:
            print "Connect to log DB failed!\n\r"

    def cleanData(self):
        cursor = self._conn_order.cursor()
        cursor.execute('TRUNCATE tp_temp_collection');
        cursor.close()

class VisitPageThread(threading.Thread):  
    def __init__(self,threadName,url): 
        threading.Thread.__init__(self, name = threadName)  
        self.url = url  
        self.threadName = threadName
      
    def run(self):  
        url = self.url   
        print get_cur_time() + " === start get : %s" % url
        try: 
            response = urllib2.urlopen(url)
            html = response.read()
            # time.sleep(10)
            # print self.threadName + " is work"
            #print doc  
        except Exception, e:  
            print "urlopen Exception : %s" %e  
    def _get_my_tid(self):
        """determines this (self's) thread id"""
        if not self.isAlive():
            return None
            # raise threading.ThreadError("the thread is not active")

        # do we have it cached?
        if hasattr(self, "_thread_id"):
            return self._thread_id

        # no, look for it in the _active dict
        for tid, tobj in threading._active.items():
            if tobj is self:
                self._thread_id = tid
                return tid



if __name__ == '__main__':
    mgr = collectiondb()
    mgr.cleanData()
    print "start";
    main()
    startThead()
    # wait 30s and exit
    time.sleep(40)

    stopThead();
    os.kill(os.getpid(), signal.SIGTERM)
    try:
        sys.exit()
    except:
        print 'die'
    finally:
        print 'cleanup'
    print "end";