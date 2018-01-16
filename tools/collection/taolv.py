#coding:utf-8
import urllib,urllib2
import threading
import Queue
import sys
import json
import time
import re
import MySQLdb
import ConfigParser

reload(sys)
sys.setdefaultencoding('utf-8')

THREAD_LIMIT = 3
jobs = Queue.Queue()
singlelock = threading.Lock()
info = Queue.Queue()

urls = [{'brand':'三星','id':'012'},
        {'brand':'苹果','id':'023'},
        {'brand':'诺基亚','id':'001'},
        {'brand':'小米','id':'034'},
        {'brand':'HTC','id':'028'},
        {'brand':'索尼','id':'015'},
        {'brand':'魅族','id':'033'},
        {'brand':'摩托罗拉','id':'027'},
        {'brand':'康佳','id':'025'},
        {'brand':'朵唯','id':'029'},
        {'brand':'华硕','id':'026'},
        {'brand':'LG','id':'022'},
        {'brand':'黑莓','id':'021'},
        {'brand':'西门子','id':'020'},
        {'brand':'CECT','id':'019'},
        {'brand':'TCL','id':'018'},
        {'brand':'步步高','id':'017'},
        {'brand':'OPPO','id':'016'},
        {'brand':'夏普','id':'013'},
        {'brand':'长虹','id':'014'},
        {'brand':'多普达','id':'011'},
        {'brand':'金立','id':'010'},
        {'brand':'华为','id':'009'},
        {'brand':'天语','id':'008'},
        {'brand':'联想','id':'007'},
        {'brand':'中兴','id':'006'},
        {'brand':'飞利浦','id':'005'},
        {'brand':'首信','id':'004'},
        {'brand':'波导','id':'003'},
        {'brand':'创维','id':'002'},
        {'brand':'小辣椒','id':'096'},
        {'brand':'酷派','id':'032'},
        {'brand':'夏新','id':'031'},
        {'brand':'海尔','id':'030'},
        {'brand':'中天','id':'093'},
        ]
def workerbee(inputlist):
    for x in xrange(THREAD_LIMIT):
        print 'Thead {0} started.'.format(x)
        t = spider()
        t.start()
    for i in inputlist:
        try:
            jobs.put(i, block=True, timeout=5)
        except:
            # singlelock.acquire()
            print "The queue is full !"
            # singlelock.release()
        # Wait for the threads to finish
        # singlelock.acquire()    # Acquire the lock so we can print
        # print "Waiting for threads to finish."
        # singlelock.release()    # Release the lock
        jobs.join()       # This command waits for all threads to finish.
        # while not jobs.empty():
        #  print jobs.get()

class taolv:
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
    def cleanData(self):
        self._cursor = self._conn_order.cursor()
        self._cursor.execute('TRUNCATE tp_temp_taolv_collection');

    def closeMysql(self):
        self._cursor.close();

    def getPhone(self,urldata,time=10):
        brand = urldata['brand']
        print "brand is %s " % brand
        brand_url = []
        for i in range(0, 250+1):
            brand_url.append('http://m.taolv365.com/Common/Wap/Page_Search.ashx?P=%s&BR=%s&KW=' % (i,urldata['id']))

        for url in brand_url:
            print "url %s is started" % url
            response = urllib2.urlopen(url,timeout=time)
            html = response.read().replace('\n', '').replace('\t', '')
            response.close()
            data = json.loads(html)
            if(data['st'] == '0'):
                print "no result"
                return 1
            for v in data['con']:
                model = re.findall(r'<dt>(.+?)</dt>',v['sub'],re.DOTALL)
                model = model[0].encode('utf-8')
                price = re.findall(r'<span>(.+?)</span></dd>',v['sub'],re.DOTALL)
                price = price[0].encode('utf-8').replace('元','')
                print "model and price is %s,%s" % (model,price)
                self.postData(brand,model,price,url)
        return 1;
    def postData(self,brand,model,price,url):
        postVal = {'pass':'fantuan123','brand':brand,'model':model,'price':price,'url':url}
        postVal_urlencode = urllib.urlencode(postVal)
        postUrl = "http://abak.shijiashou.cn/phone/collection/index/"
        print postVal
        req = urllib2.Request(url = postUrl,data = postVal_urlencode)
        print req
        res_data = urllib2.urlopen(req)
        res = res_data.read()
        print res





class spider(threading.Thread):
    def run(self):
        while 1:
            try:
                job = jobs.get(True,1)
                print job
                singlelock.acquire()
                mgr.getPhone(job)
                singlelock.release()
                jobs.task_done()
            except:
                break;
def stopThead():
    for i in jobs: 
        _async_raise(i._get_my_tid(), SystemExit)



if __name__ == '__main__':
    # getPhone(urls[0])
    mgr = taolv();
    mgr.cleanData();
    # mgr.getPhone(urls[0])
    workerbee(urls);
    mgr.closeMysql();
    # workerbee(urls)
    # phone = getTitle('http://m.taolv365.com/Common/Wap/Page_Search.ashx?P=0&BR=012&KW=');
    # print phone[0]
