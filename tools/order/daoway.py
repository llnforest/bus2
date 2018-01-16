import urllib2

if __name__ == '__main__':
    response = urllib2.urlopen('http://abak.shijiashou.cn/index/python/changedaoway')
    html = response.read()
    print html;