#!/usr/bin/python

import sys
import xml.etree.ElementTree as xml

fileName = sys.argv[1]

tree = xml.parse(fileName)
root = tree.getroot()

for hosts in root.findall('host'):
    if (hosts.find('hostscript')):
        ip = hosts.find('address').get('addr')
        print ip, ", this host is Vulnerable to smb-vuln-ms17-010."
